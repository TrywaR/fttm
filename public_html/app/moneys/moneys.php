<?
$olang = new lang();

switch ($_REQUEST['form']) {
  case 'actions': # Элементы управления
    $sResultHtml = '';
    $sResultHtml .= '
      <div class="btn-group">
        <a data-action="moneys" data-animate_class="animate__flipInY" data-elem=".money" data-form="form" data-filter="true" href="javascript:;" class="btn btn-dark content_loader_show">
          <span class="_icon"><i class="fas fa-plus-circle"></i></span>
          <span class="_text">' . $oLang->get("Add") . '</span>
        </a>
      </div>
      ';

    notification::send( $sResultHtml );
    break;

  case 'show': # Вывод элементов
    $oMoney = $_REQUEST['id'] ? new money( $_REQUEST['id'] ) : new money();

    if ( $_REQUEST['from'] ) $oMoney->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oMoney->limit = $_REQUEST['limit'];

    $oMoney->sortMulti = ' `date` DESC, `date_update` DESC ';
    $oMoney->query .= ' AND `user_id` = ' . $_SESSION['user']['id'];

    $oFilter = new filter();
    $oMoney->query .= $oFilter->get();

    $arrMoneys = $oMoney->get_moneys();

    notification::send($arrMoneys);
    break;

  case 'form': # Форма добавления / редактирования
    // Параметры
    $arrResults = [];
    $oForm = new form();

    // Если редактировани
    if ( $_REQUEST['id'] ) {
      $arrResults['event'] = 'edit';
      $oMoney = new money( $_REQUEST['id'] );
    }
    // Если добавление
    else {
      $arrResults['event'] = 'add';
      $oMoney = new money();
      // Случайное имя для корректной работы
      $arrDefaultsNames = array(
        'Money for reflection',
        'The best way',
        'Good name, good job',
      );
      // Создаем элемент
      $oMoney->title = $arrDefaultsNames[array_rand($arrDefaultsNames, 1)];
      $oMoney->user_id = $_SESSION['user']['id'];
      $oMoney->date = date('Y-m-d');
      $oMoney->active = 1;
      $oMoney->add();
      $oMoney = new money( $oMoney->id );
    }

    // Поля для добавления
    $oForm->arrFields = $oMoney->fields();

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
    $oForm->arrFields['action'] = ['value'=>'moneys','type'=>'hidden'];
    $oForm->arrFields['app'] = ['value'=>'app','type'=>'hidden'];
    if ( $_REQUEST['data'] && $_REQUEST['data']['success_click'] ) $oForm->arrFields['success_click'] = ['value'=>$_REQUEST['data']['success_click'],'type'=>'hidden'];
    $oForm->arrFields['session'] = ['value'=>$_SESSION['session'],'type'=>'hidden'];

    // Настройки шаблона
    $oForm->arrTemplateParams['id'] = 'content_loader_save';
    $oForm->arrTemplateParams['title'] = $olang->get('Moneys');
    $oForm->arrTemplateParams['button'] = 'Save';
    $sFormHtml = $oForm->show();

    // Вывод результата
    $arrResults['form'] = $sFormHtml;
    $arrResults['data'] = $oMoney->get_moneys();
    $arrResults['action'] = 'moneys';

    notification::send($arrResults);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $oMoney = $_REQUEST['id'] ? new money( $_REQUEST['id'] ) : new money();
    $oMoney->arrAddFields['date_update'] = date("Y-m-d H:i:s");
    $oMoney->arrAddFields = $_REQUEST;

    // Обновление карты
    if ( $_REQUEST['card'] ) {
      $oCard = new card( $_REQUEST['card'] );

      // Если обновление, удаляем старое значение
      if ( $oMoney->id )
      if ( (int)$oMoney->type == 2 ) $oCard->balance_remove( $oMoney->price );
      else {
        $oCard->balance_add( $oMoney->price );
        // Если комиссиия
        if ( (int)$oMoney->category == 2 ) $oCard->commission_remove( $oMoney->price );
      }

      // Если пополнение
      if ( (int)$_REQUEST['type'] == 2 ) $oCard->balance_add( $_REQUEST['price'] );
      // Если тарата
      else {
        $oCard->balance_remove( $_REQUEST['price'] );
        // Если комиссиия
        if ( (int)$_REQUEST['category'] == 2 ) $oCard->commission_add( $_REQUEST['price'] );
      }
    }

    // Обновление карты на которую зачисление
    if ( $_REQUEST['to_card'] ) {
      $oCardTo = new card( $_REQUEST['to_card'] );
      $oCardTo->balance_add( $_REQUEST['price'] );
    }

    if ( $_REQUEST['id'] ) {
      $arrResult['event'] = 'save';
      $oMoney->save();
    }
    else {
      $arrResult['event'] = 'add';
      $oMoney->add();
    }

    $oMoney = new money( $oMoney->id );
    $arrResult['data'] = $oMoney->get_moneys();
    $arrResult['text'] = $oLang->get("ChangesSaved");

    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oMoney = new money( $_REQUEST['id'] );
    $oMoney->del();
    $arrResult = [];

    // Обновление карты
    if ( $_REQUEST['card'] ) {
      $oCard = new card( $_REQUEST['card'] );
      // Если пополнение
      if ( (int)$_REQUEST['type'] == 2 ) {
        $oCard->balance_remove( $_REQUEST['price'] );
      }
      // Если тарата
      else {
        $oCard->balance_add( $_REQUEST['price'] );
        // Если комиссиия
        if ( (int)$_REQUEST['category'] == 1 ) $oCard->commission_remove( $_REQUEST['price'] );
      }
    }

    $arrResult['event'] = 'del';
    $arrResult['text'] = $oLang->get("DeleteSuccess");
    notification::success($arrResult);
    break;
}
