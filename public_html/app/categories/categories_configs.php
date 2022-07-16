<?
$olang = new lang();

switch ($_REQUEST['form']) {
  case 'show': # Вывод элементов
    $oCategoryConf = $_REQUEST['id'] ? new category_config( $_REQUEST['id'] ) : new category_config();

    if ( $_REQUEST['from'] ) $oCategoryConf->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oCategoryConf->limit = $_REQUEST['limit'];

    $oCategoryConf->sortname = 'sort';
    $oCategoryConf->sortdir = 'ASC';
    $oCategoryConf->query .= ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';

    $arrCategories = $oCategoryConf->get_categories_configs();

    notification::send($arrCategories);
    break;

  case 'form': # Форма добавления / редактирования
    // Параметры
    $arrResults = [];
    $oForm = new form();

    // Если редактировани
    if ( $_REQUEST['id'] ) {
      $arrResults['event'] = 'edit';
      $oCategoryConf = new category_config( $_REQUEST['id'] );
    }
    // Если добавление
    else {
      $arrResults['event'] = 'add';
      $oCategoryConf = new category_config();
      // Случайное имя для корректной работы
      $arrDefaultsNames = array(
        'Money for reflection',
        'The best way',
        'Good name, good job',
      );
      // Создаем элемент
      $oCategoryConf->title = $arrDefaultsNames[array_rand($arrDefaultsNames, 1)];
      $oCategoryConf->user_id = $_SESSION['user']['id'];
      $oCategoryConf->active = 1;
      $oCategoryConf->add();
    }

    // Поля для добавления
    $oForm->arrFields = $oCategoryConf->fields();
    $oForm->arrFields['form'] = ['value'=>'save','type'=>'hidden'];
    $oForm->arrFields['action'] = ['value'=>'categories_configs','type'=>'hidden'];
    $oForm->arrFields['app'] = ['value'=>'app','type'=>'hidden'];
    $oForm->arrFields['session'] = ['value'=>$_SESSION['session'],'type'=>'hidden'];

    // Настройки шаблона
    $oForm->arrTemplateParams['id'] = 'content_loader_save';
    $oForm->arrTemplateParams['title'] = $olang->get('Categories');
    $oForm->arrTemplateParams['button'] = 'Save';
    $sFormHtml = $oForm->show();

    // Вывод результата
    $arrResults['form'] = $sFormHtml;
    $arrResults['data'] = $oCategoryConf->get_categories_configs();

    $arrResults['action'] = 'categories_configs';
    notification::send($arrResults);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $oCategoryConf = $_REQUEST['category_id'] ? new category_config( $_REQUEST['category_id'] ) : new category_config();
    $oCategoryConf->arrAddFields = $_REQUEST;

    if ( $_REQUEST['id'] ) {
      $arrResult['event'] = 'save';
      $oCategoryConf->save();
    }
    else {
      $arrResult['event'] = 'add';
      $oCategoryConf->add();
    }

    $oCategoryConf = new category_config( $oCategoryConf->category_id );
    $arrResult['data'] = $oCategoryConf->get_categories_configs();
    $arrResult['text'] = $olang->get('ChangesSaved');

    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oCategoryConf = new category_config( $_REQUEST['category_id'] );
    $oCategoryConf->del();
    break;
}
