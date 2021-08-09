<?
switch ($_REQUEST['action']) {
  case 'authorizations': # Вход и регистрации
    include_once 'authorizations/authorizations.php';
    break;

  case 'clients': # Обработка клиентов
    include_once 'clients/clients.php';
    break;

  case 'projects': # Обработка проектов
    include_once 'projects/projects.php';
    break;

  case 'moneys': # Обработка денежек
    include_once 'moneys/moneys.php';
    break;

  case 'cards': # Карточки для денежек
    include_once 'cards/cards.php';
    break;

  case 'moneys_categories': # Типы затрат
    include_once 'moneys_categories/moneys_categories.php';
    break;

  default:
    // code...
    break;
}
