<?
switch ($_REQUEST['form']) {
  case 'login':
    // code...
    break;

  case 'registration':
    // Если пароли не совпадают
    if ( $_REQUEST['password'] != $_REQUEST['password_confirm'] ) notification::error('Пароли не совпадают.');

    // Проверка, используется ли такой Email
    $arrUser = db::query("SELECT * FROM `users` WHERE `email` = '". $_REQUEST['email'] ."'");
    if ( is_array($arrUser) ) notification::error('Такой email уже занят.');

    // Регистрация
    $date = date('Y-m-d H:i:s');
    $password = hash( 'ripemd128', $_REQUEST['password'] );
    $oUser = new user();

    break;

  default:
    // code...
    break;
}
