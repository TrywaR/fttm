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
      'NoTask' => 'Не задача',
      'Tasks' => 'Задачи',
      'Task' => 'Задача',

      'Moneys' => 'Деньги',
      'Cards' => 'Карты',
      'Card' => 'Карта',
      'ToCard' => 'На карту',
      'FromCard' => 'С карты',
      'Price' => 'Цена',

      'Times' => 'Время',

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
      'Clients' => 'Клиенты',
      'Add' => 'Добавить',
      'Save' => 'Сохранить',
      'Edit' => 'Редактировать',
      'Exit' => 'Выход',
      'Other' => 'Прочее',
      'Config' => 'Конфигурации',
      'Info' => 'Информация',
      'ChangePassword' => 'Поменять пароль',
      'Delete' => 'Удалить',
      'Cash' => 'Наличные',
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
      'NoTask' => 'No Task',
      'Tasks' => 'Tasks',
      'Task' => 'Task',

      'Moneys' => 'Moneys',
      'Cards' => 'Cards',
      'Card' => 'Card',
      'ToCard' => 'To card',
      'FromCard' => 'From card',
      'Price' => 'Price',

      'Times' => 'Times',

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
      'Clients' => 'Clients',
      'Add' => 'Add',
      'Save' => 'Save',
      'Edit' => 'Edit',
      'Exit' => 'Exit',
      'Other' => 'Other',
      'Config' => 'Config',
      'Info' => 'Info',
      'ChangePassword' => 'Change password',
      'Delete' => 'Delete',
      'Cash' => 'Cash',
    ];
  }
}
$oLang = new lang();
