<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод элементов
    $oTask = new task( $_REQUEST['id'] );
    $oTask->sort = 'date';
    $oTask->sortDir = 'DESC';
    $oTask->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $arrTasks = $oTask->get_task();
    notification::send($arrTasks);
    break;

  case 'show_all': # Вывод элементов
    $oTask = new task();
    if ( $_REQUEST['from'] ) $oTask->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oTask->limit = $_REQUEST['limit'];
    $oTask->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $arrTasks = $oTask->get_tasks();
    notification::send($arrTasks);
    break;

  case 'save': # Сохранение изменений
    $arrElem = [];
    $oTask = $_REQUEST['id'] ? new task( $_REQUEST['id'] ) : new task();
    $oTask->arrAddFields = $_REQUEST;
    if ( $_REQUEST['id'] ) $arrElem = $oTask->save();
    else $arrElem = $oTask->add();

    $oTask = new task( $arrElem['id'] );
    notification::send($oTask->get());
    break;

  case 'del': # Удаление
    $oTask = new task( $_REQUEST['id'] );
    $oTask->del();
    break;
}
