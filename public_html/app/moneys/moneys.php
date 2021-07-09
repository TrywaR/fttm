<?
switch ($_REQUEST['form']) {
  case 'save': # Сохранение изменений
    $oMoney = new money( $_REQUEST['id'] );
    $oMoney->arrAddFields = $_REQUEST;
    if ( $_REQUEST['id'] ) $oMoney->save();
    else $oMoney->add();
    break;

  case 'del': # Удаление
    $oMoney = new money( $_REQUEST['id'] );
    $oMoney->del();
    break;
}
