<?
$olang = new lang();

switch ($_REQUEST['form']) {
  case 'actions': # Элементы управления
    $sResultHtml = '';
    $sResultHtml .= '
      <div class="btn-group">
        <a data-action="categories" data-animate_class="animate__flipInY" data-elem=".category" data-form="form" href="javascript:;" class="btn btn-dark content_loader_show">
          <span class="_icon"><i class="fas fa-plus-circle"></i></span>
          <span class="_text">' . $oLang->get("Add") . '</span>
        </a>
      </div>
      ';

    notification::send( $sResultHtml );
    break;

  case 'show': # Вывод элементов
    if ( $_REQUEST['from'] ) return false;

    // Берём все категории
    $oCategory = $_REQUEST['id'] ? new category( $_REQUEST['id'] ) : new category();

    // if ( $_REQUEST['from'] ) $oCategory->from = $_REQUEST['from'];
    // if ( $_REQUEST['limit'] ) $oCategory->limit = $_REQUEST['limit'];

    $oCategory->sortname = 'sort';
    $oCategory->sortdir = 'ASC';
    $oCategory->limit = 30;
    $oCategory->query .= ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    if ( $_REQUEST['only_active'] ) $oCategory->query .= ' AND `active` > 0';
    // Конфиги пользователей
    // SELECT * FROM `categories` LEFT JOIN  `categories_configs` ON `categories_configs`.`category_id` = `categories`.`id`
    $arrCategories = $oCategory->get_categories();

    // Берём конфики костомных категорий пользователя
    $oCategoryConf = new category_config();
    $arrCategories = $oCategoryConf->update_categories($arrCategories);

    notification::send($arrCategories);
    break;

  case 'form': # Форма добавления / редактирования
    // Параметры
    $arrResults = [];
    $oForm = new form();

    // Если редактировани
    if ( $_REQUEST['id'] ) {
      $arrResults['event'] = 'edit';
      $oCategory = new category( $_REQUEST['id'] );
    }
    // Если добавление
    else {
      $arrResults['event'] = 'add';
      $oCategory = new category();
      // Случайное имя для корректной работы
      $arrDefaultsNames = array(
        'Money for reflection',
        'The best way',
        'Good name, good job',
      );
      // Создаем элемент
      $oCategory->title = $arrDefaultsNames[array_rand($arrDefaultsNames, 1)];
      $oCategory->user_id = $_SESSION['user']['id'];
      $oCategory->date = date('Y-m-d');
      $oCategory->active = 1;
      $oCategory->add();
    }

    // Поля для добавления
    $oForm->arrFields = $oCategory->fields();
    $oForm->arrFields['form'] = ['value'=>'save','type'=>'hidden'];
    $oForm->arrFields['action'] = ['value'=>'categories','type'=>'hidden'];
    $oForm->arrFields['app'] = ['value'=>'app','type'=>'hidden'];
    $oForm->arrFields['session'] = ['value'=>$_SESSION['session'],'type'=>'hidden'];

    // Настройки шаблона
    $oForm->arrTemplateParams['id'] = 'content_loader_save';
    $oForm->arrTemplateParams['title'] = $olang->get('Categories');
    $oForm->arrTemplateParams['button'] = 'Save';
    $sFormHtml = $oForm->show();

    // Вывод результата
    $arrResults['form'] = $sFormHtml;
    $arrResults['data'] = $oCategory->get_categories();

    $arrResults['action'] = 'categories';
    notification::send($arrResults);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $oCategory = $_REQUEST['id'] ? new category( $_REQUEST['id'] ) : new category();
    $oCategory->arrAddFields = $_REQUEST;

    if ( $_REQUEST['id'] ) {
      $arrResult['event'] = 'save';
      $oCategory->save();
    }
    else {
      $arrResult['event'] = 'add';
      $oCategory->add();
    }

    $oCategory = new category( $oCategory->id );
    $arrResult['data'] = $oCategory->get_categories();
    $arrResult['text'] = $olang->get('ChangesSaved');

    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oCategory = new category( $_REQUEST['id'] );
    $oCategory->del();
    break;
}
