<?
switch ($_REQUEST['action']) {
  case 'clients': # Обработка клиентов
    include_once 'clients/clients.php';
    break;

  case 'projects': # Обработка проектов
    include_once 'projects/projects.php';
    break;

  case 'moneys': # Обработка денежек
    include_once 'moneys/moneys.php';
    break;

  default:
    // code...
    break;
}
