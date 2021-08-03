<?
switch ($_REQUEST['form']) {
  case 'save': # Сохранение изменений
    $oClient = new client( $_REQUEST['id'] );
    $oClient->arrAddFields = $_REQUEST;
    $oClient->arrAddFields['user_id'] = $_SESSION['user']['id'];
    if ( $_REQUEST['id'] ) $oClient->save();
    else $oClient->add();
    break;

  case 'del': # Удаление
    $oClient = new client( $_REQUEST['id'] );
    $oClient->del();
    break;
}
