<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод элементов
    $oTask = new task( $_REQUEST['id'] );
    $arrTask = $oTask->get_task();
    notification::send($arrTask);
    break;

  case 'show_all': # Вывод элементов
    $oTask = new task();
    if ( $_REQUEST['from'] ) $oTask->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oTask->limit = $_REQUEST['limit'];

    if ( $_REQUEST['filter'] ) {
      $arrFilters = $_REQUEST['filter'];
      foreach ($arrFilters as $arrFilter) {
        if ( $arrFilter['value'] )
          $oTask->query .= ' AND `' . $arrFilter['name'] . '` = "' . $arrFilter['value'] . '"';
      }
    }

    $oTask->query .= ' AND `user_id` = ' . $_SESSION['user']['id'];
    $arrTasks = $oTask->get_tasks();
    notification::send($arrTasks);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];

    $oTask = $_REQUEST['id'] ? new task( $_REQUEST['id'] ) : new task();
    $oTask->arrAddFields = $_REQUEST;
    $oTask->arrAddFields['date_update'] = date("Y-m-d H:i:s");
    if ( $_REQUEST['id'] ) $oTask->save();
    else $oTask->add();

    $arrResult['data'] = $oTask->get_task();

    if ( $_REQUEST['id'] ) $arrResult['event'] = 'save';
    else $arrResult['event'] = 'add';
    $arrResult['text'] = 'Changes saved';

    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oTask = new task( $_REQUEST['id'] );
    $oTask->del();
    break;
}
