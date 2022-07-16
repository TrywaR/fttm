<?
$oLang = new lang();

switch ($_REQUEST['form']) {
  case 'actions': # Элементы управления
    $sResultHtml = '';
    $sResultHtml .= '
      <div class="btn-group">
        <a data-action="projects" data-animate_class="animate__flipInY" data-elem=".project" data-form="form" href="javascript:;" class="btn btn-dark content_loader_show">
          <span class="_icon"><i class="fas fa-plus-circle"></i></span>
          <span class="_text">' . $oLang->get("Add") . '</span>
        </a>
      </div>
      ';

    notification::send( $sResultHtml );
    break;

  case 'show': # Вывод элементов
    $oProject = $_REQUEST['id'] ? new project( $_REQUEST['id'] ) : new project();

    if ( $_REQUEST['from'] ) $oProject->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oProject->limit = $_REQUEST['limit'];

    $oProject->sortname = 'sort';
    $oProject->sortdir = 'ASC';
    $oProject->query = ' AND `user_id` = ' . $_SESSION['user']['id'];

    $oFilter = new filter();
    $oProject->query .= $oFilter->get();

    $arrProjects = $oProject->get_projects();
    notification::send($arrProjects);
    break;

  case 'form': # Форма добавления / редактирования
    // Параметры
    $arrResults = [];
    $oForm = new form();

    // Если редактировани
    if ( $_REQUEST['id'] ) {
      $arrResults['event'] = 'edit';
      $oProject = new project( $_REQUEST['id'] );
    }
    // Если добавление
    else {
      $arrResults['event'] = 'add';
      $oProject = new project();
      // Случайное имя для корректной работы
      $arrDefaultsNames = array(
        'Project for reflection',
        'The best way',
        'Good name, good job',
      );
      // Создаем элемент
      $oProject->title = $arrDefaultsNames[array_rand($arrDefaultsNames, 1)];
      $oProject->user_id = $_SESSION['user']['id'];
      $oProject->active = 1;
      $oProject->add();
    }

    // Поля для добавления
    $oForm->arrFields = $oProject->fields();
    $oForm->arrFields['form'] = ['value'=>'save','type'=>'hidden'];
    $oForm->arrFields['action'] = ['value'=>'projects','type'=>'hidden'];
    $oForm->arrFields['app'] = ['value'=>'app','type'=>'hidden'];
    $oForm->arrFields['session'] = ['value'=>$_SESSION['session'],'type'=>'hidden'];

    // Настройки шаблона
    $oForm->arrTemplateParams['id'] = 'content_loader_save';
    $oForm->arrTemplateParams['title'] = $oLang->get('Projects');
    $oForm->arrTemplateParams['button'] = 'Save';
    $sFormHtml = $oForm->show();

    // Вывод результата
    $arrResults['form'] = $sFormHtml;
    $arrResults['data'] = $oProject->get_projects();

    $arrResults['action'] = 'projects';
    notification::send($arrResults);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $oProject = $_REQUEST['id'] ? new project( $_REQUEST['id'] ) : new project();
    $oProject->arrAddFields = $_REQUEST;

    if ( $_REQUEST['id'] ) {
      $arrResult['event'] = 'save';
      $oProject->save();
    }
    else {
      $arrResult['event'] = 'add';
      $oProject->add();
    }

    $oProject = new project( $oProject->id );
    $arrResult['data'] = $oProject->get_projects();
    $arrResult['text'] = $oLang->get("ChangesSaved");

    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oProject = new project( $_REQUEST['id'] );
    $oProject->del();
    break;
}
