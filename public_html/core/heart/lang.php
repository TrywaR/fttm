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

  // Получение перевода
  function get( $sText = '' ){
    // load lang
    switch ($this->sUserLang) {
      case 'ru':
        $this->ru();
        break;
      case 'en':
        $this->en();
        break;
    }
    if ( $this->arrLang[$this->sUserLang] && isset($this->arrLang[$this->sUserLang][$sText]) ) return $this->arrLang[$this->sUserLang][$sText];
    else return $sText;
  }

  function ru(){
    $this->arrLang['ru'] = [
      'Categories' => 'Категории',
      'Category' => 'Категория',
      'NoCategory' => 'Без категории',
      'Date' => 'Дата',
      'Spend' => 'Трата',
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
      'ChangesSaved' => 'Изменения сохранены',
      'DeleteSuccess' => 'Успешное удаление',
      'ChangePassword' => 'Поменять пароль',
      'Delete' => 'Удалить',
      'Transfer' => 'Перевод',

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
      'LastUpdate' => 'Обновление',
      'DateCreate' => 'Создан',

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

      'Protect' => 'Защита',
      'ProtectType' => 'Тип защиты',
      'ProtectYes' => 'Защита установлена',
      'ProtectNo' => 'Защита не установлена',
      'ProtectKeyYes' => 'Защита по ключу',

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
  }

  function en(){
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

      'Moneys' => 'Money',
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

      'NoStatus' => 'No status',
      'Planned' => 'Planned',
      'InWork' => 'In work',
      'Complited' => 'Complited',

      'PricePlanned' => 'Price planned',
      'MoneysCategories' => 'Moneys categories',

      'Times' => 'Time',
      'Time' => 'Time',
      'TimesPlanned' => 'Time planned',
      'TimesReally' => 'Time really',
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
      'ChangesSaved' => 'Changes saved',
      'DeleteSuccess' => 'Delete success',
      'ChangePassword' => 'Change password',
      'Delete' => 'Delete',
      'Transfer' => 'Transfer',

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
      'LastUpdate' => 'Update',
      'DateCreate' => 'Create',

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

      'Protect' => 'Protect',
      'ProtectType' => 'Protect type',
      'ProtectYes' => 'Protect yes',
      'ProtectNo' => 'Protect no',
      'ProtectKeyYes' => 'Protect key yes',

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

  function __construct()
  {
    if ( $_SESSION['user'] && $_SESSION['user']['lang'] ) {
      $this->sUserLang = $_SESSION['user']['lang'];
    }
    else {
      if ( $_SERVER['HTTP_ACCEPT_LANGUAGE'] ) {
        $arrlang = explode(';',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $arrlangs = explode(',',$arrlang[0]);
        if ( count($arrlangs) ) {
          $slang = $arrlangs[1];
          if ( $slang ) $this->sUserLang = $slang;
          else $this->sUserLang = 'ens';
        }
      }
    }
    // $this->sUserLang = 'en';
    // if ( $_SESSION['user'] && $_SESSION['user']['lang'] ) $this->sUserLang = $_SESSION['user']['lang'];
    $this->arrLang = [];
  }
}
$oLang = new lang();
