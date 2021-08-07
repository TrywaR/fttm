<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод элементов
    $oMoney = new money();

    if ( $_REQUEST['from'] ) $oMoney->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oMoney->limit = $_REQUEST['limit'];

    $arrMoneys = $oMoney->get();
    notification::send($arrMoneys);
    break;

  case 'save': # Сохранение изменений
    $oMoney = new money( $_REQUEST['id'] );
    $oMoney->arrAddFields = $_REQUEST;
    $oMoney->arrAddFields['user_id'] = $_SESSION['user']['id'];
    if ( $_REQUEST['id'] ) $oMoney->save();
    else $oMoney->add();
    break;

  case 'del': # Удаление
    $oMoney = new money( $_REQUEST['id'] );
    $oMoney->del();
    break;
}
