<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод элементов
    $oProject = $_REQUEST['id'] ? new project( $_REQUEST['id'] ) : new project();
    if ( $_REQUEST['from'] ) $oProject->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oProject->limit = $_REQUEST['limit'];
    $oProject->sort = 'sort';
    $oProject->sortDir = 'ASC';
    $oProject->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $arrProjects = $oProject->get();
    notification::send($arrProjects);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $oProject = $_REQUEST['id'] ? new project( $_REQUEST['id'] ) : new project();
    $oProject->arrAddFields = $_REQUEST;
    if ( $_REQUEST['id'] ) $oProject->save();
    else $oProject->add();

    $arrResult['data'] = $oProject->get();

    if ( $_REQUEST['id'] ) $arrResult['event'] = 'save';
    else $arrResult['event'] = 'add';

    $arrResult['text'] = 'Changes saved';
    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oProject = new project( $_REQUEST['id'] );
    $oProject->del();
    break;
}
