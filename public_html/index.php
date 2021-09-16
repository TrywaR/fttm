<?
session_start();
include_once 'core/core.php'; # Основные настройки

// Если запросы на обработку данных
if ( $_REQUEST['app'] ) {
  include_once 'app/app.php';
  die();
}

include_once 'core/templates/pages/head.php'; # Подключаемые необходимые данныу
include_once 'core/templates/pages/header.php'; # Шапка

// Определяем что открыть
switch ($_SERVER['REQUEST_URI']) {
  case '/': # Главная страница
    include_once 'page/home.php';
    break;

  case '/authorizations/': # Авторизация
    include_once 'page/authorizations/index.php';
    break;

  case '/registration/': # Регистрация
    include_once 'page/authorizations/registration.php';
    break;

  case '/password_recovery/': # Восстановление пароля
    break;

  default: # Запрашиваемая страница
    // Если пользователь авторизирован
    if ( isset($_SESSION['user']) ) {
      if (file_exists('page'.$_SERVER['REDIRECT_URL'].'index.php')) include_once 'page'.$_SERVER['REDIRECT_URL'].'index.php';
      else echo '<main class="container pt-4 pb-4 text-center"><h1>Error 404</h1></main>';
    }
    // Пользователь не авторизирован
    else {
      exit("<meta http-equiv='refresh' content='0; url= /authorizations/'>");
    }
    break;
}

include_once 'core/templates/pages/footer.php'; # Подвал
