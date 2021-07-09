<?
session_start();
include_once 'core/core.php'; # Основные настройки

// Если запросы на обработку данных
if ( $_REQUEST['app'] ) {
  include_once 'app/app.php';
  die();
}

include_once 'head.php'; # Подключаемые необходимые данныу
include_once 'header.php'; # Шапка

// Определяем что открыть
switch ($_SERVER['REQUEST_URI']) {
  case '/authorizations/': # Авторизация
    include_once 'page/authorizations/index.php';
    break;

  case '/registration/': # Регистрация
    include_once 'page/authorizations/registration.php';
    break;

  case '/password_recovery/': # Восстановление пароля
    break;

  case '/welcome/': # Приветственая страница пользователя
    // Если пользователь авторизирован
    if ( isset($_SESSION['session_key']) ) include_once 'page/welcome/index.php';
    else exit("<meta http-equiv='refresh' content='0; url= /'>");
    break;

  case '/': # Главная страница
    include_once 'page/home.php';
    break;

  default: # Запрашиваемая страница
    // Если пользователь авторизирован
    if ( isset($_SESSION['session_key']) ) {
      if (file_exists('page'.$_SERVER['REQUEST_URI'].'index.php')) include_once 'page'.$_SERVER['REQUEST_URI'].'index.php';
      else echo '<main><h1>error 404</h1></main>';
    }
    // Пользователь не авторизирован
    else {
      exit("<meta http-equiv='refresh' content='0; url= /authorizations/'>");
    }
    break;
}

include_once 'footer.php'; # Подвал
