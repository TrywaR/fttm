<?
$olang = new lang();

switch ($_REQUEST['form']) {
  case 'actions': # Элементы управления
    $sResultHtml = '';
    $sResultHtml .= '
      <div class="btn-group">
        <a data-action="moneys_subscriptions" data-animate_class="animate__flipInY" data-elem=".money_subscription" data-form="form" href="javascript:;" class="btn btn-dark content_loader_show">
          <span class="_icon"><i class="fas fa-plus-circle"></i></span>
          <span class="_text">' . $oLang->get("Add") . '</span>
        </a>
      </div>
      ';

    notification::send( $sResultHtml );
    break;

  case 'show': # Вывод элементов
    $oSubscriptions = $_REQUEST['id'] ? new moneys_subscriptions( $_REQUEST['id'] ) : new moneys_subscriptions();

    if ( $_REQUEST['from'] ) $oSubscriptions->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oSubscriptions->limit = $_REQUEST['limit'];

    $oSubscriptions->sort = 'sort';
    $oSubscriptions->sortDir = 'ASC';
    $oSubscriptions->query = ' AND `user_id` = ' . $_SESSION['user']['id'];

    $arrSubscriptions = $oSubscriptions->get_subscriptions();

    notification::send($arrSubscriptions);
    break;

  case 'form': # Форма добавления / редактирования
    // Параметры
    $arrResults = [];
    $oForm = new form();

    // Если редактировани
    if ( $_REQUEST['id'] ) {
      $arrResults['event'] = 'edit';
      $oSubscriptions = new moneys_subscriptions( $_REQUEST['id'] );
    }
    // Если добавление
    else {
      $arrResults['event'] = 'add';
      $oSubscriptions = new moneys_subscriptions();
      // Случайное имя для корректной работы
      $arrDefaultsNames = array(
        'Money for reflection',
        'The best way',
        'Good name, good job',
      );
      // Создаем элемент
      $oSubscriptions->title = $arrDefaultsNames[array_rand($arrDefaultsNames, 1)];
      $oSubscriptions->user_id = $_SESSION['user']['id'];
      $oSubscriptions->active = 1;
      $oSubscriptions->add();
    }

    // Поля для добавления
    $oForm->arrFields = $oSubscriptions->fields();
    $oForm->arrFields['form'] = ['value'=>'save','type'=>'hidden'];
    $oForm->arrFields['action'] = ['value'=>'moneys_subscriptions','type'=>'hidden'];
    $oForm->arrFields['app'] = ['value'=>'app','type'=>'hidden'];
    $oForm->arrFields['session'] = ['value'=>$_SESSION['session'],'type'=>'hidden'];

    // Настройки шаблона
    $oForm->arrTemplateParams['id'] = 'content_loader_save';
    $oForm->arrTemplateParams['title'] = $olang->get('Subscriptions');
    $oForm->arrTemplateParams['button'] = 'Save';
    $sFormHtml = $oForm->show();

    // Вывод результата
    $arrResults['form'] = $sFormHtml;
    $arrResults['data'] = $oSubscriptions->get_subscription();
    $arrResults['action'] = 'moneys_subscriptions';

    notification::send($arrResults);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $oSubscriptions = $_REQUEST['id'] ? new moneys_subscriptions( $_REQUEST['id'] ) : new moneys_subscriptions();
    $oSubscriptions->arrAddFields = $_REQUEST;

    if ( $_REQUEST['id'] ) {
      $arrResult['event'] = 'save';
      $oSubscriptions->save();
    }
    else {
      $arrResult['event'] = 'add';
      $oSubscriptions->add();
    }

    $oSubscriptions = new moneys_subscriptions( $oSubscriptions->id );
    $arrResult['data'] = $oSubscriptions->get_subscription();
    $arrResult['text'] = $olang->get('ChangesSaved');

    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oSubscriptions = new moneys_subscriptions( $_REQUEST['id'] );
    $oSubscriptions->del();
    break;
}
