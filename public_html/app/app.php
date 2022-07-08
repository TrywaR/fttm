<?
switch ($_REQUEST['action']) {
  case 'authorizations': # Вход и регистрации
    include_once 'authorizations/authorizations.php';
    break;

  case 'clients': # Обработка клиентов
    include_once 'clients/clients.php';
    break;

  case 'dashboards': # Главная страница
    include_once 'dashboards/dashboards.php';
    break;

  case 'navs': # Структура сайта
    include_once 'navs/navs.php';
    break;

  case 'analytics': # Общая статистика
    include_once 'analytics/analytics.php';
    break;

  case 'sessions': # Обработка сессий
    include_once 'sessions/sessions.php';
    break;

  case 'categories': # Категории
    include_once 'categories/categories.php';
    break;

  case 'projects': # Обработка проектов
    include_once 'projects/projects.php';
    break;

  case 'projects_analytics': # Статистика
    include_once 'projects/analytics.php';
    break;

  case 'projects_analytics_money': # Статистика
    include_once 'projects/analytics_money.php';
    break;

  case 'projects_analytics_times': # Статистика
    include_once 'projects/analytics_times.php';
    break;

  case 'tasks': # Задачи по проектам
    include_once 'tasks/tasks.php';
    break;

  case 'times': # Время
    include_once 'times/times.php';
    include_once 'times/analytics.php';
    break;

  case 'profiles': # Профиль
    include_once 'profiles/profiles.php';
    break;

  case 'users': # Пользователи
    include_once 'users/users.php';
    break;

  case 'moneys': # Обработка денежек
    include_once 'moneys/moneys.php';
    include_once 'moneys/analytics.php';
    break;

  case 'cards': # Карточки для денежек
    include_once 'cards/cards.php';
    break;

  case 'subscriptions': # Подписки
    include_once 'subscriptions/subscriptions.php';
    break;

  case 'charts': # Графики
    include_once 'charts/charts.php';
    break;
}
