<?
switch ($_REQUEST['form']) {
  case 'analytics_week': # Вывод статистики за неделю
    $arrResults = [];
    $arrCategories = [];

    // Считаем неделю
    $arrWeek = [];
    $dDateStart = $dDateCurrent = date('Y-m-d', strtotime('monday this week'));
    $dDateStop = date('Y-m-d', strtotime('sunday this week'));
    $iProjectId = $_REQUEST['project_id'];

    // Получаем категории
    $arrCategories = [];
    $arrCategories[0] = array(
      'title' => 'Times',
      'color' => '#dd3e3e'
    );
    $arrResults['categories'] = $arrCategories;
    $arrResults['data'] = [];

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
      $oTime->query .= " AND `project_id` = '" . $iProjectId . "'";
      $arrData = $oTime->get();

      // Сумма
      $arrResultsSum = 0;

      // Подготавливаем категории
      foreach ($arrCategories as $key => $arrCategory) {
        $arrResults['data'][$iIndex]['categories'][$key]['title'] = $arrCategory['title'];
        $arrResults['data'][$iIndex]['categories'][$key]['value'] = 0;
        $arrResults['data'][$iIndex]['categories'][$key]['color'] = $arrCategory['color'];
      }

      // Записываем данные по категориям за неделю
      foreach ($arrData as & $arrDataItem) {
        $dDateReally = new DateTime($arrDataItem['time_really']);
        $arrDataItem['time'] = $dDateReally->format('H.i');
        $arrResults['data'][$iIndex]['categories'][0]['value'] = (float)$arrResults['data'][$iIndex]['categories'][0]['value'] + (float)$arrDataItem['time'];
        $arrResultsSum = $arrResultsSum + (float)$arrDataItem['time'];
      }

      $arrResults['data'][$iIndex]['sum'] = $arrResultsSum;
      $arrResults['sum'] = (float)$arrResults['sum'] + (float)$arrResultsSum;

      // Сумма
      $arrResultsTimesSum = 0;

      $iIndex++;
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

    $iYear = date('Y');
    $iMonth = date('m');
    $iMonthDaysSum = cal_days_in_month(CAL_GREGORIAN, $iMonth, $iYear);
    $iProjectId = $_REQUEST['project_id'];

    // Получаем категории
    $arrCategories = [];
    $arrCategories[0] = array(
      'title' => 'Times',
      'color' => '#dd3e3e'
    );
    $arrResults['categories'] = $arrCategories;
    $arrResults['data'] = [];

    // Суммы по месяцам
    for ($i=1; $i <= $iMonthDaysSum; $i++) {
      // Собираем потраченное время
      $oTime = new time();
      $oTime->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
      $oTime->query .= " AND `date` = '" . $dDateCurrent . "'";
      $oTime->query .= " AND `project_id` = '" . $iProjectId . "'";
      $arrTimes = $oTime->get();

      // Подготавливаем категории
      foreach ($arrCategories as $key => $arrCategory) {
        $arrResults['data'][$i]['categories'][$key]['title'] = $arrCategory['title'];
        $arrResults['data'][$i]['categories'][$key]['value'] = 0;
        $arrResults['data'][$i]['categories'][$key]['color'] = $arrCategory['color'];
      }

      // Заполняем данные
      $iMounthSum = 0;

      foreach ($arrTimes as &$arrTime) {
        $dDateReally = new DateTime($arrTime['time_really']);
        $arrTime['time'] = $dDateReally->format('H.i');
        $arrResults['data'][$i]['categories'][0]['value'] = (float)$arrResults['data'][$i]['categories'][0]['value'] + (float)$arrTime['time'];
        $iMounthSum = $iMounthSum + (float)$arrTime['time'];
      }
      $arrResults['data'][$i]['sum'] = $iMounthSum;
      $arrResults['data'][$i]['title'] = sprintf("%02d", $i);
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

    $iYear = date('Y');
    $iProjectId = $_REQUEST['project_id'];

    // Получаем категории
    $arrCategories = [];
    $arrCategories[0] = array(
      'title' => 'Times',
      'color' => '#dd3e3e'
    );
    $arrResults['categories'] = $arrCategories;
    $arrResults['data'] = [];

    // Суммы по месяцам
    for ($i=1; $i < 13; $i++) {
      $oTime = new time();
      $oTime->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
      $oTime->query .= " AND `date` LIKE '" . $iYear . '-' . sprintf("%02d", $i) . "%'";
      $oTime->query .= " AND `project_id` = '" . $iProjectId . "'";
      $arrTimes = $oTime->get();

      // Подготавливаем категории
      foreach ($arrCategories as $key => $arrCategory) {
        $arrResults['data'][$i]['categories'][$key]['title'] = $arrCategory['title'];
        $arrResults['data'][$i]['categories'][$key]['value'] = 0;
        $arrResults['data'][$i]['categories'][$key]['color'] = $arrCategory['color'];
      }

      // Заполняем данные
      $iMounthSum = 0;
      foreach ($arrTimes as &$arrTime) {
        $dDateReally = new DateTime($arrTime['time_really']);
        $arrTime['time'] = $dDateReally->format('H.i');
        $arrResults['data'][$i]['categories'][0]['value'] = (float)$arrResults['data'][$i]['categories'][0]['value'] + (float)$arrTime['time'];
        $iMounthSum = $iMounthSum + (float)$arrTime['time'];
      }
      $arrResults['data'][$i]['sum'] = $iMounthSum;
      $arrResults['data'][$i]['title'] = date("F", strtotime($iYear . "-" . sprintf("%02d", $i)));
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
