<?
$oLang = new lang();

switch ($_REQUEST['form']) {
  case 'actions': # Элементы управления
    $sResultHtml = '';
    $sResultHtml .= '
      <div class="btn-group">
        <a data-action="times" data-animate_class="animate__flipInY" data-elem=".time" data-form="form" data-filter="true" href="javascript:;" class="btn btn-dark content_loader_show">
          <span class="_icon"><i class="fas fa-plus-circle"></i></span>
          <span class="_text">' . $oLang->get("Add") . '</span>
        </a>
      </div>
      ';

    notification::send( $sResultHtml );
    break;

  case 'show': # Вывод элементов
    $oTime = $_REQUEST['id'] ? new time( $_REQUEST['id'] ) : new time();

    if ( $_REQUEST['from'] ) $oTime->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oTime->limit = $_REQUEST['limit'];

    $oTime->sortMulti = ' `date` DESC, `date_update` DESC ';
    $oTime->query .= ' AND `user_id` = ' . $_SESSION['user']['id'];

    $oFilter = new filter();
    $oTime->query .= $oFilter->get();

    $arrTimes = $oTime->get_times();

    notification::send($arrTimes);
    break;

  case 'form': # Форма добавления / редактирования
    // Параметры
    $arrResults = [];
    $oForm = new form();

    // Если редактировани
    if ( $_REQUEST['id'] ) {
      $arrResults['event'] = 'edit';
      $oTime = new time( $_REQUEST['id'] );
    }
    // Если добавление
    else {
      $arrResults['event'] = 'add';
      $oTime = new time();
      // Случайное имя для корректной работы
      $arrDefaultsNames = array(
        'Time for reflection',
        'The best way',
        'Good name, good job',
      );
      // Создаем элемент
      $oTime->title = $arrDefaultsNames[array_rand($arrDefaultsNames, 1)];
      $oTime->user_id = $_SESSION['user']['id'];
      $oTime->time_planned = '00:00';
      $oTime->time_really = '00:00';
      $oTime->date = date('Y-m-d');
      $oTime->active = 1;
      $oTime->add();
    }

    // Поля для добавления
    $oForm->arrFields = $oTime->fields();

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
    $oForm->arrFields['action'] = ['value'=>'times','type'=>'hidden'];
    $oForm->arrFields['app'] = ['value'=>'app','type'=>'hidden'];
    if ( $_REQUEST['data'] && $_REQUEST['data']['success_click'] ) $oForm->arrFields['success_click'] = ['value'=>$_REQUEST['data']['success_click'],'type'=>'hidden'];
    $oForm->arrFields['session'] = ['value'=>$_SESSION['session'],'type'=>'hidden'];

    // Настройки шаблона
    $oForm->arrTemplateParams['id'] = 'content_loader_save';
    $oForm->arrTemplateParams['title'] = $oLang->get('Times');
    $oForm->arrTemplateParams['button'] = 'Save';
    $sFormHtml = $oForm->show();

    // Вывод результата
    $arrResults['form'] = $sFormHtml;
    $arrResults['data'] = $oTime->get_times();
    $arrResults['action'] = 'times';

    notification::send($arrResults);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $oTime = $_REQUEST['id'] ? new time( $_REQUEST['id'] ) : new time();
    $oTime->arrAddFields = $_REQUEST;
    $oTime->arrAddFields['date_update'] = date("Y-m-d H:i:s");

    if ( $_REQUEST['id'] ) {
      $arrResult['event'] = 'save';
      $oTime->save();
    }
    else {
      $arrResult['event'] = 'add';
      $oTime->add();
    }

    $oTime = new time( $oTime->id );
    $arrResult['data'] = $oTime->get_times();
    $arrResult['text'] = $oLang->get("ChangesSaved");

    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oTime = new time( $_REQUEST['id'] );
    $oTime->del();
    $arrResult = [];
    $arrResult['event'] = 'del';
    $arrResult['text'] = $oLang->get("DeleteSuccess");
    notification::success($arrResult);
    break;
}
