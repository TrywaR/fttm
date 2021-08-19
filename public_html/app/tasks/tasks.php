<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод элементов
    $oTask = $_REQUEST['id'] ? new task( $_REQUEST['id'] ) : new task();

    if ( $_REQUEST['from'] ) $oTask->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oTask->limit = $_REQUEST['limit'];
    $oTask->sort = 'date';
    $oTask->sortDir = 'DESC';
    $arrTasks = $oTask->get();

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
