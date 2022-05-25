<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод элементов
    $oCard = new card( $_REQUEST['id'] );

    if ( $_REQUEST['from'] ) $oCard->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oCard->limit = $_REQUEST['limit'];

    $oCard->sort = 'sort';
    $oCard->sortDir = 'DESC';
    $oCard->query .= ' AND `user_id` = ' . $_SESSION['user']['id'];

    if ( $_REQUEST['id'] ) $arrCard = $oCard->get_card();
    else $arrCard = $oCard->get_cards();

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

    $arrResult['text'] = 'Changes saved';
    notification::success($arrResult);
    break;

  case 'reload': # Обновление данных
    $arrResult = [];
    $oCard = new card( $_REQUEST['id'] );
    $oCard->balance_reload();
    $arrResult['data'] = $oCard->get();
    $arrResult['event'] = 'save';
    $arrResult['text'] = 'Card update';
    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oCard = new card( $_REQUEST['id'] );
    $oCard->del();
    break;
}
