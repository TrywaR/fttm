<?
switch ($_REQUEST['form']) {
  case 'analytics_week': # Вывод статистики за неделю
    $arrResults = [];
    $arrCategories = [];
    $arrWeek = [];

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

    // Получаем категории
    $oTimesCategory = new times_category();
    $oTimesCategory->limit = 0;
    $oTimesCategory->sort = 'sort';
    $oTimesCategory->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $arrTimesCategories = $oTimesCategory->get();
    foreach ($arrTimesCategories as &$arrTimesCategory) $arrCategories[$arrTimesCategory['id']] = $arrTimesCategory;

    $arrResults['categories'] = $arrCategories;
    $arrResults['data'] = [];
    $arrTimesSum = [];

    // Обработка данных
    $iIndex = 1;
    while (strtotime($dDateCurrent) < strtotime($dDateStop)) {
      if ( $iIndex > 1 ) $dDateCurrent = date('Y-m-d', strtotime('+1 day', strtotime($dDateCurrent)));

      // Заполняем данные
      $arrResults['data'][$iIndex]['title'] = $dDateCurrent;

      // Собираем потраченное время
      $oTime = new time();
      $oTime->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
      $oTime->query .= " AND `date` = '" . $dDateCurrent . "'";
      $arrData = $oTime->get();

      // Сумма
      $arrDaysTimes = [];

      // Подготавливаем категории
      foreach ($arrCategories as $key => $arrCategory) {
        $arrResults['data'][$iIndex]['categories'][$key]['title'] = $arrCategory['title'];
        $arrResults['data'][$iIndex]['categories'][$key]['value'] = '00:00:00';
        $arrResults['data'][$iIndex]['categories'][$key]['color'] = $arrCategory['color'];
      }

      // Записываем данные по категориям за неделю
      foreach ($arrData as & $arrDataItem) {
        $dDateReally = new DateTime($arrDataItem['time_really']);
        $arrTimesSum[] = $arrDaysTimes[] = $arrDataItem['time'] = $dDateReally->format('H:i:s');
        if ( $arrResults['data'][$iIndex]['categories'][$arrDataItem['category_id']]['value'] == '00:00:00' ) $arrResults['data'][$iIndex]['categories'][$arrDataItem['category_id']]['value'] = $arrDataItem['time'];
        else $arrResults['data'][$iIndex]['categories'][$arrDataItem['category_id']]['value'] =  $oTime->get_sum( [$arrResults['data'][$iIndex]['categories'][$arrDataItem['category_id']]['value'], $arrDataItem['time']]);
      }

      $arrResults['data'][$iIndex]['sum'] = $oTime->get_sum( $arrDaysTimes );

      $iIndex++;
    }

    // Заменяем значения дат на не роботские
    foreach ( $arrResults['data'] as & $arrMonth ) {
      $arrTime = explode(':',$arrMonth['sum']);
      $iTimeSum = $arrTime[0] . '.' . $arrTime[1];
      $arrMonth['sum'] = $iTimeSum;

      foreach ( $arrMonth['categories'] as & $arrCategory ) {
        $arrTime = explode(':',$arrCategory['value']);
        $iTimeSum = $arrTime[0] . '.' . $arrTime[1];
        $arrCategory['value'] = $iTimeSum;
      }
    }

    // Создаём график
    $oChart = new chart();
    $oChart->arrDataset = $arrResults['data'];
    $oChart->arrCategories = $arrResults['categories'];
    if ( $_REQUEST['chart_type'] ) $oChart->sChartType = $_REQUEST['chart_type'];
    if ( $_REQUEST['chart_type_sum'] ) $oChart->sChartTypeSum = $_REQUEST['chart_type_sum'];
    if ( $_REQUEST['sChartScaleX'] ) $oChart->sChartScaleX = $_REQUEST['sChartScaleX'];
    if ( $_REQUEST['sChartScaleY'] ) $oChart->sChartScaleY = $_REQUEST['sChartScaleY'];

    $arrResults['chart'] = $oChart->show();
    $arrResults['chart_sum'] = $oChart->show_sum();

    notification::success($arrResults);
    break;

  case 'analytics_month': # Вывод статистики за месяц
    $arrResults = [];
    $arrCategories = [];

    $iYear = (int)$_REQUEST['year'] ? $_REQUEST['year'] : date('Y');
    $iMonth = (int)$_REQUEST['month'] ? $_REQUEST['month'] : date('m');
    $iMonthDaysSum = cal_days_in_month(CAL_GREGORIAN, $iMonth, $iYear);

    // Получаем категории
    $oTimesCategory = new times_category();
    $oTimesCategory->limit = 0;
    $oTimesCategory->sort = 'sort';
    $oTimesCategory->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $arrTimesCategories = $oTimesCategory->get();
    foreach ($arrTimesCategories as &$arrTimesCategory) $arrCategories[$arrTimesCategory['id']] = $arrTimesCategory;

    $arrResults['categories'] = $arrCategories;
    $arrResults['data'] = [];
    $arrTimesSum = [];

    // Суммы по месяцам
    for ($i=1; $i <= $iMonthDaysSum; $i++) {
      $oTime = new time();
      $oTime->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
      $oTime->query .= " AND `date` LIKE '" . $iYear . '-' . sprintf("%02d", $iMonth) . '-' . sprintf("%02d", $i) . "%'";
      $arrTimes = $oTime->get();

      // Подготавливаем категории
      foreach ($arrCategories as $key => $arrCategory) {
        $arrResults['data'][$i]['categories'][$key]['title'] = $arrCategory['title'];
        $arrResults['data'][$i]['categories'][$key]['value'] = '00:00:00';
        $arrResults['data'][$i]['categories'][$key]['color'] = $arrCategory['color'];
      }

      // Сумма
      $arrDaysTimes = [];

      foreach ($arrTimes as &$arrTime) {
        $dDateReally = new DateTime($arrTime['time_really']);
        $arrTimesSum[] = $arrDaysTimes[] = $arrTime['time'] = $dDateReally->format('H:i:s');
        if ( $arrResults['data'][$i]['categories'][$arrTime['category_id']]['value'] == '00:00:00' ) $arrResults['data'][$i]['categories'][$arrTime['category_id']]['value'] = $arrTime['time'];
        else $arrResults['data'][$i]['categories'][$arrTime['category_id']]['value'] =  $oTime->get_sum( [$arrResults['data'][$i]['categories'][$arrTime['category_id']]['value'], $arrTime['time']]);
      }

      $arrResults['data'][$i]['sum'] = $oTime->get_sum( $arrDaysTimes );
      $arrResults['data'][$i]['title'] = sprintf("%02d", $i);
    }

    // Заменяем значения дат на не роботские
    foreach ( $arrResults['data'] as & $arrMonth ) {
      $arrTime = explode(':',$arrMonth['sum']);
      $iTimeSum = $arrTime[0] . '.' . $arrTime[1];
      $arrMonth['sum'] = $iTimeSum;

      foreach ( $arrMonth['categories'] as & $arrCategory ) {
        $arrTime = explode(':',$arrCategory['value']);
        $iTimeSum = $arrTime[0] . '.' . $arrTime[1];
        $arrCategory['value'] = $iTimeSum;
      }
    }

    // Создаём график
    $oChart = new chart();
    $oChart->arrDataset = $arrResults['data'];
    $oChart->arrCategories = $arrResults['categories'];
    // $oChart->sChartScaleY;

    $arrResults['chart'] = $oChart->show();
    $arrResults['chart_sum'] = $oChart->show_sum();

    notification::success($arrResults);
    break;

  case 'analytics_year': # Вывод статистики за год
    $arrResults = [];
    $arrCategories = [];

    $iYear = (int)$_REQUEST['year'] ? $_REQUEST['year'] : date('Y');

    // Получаем категории
    $oTimesCategory = new times_category();
    $oTimesCategory->limit = 0;
    $oTimesCategory->sort = 'sort';
    $oTimesCategory->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $arrTimesCategories = $oTimesCategory->get();
    foreach ($arrTimesCategories as &$arrTimesCategory) $arrCategories[$arrTimesCategory['id']] = $arrTimesCategory;

    $arrResults['categories'] = $arrCategories;
    $arrResults['data'] = [];
    $arrTimesSum = [];

    // Суммы по месяцам
    for ($i=1; $i < 13; $i++) {
      $oTime = new time();
      $oTime->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
      $oTime->query .= " AND `date` LIKE '" . $iYear . '-' . sprintf("%02d", $i) . "%'";
      $arrTimes = $oTime->get();

      // Подготавливаем категории
      foreach ($arrCategories as $key => $arrCategory) {
        $arrResults['data'][$i]['categories'][$key]['title'] = $arrCategory['title'];
        $arrResults['data'][$i]['categories'][$key]['value'] = '00:00:00';
        $arrResults['data'][$i]['categories'][$key]['color'] = $arrCategory['color'];
      }

      // Сумма
      $arrMonthTimes = [];

      foreach ($arrTimes as &$arrTime) {
        $dDateReally = new DateTime($arrTime['time_really']);
        $arrTimesSum[] = $arrMonthTimes[] = $arrTime['time'] = $dDateReally->format('H:i:s');
        if ( $arrResults['data'][$i]['categories'][$arrTime['category_id']]['value'] == '00:00:00' ) $arrResults['data'][$i]['categories'][$arrTime['category_id']]['value'] = $arrTime['time'];
        else $arrResults['data'][$i]['categories'][$arrTime['category_id']]['value'] =  $oTime->get_sum( [$arrResults['data'][$i]['categories'][$arrTime['category_id']]['value'], $arrTime['time']]);
      }

      $arrResults['data'][$i]['sum'] = $oTime->get_sum( $arrMonthTimes );
      $arrResults['data'][$i]['title'] = date("F", strtotime($iYear . "-" . sprintf("%02d", $i)));
    }

    // Заменяем значения дат на не роботские
    foreach ( $arrResults['data'] as & $arrMonth ) {
      $arrTime = explode(':',$arrMonth['sum']);
      $iTimeSum = $arrTime[0] . '.' . $arrTime[1];
      $arrMonth['sum'] = $iTimeSum;

      foreach ( $arrMonth['categories'] as & $arrCategory ) {
        $arrTime = explode(':',$arrCategory['value']);
        $iTimeSum = $arrTime[0] . '.' . $arrTime[1];
        $arrCategory['value'] = $iTimeSum;
      }
    }

    // Создаём график
    $oChart = new chart();
    $oChart->arrDataset = $arrResults['data'];
    $oChart->arrCategories = $arrResults['categories'];
    if ( $_REQUEST['chart_type'] ) $oChart->sChartType = $_REQUEST['chart_type'];
    if ( $_REQUEST['chart_type_sum'] ) $oChart->sChartTypeSum = $_REQUEST['chart_type_sum'];
    if ( $_REQUEST['sChartScaleX'] ) $oChart->sChartScaleX = $_REQUEST['sChartScaleX'];
    if ( $_REQUEST['sChartScaleY'] ) $oChart->sChartScaleY = $_REQUEST['sChartScaleY'];

    $arrResults['chart'] = $oChart->show();
    $arrResults['chart_sum'] = $oChart->show_sum();

    notification::success($arrResults);
    break;
}
