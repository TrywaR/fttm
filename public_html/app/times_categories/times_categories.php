<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод элементов
    $oCategory = $_REQUEST['id'] ? new times_category( $_REQUEST['id'] ) : new times_category();

    if ( $_REQUEST['from'] ) $oCategory->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oCategory->limit = $_REQUEST['limit'];
    $oCategory->sort = 'date';
    $oCategory->sortDir = 'DESC';
    $oCategory->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $arrCategory = $oCategory->get();

    notification::send($arrCategory);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $arrElem = [];
    $oCategory = $_REQUEST['id'] ? new times_category( $_REQUEST['id'] ) : new times_category();
    $oCategory->arrAddFields = $_REQUEST;
    if ( $_REQUEST['id'] ) $arrElem = $oCategory->save();
    else $arrElem = $oCategory->add();

    $oCategory = new times_category( $arrElem['id'] );
    $arrResult['elems'] = $oCategory->get();
    $arrResult['text'] = 'Изменения сохранены';
    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oCategory = new times_category( $_REQUEST['id'] );
    $oCategory->del();
    break;
}
