<?
$olang = new lang();

switch ($_REQUEST['form']) {
  case 'actions': # Элементы управления
    $sResultHtml = '';
    $sResultHtml .= '
      <div class="btn-group">
        <a data-action="moneys_categories" data-animate_class="animate__flipInY" data-elem=".money_category" data-form="form" href="javascript:;" class="btn btn-dark content_loader_show">
          <span class="_icon"><i class="fas fa-plus-circle"></i></span>
          <span class="_text">' . $oLang->get("Add") . '</span>
        </a>
      </div>
      ';

    notification::send( $sResultHtml );
    break;

  case 'show': # Вывод элементов
    $oCategory = $_REQUEST['id'] ? new moneys_category( $_REQUEST['id'] ) : new moneys_category();

    if ( $_REQUEST['from'] ) $oCategory->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oCategory->limit = $_REQUEST['limit'];

    $oCategory->sort = 'sort';
    $oCategory->sortDir = 'ASC';
    $oCategory->query .= ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';

    $arrCategories = $oCategory->get_categories();

    notification::send($arrCategories);
    break;

  case 'form': # Форма добавления / редактирования

    // Параметры
    $arrResults = [];
    $oForm = new form();

    // Если редактировани
    if ( $_REQUEST['id'] ) {
      $arrResults['event'] = 'edit';
      $oMoneysCategory = new moneys_category( $_REQUEST['id'] );
    }
    // Если добавление
    else {
      $arrResults['event'] = 'add';
      $oMoneysCategory = new moneys_category();
      // Случайное имя для корректной работы
      $arrDefaultsNames = array(
        'Money for reflection',
        'The best way',
        'Good name, good job',
      );
      // Создаем элемент
      $oMoneysCategory->title = $arrDefaultsNames[array_rand($arrDefaultsNames, 1)];
      $oMoneysCategory->user_id = $_SESSION['user']['id'];
      $oMoneysCategory->date = date('Y-m-d');
      $oMoneysCategory->active = 1;
      $oMoneysCategory->add();
    }

    // Поля для добавления
    $oForm->arrFields = $oMoneysCategory->fields();
    $oForm->arrFields['form'] = ['value'=>'save','type'=>'hidden'];
    $oForm->arrFields['action'] = ['value'=>'moneys_categories','type'=>'hidden'];
    $oForm->arrFields['app'] = ['value'=>'app','type'=>'hidden'];
    $oForm->arrFields['session'] = ['value'=>$_SESSION['session'],'type'=>'hidden'];

    // Настройки шаблона
    $oForm->arrTemplateParams['id'] = 'content_loader_save';
    $oForm->arrTemplateParams['title'] = $olang->get('MoneysCategories');
    $oForm->arrTemplateParams['button'] = 'Save';
    $sFormHtml = $oForm->show();

    // Вывод результата
    $arrResults['form'] = $sFormHtml;
    $arrResults['data'] = $oMoneysCategory->get_categories();

    $arrResults['action'] = 'moneys_categories';
    notification::send($arrResults);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $oCategory = $_REQUEST['id'] ? new moneys_category( $_REQUEST['id'] ) : new moneys_category();
    $oCategory->arrAddFields = $_REQUEST;

    if ( $_REQUEST['id'] ) {
      $arrResult['event'] = 'save';
      $oCategory->save();
    }
    else {
      $arrResult['event'] = 'add';
      $oCategory->add();
    }

    $oCategory = new moneys_category( $oCategory->id );
    $arrResult['data'] = $oCategory->get_category();
    $arrResult['text'] = $olang->get('ChangesSaved');

    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oCategory = new moneys_category( $_REQUEST['id'] );
    $oCategory->del();
    break;
}
