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
      'Replenish' => 'Получение',
      'NoProject' => 'Не проект',
      'Commissions' => 'Комиссия',
      'Subscription' => 'Подписка',
      'NoSubscription' => 'Не подписка',
      'Subscriptions' => 'Подписки',
      'NoTask' => 'Не задача',
      'Tasks' => 'Задачи',
      'Task' => 'Задача',

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
      'PricePlanned' => 'Планируемая стоимость',
      'MoneysCategories' => 'Категории для финансов',

      'Times' => 'Время',
      'Time' => 'Время',
      'TimesPlanned' => 'Планируемое время',
      'TimesReally' => 'Реальное время',

      'User' => 'Пользователь',
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
      'Week' => 'Неделя',
      'Month' => 'Месяц',
      'Year' => 'Год',

      'Costs' => 'Расходы',
      'Sum' => 'Сумма',
      'Wages' => 'Доходы',

      'Home' => 'Главная',
      'Projects' => 'Проекты',
      'Project' => 'Проект',

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
      'Replenish' => 'Replenish',
      'NoProject' => 'No project',
      'Commissions' => 'Commissions',
      'Subscription' => 'Subscription',
      'NoSubscription' => 'No subscription',
      'Subscriptions' => 'Subscriptions',
      'NoTask' => 'No Task',
      'Tasks' => 'Tasks',
      'Task' => 'Task',

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
      'PricePlanned' => 'Price planned',
      'MoneysCategories' => 'Moneys categories',

      'Times' => 'Times',
      'Time' => 'Time',
      'TimesPlanned' => 'Times planned',
      'TimesReally' => 'Times really',

      'User' => 'User',
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
      'Week' => 'Week',
      'Month' => 'Month',
      'Year' => 'Year',

      'Costs' => 'Costs',
      'Sum' => 'Sum',
      'Wages' => 'Wages',

      'Home' => 'Home',
      'Projects' => 'Projects',
      'Project' => 'Project',

      'Menu' => 'Menu',
      'Filter' => 'Filter',
      'MenuSub' => 'Subs',
      'SignUp' => 'Sign up',
      'SignIn' => 'Sign in',
    ];
  }
}
$oLang = new lang();
