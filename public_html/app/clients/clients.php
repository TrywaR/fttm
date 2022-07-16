<?
$oLang = new lang();

switch ($_REQUEST['form']) {
  case 'actions': # Элементы управления
    $sResultHtml = '';

    $sResultHtml .= '
      <div class="btn-group">
        <a data-action="clients" data-animate_class="animate__flipInY" data-elem=".client" data-form="form" href="javascript:;" class="btn btn-dark content_loader_show">
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
      $oClient = new client( $_REQUEST['id'] );
    }
    // Если добавление
    else {
      $arrResults['event'] = 'add';
      $oClient = new client();
      // Случайное имя для корректной работы
      $arrDefaultsNames = array(
        'Clients for reflection',
        'The best way',
        'Good name, good job',
      );
      // Создаем элемент
      $oClient->title = $arrDefaultsNames[array_rand($arrDefaultsNames, 1)];
      $oClient->user_id = $_SESSION['user']['id'];
      $oClient->active = 1;
      $oClient->add();
    }
    // Поля для добавления
    $oForm->arrFields = $oClient->fields();
    $oForm->arrFields['form'] = ['value'=>'save','type'=>'hidden'];
    $oForm->arrFields['action'] = ['value'=>'clients','type'=>'hidden'];
    $oForm->arrFields['app'] = ['value'=>'app','type'=>'hidden'];
    $oForm->arrFields['session'] = ['value'=>$_SESSION['session'],'type'=>'hidden'];

    // Настройки шаблона
    $oForm->arrTemplateParams['id'] = 'content_loader_save';
    $oForm->arrTemplateParams['title'] = $oLang->get('Clients');
    $oForm->arrTemplateParams['button'] = 'Save';
    $sFormHtml = $oForm->show();

    // Вывод результата
    $arrResults['form'] = $sFormHtml;
    $arrResults['data'] = $oClient->get();

    $arrResults['action'] = 'clients';
    notification::send($arrResults);
    break;

  case 'show': # Вывод элементов
    $oClient = $_REQUEST['id'] ? new client( $_REQUEST['id'] ) : new client();
    if ( $_REQUEST['from'] ) $oClient->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oClient->limit = $_REQUEST['limit'];
    $oClient->sortname = 'sort';
    $oClient->sortdir = 'DESC';
    $oClient->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $arrClients = $oClient->get();
    notification::send($arrClients);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $oClient = $_REQUEST['id'] ? new client( $_REQUEST['id'] ) : new client();
    $oClient->arrAddFields = $_REQUEST;
    if ( $_REQUEST['id'] ) $oClient->save();
    else $oClient->add();

    $arrResult['data'] = $oClient->get();

    if ( $_REQUEST['id'] ) $arrResult['event'] = 'save';
    else $arrResult['event'] = 'add';

    $arrResult['text'] = $oLang->get("ChangesSaved");
    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oClient = new client( $_REQUEST['id'] );
    $oClient->del();
    break;
}
