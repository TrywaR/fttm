<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод элементов
    $oClient = $_REQUEST['id'] ? new client( $_REQUEST['id'] ) : new client();

    if ( $_REQUEST['from'] ) $oClient->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oClient->limit = $_REQUEST['limit'];
    $oClient->sort = 'date';
    $oClient->sortDir = 'DESC';
    $arrClients = $oClient->get();

    notification::send($arrClients);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $arrElem = [];
    $oClient = $_REQUEST['id'] ? new client( $_REQUEST['id'] ) : new client();
    $oClient->arrAddFields = $_REQUEST;
    if ( $_REQUEST['id'] ) $arrElem = $oClient->save();
    else $arrElem = $oClient->add();

    $oClient = new client( $arrElem['id'] );
    $arrResult['elems'] = $oClient->get();
    $arrResult['text'] = 'Изменения сохранены';
    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oClient = new client( $_REQUEST['id'] );
    $oClient->del();
    break;
}
