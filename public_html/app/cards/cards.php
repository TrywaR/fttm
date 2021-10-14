<?
switch ($_REQUEST['form']) {
  case 'save': # Сохранение изменений
    $oCard = new card( $_REQUEST['id'] );
    $oCard->arrAddFields = $_REQUEST;
    if ( $_REQUEST['id'] ) notification::success( $oCard->save() );
    else notification::success( $oCard->add() );
    break;

  case 'del': # Удаление
    $oCard = new card( $_REQUEST['id'] );
    $oCard->del();
    break;
}
