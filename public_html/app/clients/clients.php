<?
switch ($_REQUEST['form']) {
  case 'save': # Сохранение изменений
    $oClient = new client( $_REQUEST['id'] );
    $oClient->arrAddFields = $_REQUEST;
    if ( $_REQUEST['id'] ) notification::success( $oClient->save() );
    else notification::success( $oClient->add() );
    break;

  case 'del': # Удаление
    $oClient = new client( $_REQUEST['id'] );
    $oClient->del();
    break;
}
