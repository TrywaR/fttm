<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод элементов
    $oMoney = $_REQUEST['id'] ? new money( $_REQUEST['id'] ) : new money();

    if ( $_REQUEST['from'] ) $oMoney->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oMoney->limit = $_REQUEST['limit'];
    $oMoney->sort = 'date';
    $oMoney->sortDir = 'DESC';
    $oMoney->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $arrMoneys = $oMoney->get_money();

    notification::send($arrMoneys);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $oMoney = $_REQUEST['id'] ? new money( $_REQUEST['id'] ) : new money();
    $oMoney->arrAddFields = $_REQUEST;
    if ( $_REQUEST['id'] ) $oMoney->save();
    else $oMoney->add();

    $arrResult['data'] = $oMoney->get_money();

    if ( $_REQUEST['id'] ) $arrResult['event'] = 'save';
    else $arrResult['event'] = 'add';
    $arrResult['text'] = 'Changes saved';
    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oMoney = new money( $_REQUEST['id'] );
    $oMoney->del();
    $arrResult = [];
    $arrResult['event'] = 'del';
    $arrResult['text'] = 'Delete success';
    notification::success($arrResult);
    break;
}
