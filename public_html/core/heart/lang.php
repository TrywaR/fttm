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
      'Spend' => 'Потратить',
      'Replenish' => 'Получить',
      'NoProject' => 'Не проект',
      'Commissions' => 'Комиссия',
      'Subscription' => 'Подписка',
      'NoSubscription' => 'Не подписка',
      'NoTask' => 'Не задача',
      'Tasks' => 'Задачи',

      'Moneys' => 'Деньги',

      'Times' => 'Время',

      'Clear' => 'Отчистить',
      'Clients' => 'Клиенты',
      'Add' => 'Добавить',
      'Save' => 'Сохранить',
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

      'Moneys' => 'Moneys',

      'Times' => 'Times',

      'Clear' => 'Clear',
      'Clients' => 'Clients',
      'Add' => 'Add',
      'Save' => 'Save',
      'Cash' => 'Cash',
    ];
  }
}
// $oLang = new lang();
