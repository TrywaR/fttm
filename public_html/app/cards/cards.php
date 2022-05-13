<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод элементов
    $oCard = $_REQUEST['id'] ? new card( $_REQUEST['id'] ) : new card();

    if ( $_REQUEST['from'] ) $oCard->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oCard->limit = $_REQUEST['limit'];
    $oCard->sort = 'sort';
    $oCard->sortDir = 'DESC';
    $oCard->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $arrCard = $oCard->get();

    notification::send($arrCard);
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

    $arrResult['text'] = 'Изменения сохранены';
    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oCard = new card( $_REQUEST['id'] );
    $oCard->del();
    break;
}
