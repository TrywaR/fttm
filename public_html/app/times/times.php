<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод элементов
    $oTime = $_REQUEST['id'] ? new time( $_REQUEST['id'] ) : new time();
    if ( $_REQUEST['from'] ) $oTime->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oTime->limit = $_REQUEST['limit'];

    if ( $_REQUEST['filter'] ) {
      $arrFilters = $_REQUEST['filter'];
      foreach ($arrFilters as $arrFilter) {
        if ( $arrFilter['value'] )
          $oTime->query .= ' AND `' . $arrFilter['name'] . '` = "' . $arrFilter['value'] . '"';
      }
    }

    $oTime->sort = 'date';
    $oTime->sortDir = 'DESC';
    $oTime->query .= ' AND `user_id` = ' . $_SESSION['user']['id'];
    $arrTimes = $oTime->get_time();
    notification::send($arrTimes);
    break;

  case 'form': # Форма добавления / редактирования
    // Параметры
    $arrResults = [];
    $oForm = new form();

    // Если редактировани
    if ( $_REQUEST['id'] ) {
      $arrResults['event'] = 'edit';
      $oTime = new time( $_REQUEST['id'] );
    }
    // Если добавление
    else {
      $arrResults['event'] = 'add';
      $oTime = new time();
      // Случайное имя для корректной работы
      $arrDefaultsNames = array(
        'Time for reflection',
        'The best way',
        'Good name, good job',
      );
      // Создаем элемент
      $oTime->title = $arrDefaultsNames[array_rand($arrDefaultsNames, 1)];
      $oTime->user_id = $_SESSION['user']['id'];
      $oTime->time_planned = '00:00';
      $oTime->time_really = '00:00';
      $oTime->date = date('Y-m-d');
      $oTime->active = 1;
      $oTime->add();
    }
    // Поля для добавления
    $oForm->arrFields = $oTime->fields();
    $oForm->arrFields['form'] = ['value'=>'save','type'=>'hidden'];
    $oForm->arrFields['action'] = ['value'=>'times','type'=>'hidden'];
    $oForm->arrFields['app'] = ['value'=>'app','type'=>'hidden'];
    $oForm->arrFields['session'] = ['value'=>$_SESSION['session'],'type'=>'hidden'];
    // Настройки шаблона
    $oForm->arrTemplateParams['id'] = 'content_loader_save';
    $oForm->arrTemplateParams['title'] = 'Time';
    $oForm->arrTemplateParams['button'] = 'Save';
    $sFormHtml = $oForm->show();
    // Вывод результата
    $arrResults['form'] = $sFormHtml;
    $arrResults['data'] = (array)$oTime;

    $arrResults['action'] = 'times';
    notification::send($arrResults);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $oTime = $_REQUEST['id'] ? new time( $_REQUEST['id'] ) : new time();
    $oTime->arrAddFields = $_REQUEST;

    if ( $_REQUEST['id'] ) $oTime->save();
    else $oTime->add();

    $arrResult['data'] = $oTime->get_time();

    if ( $_REQUEST['id'] ) $arrResult['event'] = 'save';
    else $arrResult['event'] = 'add';
    $arrResult['text'] = 'Changes saved';

    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oTime = new time( $_REQUEST['id'] );
    $oTime->del();
    $arrResult = [];
    $arrResult['event'] = 'del';
    $arrResult['text'] = 'Delete success';
    notification::success($arrResult);
    break;
}
