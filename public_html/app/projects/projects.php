<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод элементов
    $oProject = $_REQUEST['id'] ? new project( $_REQUEST['id'] ) : new project();

    if ( $_REQUEST['from'] ) $oProject->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oProject->limit = $_REQUEST['limit'];
    $oProject->sort = 'date';
    $oProject->sortDir = 'DESC';
    $arrProjects = $oProject->get();

    notification::send($arrProjects);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $arrElem = [];
    $oProject = $_REQUEST['id'] ? new project( $_REQUEST['id'] ) : new project();
    $oProject->arrAddFields = $_REQUEST;
    if ( $_REQUEST['id'] ) $arrElem = $oProject->save();
    else $arrElem = $oProject->add();

    $oProject = new project( $arrElem['id'] );
    $arrResult['elems'] = $oProject->get();
    $arrResult['text'] = 'Изменения сохранены';
    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oProject = new project( $_REQUEST['id'] );
    $oProject->del();
    break;
}
