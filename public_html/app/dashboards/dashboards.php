<?
function get_day ( $iDay = 0, $iMonth = 0, $iYear = 0 ) {
  $arrResult = [];

  // Получаем категории
  $oCategory = new category();
  $oCategory->limit = 0;
  $oCategory->sortname = 'sort';
  $oCategory->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
  $arrCategories = $oCategory->get_categories();
  $arrCategoriesIds = [];
  foreach ($arrCategories as &$arrCategory) $arrCategoriesIds[$arrCategory['id']] = $arrCategory;

  $arrResult['day'] = sprintf("%02d", $iDay);
  $arrResult['month'] = sprintf("%02d", $iMonth);
  $arrResult['year'] = (int)$iYear;

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

  case 'cards':
    $arrResults = [];

    $oCard = new card();
    $oCard->sortname = 'sort';
    $oCard->sortdir = 'ASC';
    $oCard->query .= ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $arrResults['cards'] = $oCard->get_cards();

    $iBalance = 0;
    foreach ( $arrResults['cards'] as & $arrCard ) $iBalance = (int)$iBalance + (int)$arrCard['balance'];
    if ( (int)$iBalance > 0 ) floor($iBalance);
    $arrResults['balance'] = $iBalance;

    notification::send($arrResults);
    break;

  case 'main':
    $arrResults = [];

    // Месяц
    $iYear = (int)$_REQUEST['year'] ? $_REQUEST['year'] : date('Y');
    $iMonth = (int)$_REQUEST['month'] ? $_REQUEST['month'] : date('m');
    $dMonth = $iYear . '-' . sprintf("%02d", $iMonth);

    // Получаем категории
    $oCategory = new category();
    $oCategory->limit = 0;
    $oCategory->sortname = 'sort';
    $oCategory->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $arrCategories = $oCategory->get();
    $arrCategoriesIds = [];
    foreach ($arrCategories as &$arrCategory) $arrCategoriesIds[$arrCategory['id']] = $arrCategory;
    // Подготавливаем категории
    foreach ($arrCategoriesIds as $key => $arrCategory) {
      $arrResults['categories'][$key]['title'] = $arrCategory['title'];
      $arrResults['categories'][$key]['value'] = '00:00:00';
      $arrResults['categories'][$key]['color'] = $arrCategory['color'];
    }

    // Время
    $arrMonthTimes = [];
    $oTime = new time();
    $oTime->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $oTime->query .= " AND `date` LIKE '" . $dMonth . "%'";
    $arrTimes = $oTime->get();
    foreach ($arrTimes as &$arrTime) {
      $dDateReally = new DateTime($arrTime['time_really']);
      $arrTimesSum[] = $arrMonthTimes[] = $arrTime['time'] = $dDateReally->format('H:i:s');
      if ( $arrResults['categories'][$arrTime['category_id']]['times']['value'] == '00:00:00' ) $arrResults['categories'][$arrTime['category_id']]['times']['value'] = $arrTime['time'];
      else $arrResults['categories'][$arrTime['category_id']]['times']['value'] =  $oTime->get_sum( [$arrResults['categories'][$arrTime['category_id']]['times']['value'], $arrTime['time']]);
    }
    $arrResults['times']['works'] = $arrResults['categories'][4]['times']['value'];
    $arrResults['times']['sum'] = $oTime->get_sum( $arrMonthTimes );

    // За месяц ушло
    $oMoney = new money();
    $oMoney->sortname = 'date';
    $oMoney->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $oMoney->query .= " AND `date` LIKE '" . $dMonth . "%' AND `type` = '1' ";
    $oMoney->query .= " AND `to_card` = '0' ";
    $arrMoneys = $oMoney->get();
    $iMonthSumm = 0;
    foreach ($arrMoneys as $arrMoney) $iMonthSumm = (int)$arrMoney['price'] + (int)$iMonthSumm;
    $arrResults['moneys']['costs'] = number_format($iMonthSumm, 2, '.', ' ');

    // За месяц пришло
    $oMoney = new money();
    $oMoney->sortname = 'date';
    $dCurrentDate = date('Y-m');
    $oMoney->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $oMoney->query .= " AND `date` LIKE '" . $dMonth . "%' AND `type` = '2' ";
    $arrMoneys = $oMoney->get();
    $iMonthSummSalary = 0;
    $iMonthSummSalaryWork = 0;
    foreach ($arrMoneys as $arrMoney) {
      $iMonthSummSalary = (int)$arrMoney['price'] + (int)$iMonthSummSalary;
      if ( (int)$arrMoney['category'] == 4 ) $iMonthSummSalaryWork = (int)$arrMoney['price'] + (int)$iMonthSummSalaryWork;
    }
    $arrResults['moneys']['wages'] = number_format($iMonthSummSalary, 2, '.', ' ');
    $arrResults['moneys']['wages_work'] = number_format($iMonthSummSalaryWork, 2, '.', ' ');

    // Balance
    $oCard = new card();
    $oCard->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $arrCards = $oCard->get();
    $iBalance = 0;
    foreach ( $arrCards as & $arrCard ) $iBalance = (int)$iBalance + (int)$arrCard['balance'];
    if ( (int)$iBalance > 0 ) $arrResults['balance'] = number_format($iBalance, 2, '.', ' ');
    else $arrResults['moneys']['balance'] = 0;

    // Money from hour
    $arrTime = explode(':',$arrResults['work']);
    $iTimeSum = $arrTime[0] + $arrTime[1] / 60;
    $iMoneyForHour = $iMonthSummSalaryWork / $iTimeSum;
    if ( (int)$iMoneyForHour > 0 ) $arrResults['moneyforhour'] = number_format($iMoneyForHour, 2, '.', ' ');
    else $arrResults['moneyforhour'] = 0;

    notification::success($arrResults);
    break;
}
