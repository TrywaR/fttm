<?
$oLang = new lang();

switch ($_REQUEST['form']) {
  case 'actions': # Элементы управления
    $sResultHtml = '';
    $sResultHtml .= '
      <div class="btn-group">
        <a data-action="cards" data-animate_class="animate__flipInY" data-elem=".card_item" data-form="form" href="javascript:;" class="btn btn-dark content_loader_show">
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
      $oCard = new card( $_REQUEST['id'] );
    }
    // Если добавление
    else {
      $arrResults['event'] = 'add';
      $oCard = new card();
      // Случайное имя для корректной работы
      $arrDefaultsNames = array(
        'Money for reflection',
        'The best way',
        'Good name, good job',
      );
      // Создаем элемент
      $oCard->title = $arrDefaultsNames[array_rand($arrDefaultsNames, 1)];
      $oCard->user_id = $_SESSION['user']['id'];
      $oCard->date_update = date('Y-m-d H:i:s');
      $oCard->active = 1;
      $oCard->add();
    }

    // Поля для добавления
    $oForm->arrFields = $oCard->fields();
    $oForm->arrFields['form'] = ['value'=>'save','type'=>'hidden'];
    $oForm->arrFields['action'] = ['value'=>'cards','type'=>'hidden'];
    $oForm->arrFields['app'] = ['value'=>'app','type'=>'hidden'];
    $oForm->arrFields['session'] = ['value'=>$_SESSION['session'],'type'=>'hidden'];

    // Настройки шаблона
    $oForm->arrTemplateParams['id'] = 'content_loader_save';
    $oForm->arrTemplateParams['title'] = $oLang->get('Cards');
    $oForm->arrTemplateParams['button'] = 'Save';
    $sFormHtml = $oForm->show();

    // Вывод результата
    $arrResults['form'] = $sFormHtml;
    $arrResults['data'] = (array)$oCard;

    $arrResults['action'] = 'cards';
    notification::send($arrResults);
    break;

  case 'show': # Вывод элементов
    $oCard = new card( $_REQUEST['id'] );
    $arrCard = $oCard->get_card();
    notification::send($arrCard);
    break;

  case 'show_all': # Вывод элементов
    $oCard = new card();

    if ( $_REQUEST['from'] ) $oCard->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oCard->limit = $_REQUEST['limit'];

    $oCard->sort = 'sort';
    $oCard->sortDir = 'DESC';
    $oCard->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $arrCards = $oCard->get_cards();

    foreach ( $arrCards as & $arrCard ) if ( (int)$arrCard['user_id'] != 0 ) $arrCard['noedit'] = 'true';

    notification::send( $arrCards );
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $oCard = $_REQUEST['id'] ? new card( $_REQUEST['id'] ) : new card();
    $oCard->arrAddFields = $_REQUEST;
    if ( $_REQUEST['id'] ) $oCard->save();
    else $oCard->add();

    $arrResult['data'] = $oCard->get();

    if ( $_REQUEST['id'] ) $arrResult['event'] = 'save';
    else $arrResult['event'] = 'add';

    $arrResult['text'] = $olang->get('ChangesSaved');
    notification::success($arrResult);
    break;

  case 'reload': # Обновление данных
    $arrResult = [];
    $oCard = new card( $_REQUEST['id'] );
    $oCard->balance_reload();
    $arrResult['data'] = $oCard->get();
    $arrResult['event'] = 'save';
    $arrResult['location_reload'] = true;
    $arrResult['text'] = $olang->get('CardUpdate');
    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oCard = new card( $_REQUEST['id'] );
    $oCard->del();
    break;
}
