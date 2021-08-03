<?
switch ($_REQUEST['form']) {
  case 'save': # Сохранение изменений
    $oMoney = new money( $_REQUEST['id'] );
    $oMoney->arrAddFields = $_REQUEST;
    $oClient->arrAddFields['user_id'] = $_SESSION['user']['id'];
    if ( $_REQUEST['id'] ) $oMoney->save();
    else $oMoney->add();
    break;

  case 'del': # Удаление
    $oMoney = new money( $_REQUEST['id'] );
    $oMoney->del();
    break;
}
