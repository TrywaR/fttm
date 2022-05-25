<?
switch ($_REQUEST['form']) {
  case 'login': # Вход
    // Готовим результат вывода
    $arrResult = [
      'text' => 'Error entering login or password!'
    ];
    // Кодируем пасс
    $password = hash( 'ripemd128', $_REQUEST['password'] );
    // Вытаскиваем пользователя
    $arrUser = db::query("SELECT * FROM `users` WHERE `login` = '". $_REQUEST['login'] ."' AND `password` = '". $password . "'");
    if ( $arrUser ) {
      // Создаём модель пользователя
      $arrResult['model'] = 'user';
      $arrResult['data'] = $_SESSION['user'] = $arrUser;
      $arrResult['text'] = 'Successful login!';
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
    $arrResult['text'] = 'Successful Exit!';
    notification::success( $arrResult );
    break;

  case 'registration': # Регистрация
    // Если пароли не совпадают
    if ( $_REQUEST['password'] != $_REQUEST['password_confirm'] ) notification::error('Passwords do not match.');

    // Проверка, используется ли такой Login
    $arrUser = db::query("SELECT * FROM `users` WHERE `login` = '". $_REQUEST['login'] ."'");
    if ( is_array($arrUser) ) notification::error('This login is already taken.');

    // Проверка, используется ли такой Email
    if ( $_REQUEST['email'] ) {
      $arrUser = db::query("SELECT * FROM `users` WHERE `email` = '". $_REQUEST['email'] ."'");
      if ( is_array($arrUser) ) notification::error('This email is already taken.');
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
    $arrResults['text'] = 'Registration completed successfully! (:';
    $arrResults['location'] = '/authorizations/';
    $arrResults['location_time'] = 2000;

    if ( $oUser->add() ) notification::success($arrResults);
    else notification::error('Something went wrong, oh, call the super programmers!');
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
      notification::error('Error saving password.');

      // + Отправляем новый пароль пользователю на почту
      $mailNew = new mail();
      $mailNew->to      = $arrUser['email'];
      $mailNew->subject = $mailNew->subject . 'Password recovery';
      $mailNew->message .= 'Account password changed <strong>' . $arrUser['email'] . '</strong><br/>';
      $mailNew->message .= 'New password: <strong>' . $new_password . '</strong><br/>';

      $mailNew->send();

      $arrResults = [];
      $arrResults['text'] = 'New password send to mail '. $arrUser['email'] .'!';
      $arrResults['location'] = '/authorizations/';
      $arrResults['location_time'] = 2000;
      notification::success($arrResults);
    }

    // Пользователя нет
    else notification::error('This email is not registered.');
    break;

  # Delete account
  case 'delete':
    $oUser = new user( $_SESSION['user']['id'] );
    $oUser->del();
    $arrResults = [];
    $arrResults['text'] = 'New password send to mail '. $arrUser['email'] .'!';
    $arrResults['location'] = '/authorizations/';
    $arrResults['location_time'] = 2000;
    notification::success($arrResults);
    break;
}
