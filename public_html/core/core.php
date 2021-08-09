<?
// Общие настройки
include_once 'config.php';
// Работа с базой
include_once 'db.php';
// Уведомления
include_once 'notification.php';

// Модели
include_once 'models/model.php'; # Основной класс
include_once 'models/user.php'; # Пользователь
include_once 'models/client.php'; # Клиент
include_once 'models/project.php'; # Проект
include_once 'models/task.php'; # Задачи
include_once 'models/money.php'; # Деньги
include_once 'models/card.php'; # Карты для денег
include_once 'models/moneys_category.php'; # Категории затрат
