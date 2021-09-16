<?
/**
 * Form
 */
class form
{
  public static $arrFields = []; # Поля в форму
  public static $arrTemplateParams = []; # Параметры шаблона

  // Показ формы
  public function show(){
    // Настройки шаблона
    $sContent = $this->sections();
    $arrTemplateParams = $this->arrTemplateParams;
    $arrTemplateParams['content'] = $sContent;

    include 'core/templates/forms/block_modal.php';
    die();
  }

  // Оформление полей
  public function sections(){
    $sResultHtml = '';
    $arrFields = $this->arrFields;

    $bSection = false;
    $arrFieldsTextarea = [];
    foreach ($arrFields as $name => $oFields) {
      switch ($oFields['type']) {
        case 'files':
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

    $sResultHtml .= '<div class="block_section _40">';
      $sResultHtml .= $this->fields( $arrFields );
    $sResultHtml .= '</div>';
    $sResultHtml .= '<div class="block_section _60">';
      $sResultHtml .= $this->fields( $arrFieldsTextarea );
    $sResultHtml .= '</div>';

    return $sResultHtml;
  }

  // Обработка полей ввода
  public function fields( $arrFields ){
    ob_start();
    $sResultHtml = '';

    // Проверки
    if ( $_SESSION['role']['role'] > 1 ) $arrFields['moderation'] = ['title'=>'Запрос на активацию раздела','type'=>'checkbox'];
    if ( $_SESSION['role']['role'] >= 2 ) {
      unset($arrFields['user_group']);
      unset($arrFields['active']);
      unset($arrFields['disabled']);
    }

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

        case 'files':
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
    // + Праметры
    // $sCategoryName - Название раздела
    // $iItenId - Id материала

    // + Собираем почты менеджеров и администраторов
    $sUsersGroupsRoleValidIds = '';
    $sSeporator = '';
    foreach (config::$arrUsersGroups as $arrUsersGroup)
    if ( $arrUsersGroup['role'] < 2 ) {
      $sUsersGroupsRoleValidIds .= $sSeporator . $arrUsersGroup['id'];
      if ( $sSeporator === '' ) $sSeporator = ', ';
    }

    // + Если есть права кому можно отправлять, собираем пользователей с такими правами
    if ( isset($sUsersGroupsRoleValidIds) ) {
      // + Вытаскиваем пользователей с правами на получение уведомлений о модерации
      $sQuery = "SELECT * FROM `app_users` WHERE `active` > 0 AND `group_id` IN (".$sUsersGroupsRoleValidIds.")";
      $arrValidUsers = db::query_all($sQuery);

      // + Если такие есть
      if ( count($arrValidUsers) ) {
        // + Собираем их почты
        $sUsersValidEmails = '';
        $sSeporator = '';
        foreach ($arrValidUsers as $arrValidUser) {
          $sUsersValidEmails .= $sSeporator . $arrValidUser['email'];
          if ( $sSeporator === '' ) $sSeporator = ', ';
        }
        // + Собираем информацию о пользователе
        $arrUser = new user($_SESSION['user']['id']);

        // + Отправляем запрос на модерацию на почту
        $mailNew = new mail();
        $mailNew::$to = $sUsersValidEmails;
        $mailNew::$subject .= 'Запрос на модерацию';
        $mailNew::$message .= 'Событие <strong>' . $sCategoryName . '</strong><br/>';
        if ( isset($arrUser->email) ){
          $mailNew::$message .= 'Автор <strong>' . $arrUser->first_name;
          $mailNew::$message .=  ' ' . $arrUser->last_name;
          $mailNew::$message .=  ' (' . $arrUser->email . ')</strong><br/>';
        }
        $mailNew::$message .= 'Id материала <strong>' . $iItenId . '</strong><br/>';
        $mailNew::$message .= '<a href="'.config::$site_url.'" target="_blank">Посмотреть</a>';
        $mailNew::send();

        // + Отправляем в телегу
        $telegram_messages = '';
        if ( isset($arrUser->email) ){
          $telegram_messages .= 'Автор *' . $arrUser->first_name;
          $telegram_messages .=  ' ' . $arrUser->last_name;
          $telegram_messages .=  ' (' . $arrUser->email . ')* %0A';
        }
        $telegram_messages .= 'Событие * ' . $sCategoryName . ' * %0A';
        $telegram_messages .= 'Id материала * ' . $iItenId . ' * %0A';
        mail::telegram('Запрос на модерацию', $telegram_messages);
      }
    }
  }

  function __construct(){
    $this->arrFields = []; # Поля в форму
    $this->arrTemplateParams = []; # Параметры шаблона
  }
}
