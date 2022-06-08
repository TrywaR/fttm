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
    // ru
    $this->arrNav = [];
    $this->arrNav = [
      // '/' => array(
      //   'id' => 1,
      //   'name' => 'Welcome',
      //   'url' => '/',
      //   'icon' => '',
      // ),
      '/home/' => array(
        'id' => 2,
        'name' => 'Home',
        'url' => '/home/',
        'icon' => '<i class="fa-solid fa-house"></i>',
      ),
      '/moneys/' => array(
        'id' => 3,
        'name' => 'Moneys',
        'url' => '/moneys/',
        'icon' => '<i class="fa-solid fa-wallet"></i>',
        'subs' => [
          '/times/data/categories/' => array(
            'name' => 'Categories',
            'url' => '/moneys/data/categories/',
            'icon' => '<i class="fa-solid fa-folder-tree"></i>',
          ),
          '/moneys/data/cards/' => array(
            'name' => 'Cards',
            'url' => '/moneys/data/cards/',
            'icon' => '<i class="fa-solid fa-credit-card"></i>',
          ),
          '/moneys/data/subscriptions/' => array(
            'name' => 'Subscriptions',
            'url' => '/moneys/data/subscriptions/',
            'icon' => '<i class="fa-solid fa-money-check-dollar"></i>',
          ),
          '/moneys/analytics/costs/' => array(
            'name' => 'Costs',
            'url' => '/moneys/analytics/costs/',
            'icon' => '<i class="fa-solid fa-chart-area"></i>',
          ),
          '/moneys/analytics/wages/' => array(
            'name' => 'Wages',
            'url' => '/moneys/analytics/wages/',
            'icon' => '<i class="fa-solid fa-chart-bar"></i>',
          ),
        ],
      ),
      '/times/' => array(
        'id' => 4,
        'name' => 'Times',
        'url' => '/times/',
        'icon' => '<i class="fa-solid fa-clock"></i>',
        'subs' => [
          '/times/data/categories/' => array(
            'name' => 'Categories',
            'url' => '/times/data/categories/',
            'icon' => '<i class="fa-solid fa-folder-tree"></i>',
          ),
          '/times/analytics/costs/' => array(
            'name' => 'Time spent',
            'url' => '/times/analytics/costs/',
            'icon' => '<i class="fa-solid fa-chart-bar"></i>',
          ),
        ],
      ),
      '/tasks/' => array(
        'id' => 5,
        'name' => 'Tasks',
        'url' => '/tasks/',
        'icon' => '<i class="fa-solid fa-person-digging"></i>',
        'subs' => [
          '/projects/data/clients/' => array(
            'name' => 'Clients',
            'url' => '/projects/data/clients/',
            'icon' => '<i class="fa-solid fa-folder"></i>',
          ),
          '/projects/' => array(
            'name' => 'Projects',
            'url' => '/projects/',
            'icon' => '<i class="fa-solid fa-folder-tree"></i>',
          ),
        ],
      ),
      '/projects/' => array(
        'id' => 6,
        'name' => 'Projects',
        'url' => '/projects/',
        'icon' => '<i class="fa-solid fa-folder-tree"></i>',
        'subs' => [
          '/projects/data/clients/' => array(
            'name' => 'Clients',
            'url' => '/projects/data/clients/',
            'icon' => '<i class="fa-solid fa-folder"></i>',
          ),
        ],
      ),
      '/info/' => array(
        'id' => 7,
        'name' => 'Info',
        'url' => '/info/',
        'icon' => '<i class="fa-solid fa-circle-info"></i>',
        'subs' => [
          '/info/versions/' => array(
            'name' => 'Versions',
            'url' => '/info/versions/',
            'icon' => '<i class="fas fa-code-branch"></i>',
          ),
          '/info/contacts/' => array(
            'name' => 'Contacts',
            'url' => '/info/contacts/',
            'icon' => '<i class="fas fa-info"></i>',
          ),
          '/info/analytics/' => array(
            'name' => 'Analytics',
            'url' => '/info/analytics/',
            'icon' => '<i class="fas fa-chart-line"></i>',
          ),
          '/info/buy/' => array(
            'name' => 'Donate',
            'url' => '/info/buy/',
            'icon' => '<i class="fas fa-donate"></i>',
          ),
          '/info/docs/' => array(
            'name' => 'Docs',
            'url' => '/info/docs/',
            'icon' => '<i class="fas fa-book-dead"></i>',
          ),
        ],
      ),
    ];
  }
}