<?
$oLang = new lang();

switch ($_REQUEST['form']) {
  case 'actions': # Элементы управления
    $sResultHtml = '';
    $sResultHtml .= '
      <div class="btn-group">
        <a data-action="cards" data-animate_class="animate__flipInY" data-elem=".card_item" data-form="form" href="javascript:;" class="btn btn-dark content_loader_show">
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

    // Собираем карты
    $oCard = $_REQUEST['id'] ? new card( $_REQUEST['id'] ) : new card();
    if ( $_REQUEST['from'] ) $oCard->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oCard->limit = $_REQUEST['limit'];
    $oCard->sortname = 'sort';
    $oCard->sortdir = 'ASC';
    $oCard->query .= ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $arrCards = $oCard->get_cards();

    $arrMoneys = [];

    foreach ($arrCards as $arrCard) {
      // array('id'=>0,'name'=>$oLang->get('CardDebit')),
      // array('id'=>1,'name'=>$oLang->get('CardCredit')),
      // array('id'=>2,'name'=>$oLang->get('CardBill')),
      switch ($arrCard['type']) {
        case 0: # Депетовая
          break;
        case 1: # Кредитовая
          // Оплата за обслуживание
          // Оплата коммиссии
          // - Определяем когда оплата за обслуживание
          // $arrCard['service']
          // $arrCard['date_service']
          // - Если время платить, собираем денежку
          // $arrMoneys
          break;
        case 2: # Счёт
          // Начисление
          break;
      }
    }

    // Определяем тип
    // - Карты
    // Оплата за обслуживание
    // - Определяем когда оплата за обслуживание
    // - Если время платить, собираем денежку

    // - Кредитка
    // Оплата коммиссии
    // - Определяем безпроцентный период
    // - Вытасвиваем платежи за это время (хз зачем)
    // - Вытаскиваем платежи дальше без процентного периода (Берём лемит в год)
    // - Прибавляем переводы на карту
    // - От полученной суммы вычитаем процент
    // - Выставляем этот платёж, учитывая дату платежа

    // - Счёт, дебет
    // Начисление
    // - Узнаем период после которого идёт начисление (Например месяц)
    // - Берем платежи сделанные месяц* назад
    // - Добавляем переводы на карту или счёт
    // - Получаем процент от суммы
    // Выставляем начисление

    // Сортируем по дате

    notification::send($arrResults);
    break;

  case 'show': # Вывод элементов
    $oCard = $_REQUEST['id'] ? new card( $_REQUEST['id'] ) : new card();

    if ( $_REQUEST['from'] ) $oCard->from = $_REQUEST['from'];
    if ( $_REQUEST['limit'] ) $oCard->limit = $_REQUEST['limit'];

    $oCard->sortname = 'sort';
    $oCard->sortdir = 'ASC';
    $oCard->query .= ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';

    $arrCard = $oCard->get_cards();

    notification::send($arrCard);
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
    $arrResults['data'] = $oCard->get_cards();

    $arrResults['action'] = 'cards';
    notification::send($arrResults);
    break;

  case 'save': # Сохранение изменений
    $arrResult = [];
    $oCard = $_REQUEST['id'] ? new card( $_REQUEST['id'] ) : new card();
    $oCard->arrAddFields = $_REQUEST;

    if ( $_REQUEST['id'] ) {
      $arrResult['event'] = 'save';
      $oCard->save();
    }
    else {
      $arrResult['event'] = 'add';
      $oCard->add();
    }

    $oCard = new card( $oCard->id );
    $arrResult['data'] = $oCard->get_cards();
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
