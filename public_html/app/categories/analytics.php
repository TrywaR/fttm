<?
switch ($_REQUEST['form']) {
  case 'analytics_week': # Вывод статистики за неделю
    $arrResults = [];

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
    $iCategoryId = $_REQUEST['category_id'];

    // $arrTimesSum = [];
    //
    // // Обработка данных
    // $iIndex = 1;
    // while (strtotime($dDateCurrent) < strtotime($dDateStop)) {
    //   if ( $iIndex > 1 ) $dDateCurrent = date('Y-m-d', strtotime('+1 day', strtotime($dDateCurrent)));
    //
    //   // Заполняем данные
    //   $arrResults['data_times'][$iIndex]['title'] = $dDateCurrent;
    //
    //   // Собираем потраченное время
    //   $oTime = new time();
    //   $oTime->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    //   $oTime->query .= " AND `date` = '" . $dDateCurrent . "'";
    //   $oTime->query .= " AND `project_id` = '" . $iProjectId . "'";
    //   $arrData = $oTime->get();
    //
    //   // Сумма
    //   $arrDaysTimes = [];
    //
    //   // Записываем данные по категориям за неделю
    //   foreach ($arrData as & $arrDataItem) {
    //     $dDateReally = new DateTime($arrDataItem['time_really']);
    //     $arrTimesSum[] = $arrDaysTimes[] = $arrDataItem['time'] = $dDateReally->format('H:i:s');
    //     $arrResults['data_times'][$iIndex]['categories'][0]['value'] = $arrResults['data_times'][$iIndex]['categories'][0]['value'] + strtotime($arrDataItem['time']) - strtotime("00:00:00");
    //   }
    //   $arrResults['data_times'][$iIndex]['sum'] = $oTime->get_sum( $arrDaysTimes );
    // }

    notification::success($arrResults);
    break;

  case 'analytics_month': # Вывод статистики за месяц
    $arrResults = [];

    $iYear = (int)$_REQUEST['year'] ? $_REQUEST['year'] : date('Y');
    $iMonth = (int)$_REQUEST['month'] ? $_REQUEST['month'] : date('m');
    $iMonthDaysSum = cal_days_in_month(CAL_GREGORIAN, $iMonth, $iYear);
    $iCategoryId = $_REQUEST['category_id'];

    // Сумма
    $arrDaysTimes = [];
    $iMounthSum = 0;

    // Суммы по месяцам
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
        $arrDaysTimes[] = $arrTime['time'] = $dDateReally->format('H:i:s');

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
          $iMounthSum = $iMounthSum + (float)$arrMoney['price'];
        }
        if ( (int)$arrMoney['type'] == 1 ) {
          $arrResults['data'][$i]['moneys'] = (float)$arrResults['data'][$i]['moneys'] - (float)$arrMoney['price'];
          $iMounthSum = $iMounthSum - (float)$arrMoney['price'];
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
      // if ( abs($arrDay['moneys']) > 0 ) $arrEvents[$iDay.'.'.$iMonth] .= 'Денежки, ';
      // if ( $arrDay['times'] > 0 ) $arrEvents[$iDay.'.'.$iMonth] .= 'Время, ';
      $arrEvents[$iDay.'.'.$iMonth] = 0;
      if ( abs($arrDay['moneys']) > 0 ) $arrEvents[$iDay.'.'.$iMonth]++;
      if ( $arrDay['times'] > 0 ) $arrEvents[$iDay.'.'.$iMonth]++;
    }

    $arrResults['times'] = $oTime->get_sum( $arrDaysTimes );
    $arrResults['moneys'] = $iMounthSum;
    $arrResults['calendar'] = calendar::getMonth($iMonth, $iYear, $arrEvents);

    notification::success($arrResults);
    break;

  case 'analytics_year': # Вывод статистики за год
    $arrResults = [];

    notification::success($arrResults);
    break;
}
