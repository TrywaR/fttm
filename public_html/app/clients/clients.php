<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод элементов
    $oClient = $_REQUEST['id'] ? new client( $_REQUEST['id'] ) : new client();
    if ( $_REQUEST['from'] ) $oClient->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oClient->limit = $_REQUEST['limit'];
    $oClient->sort = 'sort';
    $oClient->sortDir = 'DESC';
    $oClient->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $arrClients = $oClient->get();
    notification::send($arrClients);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $oClient = $_REQUEST['id'] ? new client( $_REQUEST['id'] ) : new client();
    $oClient->arrAddFields = $_REQUEST;
    if ( $_REQUEST['id'] ) $oClient->save();
    else $oClient->add();
    
    $arrResult['data'] = $oClient->get();

    if ( $_REQUEST['id'] ) $arrResult['event'] = 'save';
    else $arrResult['event'] = 'add';

    $arrResult['text'] = 'Изменения сохранены';
    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oClient = new client( $_REQUEST['id'] );
    $oClient->del();
    break;
}
