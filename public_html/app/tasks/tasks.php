<?
$oLang = new lang();

switch ($_REQUEST['form']) {
  case 'actions': # Элементы управления
    $sResultHtml = '';

    $sResultHtml .= '
      <div class="btn-group">
        <a data-action="tasks" data-animate_class="animate__flipInY" data-elem=".task" data-form="form" href="javascript:;" class="btn btn-dark content_loader_show">
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
      $oTask = new task( $_REQUEST['id'] );
    }
    // Если добавление
    else {
      $arrResults['event'] = 'add';
      $oTask = new task();
      // Случайное имя для корректной работы
      $arrDefaultsNames = array(
        'Task for reflection',
        'The best way',
        'Good name, good job',
      );
      // Создаем элемент
      $oTask->title = $arrDefaultsNames[array_rand($arrDefaultsNames, 1)];
      $oTask->user_id = $_SESSION['user']['id'];
      $oTask->active = 1;
      $oTask->add();
    }

    // Поля для добавления
    $oForm->arrFields = $oTask->fields();
    $oForm->arrFields['form'] = ['value'=>'save','type'=>'hidden'];
    $oForm->arrFields['action'] = ['value'=>'tasks','type'=>'hidden'];
    $oForm->arrFields['app'] = ['value'=>'app','type'=>'hidden'];
    $oForm->arrFields['session'] = ['value'=>$_SESSION['session'],'type'=>'hidden'];

    // Настройки шаблона
    $oForm->arrTemplateParams['id'] = 'content_loader_save';
    $oForm->arrTemplateParams['title'] = $oLang->get('Tasks');
    $oForm->arrTemplateParams['button'] = 'Save';
    $sFormHtml = $oForm->show();

    // Вывод результата
    $arrResults['form'] = $sFormHtml;
    $arrResults['data'] = $oTask->get_task();

    $arrResults['action'] = 'tasks';
    notification::send($arrResults);
    break;

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
    $arrResult['text'] = $oLang->get("ChangesSaved");

    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oTask = new task( $_REQUEST['id'] );
    $oTask->del();
    break;
}
