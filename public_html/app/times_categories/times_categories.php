<?
switch ($_REQUEST['form']) {
  case 'save': # Сохранение изменений
    $oCategory = new times_category( $_REQUEST['id'] );
    $oCategory->arrAddFields = $_REQUEST;
    if ( $_REQUEST['id'] ) notification::success( $oCategory->save() );
    else notification::success( $oCategory->add() );
    break;

  case 'del': # Удаление
    $oCategory = new times_category( $_REQUEST['id'] );
    $oCategory->del();
    break;
}
