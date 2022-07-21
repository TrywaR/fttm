<?
switch ($_REQUEST['form']) {
  case 'analytics_month': # Вывод статистики за месяц
    $arrResults = [];

    $iYear = (int)$_REQUEST['year'] ? $_REQUEST['year'] : date('Y');
    $iMonth = (int)$_REQUEST['month'] ? $_REQUEST['month'] : date('m');
    $iMonthDaysSum = cal_days_in_month(CAL_GREGORIAN, $iMonth, $iYear);
    $iCategoryId = $_REQUEST['category_id'];

    // Сумма
    $arrMonthTimes = [];
    $iMonthSum = 0;

    // Суммы по дням
    for ($i=1; $i <= $iMonthDaysSum; $i++) {
      $arrResults['data'][$i]['title'] = sprintf("%02d", $i);
      $arrResults['data'][$i]['times'] = '00:00:00';
      $arrResults['data'][$i]['moneys'] = 0;

      // Время
      // __________
      // Собираем потраченное время
      $oTime = new time();
      $oTime->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
      $oTime->query .= " AND `date` LIKE '" . $iYear . '-' . sprintf("%02d", $iMonth) . '-' . sprintf("%02d", $i) . "%'";
      $oTime->query .= " AND `category_id` = '" . $iCategoryId . "'";
      $arrTimes = $oTime->get();
      foreach ($arrTimes as &$arrTime) {
        $dDateReally = new DateTime($arrTime['time_really']);
        $arrMonthTimes[] = $arrTime['time'] = $dDateReally->format('H:i:s');

        if ( $arrResults['data'][$i]['times'] == '00:00:00' ) $arrResults['data'][$i]['times'] = $arrTime['time'];
        else $arrResults['data'][$i]['times'] =  $oTime->get_sum( [$arrResults['data'][$i]['times'], $arrTime['time']]);
      }

      // Деньги
      // __________
      $oMoney = new money();
      $oMoney->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
      $oMoney->query .= " AND `date` LIKE '" . $iYear . '-' . sprintf("%02d", $iMonth) . '-' . sprintf("%02d", $i) . "%'";
      $oMoney->query .= " AND `category` = '" . $iCategoryId . "'";
      $arrMoneys = $oMoney->get();
      foreach ($arrMoneys as &$arrMoney) {
        if ( (int)$arrMoney['type'] == 2 ) {
          $arrResults['data'][$i]['moneys'] = (float)$arrResults['data'][$i]['moneys'] + (float)$arrMoney['price'];
          $iMonthSum = $iMonthSum + (float)$arrMoney['price'];
        }
        if ( (int)$arrMoney['type'] == 1 ) {
          $arrResults['data'][$i]['moneys'] = (float)$arrResults['data'][$i]['moneys'] - (float)$arrMoney['price'];
          $iMonthSum = $iMonthSum - (float)$arrMoney['price'];
        }
      }
    }

    // $events = array(
    // 	'16'    => 'Заплатить ипотеку',
    // 	'23.02' => 'День защитника Отечества',
    // 	'08.03' => 'Международный женский день',
    // 	'31.12' => 'Новый год'
    // );
    $arrEvents = [];
    foreach ($arrResults['data'] as $iDay => $arrDay) {
      $arrEvents[$iDay.'.'.$iMonth] = 0;
      if ( abs($arrDay['moneys']) > 0 ) $arrEvents[$iDay.'.'.$iMonth] = 1;
      if ( $arrDay['times'] > 0 ) $arrEvents[$iDay.'.'.$iMonth] = 2;
      if ( abs($arrDay['moneys']) > 0 && $arrDay['times'] > 0 ) $arrEvents[$iDay.'.'.$iMonth] = 3;
    }

    $arrResults['times'] = $oTime->get_sum( $arrMonthTimes );
    $arrResults['moneys'] = $iMonthSum;
    $arrResults['calendar'] = calendar::getMonth($iMonth, $iYear, $arrEvents);

    notification::success($arrResults);
    break;

  case 'analytics_year': # Вывод статистики за год
    $arrResults = [];

    $iYear = (int)$_REQUEST['year'] ? $_REQUEST['year'] : date('Y');
    $iCategoryId = $_REQUEST['category_id'];

    // Сумма
    $arrDaysTimes = [];
    $arrMonthTimes = [];
    $arrYearTimes = [];
    $iMonthSum = 0;
    $iYearSum = 0;
    $oTime = new time();

    // Суммы по месяцам
    for ($iMonth=1; $iMonth <= 12; $iMonth++) {
      $iMonthDaysSum = cal_days_in_month(CAL_GREGORIAN, $iMonth, $iYear);

      // Суммы по дням
      for ($iDay=1; $iDay <= $iMonthDaysSum; $iDay++) {
        $arrResults['data'][$iMonth][$iDay]['title'] = sprintf("%02d", $iDay);
        $arrResults['data'][$iMonth][$iDay]['times'] = '00:00:00';
        $arrResults['data'][$iMonth][$iDay]['moneys'] = 0;

        // Время
        // __________
        // Собираем потраченное время
        $oTime = new time();
        $oTime->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
        $oTime->query .= " AND `date` LIKE '" . $iYear . '-' . sprintf("%02d", $iMonth) . '-' . sprintf("%02d", $iDay) . "%'";
        $oTime->query .= " AND `category_id` = '" . $iCategoryId . "'";
        $arrTimes = $oTime->get();
        foreach ($arrTimes as &$arrTime) {
          $dDateReally = new DateTime($arrTime['time_really']);
          $arrDaysTimes[] = $arrTime['time'] = $dDateReally->format('H:i:s');

          if ( $arrResults['data'][$iMonth][$iDay]['times'] == '00:00:00' ) $arrResults['data'][$iMonth][$iDay]['times'] = $arrTime['time'];
          else $arrResults['data'][$iMonth][$iDay]['times'] =  $oTime->get_sum( [$arrResults['data'][$iMonth][$iDay]['times'], $arrTime['time']]);
        }

        // Деньги
        // __________
        $oMoney = new money();
        $oMoney->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
        $oMoney->query .= " AND `date` LIKE '" . $iYear . '-' . sprintf("%02d", $iMonth) . '-' . sprintf("%02d", $iDay) . "%'";
        $oMoney->query .= " AND `category` = '" . $iCategoryId . "'";
        $arrMoneys = $oMoney->get();
        foreach ($arrMoneys as &$arrMoney) {
          if ( (int)$arrMoney['type'] == 2 ) {
            $arrResults['data'][$iMonth][$iDay]['moneys'] = (float)$arrResults['data'][$iMonth][$iDay]['moneys'] + (float)$arrMoney['price'];
            $iMonthSum = $iMonthSum + (float)$arrMoney['price'];
          }
          if ( (int)$arrMoney['type'] == 1 ) {
            $arrResults['data'][$iMonth][$iDay]['moneys'] = (float)$arrResults['data'][$iMonth][$iDay]['moneys'] - (float)$arrMoney['price'];
            $iMonthSum = $iMonthSum - (float)$arrMoney['price'];
          }
        }
      }

      $arrMonthTimes = $oTime->get_sum( $arrDaysTimes );
      $arrYearTimes[] = $arrMonthTimes;
      $arrResults['data'][$iMonth]['times'] = $arrMonthTimes;
      $arrDaysTimes = [];

      $arrResults['data'][$iMonth]['moneys'] = $iMonthSum;
      $iYearSum = (float)$iYearSum + (float)$iMonthSum;
      $iMonthSum = 0;
    }

    // $events = array(
    // 	'16'    => 'Заплатить ипотеку',
    // 	'23.02' => 'День защитника Отечества',
    // 	'08.03' => 'Международный женский день',
    // 	'31.12' => 'Новый год'
    // );
    $arrEvents = [];
    foreach ($arrResults['data'] as $iMonth => $arrMonth) {
      foreach ($arrMonth as $iDay => $arrDay) {
        $arrEvents[$iDay.'.'.$iMonth] = 0;
        if ( abs($arrDay['moneys']) > 0 ) $arrEvents[$iDay.'.'.$iMonth] = 1;
        if ( $arrDay['times'] > 0 ) $arrEvents[$iDay.'.'.$iMonth] = 2;
        if ( abs($arrDay['moneys']) > 0 && $arrDay['times'] > 0 ) $arrEvents[$iDay.'.'.$iMonth] = 3;
      }
    }

    $arrResults['times'] = $oTime->get_sum( $arrYearTimes );
    $arrResults['moneys'] = $iYearSum;
    $arrResults['calendar'] = calendar::getInterval(date('01.'.$iYear), date('12.'.$iYear), $arrEvents);

    notification::success($arrResults);
    break;
}
