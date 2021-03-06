<?
/**
 * Nav - Структура сайта
 */
class nav
{
  public $arrNav = []; # Структура
  public $arrNavs = []; # Обработанная структура
  public $arrNavsPath = []; # Текущий путь

  // Получить цепочку до текущего элемента
  public function get_path(){
    $arrUrls = explode('/',$_SERVER['REDIRECT_URL']);
    $sCurrentUrl = '/';

    // if ( isset( $this->arrNavs[ $sCurrentUrl ] ) ) {
    //   $arrNavItem = $this->arrNavs[ $sCurrentUrl ];
    //   unset($arrNavItem['subs']);
    //   $this->arrNavsPath[ $arrNavItem['url'] ] = $arrNavItem;
    // }

    foreach ($arrUrls as $sUrl) {
      if ( ! $sUrl ) continue;

      $sCurrentUrl = $sCurrentUrl . $sUrl . '/';

      if ( isset( $this->arrNavs[ $sCurrentUrl ] ) ) {
        $arrNavItem = $this->arrNavs[ $sCurrentUrl ];
        unset($arrNavItem['subs']);
        $this->arrNavsPath[ $arrNavItem['url'] ] = $arrNavItem;
      }
    }
  }

  public function get_navs(){
    foreach ($this->arrNav as $arrNav) {
      $arrUnsetSubs = $arrNav;
      unset($arrUnsetSubs['subs']);
      $this->arrNavs[ $arrUnsetSubs['url'] ] = $arrUnsetSubs;
      $this->get_navs_subs( $arrNav );
    }
  }

  public function get_navs_subs( $arrNav = [] ) {
    if ( count($arrNav['subs']) )
      foreach ($arrNav['subs'] as $arrItem) {
        $arrUnsetSubs = $arrItem;
        unset($arrUnsetSubs['subs']);
        $this->arrNavs[ $arrUnsetSubs['url'] ] = $arrUnsetSubs;
        if ( count($arrItem['subs']) ) $this->get_navs_subs( $arrItem );
      }
  }

  // Получить nav
  public function get(){
    $arrResult = [];

    foreach ( $this->arrNav as $arrNav ) {
      if ( isset($arrNav['menu_hide']) && $arrNav['menu_hide'] ) continue;

      $arrNav = $this->check_sub( $arrNav );

      if ( isset($arrNav['access']) ) {
        if ( $arrNav['access'] < 0 ) $arrResult[] = $arrNav;
        else if ( isset($_SESSION['user']) && $_SESSION['user']['role'] >= $arrNav['access'] ) $arrResult[] = $arrNav;
      }
      else {
        $arrResult[] = $arrNav;
      }
    }

    return $arrResult;
  }

  public function check_sub( $arrNav = [] ){
    if ( count($arrNav['subs']) ) {
      foreach ($arrNav['subs'] as $iIndex => $arrSub) {
        if ( isset($arrSub['menu_hide']) && $arrSub['menu_hide'] ) {
          if ( count($arrNav['subs']) ) unset($arrNav['subs'][$iIndex]);
          else unset($arrNav['subs']);
        }
        // else check_sub($arrSub);
      }
    }

    return $arrNav;
  }

  function __construct()
  {
    $oLang = new lang();
    $this->arrNav = [
      '/' => array(
        'name' => $oLang->get('HomePageTitle'),
        'description' => $oLang->get('HomePageDescription'),
        'url' => '/',
        'icon' => '<i class="fa-solid fa-house"></i>',
        'access' => -1,
      ),

      '/authorizations/' => array(
        'name' => $oLang->get('Authorizations'),
        'description' => $oLang->get('Authorizations'),
        'url' => '/authorizations/',
        'icon' => '<i class="fas fa-user-check"></i>',
        'menu_hide' => true,
        'access' => -1,
        'subs' => [
          '/authorizations/registration/' => array(
            'name' => $oLang->get('Registration'),
            'description' => $oLang->get('Registration'),
            'url' => '/authorizations/registration/',
            'icon' => '<i class="fas fa-user-plus"></i>',
            'menu_hide' => true,
            'access' => -1,
          ),
          '/authorizations/password_recovery/' => array(
            'name' => $oLang->get('PasswordRecovery'),
            'description' => $oLang->get('PasswordRecovery'),
            'url' => '/authorizations/password_recovery/',
            'icon' => '<i class="fa-solid fa-user-gear"></i>',
            'menu_hide' => true,
            'access' => -1,
          ),
        ]
      ),

      '/profile/' => array(
        'name' => $oLang->get('User'),
        'description' => $oLang->get('User'),
        'url' => '/profile/',
        'icon' => '<i class="fa-solid fa-user"></i>',
        'access' => 0,
        'menu_hide' => true,
      ),

      '/users/' => array(
        'name' => $oLang->get('Users'),
        'description' => $oLang->get('Users'),
        'url' => '/users/',
        'icon' => '<i class="fa-solid fa-users"></i>',
        'access' => 0,
        'menu_hide' => true,
      ),

      '/dashboard/' => array(
        'name' => $oLang->get('Dashboard'),
        'description' => $oLang->get('Dashboard'),
        'url' => '/dashboard/',
        'icon' => '<i class="fa-solid fa-grip"></i>',
        'access' => 0,
        'subs' => [
          '/dashboard/analytics/days/' => array(
            'name' => $oLang->get('Days'),
            'description' => $oLang->get('Days'),
            'url' => '/dashboard/analytics/days/',
            'icon' => '<i class="fa-solid fa-calendar-day"></i>',
            'menu_hide' => false,
          ),
        ]
      ),

      '/moneys/' => array(
        'name' => $oLang->get('Moneys'),
        'description' => $oLang->get('Moneys'),
        'url' => '/moneys/',
        'icon' => '<i class="fa-solid fa-wallet"></i>',
        'access' => 0,
        'subs' => [
          '/moneys/data/cards/' => array(
            'name' => $oLang->get('Cards'),
            'description' => $oLang->get('Cards'),
            'url' => '/moneys/data/cards/',
            'icon' => '<i class="fa-solid fa-credit-card"></i>',
            'access' => 0,
          ),
          '/moneys/analytics/costs/' => array(
            'name' => $oLang->get('Costs'),
            'description' => $oLang->get('Costs'),
            'url' => '/moneys/analytics/costs/',
            'icon' => '<i class="fa-solid fa-chart-area"></i>',
            'access' => 0,
          ),
          '/moneys/analytics/wages/' => array(
            'name' => $oLang->get('Wages'),
            'description' => $oLang->get('Wages'),
            'url' => '/moneys/analytics/wages/',
            'icon' => '<i class="fa-solid fa-chart-bar"></i>',
            'access' => 0,
          ),
        ],
      ),

      '/times/' => array(
        'name' => $oLang->get('Times'),
        'description' => $oLang->get('Times'),
        'url' => '/times/',
        'icon' => '<i class="fa-solid fa-clock"></i>',
        'access' => 0,
        'subs' => [
          '/times/analytics/costs/' => array(
            'name' => $oLang->get('Costs'),
            'description' => $oLang->get('Costs'),
            'url' => '/times/analytics/costs/',
            'icon' => '<i class="fa-solid fa-chart-bar"></i>',
            'access' => 0,
          ),
        ],
      ),

      '/tasks/' => array(
        'name' => $oLang->get('Tasks'),
        'description' => $oLang->get('Tasks'),
        'url' => '/tasks/',
        'icon' => '<i class="fa-solid fa-person-digging"></i>',
        'access' => 0,
      ),

      '/categories/' => array(
        'name' => $oLang->get('Categories'),
        'description' => $oLang->get('Categories'),
        'url' => '/categories/',
        'icon' => '<i class="fa-solid fa-list"></i>',
        'access' => 0,
        'subs' => [
          '/categories/analytics/' => array(
            'name' => $oLang->get('Category'),
            'description' => $oLang->get('Category'),
            'url' => '/categories/analytics/',
            'icon' => '<i class="fas fa-chart-area"></i>',
            'access' => 0,
            'menu_hide' => true,
          ),
        ],
      ),

      '/subscriptions/' => array(
        'name' => $oLang->get('Subscriptions'),
        'description' => $oLang->get('Subscriptions'),
        'url' => '/subscriptions/',
        'icon' => '<i class="fa-solid fa-calendar-check"></i>',
        'access' => 0,
      ),

      '/clients/' => array(
        'name' => $oLang->get('Clients'),
        'description' => $oLang->get('Clients'),
        'url' => '/clients/',
        'icon' => '<i class="fa-solid fa-folder"></i>',
        'access' => 0,
      ),

      '/projects/' => array(
        'name' => $oLang->get('Projects'),
        'description' => $oLang->get('Projects'),
        'url' => '/projects/',
        'icon' => '<i class="fa-solid fa-folder-tree"></i>',
        'access' => 0,
      ),

      '/info/' => array(
        'name' => $oLang->get('Info'),
        'description' => $oLang->get('Info'),
        'url' => '/info/',
        'icon' => '<i class="fa-solid fa-circle-info"></i>',
        'menu_hide' => false,
        'subs' => [
          '/info/versions/' => array(
            'name' => $oLang->get('Versions'),
            'description' => $oLang->get('Versions'),
            'url' => '/info/versions/',
            'icon' => '<i class="fas fa-code-branch"></i>',
            'menu_hide' => false,
          ),
          '/info/buy/' => array(
            'name' => $oLang->get('Donate'),
            'description' => $oLang->get('Donate'),
            'url' => '/info/buy/',
            'icon' => '<i class="fas fa-donate"></i>',
            'menu_hide' => false,
          ),
          '/info/contacts/' => array(
            'name' => $oLang->get('Contacts'),
            'description' => $oLang->get('Contacts'),
            'url' => '/info/contacts/',
            'icon' => '<i class="fas fa-info"></i>',
            'menu_hide' => false,
          ),
          '/info/analytics/' => array(
            'name' => $oLang->get('Analytics'),
            'description' => $oLang->get('Analytics'),
            'url' => '/info/analytics/',
            'icon' => '<i class="fas fa-chart-line"></i>',
            'menu_hide' => false,
          ),
          '/info/docs/' => array(
            'name' => $oLang->get('Docs'),
            'description' => $oLang->get('Docs'),
            'url' => '/info/docs/',
            'icon' => '<i class="fas fa-book-dead"></i>',
            'menu_hide' => false,
          ),
        ],
      ),
    ];

    $this->get_navs();
    $this->get_path();
  }
}
