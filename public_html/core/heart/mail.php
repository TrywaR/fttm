<?
// mail conf
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ( file_exists('lib/PHPMailer/src/Exception.php') ) {
  require 'lib/PHPMailer/src/Exception.php';
  require 'lib/PHPMailer/src/PHPMailer.php';
}
else {
  if ( file_exists(config::$site_root . 'lib/PHPMailer/src/Exception.php') ) {
    require config::$site_root . 'lib/PHPMailer/src/Exception.php';
    require config::$site_root . 'lib/PHPMailer/src/PHPMailer.php';
  }
  else {
    die('PHPMailer error: ' . config::$site_root . 'slib/PHPMailer/src/PHPMailer.php');
  }
}

class mail
{
  public static $to = [];
  public static $arrEmails = [];
  public static $from = [];
  public static $subject = []; # Тема сообщения
  public static $title = []; # Заголовок сообщения
  public static $message = []; # Содержание
  public static $arrFiles = [];
  // public static $headers = [];

  function add_manager_emails() {
    // $arrEmails = [];
    //
    // // + Собираем почты менеджеров и администраторов
    // $sUsersGroupsRoleValidIds = '';
    // $sSeporator = '';
    // foreach (config::$arrUsersGroups as $arrUsersGroup)
    // if ( $arrUsersGroup['role'] < 2 ) {
    //   $sUsersGroupsRoleValidIds .= $sSeporator . $arrUsersGroup['id'];
    //   if ( $sSeporator === '' ) $sSeporator = ', ';
    // }
    //
    // // + Если есть права кому можно отправлять, собираем пользователей с такими правами
    // if ( isset($sUsersGroupsRoleValidIds) ) {
    //   // + Вытаскиваем пользователей с правами на получение уведомлений о модерации
    //   $sQuery = "SELECT * FROM `users` WHERE `active` > 0 AND `group_id` IN (".$sUsersGroupsRoleValidIds.")";
    //   $arrValidUsers = db::query_all($sQuery);
    //
    //   // + Если такие есть
    //   if ( count($arrValidUsers) ) {
    //     // + Собираем их почты
    //     $sUsersValidEmails = '';
    //     $sSeporator = '';
    //     foreach ($arrValidUsers as $arrValidUser) {
    //       $sUsersValidEmails .= $sSeporator . $arrValidUser['email'];
    //       if ( $sSeporator === '' ) $sSeporator = ', ';
    //     }
    //   }
    // }
    //
    // // Почты админов и манагеров
    // $this->arrEmails = $sUsersValidEmails;
    // // return $this->arrEmails;
  }

  function send( $sMailHtml = null ) {
    $sMailHtml = $sMailHtml ? $sMailHtml : '';

    // mail conf
    $mail = new PHPMailer();

    $sEmailBodyHtml = '<div style="display: flex; flex-direction: column; padding: 15px;">';
      $sEmailBodyHtml .= '<div style="padding-bottom: 15px; border-bottom: 1px solid white;">';
        $sEmailBodyHtml .= $this->title ? $this->title : $this->subject;
      $sEmailBodyHtml .= '</div>';
      $sEmailBodyHtml .= '<div style="padding-bottom: 15px;">';
        $sEmailBodyHtml .= $this->message . $sMailHtml;
      $sEmailBodyHtml .= '</div>';
    $sEmailBodyHtml .= '</div>';

    try {
      if ( $this->to ) $mail->addAddress($this->to);
      if ( $this->arrEmails ) foreach ( $this->arrEmails as $sEmail ) $mail->addAddress($sEmail);
      $mail->CharSet = "UTF-8";
      $mail->setFrom($this->from);
      $mail->Subject = $this->subject;
      $mail->msgHTML($sEmailBodyHtml);
      $mail->Body = $sEmailBodyHtml;
      // Attach uploaded files
      if ( count($this->arrFiles) ) foreach ($this->arrFiles as $sFile) $mail->addAttachment($sFile['path']);
      $mail->send();
      if ( $mail->ErrorInfo ) notification::error('mail send error:' . $mail->ErrorInfo);
    }
    catch (Exception $e) {
      notification::error("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
  }

  // Отправка сообщения в телеграмм
  function telegram( $sSubject = false, $sMessages = false, $addRequest = false ) {
    // - Стучим в телегу
    // -- Параметры
    $sApiKey = config::$arrConfig['telegram_api_key'];
    $sChatId = config::$arrConfig['telegram_chat_id'];
    $sSubject = $sSubject ? '*'.$sSubject.'* %0A' : '*New message from app* %0A';
    $sMessages = $sMessages ? $sMessages : '';
    $addRequest = $addRequest ? true : false;

    $sTxt = $sSubject . $sMessages . ' %0A';
    $sUrl = 'https://api.telegram.org/bot'.$sApiKey.'/sendMessage?chat_id='.$sChatId.'&parse_mode=Markdown&text='.$sTxt;

    if ( $addRequest ) {
      // -- Записываем данные с формы
      foreach ($_REQUEST as $key => $value)
      if ( $value != '' && $value != '0' && $value != 'app' )
      $sUrl .= '*'.$key.'*: '.$value.'%0A';
    }
    // -- Паша, отправь плз
    $result = file_get_contents($sUrl);

    // echo 'Сообщение успешно отправленно';
    // - Стучим в телегу х
  }

  function __construct()
  {
    $this->to      = config::$arrConfig['email_to'];
    $this->from    = config::$arrConfig['email_from'];
    $this->subject = config::$arrConfig['name'] . ': ';
    $this->message = '';
    $this->arrFiles = [];
    // mail::$headers =  "From: <". mail::$from .">" . "\r\n".
    //                   "MIME-Version: 1.0 " . "\r\n" .
    //                   "Content-type: text/html; charset=UTF-8";
  }
}
