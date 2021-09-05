<?
switch ($_REQUEST['form']) {
  case 'login': # Вход
    // Готовим результат вывода
    $arrResult = [
      'text' => 'Ошибка ввода логина или пароля!'
    ];
    // Кодируем пасс
    $password = hash( 'ripemd128', $_REQUEST['password'] );
    // Вытаскиваем пользователя
    $arrUser = db::query("SELECT * FROM `users` WHERE `login` = '". $_REQUEST['login'] ."' AND `password` = '". $password . "'");
    if ( $arrUser ) {
      // Создаём модель пользователя
      $arrResult['model'] = 'user';
      $arrResult['data'] = $_SESSION['user'] = $arrUser;
      $arrResult['text'] = 'Успешный вход!';
      $arrResult['location'] = '/';

      notification::success( $arrResult );
    }
    else notification::error( $arrResult );
    break;

  case 'logout': # Выход
    unset($_SESSION['user']);
    $arrResult['model'] = 'user';
    $arrResult['data'] = '';
    $arrResult['text'] = 'Успешный выход!';
    $arrResult['location'] = '/';
    
    notification::success( $arrResult );
    break;

  case 'registration': # Регистрация
    // Если пароли не совпадают
    if ( $_REQUEST['password'] != $_REQUEST['password_confirm'] ) notification::error('Пароли не совпадают.');

    // Проверка, используется ли такой Login
    $arrUser = db::query("SELECT * FROM `users` WHERE `login` = '". $_REQUEST['login'] ."'");
    if ( is_array($arrUser) ) notification::error('Такой login уже занят.');

    // Проверка, используется ли такой Email
    if ( $_REQUEST['email'] ) {
      $arrUser = db::query("SELECT * FROM `users` WHERE `email` = '". $_REQUEST['email'] ."'");
      if ( is_array($arrUser) ) notification::error('Такой email уже занят.');
    }

    // Регистрация
    $arrData = [];
    $arrData['date'] = date('Y-m-d H:i:s');
    $arrData['login'] = $_REQUEST['login'];
    $arrData['email'] = $_REQUEST['email'];
    $arrData['password'] = hash( 'ripemd128', $_REQUEST['password'] );

    $oUser = new user();
    $oUser->arrAddFields = $arrData;

    if ( $oUser->add() ) notification::success('Регистрация прошла успешно! (:');
    else notification::error('Что то пошло не так, ох, вызывайте тыжпрограммистов!');

    break;

  default:
    // code...
    break;
}
