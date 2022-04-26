<?
/**
 * Form
 */
class form
{
  public static $arrFields = []; # Поля в форму
  public static $arrTemplateParams = []; # Параметры шаблона
  public static $bModeration = true; # Включить запрос на модерацию

  // Показ формы
  public function show(){
    $sResultHtml = '';
    // Настройки шаблона
    $sContent = $this->sections();
    $arrTemplateParams = $this->arrTemplateParams;
    $arrTemplateParams['content'] = $sContent;
    if ( $this->arrFields['html'] ) $arrTemplateParams['html'] = $this->arrFields['html'];

    ob_start();
    include 'core/templates/forms/block_modal.php';
    $sResultHtml = ob_get_contents();
    ob_end_clean();
    return $sResultHtml;
  }

  // Оформление полей
  public function sections(){
    $sResultHtml = '';
    $arrFields = $this->arrFields;

    // Проверки
    if ( isset($arrFields['creator_id']) && $arrFields['creator_id']['value'] != $_SESSION['user']['id'] ) {
      if ( $bModeration ) {
        $arrFields['moderation'] = ['title'=>'Запрос на активацию раздела','type'=>'checkbox'];
        unset($arrFields['user_group']);
        unset($arrFields['active']);
        unset($arrFields['disabled']);
      }
    }

    $bSection = false;
    $arrFieldsTextarea = [];
    if ( ! $this->single_sections ) {
      foreach ($arrFields as $name => $oFields) {
        switch ($oFields['section']) {
          case 2:
            $arrFieldsTextarea[$name] = $oFields;
            $bSection = true;
            unset($arrFields[$name]);
            break;
        }
        switch ($oFields['type']) {
          case 'checkbox':
            $arrFieldsTextarea[$name] = $oFields;
            $bSection = true;
            unset($arrFields[$name]);
            break;
          case 'tags':
            $arrFieldsTextarea[$name] = $oFields;
            $bSection = true;
            unset($arrFields[$name]);
            break;
          case 'files':
            $arrFieldsTextarea[$name] = $oFields;
            $bSection = true;
            unset($arrFields[$name]);
            break;
          case 'code':
            $arrFieldsTextarea[$name] = $oFields;
            $bSection = true;
            unset($arrFields[$name]);
            break;
          case 'textarea':
            $arrFieldsTextarea[$name] = $oFields;
            $bSection = true;
            unset($arrFields[$name]);
            break;
        }
      }
    }

    if ( $bSection && ! $this->single_sections ) {
      $sResultHtml .= '<div class="block_section _40">';
        $sResultHtml .= $this->fields( $arrFields );
      $sResultHtml .= '</div>';
      $sResultHtml .= '<div class="block_section _60">';
        $sResultHtml .= $this->fields( $arrFieldsTextarea );
      $sResultHtml .= '</div>';
    }
    else {
      $sResultHtml .= '<div class="block_section _100">';
        $sResultHtml .= $this->fields( $arrFields );
      $sResultHtml .= '</div>';
    }

    return $sResultHtml;
  }

  // Обработка полей ввода
  public function fields( $arrFields ){
    ob_start();
    $sResultHtml = '';

    // Обработка данных
    foreach ($arrFields as $name => $oFields) {
      $arrTemplateParams = [];
      $arrTemplateParams['title'] = $oFields['title'];
      $arrTemplateParams['name'] = $name;
      $arrTemplateParams['options'] = $oFields['options'];
      $arrTemplateParams['value'] = $oFields['value'];
      $arrTemplateParams['class'] = $oFields['class'];
      $arrTemplateParams['buttons'] = $oFields['buttons'];
      if ( $oFields['disabled'] ) $arrTemplateParams['disabled'] = $oFields['disabled'];
      if ( $oFields['required'] ) $arrTemplateParams['required'] = $oFields['required'];

      switch ( $oFields['type'] ) {
        case 'text':
          include 'core/templates/forms/text.php';
          break;

        case 'email':
          include 'core/templates/forms/email.php';
          break;

        case 'password':
          include 'core/templates/forms/password.php';
          break;

        case 'number':
          include 'core/templates/forms/number.php';
          break;

        case 'textarea':
          include 'core/templates/forms/textarea.php';
          break;

        case 'select':
          include 'core/templates/forms/select.php';
          break;

        case 'time':
          include 'core/templates/forms/time.php';
          break;

        case 'timer':
          include 'core/templates/forms/timer.php';
          break;

        case 'date':
          include 'core/templates/forms/date.php';
          break;

        case 'code':
          $arrTemplateParams['lang'] = $oFields['lang'];
          include 'core/templates/forms/code.php';
          break;

        case 'tags':
          $arrTemplateParams['tags_elem_id'] = $oFields['tags_elem_id'];
          $arrTemplateParams['tags_parents'] = $oFields['tags_parents'];
          $arrTemplateParams['tags_type'] = $oFields['tags_type'];
          if ( $oFields['tags_elem_id'] || $oFields['tags_parents'] )
          include 'core/templates/tags/tags.php';
          break;

        case 'files':
          $arrTemplateParams['files_elem_id'] = $oFields['files_elem_id'];
          $arrTemplateParams['files_table'] = $oFields['files_table'];
          $arrTemplateParams['files_type'] = $oFields['files_type'];
          include 'core/templates/files/files.php';
          break;

        case 'checkbox':
          include 'core/templates/forms/checkbox.php';
          break;

        case 'date_time':
          include 'core/templates/forms/date_time.php';
          break;

        case 'hidden':
          include 'core/templates/forms/hidden.php';
          break;

      }
    }

    $sResultHtml = ob_get_contents();
    ob_end_clean();
    return $sResultHtml;
  }

  // Модерация данных
  function moderation($sCategoryName, $iItenId){
    // // + Собираем их почты
    // $sUsersValidEmails = '';
    // $sSeporator = '';
    // foreach ($arrValidUsers as $arrValidUser) {
    //   $sUsersValidEmails .= $sSeporator . $arrValidUser['email'];
    //   if ( $sSeporator === '' ) $sSeporator = ', ';
    // }
    // // + Собираем информацию о пользователе
    // $arrUser = new user($_SESSION['user']['id']);
    //
    // // + Отправляем запрос на модерацию на почту
    // $mailNew = new mail();
    // // $mailNew->add_manager_emails();
    // $mailNew->to = $sUsersValidEmails;
    // $mailNew->subject .= 'Запрос на модерацию';
    // $mailNew->message .= 'Событие <strong>' . $sCategoryName . '</strong><br/>';
    // if ( isset($arrUser->email) ){
    //   $mailNew->message .= 'Автор <strong>' . $arrUser->first_name;
    //   $mailNew->message .=  ' ' . $arrUser->last_name;
    //   $mailNew->message .=  ' (' . $arrUser->email . ')</strong><br/>';
    // }
    // $mailNew->message .= 'Id материала <strong>' . $iItenId . '</strong><br/>';
    // $mailNew->message .= '<a href="'.config::$site_url.'" target="_blank">Посмотреть</a>';
    // $mailNew->send();
    //
    // // + Отправляем в телегу
    // $telegram_messages = '';
    // if ( isset($arrUser->email) ){
    //   $telegram_messages .= 'Автор *' . $arrUser->first_name;
    //   $telegram_messages .=  ' ' . $arrUser->last_name;
    //   $telegram_messages .=  ' (' . $arrUser->email . ')* %0A';
    // }
    // $telegram_messages .= 'Событие * ' . $sCategoryName . ' * %0A';
    // $telegram_messages .= 'Id материала * ' . $iItenId . ' * %0A';
    // mail::telegram('Запрос на модерацию', $telegram_messages);
  }

  function __construct(){
    $this->arrFields = []; # Поля в форму
    $this->arrTemplateParams = []; # Параметры шаблона
    // Модерация
    if ( $_SESSION['user']['role_val'] > 1 ) $this->bModeration = true;
    else $this->bModeration = false;
  }
}
