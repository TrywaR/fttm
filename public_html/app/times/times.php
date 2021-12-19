<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод элементов
    $oTime = $_REQUEST['id'] ? new time( $_REQUEST['id'] ) : new time();
    if ( $_REQUEST['from'] ) $oTime->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oTime->limit = $_REQUEST['limit'];
    $oTime->sort = 'date';
    $oTime->sortDir = 'DESC';
    $arrTimes = $oTime->get_time();
    notification::send($arrTimes);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $arrElem = [];
    $oTime = $_REQUEST['id'] ? new time( $_REQUEST['id'] ) : new time();
    $oTime->arrAddFields = $_REQUEST;

    if ( $_REQUEST['id'] ) $arrElem = $oTime->save();
    else $arrElem = $oTime->add();

    $oTime = new time( $arrElem['id'] );
    $arrResult['elems'] = $oTime->get_time();

    $arrResult['text'] = 'Изменения сохранены';
    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oTime = new time( $_REQUEST['id'] );
    $oTime->del();
    break;
}
