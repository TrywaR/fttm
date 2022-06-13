<?
$olang = new lang();

switch ($_REQUEST['form']) {
  case 'actions': # Элементы управления
    $sResultHtml = '';
    $sResultHtml .= '
      <div class="btn-group">
        <a data-action="times_categories" data-animate_class="animate__flipInY" data-elem=".times_category" data-form="form" href="javascript:;" class="btn btn-dark content_loader_show">
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
      $oTimesCategory = new times_category( $_REQUEST['id'] );
    }
    // Если добавление
    else {
      $arrResults['event'] = 'add';
      $oTimesCategory = new times_category();
      // Случайное имя для корректной работы
      $arrDefaultsNames = array(
        'Money for reflection',
        'The best way',
        'Good name, good job',
      );
      // Создаем элемент
      $oTimesCategory->title = $arrDefaultsNames[array_rand($arrDefaultsNames, 1)];
      $oTimesCategory->user_id = $_SESSION['user']['id'];
      $oTimesCategory->date = date('Y-m-d');
      $oTimesCategory->active = 1;
      $oTimesCategory->add();
    }

    // Поля для добавления
    $oForm->arrFields = $oTimesCategory->fields();
    $oForm->arrFields['form'] = ['value'=>'save','type'=>'hidden'];
    $oForm->arrFields['action'] = ['value'=>'times_categories','type'=>'hidden'];
    $oForm->arrFields['app'] = ['value'=>'app','type'=>'hidden'];
    $oForm->arrFields['session'] = ['value'=>$_SESSION['session'],'type'=>'hidden'];

    // Настройки шаблона
    $oForm->arrTemplateParams['id'] = 'content_loader_save';
    $oForm->arrTemplateParams['title'] = $olang->get('MoneysCategories');
    $oForm->arrTemplateParams['button'] = 'Save';
    $sFormHtml = $oForm->show();

    // Вывод результата
    $arrResults['form'] = $sFormHtml;
    $arrResults['data'] = (array)$oTimesCategory;

    $arrResults['action'] = 'times_categories';
    notification::send($arrResults);
    break;

  case 'show': # Вывод элементов
    $oCategory = $_REQUEST['id'] ? new times_category( $_REQUEST['id'] ) : new times_category();

    if ( $_REQUEST['from'] ) $oCategory->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oCategory->limit = $_REQUEST['limit'];
    $oCategory->sort = 'sort';
    $oCategory->sortDir = 'ASC';
    $oCategory->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $arrCategories = $oCategory->get_categories();

    notification::send($arrCategories);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $oCategory = $_REQUEST['id'] ? new times_category( $_REQUEST['id'] ) : new times_category();
    $oCategory->arrAddFields = $_REQUEST;
    if ( $_REQUEST['id'] ) $oCategory->save();
    else $oCategory->add();

    $arrResult['data'] = $oCategory->get();

    if ( $_REQUEST['id'] ) $arrResult['event'] = 'save';
    else $arrResult['event'] = 'add';

    $arrResult['text'] = 'Changes saved';
    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oCategory = new times_category( $_REQUEST['id'] );
    $oCategory->del();
    break;
}
