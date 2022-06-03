<?
switch ($_REQUEST['action']) {
  case 'authorizations': # Вход и регистрации
    include_once 'authorizations/authorizations.php';
    break;

  case 'clients': # Обработка клиентов
    include_once 'clients/clients.php';
    break;

  case 'sessions': # Обработка сессий
    include_once 'sessions/sessions.php';
    break;

  case 'projects': # Обработка проектов
    include_once 'projects/projects.php';
    break;

  case 'tasks': # Задачи по проектам
    include_once 'tasks/tasks.php';
    break;

  case 'times': # Время
    include_once 'times/times.php';
    include_once 'times/analytics.php';
    break;

  case 'users': # Пользователи
    include_once 'users/users.php';
    break;

  case 'times_categories': # Категории временных затрат
    include_once 'times_categories/times_categories.php';
    break;

  case 'moneys': # Обработка денежек
    include_once 'moneys/moneys.php';
    include_once 'moneys/analytics.php';
    break;

  case 'cards': # Карточки для денежек
    include_once 'cards/cards.php';
    break;

  case 'moneys_categories': # Типы затрат
    include_once 'moneys_categories/moneys_categories.php';
    break;

  case 'moneys_subscriptions': # Подписки
    include_once 'moneys_subscriptions/moneys_subscriptions.php';
    break;

  case 'charts': # Графики
    include_once 'charts/charts.php';
    break;
}
