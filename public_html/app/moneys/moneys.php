<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод элементов
    $oMoney = $_REQUEST['id'] ? new money( $_REQUEST['id'] ) : new money();

    if ( $_REQUEST['filter'] ) {
      $arrFilters = $_REQUEST['filter'];
      foreach ($arrFilters as $arrFilter) {
        if ( $arrFilter['value'] )
          switch ($arrFilter['name']) {
            case 'date':
              $oMoney->query .= ' AND `' . $arrFilter['name'] . '` = "' . $arrFilter['value'] . ' 00:00:00"';
              break;

            default:
              $oMoney->query .= ' AND `' . $arrFilter['name'] . '` = ' . $arrFilter['value'];
              break;
          }
      }
    }

    if ( $_REQUEST['from'] ) $oMoney->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oMoney->limit = $_REQUEST['limit'];
    $oMoney->sort = 'date';
    $oMoney->sortDir = 'DESC';
    $oMoney->query .= ' AND `user_id` = ' . $_SESSION['user']['id'];
    $arrMoneys = $oMoney->get_money();

    notification::send($arrMoneys);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $oMoney = $_REQUEST['id'] ? new money( $_REQUEST['id'] ) : new money();
    $oMoney->arrAddFields = $_REQUEST;

    // Обновление карты
    if ( $_REQUEST['card'] ) {
      $oCard = new card( $_REQUEST['card'] );
      // Если пополнение
      if ( (int)$_REQUEST['type'] ) $oCard->balance_add( $_REQUEST['price'] );
      // Если тарата
      else {
        $oCard->balance_remove( $_REQUEST['price'] );
        // Если комиссиия
        if ( (int)$_REQUEST['category'] == 1 ) $oCard->commission_add( $_REQUEST['price'] );
      }
    }

    // Обновление карты на которую зачисление
    if ( $_REQUEST['to_card'] ) {
      $oCardTo = new card( $_REQUEST['to_card'] );
      $oCardTo->balance_add( $_REQUEST['price'] );
    }

    // Убираем с карты старое значени суммы
    if ( $_REQUEST['id'] ) {
      $oCard->balance_remove( $oMoney->price );
      $oMoney->save();
    }
    else $oMoney->add();

    $arrResult['data'] = $oMoney->get_money();

    if ( $_REQUEST['id'] ) $arrResult['event'] = 'save';
    else $arrResult['event'] = 'add';
    $arrResult['text'] = 'Changes saved';
    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oMoney = new money( $_REQUEST['id'] );
    $oMoney->del();
    $arrResult = [];

    // Обновление карты
    if ( $_REQUEST['card'] ) {
      $oCard = new card( $_REQUEST['card'] );
      // Если пополнение
      if ( (int)$_REQUEST['type'] ) {
        $oCard->balance_remove( $_REQUEST['price'] );
      }
      // Если тарата
      else {
        $oCard->balance_add( $_REQUEST['price'] );
        // Если комиссиия
        if ( (int)$_REQUEST['category'] == 1 ) $oCard->commission_remove( $_REQUEST['price'] );
      }
    }

    $arrResult['event'] = 'del';
    $arrResult['text'] = 'Delete success';
    notification::success($arrResult);
    break;
}
