<?
switch ($_REQUEST['form']) {
  case 'save': # Сохранение изменений
    $oCategory = new moneys_category( $_REQUEST['id'] );
    $oCategory->arrAddFields = $_REQUEST;
    if ( $_REQUEST['id'] ) $oCategory->save();
    else $oCategory->add();
    break;

  case 'del': # Удаление
    $oCategory = new moneys_category( $_REQUEST['id'] );
    $oCategory->del();
    break;
}
