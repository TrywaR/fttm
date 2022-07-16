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
    $oCategory = new category();
    $oCategory->limit = 0;
    $oCategory->sortname = 'sort';
    $oCategory->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $arrCategories = $oCategory->get_categories();
    $arrCategoriesIds = [];
    foreach ($arrCategories as &$arrCategory) $arrCategoriesIds[$arrCategory['id']] = $arrCategory;

    $arrResults['categories'] = $arrCategoriesIds;
    $arrResults['data'] = [];

    // Обработка данных
    $iIndex = 1;
    while (strtotime($dDateCurrent) < strtotime($dDateStop)) {
      if ( $iIndex > 1 ) $dDateCurrent = date('Y-m-d', strtotime('+1 day', strtotime($dDateCurrent)));

      // Заполняем данные
      $arrResults['data'][$iIndex]['title'] = $dDateCurrent;

      // Собираем потраченное время
      $oMoney = new money();
      $oMoney->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
      $oMoney->query .= " AND `date` = '" . $dDateCurrent . "'";
      if ( isset($_REQUEST['money_type']) ) $oMoney->query .= " AND `type` = '" . $_REQUEST['money_type'] . "'";
      if ( isset($_REQUEST['money_to_card']) ) $oMoney->query .= " AND `to_card` = '" . $_REQUEST['money_to_card'] . "'";
      $arrData = $oMoney->get();

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
        $arrResults['data'][$iIndex]['categories'][$arrDataItem['category']]['value'] = (float)$arrResults['data'][$iIndex]['categories'][$arrDataItem['category']]['value'] + (float)$arrDataItem['price'];
        $arrResultsSum = $arrResultsSum + (float)$arrDataItem['price'];
      }

      $arrResults['data'][$iIndex]['sum'] = $arrResultsSum;
      $arrResults['sum'] = floor((float)$arrResults['sum'] + (float)$arrResultsSum);

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
    if ( $_REQUEST['sChartScaleStackedX'] ) $oChart->sChartScaleStackedX = $_REQUEST['sChartScaleStackedX'];
    if ( $_REQUEST['sChartScaleStackedY'] ) $oChart->sChartScaleStackedY = $_REQUEST['sChartScaleStackedY'];

    $arrResults['chart'] = $oChart->show();
    // $arrResults['chart_sum'] = $oChart->show_sum();

    notification::success($arrResults);
    break;

  case 'analytics_month': # Вывод статистики за месяц
    $arrResults = [];
    $arrCategories = [];

    $iYear = (int)$_REQUEST['year'] ? $_REQUEST['year'] : date('Y');
    $iMonth = (int)$_REQUEST['month'] ? $_REQUEST['month'] : date('m');
    $iMonthDaysSum = cal_days_in_month(CAL_GREGORIAN, $iMonth, $iYear);

    // Получаем категории
    $oCategory = new category();
    $oCategory->limit = 0;
    $oCategory->sortname = 'sort';
    $oCategory->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $arrCategories = $oCategory->get_categories();
    $arrCategoriesIds = [];
    foreach ($arrCategories as &$arrCategory) $arrCategoriesIds[$arrCategory['id']] = $arrCategory;

    $arrResults['categories'] = $arrCategoriesIds;
    $arrResults['data'] = [];

    // Суммы по месяцам
    for ($i=1; $i <= $iMonthDaysSum; $i++) {
      $oMoney = new money();
      $oMoney->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
      $oMoney->query .= " AND `date` LIKE '" . $iYear . '-' . sprintf("%02d", $iMonth) . '-' . sprintf("%02d", $i) . "%'";
      if ( isset($_REQUEST['money_type']) ) $oMoney->query .= " AND `type` = '" . $_REQUEST['money_type'] . "'";
      if ( isset($_REQUEST['money_to_card']) ) $oMoney->query .= " AND `to_card` = '" . $_REQUEST['money_to_card'] . "'";
      $arrMoneys = $oMoney->get();

      // Подготавливаем категории
      foreach ($arrCategories as $key => $arrCategory) {
        $arrResults['data'][$i]['categories'][$key]['title'] = $arrCategory['title'];
        $arrResults['data'][$i]['categories'][$key]['value'] = 0;
        $arrResults['data'][$i]['categories'][$key]['color'] = $arrCategory['color'];
      }

      // Заполняем данные
      $iMounthSum = 0;

      foreach ($arrMoneys as &$arrMoney) {
        $arrResults['data'][$i]['categories'][$arrMoney['category']]['value'] = (float)$arrResults['data'][$i]['categories'][$arrMoney['category']]['value'] + (float)$arrMoney['price'];
        $iMounthSum = $iMounthSum + (float)$arrMoney['price'];
      }
      $arrResults['data'][$i]['sum'] = $iMounthSum;
      $arrResults['data'][$i]['title'] = sprintf("%02d", $i);
      $arrResults['sum'] = floor((float)$arrResults['sum'] + (float)$iMounthSum);
    }

    // Создаём график
    $oChart = new chart();
    $oChart->arrDataset = $arrResults['data'];
    $oChart->arrCategories = $arrResults['categories'];
    // $oChart->sChartScaleY;

    if ( $_REQUEST['chart_type'] ) $oChart->sChartType = $_REQUEST['chart_type'];
    if ( $_REQUEST['chart_type_sum'] ) $oChart->sChartTypeSum = $_REQUEST['chart_type_sum'];
    if ( $_REQUEST['sChartScaleX'] ) $oChart->sChartScaleX = $_REQUEST['sChartScaleX'];
    if ( $_REQUEST['sChartScaleY'] ) $oChart->sChartScaleY = $_REQUEST['sChartScaleY'];
    if ( $_REQUEST['sChartScaleStackedX'] ) $oChart->sChartScaleStackedX = $_REQUEST['sChartScaleStackedX'];
    if ( $_REQUEST['sChartScaleStackedY'] ) $oChart->sChartScaleStackedY = $_REQUEST['sChartScaleStackedY'];

    $arrResults['chart'] = $oChart->show();
    // $arrResults['chart_sum'] = $oChart->show_sum();

    notification::success($arrResults);
    break;

  case 'analytics_year': # Вывод статистики за год
    $arrResults = [];
    $arrCategories = [];

    $iYear = (int)$_REQUEST['year'] ? $_REQUEST['year'] : date('Y');

    // Получаем категории
    $oCategory = new category();
    $oCategory->limit = 0;
    $oCategory->sortname = 'sort';
    $oCategory->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $arrCategories = $oCategory->get_categories();
    $arrCategoriesIds = [];
    foreach ($arrCategories as &$arrCategory) $arrCategoriesIds[$arrCategory['id']] = $arrCategory;

    $arrResults['categories'] = $arrCategoriesIds;
    $arrResults['data'] = [];

    // Суммы по месяцам
    for ($i=1; $i < 13; $i++) {
      $oMoney = new money();
      $oMoney->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
      $oMoney->query .= " AND `date` LIKE '" . $iYear . '-' . sprintf("%02d", $i) . "%'";
      if ( isset($_REQUEST['money_type']) ) $oMoney->query .= " AND `type` = '" . $_REQUEST['money_type'] . "'";
      if ( isset($_REQUEST['money_to_card']) ) $oMoney->query .= " AND `to_card` = '" . $_REQUEST['money_to_card'] . "'";
      $arrMoneys = $oMoney->get();

      // Подготавливаем категории
      foreach ($arrCategories as $key => $arrCategory) {
        $arrResults['data'][$i]['categories'][$key]['title'] = $arrCategory['title'];
        $arrResults['data'][$i]['categories'][$key]['value'] = 0;
        $arrResults['data'][$i]['categories'][$key]['color'] = $arrCategory['color'];
      }

      // Заполняем данные
      $iMounthSum = 0;
      foreach ($arrMoneys as &$arrMoney) {
        $arrResults['data'][$i]['categories'][$arrMoney['category']]['value'] = (float)$arrResults['data'][$i]['categories'][$arrMoney['category']]['value'] + (float)$arrMoney['price'];
        $iMounthSum = $iMounthSum + (float)$arrMoney['price'];
      }
      $arrResults['data'][$i]['sum'] = $iMounthSum;
      $arrResults['data'][$i]['title'] = date("F", strtotime($iYear . "-" . sprintf("%02d", $i)));
      $arrResults['sum'] = floor((float)$arrResults['sum'] + (float)$iMounthSum);
    }

    // Создаём график
    $oChart = new chart();
    $oChart->arrDataset = $arrResults['data'];
    $oChart->arrCategories = $arrResults['categories'];
    if ( $_REQUEST['chart_type'] ) $oChart->sChartType = $_REQUEST['chart_type'];
    if ( $_REQUEST['chart_type_sum'] ) $oChart->sChartTypeSum = $_REQUEST['chart_type_sum'];
    if ( $_REQUEST['sChartScaleX'] ) $oChart->sChartScaleX = $_REQUEST['sChartScaleX'];
    if ( $_REQUEST['sChartScaleY'] ) $oChart->sChartScaleY = $_REQUEST['sChartScaleY'];
    if ( $_REQUEST['sChartScaleStackedX'] ) $oChart->sChartScaleStackedX = $_REQUEST['sChartScaleStackedX'];
    if ( $_REQUEST['sChartScaleStackedY'] ) $oChart->sChartScaleStackedY = $_REQUEST['sChartScaleStackedY'];

    $arrResults['chart'] = $oChart->show();
    // $arrResults['chart_sum'] = $oChart->show_sum();

    notification::success($arrResults);
    break;

  case 'analytics': # Общая инфа
    $arrResults = [];

    // Категории которые не отнимать
    $oCategory = new category();
    $oCategory->limit = 0;
    $oCategory->sortname = 'sort';
    $oCategory->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $oCategory->query .= " AND `type` = 0";
    $arrCategories = $oCategory->get_categories();
    $arrCategoriesIds = [];
    foreach ($arrCategories as $arrCategory) $arrCategoriesIds[$arrCategory['id']] = $arrCategory;

    // День
    $dDay = date("Y-m-d", strtotime("-1 DAY"));

    // Потрачено за день
    $oMoney = new money();
    $oMoney->sortname = 'date';
    $oMoney->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $oMoney->query .= " AND `date` LIKE '" . $dDay . "%' AND `type` = '1' ";
    $arrMoneys = $oMoney->get_money();
    $iDaySumm = 0;
    foreach ($arrMoneys as $arrMoney) if ( isset($arrCategoriesIds[$arrMoney['category']]) ) $iDaySumm = (int)$arrMoney['price'] + (int)$iDaySumm;
    $arrResults['iDaySumm'] = number_format($iDaySumm, 2, '.', ' ');

    // Пришло за день
    $oMoney = new money();
    $oMoney->sortname = 'date';
    $oMoney->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $oMoney->query .= " AND `date` LIKE '" . $dDay . "%' AND `type` = '2' ";
    $arrMoneys = $oMoney->get_money();
    $iDaySummPlus = 0;
    foreach ($arrMoneys as $arrMoney) $iDaySummPlus = (int)$arrMoney['price'] + (int)$iDaySummPlus;
    $arrResults['iDaySummPlus'] = number_format($iDaySummPlus, 2, '.', ' ');

    // Месяц
    $iYear = (int)$_REQUEST['year'] ? $_REQUEST['year'] : date('Y');
    $iMonth = (int)$_REQUEST['month'] ? $_REQUEST['month'] : date('m');
    $dMonth = $iYear . '-' . sprintf("%02d", $iMonth);

    // За месяц ушло
    $oMoney = new money();
    $oMoney->sortname = 'date';
    $oMoney->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $oMoney->query .= " AND `date` LIKE '" . $dMonth . "%' AND `type` = '1' ";
    $oMoney->query .= " AND `to_card` = '0' ";
    $arrMoneys = $oMoney->get_money();
    $iMonthSum = 0;
    foreach ($arrMoneys as $arrMoney) if ( isset($arrCategoriesIds[$arrMoney['category']]) ) $iMonthSum = (int)$arrMoney['price'] + (int)$iMonthSum;
    $arrResults['iMonthSum'] = number_format($iMonthSum, 2, '.', ' ');

    // За месяц пришло
    $oMoney = new money();
    $oMoney->sortname = 'date';
    $dCurrentDate = date('Y-m');
    $oMoney->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $oMoney->query .= " AND `date` LIKE '" . $dMonth . "%' AND `type` = '2' ";
    $arrMoneys = $oMoney->get_money();
    $iMonthSumSalary = 0;
    foreach ($arrMoneys as $arrMoney) $iMonthSumSalary = (int)$arrMoney['price'] + (int)$iMonthSumSalary;
    $arrResults['iMonthSumSalary'] = number_format($iMonthSumSalary, 2, '.', ' ');

    $arrResults['balance'] = number_format($iMonthSumSalary-$iMonthSum, 2, '.', ' ');

    notification::success( $arrResults );
    break;
}
