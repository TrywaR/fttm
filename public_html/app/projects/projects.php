<?
switch ($_REQUEST['form']) {
  case 'save': # Сохранение изменений
    $oProject = new project( $_REQUEST['id'] );
    $oProject->arrAddFields = $_REQUEST;
    if ( $_REQUEST['id'] ) $oProject->save();
    else $oProject->add();
    break;

  case 'del': # Удаление
    $oProject = new project( $_REQUEST['id'] );
    $oProject->del();
    break;
}
