<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод элементов
    $oMoneysSubscriptions = $_REQUEST['id'] ? new moneys_subscriptions( $_REQUEST['id'] ) : new moneys_subscriptions();

    if ( $_REQUEST['from'] ) $oMoneysSubscriptions->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oMoneysSubscriptions->limit = $_REQUEST['limit'];
    $oMoneysSubscriptions->sort = 'sort';
    $oMoneysSubscriptions->sortDir = 'DESC';
    $oMoneysSubscriptions->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $arrCategory = $oMoneysSubscriptions->get();

    notification::send($arrCategory);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $oMoneysSubscriptions = $_REQUEST['id'] ? new moneys_subscriptions( $_REQUEST['id'] ) : new moneys_subscriptions();
    $oMoneysSubscriptions->arrAddFields = $_REQUEST;
    if ( $_REQUEST['id'] ) $oMoneysSubscriptions->save();
    else $oMoneysSubscriptions->add();

    $arrResult['data'] = $oMoneysSubscriptions->get();

    if ( $_REQUEST['id'] ) $arrResult['event'] = 'save';
    else $arrResult['event'] = 'add';

    $arrResult['text'] = 'Changes saved';
    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oMoneysSubscriptions = new moneys_subscriptions( $_REQUEST['id'] );
    $oMoneysSubscriptions->del();
    break;
}
