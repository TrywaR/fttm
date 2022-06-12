<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод элементов
    $oCard = new card( $_REQUEST['id'] );
    $arrCard = $oCard->get_card();
    notification::send($arrCard);
    break;

  case 'show_all': # Вывод элементов
    $oCard = new card();

    if ( $_REQUEST['from'] ) $oCard->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oCard->limit = $_REQUEST['limit'];

    $oCard->sort = 'sort';
    $oCard->sortDir = 'DESC';
    $oCard->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $arrCards = $oCard->get_cards();

    foreach ( $arrCards as & $arrCard ) if ( (int)$arrCard['user_id'] != 0 ) $arrCard['noedit'] = 'true';

    notification::send( $arrCards );
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $oCard = $_REQUEST['id'] ? new card( $_REQUEST['id'] ) : new card();
    $oCard->arrAddFields = $_REQUEST;
    if ( $_REQUEST['id'] ) $oCard->save();
    else $oCard->add();

    $arrResult['data'] = $oCard->get();

    if ( $_REQUEST['id'] ) $arrResult['event'] = 'save';
    else $arrResult['event'] = 'add';

    $arrResult['text'] = 'Changes saved';
    notification::success($arrResult);
    break;

  case 'reload': # Обновление данных
    $arrResult = [];
    $oCard = new card( $_REQUEST['id'] );
    $oCard->balance_reload();
    $arrResult['data'] = $oCard->get();
    $arrResult['event'] = 'save';
    $arrResult['location_reload'] = true;
    $arrResult['text'] = 'Card update';
    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oCard = new card( $_REQUEST['id'] );
    $oCard->del();
    break;
}
