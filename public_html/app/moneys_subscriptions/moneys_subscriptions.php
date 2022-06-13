<?
$olang = new lang();

switch ($_REQUEST['form']) {
  case 'actions': # Элементы управления
    $sResultHtml = '';
    $sResultHtml .= '
      <div class="btn-group">
        <a data-action="moneys_subscriptions" data-animate_class="animate__flipInY" data-elem=".money_subscription" data-form="form" href="javascript:;" class="btn btn-dark content_loader_show">
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
      $oMoneysSubscriptions = new moneys_subscriptions( $_REQUEST['id'] );
    }
    // Если добавление
    else {
      $arrResults['event'] = 'add';
      $oMoneysSubscriptions = new moneys_subscriptions();
      // Случайное имя для корректной работы
      $arrDefaultsNames = array(
        'Money for reflection',
        'The best way',
        'Good name, good job',
      );
      // Создаем элемент
      $oMoneysSubscriptions->title = $arrDefaultsNames[array_rand($arrDefaultsNames, 1)];
      $oMoneysSubscriptions->user_id = $_SESSION['user']['id'];
      $oMoneysSubscriptions->active = 1;
      $oMoneysSubscriptions->add();
    }

    // Поля для добавления
    $oForm->arrFields = $oMoneysSubscriptions->fields();
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
    $arrResults['data'] = $oMoneysSubscriptions->get_subscription();


    $arrResults['action'] = 'moneys_subscriptions';
    notification::send($arrResults);
    break;

  case 'show': # Вывод элементов
    $oMoneysSubscriptions = new moneys_subscriptions( $_REQUEST['id'] );
    $oMoneysSubscriptions->query .= ' AND `user_id` = ' . $_SESSION['user']['id'];
    $arrMoneysSubscriptions = $oMoneysSubscriptions->get_subscription();
    notification::send($arrMoneysSubscriptions);
    break;

  case 'show_all': # Вывод элементов
    $oMoneysSubscriptions = new moneys_subscriptions();
    if ( $_REQUEST['from'] ) $oMoneysSubscriptions->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oMoneysSubscriptions->limit = $_REQUEST['limit'];
    $oMoneysSubscriptions->sort = 'sort';
    $oMoneysSubscriptions->sortDir = 'ASC';
    $oMoneysSubscriptions->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    // $oMoneysSubscriptions->show_query = true;
    $arrMoneysSubscriptions = $oMoneysSubscriptions->get_subscriptions();
    notification::send($arrMoneysSubscriptions);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $oMoneysSubscriptions = $_REQUEST['id'] ? new moneys_subscriptions( $_REQUEST['id'] ) : new moneys_subscriptions();
    $oMoneysSubscriptions->arrAddFields = $_REQUEST;
    if ( $_REQUEST['id'] ) $oMoneysSubscriptions->save();

    else $oMoneysSubscriptions->add();

    $arrResult['data'] = $oMoneysSubscriptions->get_subscription();

    if ( $_REQUEST['id'] ) $arrResult['event'] = 'save';
    else $arrResult['event'] = 'add';

    $arrResult['text'] = $olang->get('ChangesSaved');
    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oMoneysSubscriptions = new moneys_subscriptions( $_REQUEST['id'] );
    $oMoneysSubscriptions->del();
    break;
}
