<?
switch ($_REQUEST['form']) {
  case 'login': # Вход
    // Готовим результат вывода
    $arrResult = [
      'text' => $oLang->get('ErrorLoginOrPassword')
    ];
    // Кодируем пасс
    $password = hash( 'ripemd128', $_REQUEST['password'] );
    // Вытаскиваем пользователя
    $arrUser = db::query("SELECT * FROM `users` WHERE `login` = '". $_REQUEST['login'] ."' AND `password` = '". $password . "'");
    if ( $arrUser ) {
      // Создаём модель пользователя
      $arrResult['model'] = 'user';
      $arrResult['data'] = $_SESSION['user'] = $arrUser;
      $_SESSION['theme'] = $_SESSION['user']['theme'];
      $_SESSION['lang'] = $_SESSION['user']['lang'];
      $arrResult['text'] = $oLang->get('SuccessfulLogin');
      $arrResult['location'] = '/';
      // Обновляем сессию
      $oSession = new session( 0, $_SESSION['session'] );
      $oSession->user_id = $arrUser['id'];
      $oSession->save();
      $arrResult['session'] = $oSession->session;
      // Возвращяем результат
      notification::success( $arrResult );
    }
    else notification::error( $arrResult );
    break;

  case 'logout': # Выход
    // Удаляем сессию из базы
    $oSession = new session( 0, $_SESSION['session'] );
    $oSession->del_session();
    // Отчищаем сессию
    session_destroy();
    // Возвращяем результат
    $arrResult['text'] = $oLang->get('SuccessfulExit');
    $arrResult['location'] = '/';
    notification::success( $arrResult );
    break;

  case 'registration': # Регистрация
    // Если пароли не совпадают
    if ( $_REQUEST['password'] != $_REQUEST['password_confirm'] ) notification::error($oLang->get('PasswordsDoNotMatch'));

    // Проверка, используется ли такой Login
    $arrUser = db::query("SELECT * FROM `users` WHERE `login` = '". $_REQUEST['login'] ."'");
    if ( is_array($arrUser) ) notification::error($olang->get('ThisloginIsAlreadyTaken'));

    // Проверка, используется ли такой Email
    if ( $_REQUEST['email'] ) {
      $arrUser = db::query("SELECT * FROM `users` WHERE `email` = '". $_REQUEST['email'] ."'");
      if ( is_array($arrUser) ) notification::error($oLang->get('ThisEmailIsAlreadyTaken'));
    }

    // Регистрация
    $arrData = [];
    $arrData['date_registration'] = date('Y-m-d H:i:s');
    $arrData['login'] = $_REQUEST['login'];
    $arrData['email'] = $_REQUEST['email'];
    $arrData['password'] = hash( 'ripemd128', $_REQUEST['password'] );

    // Referal system
    if ( $_SESSION['referal'] ) {
      $oUserReferal = new user( $_SESSION['referal'] );
      if ( (int)$oUserReferal->id ) {
        $arrData['referal'] = $_SESSION['referal'];
        if ( (int)$oUserReferal->role == 0 ) {
          $oUserReferal->role = 1;
          $oUserReferal->name = 'update';
          $oUserReferal->save();
        }
      }
    };

    $oUser = new user();
    $oUser->arrAddFields = $arrData;

    $arrResults = [];
    $arrResults['text'] = $oLang->get('RegistrationCompletedSuccessfully');
    $arrResults['location'] = '/authorizations/';
    $arrResults['location_time'] = 2000;

    // Отправляем в телегу
    $mailNew = new mail();
    $telegram_messages = 'Логин: ' . $_REQUEST['login'] . ' %0A';
    if ( $_SESSION['referal'] ) {
      $telegram_messages .= '_По приглашению от_: *' . $oUserReferal->login . '* (' . $oUserReferal->id . ')' . '%0A';
    }
    $oResult = $mailNew->telegram('Зарегистрирован новый пользователь', $telegram_messages);

    if ( $oUser->add() ) notification::success($arrResults);
    else notification::error($oLang->get('SomethingWentWrongOhCallTheSuperProgrammers'));
    break;

  case 'password_recovery': # Восстановление пароля
    // Получаем пользователя
    $arrUser = db::query("SELECT * FROM `users` WHERE `email` = '". $_REQUEST['email'] ."'");
    // Если пользователь есть
    if ( $arrUser ) {
      // + Генерируем новый пароль
      // Символы, которые будут использоваться в пароле.
      $chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
      // Количество символов в пароле.
      $max=6;
      // Определяем количество символов в $chars
      $size=StrLen($chars)-1;
      // Определяем пустую переменную, в которую и будем записывать символы.
      $new_password=null;
      // Создаём пароль.
      while($max--) $new_password.=$chars[rand(0,$size)];
      // Шифруем пароль
      $new_password_hash = hash( 'ripemd128', $new_password );

      // + Меняем пароль в базе
      $mySql = "UPDATE `users` SET `password` = '" . $new_password_hash . "' WHERE `email` = '". $arrUser['email'] ."'";
      $arrUserUpdate = db::query($mySql);
      if ( ! isset($arrUserUpdate) )
      notification::error($oLang->get('ErrorSavingPassword'));

      // + Отправляем новый пароль пользователю на почту
      $mailNew = new mail();
      $mailNew->to      = $arrUser['email'];
      $mailNew->subject = $mailNew->subject . $oLeng->get('PasswordRecovery');
      $mailNew->message .= $oLang->get('AccountPasswordСhanged') . ' <strong>' . $arrUser['email'] . '</strong><br/>';
      $mailNew->message .= $oLang->get('NewPassword') . ': <strong>' . $new_password . '</strong><br/>';

      $mailNew->send();

      $arrResults = [];
      $arrResults['text'] = $oLang->get('NewPasswordSendToMail') . ' ' . $arrUser['email'] .'!';
      $arrResults['location'] = '/authorizations/';
      $arrResults['location_time'] = 2000;
      notification::success($arrResults);
    }

    // Пользователя нет
    else notification::error($oLang->get('ThisEmailIsNotRegistered'));
    break;

  # Delete account
  case 'delete':
    $oUser = new user( $_SESSION['user']['id'] );
    $oUser->del();
    $arrResults = [];
    $arrResults['text'] = $oLang->get('YouAccountHasBeenDeleted');
    $arrResults['location'] = '/authorizations/';
    $arrResults['location_time'] = 2000;
    notification::success($arrResults);
    break;
}
