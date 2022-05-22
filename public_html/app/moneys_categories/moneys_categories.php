<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод элементов
    $oCategory = $_REQUEST['id'] ? new moneys_category( $_REQUEST['id'] ) : new moneys_category();

    if ( $_REQUEST['from'] ) $oCategory->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oCategory->limit = $_REQUEST['limit'];
    $oCategory->sort = 'sort';
    $oCategory->sortDir = 'DESC';
    $oCategory->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $arrCategory = $oCategory->get();

    notification::send($arrCategory);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $oCategory = $_REQUEST['id'] ? new moneys_category( $_REQUEST['id'] ) : new moneys_category();
    $oCategory->arrAddFields = $_REQUEST;
    if ( $_REQUEST['id'] ) $oCategory->save();
    else $oCategory->add();

    $arrResult['data'] = $oCategory->get();

    if ( $_REQUEST['id'] ) $arrResult['event'] = 'save';
    else $arrResult['event'] = 'add';

    $arrResult['text'] = 'Changes saved';
    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oCategory = new moneys_category( $_REQUEST['id'] );
    $oCategory->del();
    break;
}
