<?
function get_day ( $iDay = 0, $iMonth = 0, $iYear = 0 ) {
  $arrResult = [];

  // Получаем категории
  $oCategory = new category();
  $oCategory->limit = 0;
  $oCategory->sort = 'sort';
  $oCategory->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
  $arrCategories = $oCategory->get_categories();
  $arrCategoriesIds = [];
  foreach ($arrCategories as &$arrCategory) $arrCategoriesIds[$arrCategory['id']] = $arrCategory;

  $arrResult['day'] = $iDay;
  $arrResult['month'] = $iMonth;
  $arrResult['yaer'] = $iYear;

  // Собираем деньги
  $oMoney = new money();
  $oMoney->query .= ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
  $oMoney->query .= " AND `date` LIKE '" . $iYear . '-' . sprintf("%02d", $iMonth) . '-' . sprintf("%02d", $iDay) . "%'";
  $oMoney->query .= " AND `to_card` = '0'";
  $arrMoneys = $oMoney->get();
  $arrMoneysCategoriesIds = [];
  $iMoneysCategoriesSum = 0;
  foreach ($arrMoneys as $arrMoney) {
    $arrMoneysCategoriesIds[$arrMoney['category']]['elems'] = $arrMoney;
    if ( (int)$arrMoney['type'] == 1 ) {
      $arrMoneysCategoriesIds[$arrMoney['category']]['sum'] = (float)$arrMoneysCategoriesIds[$arrMoney['category']]['sum'] - (float)$arrMoney['price'];
      $iMoneysCategoriesSum = (float)$iMoneysCategoriesSum - (float)$arrMoney['price'];
    }
    if ( (int)$arrMoney['type'] == 2 ) {
      $arrMoneysCategoriesIds[$arrMoney['category']]['sum'] = (float)$arrMoneysCategoriesIds[$arrMoney['category']]['sum'] + (float)$arrMoney['price'];
      $iMoneysCategoriesSum = (float)$iMoneysCategoriesSum + (float)$arrMoney['price'];
    }
  }

  // Собираем время
  $oTime = new time();
  $oTime->query .= ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
  $oTime->query .= " AND `date` LIKE '" . $iYear . '-' . sprintf("%02d", $iMonth) . '-' . sprintf("%02d", $iDay) . "%'";
  $arrTimes = $oTime->get();
  $arrTimesCategoriesIds = [];
  $arrTimesSum = [];
  foreach ($arrTimes as $arrTime) {
    $arrTimesCategoriesIds[$arrTime['category_id']]['elems'] = $arrTime;

    $dDateReally = new DateTime($arrTime['time_really']);
    $arrTimesSum[] = $arrDataItem = $dDateReally->format('H:i:s');
    if ( ! isset($arrTimesCategoriesIds[$arrTime['category_id']]['sum']) ) $arrTimesCategoriesIds[$arrTime['category_id']]['sum'] = $arrDataItem;
    else $arrTimesCategoriesIds[$arrTime['category_id']]['sum'] =  $oTime->get_sum( [$arrTimesCategoriesIds[$arrTime['category_id']]['sum'], $arrDataItem] );
  }
  $iTimesCategoriesSum = floor($oTime->get_sum( $arrTimesSum ));

  // Пакуем по категориям
  $oLang = new lang();
  foreach ($arrCategoriesIds as $arrCategory) {
    $arrResult['categories'][$arrCategory['id']]['title'] = $oLang->get( $arrCategory['title'] );
    $arrResult['categories'][$arrCategory['id']]['color'] = $arrCategory['color'];
    $arrResult['categories'][$arrCategory['id']]['moneys'] = $arrMoneysCategoriesIds[$arrCategory['id']];
    $arrResult['categories'][$arrCategory['id']]['times'] = $arrTimesCategoriesIds[$arrCategory['id']];
  }

  if ( $iMoneysCategoriesSum ) $arrResult['moneys_sum'] = round($iMoneysCategoriesSum);
  else $arrResult['moneys_sum'] = 0;

  $arrResult['times_sum'] = $iTimesCategoriesSum;

  return $arrResult;
}

switch ($_REQUEST['form']) {
  case 'analytics': # Вывод статистики
    $arrResults = [];
    $arrCategories = [];

    $oFrom = 0;
    $oLimit = 10;
    if ( $_REQUEST['from'] ) $oFrom = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oLimit = $_REQUEST['limit'];

    // Получаем категории
    $oCategory = new category();
    $oCategory->limit = 0;
    $oCategory->sort = 'sort';
    $oCategory->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $arrCategories = $oCategory->get_categories();
    $arrCategoriesIds = [];
    foreach ($arrCategories as &$arrCategory) $arrCategoriesIds[$arrCategory['id']] = $arrCategory;

    // Разбивка по дням
    $iDay = (int)$_REQUEST['day'] ? $_REQUEST['day'] : date('d');
    $iYear = (int)$_REQUEST['year'] ? $_REQUEST['year'] : date('Y');
    $iMonth = (int)$_REQUEST['month'] ? $_REQUEST['month'] : date('m');
    $iMonthDaysSum = cal_days_in_month(CAL_GREGORIAN, $iMonth, $iYear);
    $iMonthDaysLast = (int)$iMonthDaysSum - (int)$iDay;

    // Заполняем дни
    $iDay = 20;
    $arrResults = get_day( $arrCategoriesIds, $iDay, $iMonth, $iYear );

    // Выводим текущий день
    notification::send( $arrResults );
    break;

  case 'get_day':
    $arrResults = [];

    // Разбивка по дням
    $iDay = (int)$_REQUEST['day'] ? $_REQUEST['day'] : date('d');
    $iYear = (int)$_REQUEST['year'] ? $_REQUEST['year'] : date('Y');
    $iMonth = (int)$_REQUEST['month'] ? $_REQUEST['month'] : date('m');
    $arrResults = get_day( $iDay, $iMonth, $iYear );

    // Выводим текущий день
    notification::send( $arrResults );
    break;

  case 'prev_day':
    $arrResults = [];

    // Разбивка по дням
    $iCurrentDay = (int)$_REQUEST['day'] ? $_REQUEST['day'] : date('d');
    $iCurrentYear = (int)$_REQUEST['year'] ? $_REQUEST['year'] : date('Y');
    $iCurrentMonth = (int)$_REQUEST['month'] ? $_REQUEST['month'] : date('m');

    $iDay = date('d', strtotime('-1 day', strtotime($iCurrentDay . '-' . $iCurrentMonth . '-' . $iCurrentYear)));
    $iMonth = date('m', strtotime('-1 day', strtotime($iCurrentDay . '-' . $iCurrentMonth . '-' . $iCurrentYear)));
    $iYear = date('Y', strtotime('-1 day', strtotime($iCurrentDay . '-' . $iCurrentMonth . '-' . $iCurrentYear)));

    $arrResults = get_day( $iDay, $iMonth, $iYear );

    // Выводим текущий день
    notification::send( $arrResults );
    break;
}
