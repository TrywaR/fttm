<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод элементов
    $oCategory = $_REQUEST['id'] ? new times_category( $_REQUEST['id'] ) : new times_category();

    if ( $_REQUEST['from'] ) $oCategory->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oCategory->limit = $_REQUEST['limit'];
    $oCategory->sort = 'sort';
    $oCategory->sortDir = 'ASC';
    $oCategory->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $arrCategories = $oCategory->get_categories();

    notification::send($arrCategories);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $oCategory = $_REQUEST['id'] ? new times_category( $_REQUEST['id'] ) : new times_category();
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
    $oCategory = new times_category( $_REQUEST['id'] );
    $oCategory->del();
    break;
}
