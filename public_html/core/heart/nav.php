<?
/**
 * Nav
 */
class nav
{
  public $arrNav = [];

  // Получить nav
  public function get(){
    return $this->arrNav;
  }

  function __construct()
  {
    $oLang = new lang();

    // ru
    $this->arrNav = [];
    $this->arrNav = [
      // '/' => array(
      //   'id' => 1,
      //   'name' => $oLang->get('Welcome'),
      //   'url' => '/',
      //   'icon' => '',
      // ),
      '/authorizations/' => array(
        'id' => 2,
        'name' => $oLang->get('Authorizations'),
        'url' => '/authorizations/',
        'menu_hide' => true,
      ),
      '/registration/' => array(
        'id' => 2,
        'name' => $oLang->get('Registration'),
        'url' => '/registration/',
        'menu_hide' => true,
      ),
      '/password_recovery/' => array(
        'id' => 2,
        'name' => $oLang->get('PasswordRecovery'),
        'url' => '/password_recovery/',
        'menu_hide' => true,
      ),
      '/dashboard/' => array(
        'id' => 2,
        'name' => $oLang->get('Dashboard'),
        'url' => '/dashboard/',
        'icon' => '<i class="fa-solid fa-grip"></i>',
      ),
      '/moneys/' => array(
        'id' => 3,
        'name' => $oLang->get('Moneys'),
        'url' => '/moneys/',
        'icon' => '<i class="fa-solid fa-wallet"></i>',
        'subs' => [
          '/moneys/data/cards/' => array(
            'name' => $oLang->get('Cards'),
            'url' => '/moneys/data/cards/',
            'icon' => '<i class="fa-solid fa-credit-card"></i>',
          ),
          '/moneys/analytics/costs/' => array(
            'name' => $oLang->get('Costs'),
            'url' => '/moneys/analytics/costs/',
            'icon' => '<i class="fa-solid fa-chart-area"></i>',
          ),
          '/moneys/analytics/wages/' => array(
            'name' => $oLang->get('Wages'),
            'url' => '/moneys/analytics/wages/',
            'icon' => '<i class="fa-solid fa-chart-bar"></i>',
          ),
        ],
      ),
      '/times/' => array(
        'id' => 4,
        'name' => $oLang->get('Times'),
        'url' => '/times/',
        'icon' => '<i class="fa-solid fa-clock"></i>',
        'subs' => [
          '/times/analytics/costs/' => array(
            'name' => $oLang->get('Costs'),
            'url' => '/times/analytics/costs/',
            'icon' => '<i class="fa-solid fa-chart-bar"></i>',
          ),
        ],
      ),
      '/tasks/' => array(
        'id' => 5,
        'name' => $oLang->get('Tasks'),
        'url' => '/tasks/',
        'icon' => '<i class="fa-solid fa-person-digging"></i>',
      ),
      '/categories/' => array(
        'id' => 6,
        'name' => $oLang->get('Categories'),
        'url' => '/categories/',
        'icon' => '<i class="fa-solid fa-list"></i>',
      ),
      '/subscriptions/' => array(
        'name' => $oLang->get('Subscriptions'),
        'url' => '/subscriptions/',
        'icon' => '<i class="fa-solid fa-calendar-check"></i>',
      ),
      '/clients/' => array(
        'name' => $oLang->get('Clients'),
        'url' => '/clients/',
        'icon' => '<i class="fa-solid fa-folder"></i>',
      ),
      '/projects/' => array(
        'id' => 6,
        'name' => $oLang->get('Projects'),
        'url' => '/projects/',
        'icon' => '<i class="fa-solid fa-folder-tree"></i>',
      ),
      '/info/' => array(
        'id' => 7,
        'name' => $oLang->get('Info'),
        'url' => '/info/',
        'icon' => '<i class="fa-solid fa-circle-info"></i>',
        'menu_hide' => false,
        'subs' => [
          '/info/versions/' => array(
            'name' => $oLang->get('Versions'),
            'url' => '/info/versions/',
            'icon' => '<i class="fas fa-code-branch"></i>',
            'menu_hide' => false,
          ),
          '/info/contacts/' => array(
            'name' => $oLang->get('Contacts'),
            'url' => '/info/contacts/',
            'icon' => '<i class="fas fa-info"></i>',
            'menu_hide' => false,
          ),
          '/info/analytics/' => array(
            'name' => $oLang->get('Analytics'),
            'url' => '/info/analytics/',
            'icon' => '<i class="fas fa-chart-line"></i>',
            'menu_hide' => false,
          ),
          '/info/buy/' => array(
            'name' => $oLang->get('Donate'),
            'url' => '/info/buy/',
            'icon' => '<i class="fas fa-donate"></i>',
            'menu_hide' => false,
          ),
          '/info/docs/' => array(
            'name' => $oLang->get('Docs'),
            'url' => '/info/docs/',
            'icon' => '<i class="fas fa-book-dead"></i>',
            'menu_hide' => true,
          ),
        ],
      ),
    ];
  }
}
