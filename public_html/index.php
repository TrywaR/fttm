<?
session_start();
include_once 'core/core.php'; # Основные настройки

// Если запросы на обработку данных
if ( $_REQUEST['app'] ) {
  include_once 'app/app.php';
  die();
}

// Определяем что открыть
switch ($_SERVER['REQUEST_URI']) {
  case '/': # Главная страница
    include_once 'core/templates/pages/head.php'; # Подключаемые необходимые данныу
    include_once 'core/templates/pages/header.php'; # Шапка
    include_once 'page/welcome/index.php';
    include_once 'core/templates/pages/footer.php'; # Подвал
    break;

  case '/authorizations/': # Авторизация
    include_once 'core/templates/pages/head.php'; # Подключаемые необходимые данныу
    include_once 'core/templates/pages/header.php'; # Шапка
    include_once 'page/authorizations/index.php';
    include_once 'core/templates/pages/footer.php'; # Подвал
    break;

  case '/registration/': # Регистрация
    include_once 'core/templates/pages/head.php'; # Подключаемые необходимые данныу
    include_once 'core/templates/pages/header.php'; # Шапка
    include_once 'page/authorizations/registration.php';
    include_once 'core/templates/pages/footer.php'; # Подвал
    break;

  case '/password_recovery/': # Восстановление пароля
    include_once 'core/templates/pages/head.php'; # Подключаемые необходимые данныу
    include_once 'core/templates/pages/header.php'; # Шапка
    include_once 'page/authorizations/password_recovery.php';
    include_once 'core/templates/pages/footer.php'; # Подвал
    break;

  default: # Запрашиваемая страница
    // Если пользователь авторизирован
    if ( isset($_SESSION['user']) ) {
      if (file_exists('page'.$_SERVER['REDIRECT_URL'].'index.php')) {
        include_once 'core/templates/pages/head.php'; # Подключаемые необходимые данныу
        include_once 'core/templates/pages/header.php'; # Шапка
        include_once 'page'.$_SERVER['REDIRECT_URL'].'index.php';
        include_once 'core/templates/pages/footer.php'; # Подвал
      }
      else {
        http_response_code(404);

        include_once 'core/templates/pages/head.php'; # Подключаемые необходимые данныу
        include_once 'core/templates/pages/header.php'; # Шапка
        echo '<main class="container pt-4 pb-4 text-center"><h1>Error 404</h1></main>';
        include_once 'core/templates/pages/footer.php'; # Подвал
      }
    }
    // Пользователь не авторизирован
    else {
      // exit("<meta http-equiv='refresh' content='0; url= /authorizations/'>");
      if (file_exists('page'.$_SERVER['REDIRECT_URL'].'index.php')) {
        http_response_code(403);

        include_once 'core/templates/pages/head.php'; # Подключаемые необходимые данныу
        include_once 'core/templates/pages/header.php'; # Шапка
        echo '<main class="container pt-4 pb-4 text-center"><h1>Error 403</h1><p>Для доступа нужно <a href="/authorizations/">авторизироваться</a></p></main>';
        include_once 'core/templates/pages/footer.php'; # Подвал
      }
      else {
        http_response_code(404);

        include_once 'core/templates/pages/head.php'; # Подключаемые необходимые данныу
        include_once 'core/templates/pages/header.php'; # Шапка
        echo '<main class="container pt-4 pb-4 text-center"><h1>Error 404</h1></main>';
        include_once 'core/templates/pages/footer.php'; # Подвал
      }
    }
    break;
}
