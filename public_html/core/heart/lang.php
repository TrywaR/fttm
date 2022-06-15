<?
/**
 * Lang
 */

/*
  <?=$olang->get('Clear')?>
  $olang->get('Clear')
*/

class lang
{
  public $sUserLang = '';
  public $arrLang = [];

  function get( $sText = '' ){
    if ( $this->arrLang[$this->sUserLang] && isset($this->arrLang[$this->sUserLang][$sText]) ) return $this->arrLang[$this->sUserLang][$sText];
    else return $sText;
  }

  function __construct()
  {
    $this->sUserLang = 'en';
    if ( $_SESSION['user'] && $_SESSION['user']['lang'] ) $this->sUserLang = $_SESSION['user']['lang'];
    // ru
    $this->arrLang = [];
    $this->arrLang['ru'] = [
      'Categories' => 'Категории',
      'Category' => 'Категория',
      'NoCategory' => 'Без категории',
      'Date' => 'Дата',
      'Spend' => 'Тарата',
      'Balance' => 'Баланс',
      'Replenish' => 'Получение',
      'NoProject' => 'Не проект',
      'Commissions' => 'Комиссия',
      'Subscription' => 'Подписка',
      'NoSubscription' => 'Не подписка',
      'Subscriptions' => 'Подписки',
      'NoTask' => 'Не задача',
      'Tasks' => 'Задачи',
      'Task' => 'Задача',

      'Analytics' => 'Аналитика',
      'MoneyPerHour' => 'Денег за час',

      'Moneys' => 'Деньги',
      'Money' => 'Деньги',
      'Payment' => 'Платёж',
      'PaymentDay' => 'День платежа',
      'EveryMonth' => 'Ежемесячно',
      'Cards' => 'Карты',
      'CardDebit' => 'Дебетовая карта',
      'CardReloadBalanceBtn' => 'Пересчитать баланс',
      'CardUpdate' => 'Карта обновлена',
      'CardCredit' => 'Кредитная карта',
      'CardBill' => 'Счёт',
      'CardService' => 'Обслуживание карты',
      'CardServiceDate' => 'Дата платёжа за обслуживание',
      'CardFreeDaysLimit' => 'Количество безпроцентных дней',
      'CardDateCommissions' => 'Дата платежа коммиссий',
      'CardDateBillPercent' => 'Дата зачисления процентов',
      'Card' => 'Карта',
      'ToCard' => 'На карту',
      'FromCard' => 'С карты',
      'Price' => 'Цена',
      'Status' => 'Статус',

      'NoStatus' => 'Без статуса',
      'Planned' => 'В планах',
      'InWork' => 'В работе',
      'Complited' => 'Выполено',

      'PricePlanned' => 'Планируемая стоимость',
      'MoneysCategories' => 'Категории для финансов',

      'Times' => 'Время',
      'Time' => 'Время',
      'TimesPlanned' => 'Планируемое время',
      'TimesReally' => 'Реальное время',
      'Effeciency' => 'Эффективность',

      'User' => 'Пользователь',
      'Users' => 'Пользователи',
      'UserEdit' => 'Редактирование пользователя',
      'UserPasswordEdit' => 'Редактирование пароля пользователя',
      'OldPassword' => 'Старый пароль',
      'NewPassword' => 'Новый пароль',
      'NewPasswordComfirm' => 'Подтверждение нового пароля',

      'Phone' => 'Телефон',
      'Email' => 'Почта',
      'DateRegistration' => 'Дата регистрации',
      'ReferalLink' => 'Реферальная ссылка',
      'Login' => 'Прозвище',
      'Theme' => 'Оформление',
      'Description' => 'Описание',
      'Lang' => 'Язык',
      'Title' => 'Название',
      'Type' => 'Тип',
      'Active' => 'Активность',
      'Clear' => 'Отчистить',
      'Client' => 'Клиент',
      'Clients' => 'Клиенты',
      'Add' => 'Добавить',
      'Save' => 'Сохранить',
      'Edit' => 'Редактировать',
      'Exit' => 'Выход',
      'Other' => 'Прочее',
      'Config' => 'Конфигурации',
      'Info' => 'Информация',
      'Sort' => 'Сортировка',
      'Color' => 'Цвет',
      'Limit' => 'Лимит',
      'Percent' => 'Процент',
      'LastUpdate' => 'Последнее обновление',
      'ChangesSaved' => 'Изменения сохранены',
      'DeleteSuccess' => 'Успешное удаление',
      'ChangePassword' => 'Поменять пароль',
      'Delete' => 'Удалить',
      'Cash' => 'Наличные',

      'Day' => 'День',
      'ToDay' => 'Сегодня',
      'Week' => 'Неделя',
      'Month' => 'Месяц',
      'Year' => 'Год',
      'CurrentYear' => 'Текущий год',
      'CurrentMonth' => 'Текущий месяц',
      'CurrentWeek' => 'Текущая неделя',
      'CurrentDay' => 'Текущий день',
      'PrevYear' => 'Предыдущий год',
      'PrevMonth' => 'Предыдущий месяц',
      'PrevWeek' => 'Предыдущая неделя',
      'PrevDay' => 'Предыдущий день',

      'January' => 'Январь',
      'February' => 'Февраль',
      'March' => 'Март',
      'April' => 'Апрель',
      'May' => 'Май',
      'June' => 'Июнь',
      'July' => 'Июль',
      'August' => 'Август',
      'September' => 'Сентябрь',
      'October' => 'Октябрь',
      'November' => 'Ноябрь',
      'December' => 'Декабрь',

      'Sunday' => 'Воскресенье',
      'Monday' => 'Понедельник',
      'Tuesday' => 'Вторник',
      'Wednesday' => 'Среда',
      'Thursday' => 'Четверг',
      'Friday' => 'Пятница',
      'Saturday' => 'Суббота',

      'Transport' => 'Транспорт',
      'Sleeping' => 'Сон',
      'Sleep' => 'Сон',
      'Working' => 'Работа',
      'Work' => 'Работа',
      'Eating' => 'Еда',
      'ThisService' => 'Этот сервис',

      'Costs' => 'Расходы',
      'Sum' => 'Сумма',
      'Wages' => 'Доходы',

      'WagesWork' => 'Заработано',

      'Home' => 'Главная',
      'Projects' => 'Проекты',
      'Project' => 'Проект',

      'Versions' => 'Версии',
      'Contacts' => 'Контакты',
      'Donate' => 'Донаты',
      'Docs' => 'Документация',
      'Menu' => 'Меню',
      'Filter' => 'Фильтровать',
      'MenuSub' => 'Доп.меню',
      'SignUp' => 'Регистрация',
      'SignIn' => 'Вход',
    ];

    $this->arrLang['en'] = [
      'Categories' => 'Categories',
      'Category' => 'Category',
      'NoCategory' => 'No category',
      'Date' => 'Date',
      'Spend' => 'Spend',
      'Balance' => 'Balance',
      'Replenish' => 'Replenish',
      'NoProject' => 'No project',
      'Commissions' => 'Commissions',
      'Subscription' => 'Subscription',
      'NoSubscription' => 'No subscription',
      'Subscriptions' => 'Subscriptions',
      'NoTask' => 'No Task',
      'Tasks' => 'Tasks',
      'Task' => 'Task',

      'Analytics' => 'Analytics',
      'MoneyPerHour' => 'Money per hour',

      'Moneys' => 'Moneys',
      'Money' => 'Money',
      'Payment' => 'Payment',
      'PaymentDay' => 'Payment day',
      'EveryMonth' => 'Every month',
      'Cards' => 'Cards',
      'CardDebit' => 'Card debit',
      'CardReloadBalanceBtn' => 'Reload balance',
      'CardUpdate' => 'Card update',
      'CardCredit' => 'Card credit',
      'CardBill' => 'Card bill',
      'CardService' => 'Card service',
      'CardServiceDate' => 'Card service date',
      'CardFreeDaysLimit' => 'Card free days limit',
      'CardDateCommissions' => 'Card date commissions',
      'CardDateBillPercent' => 'Card date bill enrollment',
      'Card' => 'Card',
      'ToCard' => 'To card',
      'FromCard' => 'From card',
      'Price' => 'Price',
      'Status' => 'Status',

      'NoStatus' => 'NoStatus',
      'Planned' => 'Planned',
      'InWork' => 'InWork',
      'Complited' => 'Complited',

      'PricePlanned' => 'Price planned',
      'MoneysCategories' => 'Moneys categories',

      'Times' => 'Times',
      'Time' => 'Time',
      'TimesPlanned' => 'Times planned',
      'TimesReally' => 'Times really',
      'Effeciency' => 'Effeciency',

      'User' => 'User',
      'Users' => 'Users',
      'UserEdit' => 'User edit',
      'UserPasswordEdit' => 'User password edit',
      'OldPassword' => 'Old password',
      'NewPassword' => 'New password',
      'NewPasswordComfirm' => 'New password comfirm',

      'Phone' => 'Phone',
      'Email' => 'Email',
      'DateRegistration' => 'Date registration',
      'ReferalLink' => 'Referal link',
      'Login' => 'Login',
      'Theme' => 'Theme',
      'Description' => 'Description',
      'Lang' => 'Lang',
      'Title' => 'Title',
      'Type' => 'Type',
      'Active' => 'Active',
      'Clear' => 'Clear',
      'Client' => 'Client',
      'Clients' => 'Clients',
      'Add' => 'Add',
      'Save' => 'Save',
      'Edit' => 'Edit',
      'Exit' => 'Exit',
      'Other' => 'Other',
      'Config' => 'Config',
      'Info' => 'Info',
      'Sort' => 'Sort',
      'Color' => 'Color',
      'Limit' => 'Limit',
      'Percent' => 'Percent',
      'LastUpdate' => 'Last update',
      'ChangesSaved' => 'Changes saved',
      'DeleteSuccess' => 'Delete success',
      'ChangePassword' => 'Change password',
      'Delete' => 'Delete',
      'Cash' => 'Cash',

      'Day' => 'Day',
      'ToDay' => 'To day',
      'Week' => 'Week',
      'Month' => 'Month',
      'Year' => 'Year',
      'CurrentYear' => 'Current year',
      'CurrentMonth' => 'Current month',
      'CurrentWeek' => 'Current week',
      'CurrentDay' => 'Current day',
      'PrevYear' => 'Prev year',
      'PrevMonth' => 'Prev month',
      'PrevWeek' => 'Prev week',
      'PrevDay' => 'Prev day',

      'January' => 'January',
      'February' => 'February',
      'March' => 'March',
      'April' => 'April',
      'May' => 'May',
      'June' => 'June',
      'July' => 'July',
      'August' => 'August',
      'September' => 'September',
      'October' => 'October',
      'November' => 'November',
      'December' => 'December',

      'Sunday' => 'Sunday',
      'Monday' => 'Monday',
      'Tuesday' => 'Tuesday',
      'Wednesday' => 'Wednesday',
      'Thursday' => 'Thursday',
      'Friday' => 'Friday',
      'Saturday' => 'Saturday',

      'Transport' => 'Transport',
      'Sleeping' => 'Sleeping',
      'Sleep' => 'Sleep',
      'Working' => 'Working',
      'Work' => 'Work',
      'Eating' => 'Eating',
      'ThisService' => 'This service',

      'Costs' => 'Costs',
      'Sum' => 'Sum',
      'Wages' => 'Wages',

      'WagesWork' => 'Wages for work',

      'Home' => 'Home',
      'Projects' => 'Projects',
      'Project' => 'Project',

      'Versions' => 'Versions',
      'Contacts' => 'Contacts',
      'Donate' => 'Donate',
      'Docs' => 'Docs',
      'Menu' => 'Menu',
      'Filter' => 'Filter',
      'MenuSub' => 'Subs',
      'SignUp' => 'Sign up',
      'SignIn' => 'Sign in',
    ];
  }
}
$oLang = new lang();
