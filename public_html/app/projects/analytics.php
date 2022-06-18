<?
switch ($_REQUEST['form']) {
  case 'analytics_week': # Вывод статистики за неделю
    $arrResults = [];
    $arrCategories = [];

    // Считаем неделю
    $arrWeek = [];
    if ( (int)$_REQUEST['week'] ) {
      $dDateStart = $dDateCurrent = date('Y-m-d', strtotime('last sunday -7 days'));
      $dDateStop = date('Y-m-d', strtotime('last sunday'));
    }
    else {
      $dDateStart = $dDateCurrent = date('Y-m-d', strtotime('monday this week'));
      $dDateStop = date('Y-m-d', strtotime('sunday this week'));
    }
    $iProjectId = $_REQUEST['project_id'];

    // Время
    // __________
    // Получаем категории
    $arrCategories = [];
    $arrCategories[0] = array(
      'title' => 'Times',
      'color' => '#dd3e3e'
    );
    $arrResults['time_categories'] = $arrCategories;
    $arrResults['data_times'] = [];
    $arrTimesSum = [];

    // Обработка данных
    $iIndex = 1;
    while (strtotime($dDateCurrent) < strtotime($dDateStop)) {
      if ( $iIndex > 1 ) $dDateCurrent = date('Y-m-d', strtotime('+1 day', strtotime($dDateCurrent)));

      // Заполняем данные
      $arrResults['data_times'][$iIndex]['title'] = $dDateCurrent;

      // Собираем потраченное время
      $oTime = new time();
      $oTime->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
      $oTime->query .= " AND `date` = '" . $dDateCurrent . "'";
      $oTime->query .= " AND `project_id` = '" . $iProjectId . "'";
      $arrData = $oTime->get();

      // Подготавливаем категории
      foreach ($arrCategories as $key => $arrCategory) {
        $arrResults['data_times'][$iIndex]['categories'][$key]['title'] = $arrCategory['title'];
        $arrResults['data_times'][$iIndex]['categories'][$key]['value'] = strtotime("00:00:00");
        $arrResults['data_times'][$iIndex]['categories'][$key]['color'] = $arrCategory['color'];
      }

      // Сумма
      $arrDaysTimes = [];

      // Записываем данные по категориям за неделю
      foreach ($arrData as & $arrDataItem) {
        $dDateReally = new DateTime($arrDataItem['time_really']);
        $arrTimesSum[] = $arrDaysTimes[] = $arrDataItem['time'] = $dDateReally->format('H:i:s');
        $arrResults['data_times'][$iIndex]['categories'][0]['value'] = $arrResults['data_times'][$iIndex]['categories'][0]['value'] + strtotime($arrDataItem['time']) - strtotime("00:00:00");
      }
      $arrResults['data_times'][$iIndex]['sum'] = $oTime->get_sum( $arrDaysTimes );

      $iIndex++;
    }

    // Заменяем значения дат на не роботские
    foreach ( $arrResults['data_times'] as & $arrDay ) {
      foreach ( $arrDay['categories'] as & $arrCategory ) {
        $arrCategory['value'] = date('H.i', $arrCategory['value']);
      }
    }

    // Создаём график
    $oChart = new chart();
    $oChart->arrDataset = $arrResults['data_times'];
    $oChart->arrCategories = $arrResults['time_categories'];
    $arrResults['chart_time'] = $oChart->show();

    // Деньги
    // __________
    // Получаем категории
    $arrCategories = [];
    $arrCategories[1] = array(
      'title' => 'Costs',
      'color' => '#dd3e3e'
    );
    $arrCategories[2] = array(
      'title' => 'Wages',
      'color' => '#4a8e61'
    );
    $arrResults['money_categories'] = $arrCategories;
    $arrResults['data_money'] = [];

    // Обработка данных

    if ( (int)$_REQUEST['week'] ) {
      $dDateStart = $dDateCurrent = date('Y-m-d', strtotime('last sunday -7 days'));
      $dDateStop = date('Y-m-d', strtotime('last sunday'));
    }
    else {
      $dDateStart = $dDateCurrent = date('Y-m-d', strtotime('monday this week'));
      $dDateStop = date('Y-m-d', strtotime('sunday this week'));
    }

    $iIndex = 1;
    while (strtotime($dDateCurrent) < strtotime($dDateStop)) {
      if ( $iIndex > 1 ) $dDateCurrent = date('Y-m-d', strtotime('+1 day', strtotime($dDateCurrent)));

      // Заполняем данные
      $arrResults['data_money'][$iIndex]['title'] = $dDateCurrent;

      // Собираем потраченное время
      $oMoney = new money();
      $oMoney->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
      $oMoney->query .= " AND `date` = '" . $dDateCurrent . "'";
      $oMoney->query .= " AND `project_id` = '" . $iProjectId . "'";
      $arrData = $oMoney->get();

      // Подготавливаем категории
      foreach ($arrCategories as $key => $arrCategory) {
        $arrResults['data_money'][$iIndex]['categories'][$key]['title'] = $arrCategory['title'];
        $arrResults['data_money'][$iIndex]['categories'][$key]['value'] = 0;
        $arrResults['data_money'][$iIndex]['categories'][$key]['color'] = $arrCategory['color'];
      }

      // Сумма
      $arrMoneySum = 0;

      // Записываем данные по категориям за неделю
      foreach ($arrData as & $arrDataItem) {
        $arrResults['data_money'][$iIndex]['categories'][$arrDataItem['type']]['value'] = (float)$arrResults['data_money'][$iIndex]['categories'][$arrDataItem['type']]['value'] + (float)$arrDataItem['price'];
        if ( (int)$arrDataItem['type'] == 2 ) $arrMoneySum = $arrMoneySum + (float)$arrDataItem['price'];
        if ( (int)$arrDataItem['type'] == 1 ) $arrMoneySum = $arrMoneySum - (float)$arrDataItem['price'];
      }

      $arrResults['data_money'][$iIndex]['sum'] = $arrMoneySum;
      $arrResults['money_sum'] = (float)$arrResults['money_sum'] + (float)$arrMoneySum;

      $iIndex++;
    }

    // Создаём график
    $oChart = new chart();
    $oChart->arrDataset = $arrResults['data_money'];
    $oChart->arrCategories = $arrResults['money_categories'];
    $arrResults['chart_money'] = $oChart->show();

    // Считаем за час
    $arrResults['time_sum'] = $oTime->get_sum( $arrTimesSum );
    $arrTime = explode(':',$arrResults['time_sum']);
    if ( (int)$arrTime[0] ) {
      $iTimeSum = $arrTime[0] + $arrTime[1] / 60;
      $arrResults['time_sum'] = $arrTime[0] . ':' . $arrTime[1];
    }

    if ( (int)$arrResults['money_sum'] ) {
      if ( (float)$iTimeSum > 1 ) { # Шобы не делить на нуль
        $arrResults['moneyforhour'] = $arrResults['money_sum'] / $iTimeSum;
        if ( (int)$arrResults['moneyforhour'] ) $arrResults['moneyforhour'] = number_format($arrResults['moneyforhour'], 2, '.', '');
      }
      $arrResults['money_sum'] = number_format($arrResults['money_sum'], 2, '.', '');
    }

    notification::success($arrResults);
    break;

  case 'analytics_month': # Вывод статистики за месяц
    $arrResults = [];
    $arrCategories = [];

    $iYear = (int)$_REQUEST['year'] ? $_REQUEST['year'] : date('Y');
    $iMonth = (int)$_REQUEST['month'] ? $_REQUEST['month'] : date('m');
    $iMonthDaysSum = cal_days_in_month(CAL_GREGORIAN, $iMonth, $iYear);
    $iProjectId = $_REQUEST['project_id'];

    // Время
    // __________
    // Получаем категории
    $arrCategories = [];
    $arrCategories[0] = array(
      'title' => 'Times',
      'color' => '#dd3e3e'
    );
    $arrResults['time_categories'] = $arrCategories;
    $arrResults['data_times'] = [];
    $arrTimesSum = [];

    // Суммы по месяцам
    for ($i=1; $i <= $iMonthDaysSum; $i++) {
      // Собираем потраченное время
      $oTime = new time();
      $oTime->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
      $oTime->query .= " AND `date` LIKE '" . $iYear . '-' . sprintf("%02d", $iMonth) . '-' . sprintf("%02d", $i) . "%'";
      $oTime->query .= " AND `project_id` = '" . $iProjectId . "'";
      $arrTimes = $oTime->get();

      // Подготавливаем категории
      foreach ($arrCategories as $key => $arrCategory) {
        $arrResults['data_times'][$i]['categories'][$key]['title'] = $arrCategory['title'];
        $arrResults['data_times'][$i]['categories'][$key]['value'] = '00:00:00';
        $arrResults['data_times'][$i]['categories'][$key]['color'] = $arrCategory['color'];
      }

      // Сумма
      $arrDaysTimes = [];

      foreach ($arrTimes as &$arrTime) {
        $dDateReally = new DateTime($arrTime['time_really']);
        $arrTimesSum[] = $arrDaysTimes[] = $arrTime['time'] = $dDateReally->format('H:i:s');
        if ( $arrResults['data_times'][$i]['categories'][0]['value'] == '00:00:00' ) $arrResults['data_times'][$i]['categories'][0]['value'] = $arrTime['time'];
        else $arrResults['data_times'][$i]['categories'][0]['value'] =  $oTime->get_sum( [$arrResults['data_times'][$i]['categories'][0]['value'], $arrTime['time']]);
      }
      $arrResults['data_times'][$i]['sum'] = $oTime->get_sum( $arrDaysTimes );
      $arrResults['data_times'][$i]['title'] = sprintf("%02d", $i);
    }

    // Заменяем значения дат на не роботские
    foreach ( $arrResults['data_times'] as & $arrMonth ) {
      foreach ( $arrMonth['categories'] as & $arrCategory ) {
        $arrTime = explode(':',$arrCategory['value']);
        $iTimeSum = $arrTime[0] . '.' . $arrTime[1];
        $arrCategory['value'] = $iTimeSum;
      }
    }

    // Создаём график
    $oChart = new chart();
    $oChart->arrDataset = $arrResults['data_times'];
    $oChart->arrCategories = $arrResults['time_categories'];
    $arrResults['chart_time'] = $oChart->show();

    // Деньги
    // __________
    // Получаем категории
    $arrCategories = [];
    $arrCategories[1] = array(
      'title' => 'Costs',
      'color' => '#dd3e3e'
    );
    $arrCategories[2] = array(
      'title' => 'Wages',
      'color' => '#4a8e61'
    );
    $arrResults['money_categories'] = $arrCategories;
    $arrResults['data_money'] = [];

    // Суммы по месяцам
    for ($i=1; $i <= $iMonthDaysSum; $i++) {
      $oMoney = new money();
      $oMoney->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
      $oMoney->query .= " AND `date` LIKE '" . $iYear . '-' . sprintf("%02d", $iMonth) . '-' . sprintf("%02d", $i) . "%'";
      $oMoney->query .= " AND `project_id` = '" . $iProjectId . "'";
      $arrMoneys = $oMoney->get();

      // Подготавливаем категории
      foreach ($arrCategories as $key => $arrCategory) {
        $arrResults['data_money'][$i]['categories'][$key]['title'] = $arrCategory['title'];
        $arrResults['data_money'][$i]['categories'][$key]['value'] = 0;
        $arrResults['data_money'][$i]['categories'][$key]['color'] = $arrCategory['color'];
      }

      // Заполняем данные
      $iMounthSum = 0;

      foreach ($arrMoneys as &$arrMoney) {
        $arrResults['data_money'][$i]['categories'][$arrMoney['type']]['value'] = (float)$arrResults['data_money'][$i]['categories'][$arrMoney['type']]['value'] + (float)$arrMoney['price'];
        if ( (int)$arrMoney['type'] == 2 ) $iMounthSum = $iMounthSum + (float)$arrMoney['price'];
        if ( (int)$arrMoney['type'] == 1 ) $iMounthSum = $iMounthSum - (float)$arrMoney['price'];
      }

      $arrResults['data_money'][$i]['sum'] = $iMounthSum;
      $arrResults['data_money'][$i]['title'] = sprintf("%02d", $i);
      $arrResults['money_sum'] = (float)$arrResults['money_sum'] + (float)$iMounthSum;
    }

    // Создаём график
    $oChart = new chart();
    $oChart->arrDataset = $arrResults['data_money'];
    $oChart->arrCategories = $arrResults['money_categories'];
    $arrResults['chart_money'] = $oChart->show();

    // Считаем за час
    $arrResults['time_sum'] = $oTime->get_sum( $arrTimesSum );
    $arrTime = explode(':',$arrResults['time_sum']);
    if ( $arrTime[0] ) {
      $iTimeSum = $arrTime[0] + $arrTime[1] / 60;
      $arrResults['time_sum'] = $arrTime[0] . ':' . $arrTime[1];
    }

    if ( (int)$arrResults['money_sum'] ) {
      if ( (float)$iTimeSum > 1 ) { # Шобы не делить на нуль
        $arrResults['moneyforhour'] = $arrResults['money_sum'] / $iTimeSum;
        if ( (int)$arrResults['moneyforhour'] ) $arrResults['moneyforhour'] = number_format($arrResults['moneyforhour'], 2, '.', '');
      }

      $arrResults['money_sum'] = number_format($arrResults['money_sum'], 2, '.', '');
    }

    notification::success($arrResults);
    break;

  case 'analytics_year': # Вывод статистики за год
    $arrResults = [];
    $arrCategories = [];

    $iYear = (int)$_REQUEST['year'] ? $_REQUEST['year'] : date('Y');
    $iProjectId = $_REQUEST['project_id'];

    // Время
    // __________
    // Получаем категории
    $arrCategories = [];
    $arrCategories[0] = array(
      'title' => 'Times',
      'color' => '#dd3e3e'
    );
    $arrResults['times_categories'] = $arrCategories;
    $arrResults['data_times'] = [];
    $arrTimesSum = [];

    // Суммы по месяцам
    for ($i=1; $i < 13; $i++) {
      $oTime = new time();
      $oTime->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
      $oTime->query .= " AND `date` LIKE '" . $iYear . '-' . sprintf("%02d", $i) . "%'";
      $oTime->query .= " AND `project_id` = '" . $iProjectId . "'";
      $arrTimes = $oTime->get();

      // Подготавливаем категории
      foreach ($arrCategories as $key => $arrCategory) {
        $arrResults['data_times'][$i]['categories'][$key]['title'] = $arrCategory['title'];
        $arrResults['data_times'][$i]['categories'][$key]['value'] = '00:00:00';
        $arrResults['data_times'][$i]['categories'][$key]['color'] = $arrCategory['color'];
      }

      // Сумма
      $arrMonthTimes = [];

      foreach ($arrTimes as &$arrTime) {
        $dDateReally = new DateTime($arrTime['time_really']);
        $arrTimesSum[] = $arrMonthTimes[] = $arrTime['time'] = $dDateReally->format('H:i:s');
        if ( $arrResults['data_times'][$i]['categories'][0]['value'] == '00:00:00' ) $arrResults['data_times'][$i]['categories'][0]['value'] = $arrTime['time'];
        else $arrResults['data_times'][$i]['categories'][0]['value'] =  $oTime->get_sum( [$arrResults['data_times'][$i]['categories'][0]['value'], $arrTime['time']]);
      }

      $arrResults['data_times'][$i]['sum'] = $oTime->get_sum( $arrMonthTimes );
      $arrResults['data_times'][$i]['title'] = date("F", strtotime($iYear . "-" . sprintf("%02d", $i)));
    }

    // Заменяем значения дат на не роботские
    foreach ( $arrResults['data_times'] as & $arrMonth ) {
      foreach ( $arrMonth['categories'] as & $arrCategory ) {
        $arrTime = explode(':',$arrCategory['value']);
        $iTimeSum = $arrTime[0] . '.' . $arrTime[1];
        $arrCategory['value'] = $iTimeSum;
      }
    }

    // Создаём график
    $oChart = new chart();
    $oChart->arrDataset = $arrResults['data_times'];
    $oChart->arrCategories = $arrResults['times_categories'];
    $arrResults['chart_time'] = $oChart->show();

    // Деньги
    // __________
    // Получаем категории
    $arrCategories = [];
    $arrCategories[1] = array(
      'title' => 'Costs',
      'color' => '#dd3e3e'
    );
    $arrCategories[2] = array(
      'title' => 'Wages',
      'color' => '#4a8e61'
    );
    $arrResults['money_categories'] = $arrCategories;
    $arrResults['data_money'] = [];

    // Суммы по месяцам
    for ($i=1; $i < 13; $i++) {
      $oMoney = new money();
      $oMoney->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
      $oMoney->query .= " AND `date` LIKE '" . $iYear . '-' . sprintf("%02d", $i) . "%'";
      $oMoney->query .= " AND `project_id` = '" . $iProjectId . "'";
      $arrMoneys = $oMoney->get();

      // Подготавливаем категории
      foreach ($arrCategories as $key => $arrCategory) {
        $arrResults['data_money'][$i]['categories'][$key]['title'] = $arrCategory['title'];
        $arrResults['data_money'][$i]['categories'][$key]['value'] = 0;
        $arrResults['data_money'][$i]['categories'][$key]['color'] = $arrCategory['color'];
      }

      // Заполняем данные
      $iMounthSum = 0;
      foreach ($arrMoneys as &$arrMoney) {
        $arrResults['data_money'][$i]['categories'][$arrMoney['type']]['value'] = (float)$arrResults['data_money'][$i]['categories'][$arrMoney['type']]['value'] + (float)$arrMoney['price'];
        if ( (int)$arrMoney['type'] == 2 ) $iMounthSum = $iMounthSum + (float)$arrMoney['price'];
        if ( (int)$arrMoney['type'] == 1 ) $iMounthSum = $iMounthSum - (float)$arrMoney['price'];
      }
      $arrResults['data_money'][$i]['sum'] = $iMounthSum;
      $arrResults['data_money'][$i]['title'] = date("F", strtotime($iYear . "-" . sprintf("%02d", $i)));
      $arrResults['money_sum'] = (float)$arrResults['money_sum'] + (float)$iMounthSum;
    }

    // Создаём график
    $oChart = new chart();
    $oChart->arrDataset = $arrResults['data_money'];
    $oChart->arrCategories = $arrResults['money_categories'];
    $arrResults['chart_money'] = $oChart->show();

    // Считаем за час
    $arrResults['time_sum'] = $oTime->get_sum( $arrTimesSum );
    $arrTime = explode(':',$arrResults['time_sum']);
    if ( (int)$arrTime[0] ) {
      $iTimeSum = $arrTime[0] + $arrTime[1] / 60;
      $arrResults['time_sum'] = $arrTime[0] . ':' . $arrTime[1];
    }

    if ( (int)$arrResults['money_sum'] ) {
      if ( (float)$iTimeSum > 1 ) { # Шобы не делить на нуль
        $arrResults['moneyforhour'] = $arrResults['money_sum'] / $iTimeSum;
        if ( (int)$arrResults['moneyforhour'] ) $arrResults['moneyforhour'] = number_format($arrResults['moneyforhour'], 2, '.', '');
      }

      $arrResults['money_sum'] = number_format($arrResults['money_sum'], 2, '.', '');
    }

    notification::success($arrResults);
    break;
}
