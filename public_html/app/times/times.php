<?
$oLang = new lang();

switch ($_REQUEST['form']) {
  case 'actions': # Элементы управления
    $sResultHtml = '';
    $sResultHtml .= '
      <div class="btn-group">
        <a data-action="times" data-animate_class="animate__flipInY" data-elem=".time" data-form="form" href="javascript:;" class="btn btn-dark content_loader_show">
          <span class="_icon"><i class="fas fa-plus-circle"></i></span>
          <span class="_icon">' . $oLang->get("Add") . '</span>
        </a>
      </div>
      ';

    notification::send( $sResultHtml );
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
    $oForm->arrTemplateParams['title'] = $oLang->get('Times');
    $oForm->arrTemplateParams['button'] = 'Save';
    $sFormHtml = $oForm->show();

    // Вывод результата
    $arrResults['form'] = $sFormHtml;
    $arrResults['data'] = $oTime->get_time();

    $arrResults['action'] = 'times';
    notification::send($arrResults);
    break;

  case 'show': # Вывод элементов
    $oTime = new time( $_REQUEST['id'] );
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
    $arrDataItem = $oTime->get_time();

    notification::send($arrDataItem);
    break;

  case 'show_all': # Вывод элементов
    $oTime = new time();
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
    $arrData = $oTime->get_times();

    notification::send($arrData);
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
    $arrResult['text'] = $oLang->get("ChangesSaved");

    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oTime = new time( $_REQUEST['id'] );
    $oTime->del();
    $arrResult = [];
    $arrResult['event'] = 'del';
    $arrResult['text'] = $oLang->get("DeleteSuccess");
    notification::success($arrResult);
    break;
}
