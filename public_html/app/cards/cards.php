<?
switch ($_REQUEST['form']) {
  case 'save': # Сохранение изменений
    $oCard = new card( $_REQUEST['id'] );
    $oCard->arrAddFields = $_REQUEST;
    if ( $_REQUEST['id'] ) $oCard->save();
    else $oCard->add();
    break;

  case 'del': # Удаление
    $oCard = new card( $_REQUEST['id'] );
    $oCard->del();
    break;
}
