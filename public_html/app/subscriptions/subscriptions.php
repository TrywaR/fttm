<?
$olang = new lang();

switch ($_REQUEST['form']) {
  case 'actions': # Элементы управления
    $sResultHtml = '';
    $sResultHtml .= '
      <div class="btn-group">
        <a data-action="subscriptions" data-animate_class="animate__flipInY" data-elem=".money_subscription" data-form="form" href="javascript:;" class="btn btn-dark content_loader_show">
          <span class="_icon"><i class="fas fa-plus-circle"></i></span>
          <span class="_text">' . $oLang->get("Add") . '</span>
        </a>
      </div>
      ';

    notification::send( $sResultHtml );
    break;

  case 'month': # Статистика за месяц
    $arrResults = [];

    // Месяц
    $iYear = (int)$_REQUEST['year'] ? $_REQUEST['year'] : date('Y');
    $iMonth = (int)$_REQUEST['month'] ? $_REQUEST['month'] : date('m');
    $dMonth = $iYear . '-' . sprintf("%02d", $iMonth);

    // Подписки
    $oSubscription = new subscription();
    $oSubscription->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $oSubscription->sDateQuery = $dMonth;
    // $oSubscription->show_query = true;
    $arrResults['subscriptions'] = $oSubscription->get_subscriptions();
    $arrResults['subscriptions_sum'] = 0;
    foreach ( $arrResults['subscriptions'] as $arrSubscription ) {
      if ( ! $arrSubscription['paid'] ) {
        if ( $arrSubscription['paid_sum'] ) $arrResults['subscriptions_sum'] = (int)$arrResults['subscriptions_sum'] + (int)$arrSubscription['paid_need'];
        else $arrResults['subscriptions_sum'] = (int)$arrResults['subscriptions_sum'] + (int)$arrSubscription['price'];
      }
    }
    $arrResults['subscriptions_sum'] = floor($arrResults['subscriptions_sum']);

    notification::send($arrResults);
    break;

  case 'show': # Вывод элементов
    $oSubscription = $_REQUEST['id'] ? new subscription( $_REQUEST['id'] ) : new subscription();

    if ( $_REQUEST['from'] ) $oSubscription->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oSubscription->limit = $_REQUEST['limit'];

    $oSubscription->sortname = 'sort';
    $oSubscription->sortdir = 'ASC';
    $oSubscription->query = ' AND `user_id` = ' . $_SESSION['user']['id'];

    $arrSubscriptions = $oSubscription->get_subscriptions();

    notification::send($arrSubscriptions);
    break;

  case 'form': # Форма добавления / редактирования
    // Параметры
    $arrResults = [];
    $oForm = new form();

    // Если редактировани
    if ( $_REQUEST['id'] ) {
      $arrResults['event'] = 'edit';
      $oSubscription = new subscription( $_REQUEST['id'] );
    }
    // Если добавление
    else {
      $arrResults['event'] = 'add';
      $oSubscription = new subscription();
      // Случайное имя для корректной работы
      $arrDefaultsNames = array(
        'Money for reflection',
        'The best way',
        'Good name, good job',
      );
      // Создаем элемент
      $oSubscription->title = $arrDefaultsNames[array_rand($arrDefaultsNames, 1)];
      $oSubscription->user_id = $_SESSION['user']['id'];
      $oSubscription->active = 1;
      $oSubscription->add();
    }

    // Поля для добавления
    $oForm->arrFields = $oSubscription->fields();

    // Сразу заполняем некоторые данне если переданны
    if ( $_REQUEST['data'] ) {
      foreach ($_REQUEST['data'] as $key => $value) {
        if ( isset($oForm->arrFields[$key]) ) {
          $oForm->arrFields[$key]['value'] = $value;
          // $oForm->arrFields[$key]['type'] = 'hidden';
        }
      }
    }

    $oForm->arrFields['form'] = ['value'=>'save','type'=>'hidden'];
    if ( $_REQUEST['data'] && $_REQUEST['data']['success_click'] ) $oForm->arrFields['success_click'] = ['value'=>$_REQUEST['data']['success_click'],'type'=>'hidden'];
    $oForm->arrFields['action'] = ['value'=>'subscriptions','type'=>'hidden'];
    $oForm->arrFields['app'] = ['value'=>'app','type'=>'hidden'];
    $oForm->arrFields['session'] = ['value'=>$_SESSION['session'],'type'=>'hidden'];

    // Настройки шаблона
    $oForm->arrTemplateParams['id'] = 'content_loader_save';
    $oForm->arrTemplateParams['title'] = $olang->get('Subscriptions');
    $oForm->arrTemplateParams['button'] = 'Save';
    $sFormHtml = $oForm->show();

    // Вывод результата
    $arrResults['form'] = $sFormHtml;
    $arrResults['data'] = $oSubscription->get_subscriptions();
    $arrResults['action'] = 'subscriptions';

    notification::send($arrResults);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $oSubscription = $_REQUEST['id'] ? new subscription( $_REQUEST['id'] ) : new subscription();
    $oSubscription->arrAddFields = $_REQUEST;

    if ( $_REQUEST['id'] ) {
      $arrResult['event'] = 'save';
      $oSubscription->save();
    }
    else {
      $arrResult['event'] = 'add';
      $oSubscription->add();
    }

    $oSubscription = new subscription( $oSubscription->id );
    $arrResult['data'] = $oSubscription->get_subscriptions();
    $arrResult['text'] = $olang->get('ChangesSaved');

    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oSubscription = new subscription( $_REQUEST['id'] );
    $oSubscription->del();
    break;
}
