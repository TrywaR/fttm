<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод элементов
    $oMoney = $_REQUEST['id'] ? new money( $_REQUEST['id'] ) : new money();

    if ( $_REQUEST['from'] ) $oMoney->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oMoney->limit = $_REQUEST['limit'];
    $oMoney->sort = 'date';
    $oMoney->sortDir = 'DESC';
    // print_r($oMoney);
    // die();
    $arrMoneys = $oMoney->get_money();

    notification::send($arrMoneys);
    break;

  case 'save': # Сохранение изменений
    $arrElem = [];
    $oMoney = $_REQUEST['id'] ? new money( $_REQUEST['id'] ) : new money();
    $oMoney->arrAddFields = $_REQUEST;
    if ( $_REQUEST['id'] ) $arrElem = $oMoney->save();
    else $arrElem = $oMoney->add();

    $oMoney = new money( $arrElem['id'] );
    notification::send($oMoney->get_money());
    break;

  case 'del': # Удаление
    $oMoney = new money( $_REQUEST['id'] );
    $oMoney->del();
    break;
}
