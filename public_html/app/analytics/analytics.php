<?
switch ($_REQUEST['form']) {
  case 'analytics':
    $arrResults = [];

    // Месяц
    $iYear = (int)$_REQUEST['year'] ? $_REQUEST['year'] : date('Y');
    $iMonth = (int)$_REQUEST['month'] ? $_REQUEST['month'] : date('m');
    $dMonth = $iYear . '-' . sprintf("%02d", $iMonth);

    // Время
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
      $arrResults['times']['categories'][$key]['title'] = $arrCategory['title'];
      $arrResults['times']['categories'][$key]['value'] = '00:00:00';
      $arrResults['times']['categories'][$key]['color'] = $arrCategory['color'];
    }

    // Сумма
    $arrMonthTimes = [];
    $oTime = new time();
    $oTime->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $oTime->query .= " AND `date` LIKE '" . $dMonth . "%'";
    $arrTimes = $oTime->get();
    foreach ($arrTimes as &$arrTime) {
      $dDateReally = new DateTime($arrTime['time_really']);
      $arrTimesSum[] = $arrMonthTimes[] = $arrTime['time'] = $dDateReally->format('H:i:s');
      if ( $arrResults['times']['categories'][$arrTime['category_id']]['value'] == '00:00:00' ) $arrResults['times']['categories'][$arrTime['category_id']]['value'] = $arrTime['time'];
      else $arrResults['times']['categories'][$arrTime['category_id']]['value'] =  $oTime->get_sum( [$arrResults['times']['categories'][$arrTime['category_id']]['value'], $arrTime['time']]);
    }
    $arrResults['times']['sum'] = $oTime->get_sum( $arrMonthTimes );
    $arrResults['work'] = $arrResults['times']['categories'][4]['value'];
    $arrResults['sleep'] = $arrResults['times']['categories'][5]['value'];

    // Подписки
    $oSubscription = new subscription();
    $oSubscription->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $oSubscription->sDateQuery = $dMonth;
    // $oSubscription->show_query = true;
    $arrResults['subscriptions'] = $oSubscription->get_subscriptions();
    $arrResults['subscriptions_sum'] = 0;
    foreach ( $arrResults['subscriptions'] as $arrSubscription ) {
      if ( ! $arrSubscription['paid'] ) {
        if ( $arrSubscription['paid_sum'] ) $arrResults['subscriptions_sum'] = (int)$arrResults['subscriptions_sum'] + (int)$arrSubscription['paid_need'];
        else $arrResults['subscriptions_sum'] = (int)$arrResults['subscriptions_sum'] + (int)$arrSubscription['price'];
      }
    }
    $arrResults['subscriptions_sum'] = number_format($arrResults['subscriptions_sum'], 2, '.', ' ');

    // За месяц ушло
    $oMoney = new money();
    $oMoney->sortname = 'date';
    $oMoney->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $oMoney->query .= " AND `date` LIKE '" . $dMonth . "%' AND `type` = '1' ";
    $oMoney->query .= " AND `to_card` = '0' ";
    $arrMoneys = $oMoney->get();
    $iMonthSumm = 0;
    foreach ($arrMoneys as $arrMoney) $iMonthSumm = (int)$arrMoney['price'] + (int)$iMonthSumm;
    $arrResults['costs'] = number_format($iMonthSumm, 2, '.', ' ');

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
    $arrResults['wages'] = number_format($iMonthSummSalary, 2, '.', ' ');
    $arrResults['wages_work'] = number_format($iMonthSummSalaryWork, 2, '.', ' ');

    // Balance
    $oCard = new card();
    $oCard->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $arrCards = $oCard->get();
    $iBalance = 0;
    foreach ( $arrCards as & $arrCard ) $iBalance = (int)$iBalance + (int)$arrCard['balance'];
    $arrResults['cards'] = $arrCards;
    if ( (int)$iBalance > 0 ) $arrResults['balance'] = number_format($iBalance, 2, '.', ' ');
    else $arrResults['balance'] = 0;

    // Money from hour
    $arrTime = explode(':',$arrResults['work']);
    $iTimeSum = $arrTime[0] + $arrTime[1] / 60;
    $iMoneyForHour = $iMonthSummSalaryWork / $iTimeSum;
    if ( (int)$iMoneyForHour > 0 ) $arrResults['moneyforhour'] = number_format($iMoneyForHour, 2, '.', ' ');
    else $arrResults['moneyforhour'] = 0;

    notification::success($arrResults);
    break;
}
