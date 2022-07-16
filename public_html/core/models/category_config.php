<?
/**
 * Category
 */
class category_config extends model
{
  public static $table = ''; # Таблица в bd
  public static $id = '';
  public static $sort = '';
  public static $color = '';
  public static $title = '';
  public static $user_id = '';
  public static $category_id = '';
  public static $active = '';

  function update_categories ( $arrCategories = [] ) {
    // Берём конфики костомных категорий пользователя
    $oCategoryConf = new category_config();
    $oCategoryConf->sortname = 'sort';
    $oCategoryConf->sortdir = 'ASC';
    $oCategoryConf->limit = 30;
    $arrCategoriesConf = $oCategoryConf->get_categories_configs();
    $arrCategoriesConfIds = [];
    foreach ($arrCategoriesConf as &$arrCategoryConf) $arrCategoriesConfIds[$arrCategoryConf['category_id']] = $arrCategoryConf;

    // Заменям их
    foreach ($arrCategories as &$arrCategory)
      if ( ! empty($arrCategoriesConfIds[$arrCategory['id']]) ) {
        $arrCategory['sort'] = $arrCategoriesConfIds[$arrCategory['id']]['sort'];
        $arrCategory['title'] = $arrCategoriesConfIds[$arrCategory['id']]['title'];
        $arrCategory['active'] = $arrCategoriesConfIds[$arrCategory['id']]['active'];
        $arrCategory['color'] = $arrCategoriesConfIds[$arrCategory['id']]['color'];
      }

    // и сортируем
    usort($arrCategories, function($a, $b){
      return ($a['sort'] - $b['sort']);
    });

    return $arrCategories;
  }

  function update_categories_active ( $arrCategories = [] ) {
    $arrResults = [];
    foreach ( $arrCategories as $arrCategory )
      if ( (int)$arrCategory['active'] ) $arrResults[] = $arrCategory;

    return $arrResults;
  }

  function get_category_config( $arrCategoryConfg = [] ) {
    if ( ! $arrCategoryConfg['id'] ) $arrCategoryConfg = $this->get();
    // translate
    $oLang = new lang();
    if ( $arrCategoryConfg['title'] ) $arrCategoryConfg['title'] = $oLang->get($arrCategoryConfg['title']);
    return $arrCategoryConfg;
  }

  function get_categories_configs() {
    $arrCategoriesConfigs = $this->get();
    if ( $arrCategoriesConfigs['id'] ) $arrCategoriesConfigs = $this->get_category_config( $arrCategoriesConfigs );
    else foreach ($arrCategoriesConfigs as &$arrCategoryConfg) $arrCategoryConfg = $this->get_category_config($arrCategoryConfg);
    return $arrCategoriesConfigs;
  }

  public function fields() # Поля для редактирования
  {
    $oLang = new lang();

    if ( $this->category_id ) {
      $oCategory = new category( $this->category_id );
      $arrCategory = $oCategory->get_categories();
      $this->title = $this->title ? $this->title : $arrCategory['title'];
      $this->sort = $this->sort ? $this->sort : $arrCategory['sort'];
      // $this->active = $this->active ? $this->active : $arrCategory['active'];
      $this->color = $this->color ? $this->color : $arrCategory['color'];
      $this->user_id = $this->user_id ? $this->user_id : $_SESSION['user']['id'];
    }

    $arrFields = [];
    // $arrFields['id_val'] = ['title'=>'ID','type'=>'number','disabled'=>'disabled','value'=>$this->id]; # Для отображения пользователю
    $arrFields['id'] = ['title'=>'ID','type'=>'hidden','disabled'=>'disabled','value'=>$this->id]; # Для передачи в параметры
    $arrFields['category_id'] = ['title'=>'category_id','type'=>'hidden','disabled'=>'disabled','value'=>$this->category_id]; # Для передачи в параметры
    $arrFields['user_id'] = ['title'=>$oLang->get('User'),'type'=>'hidden','value'=>$_SESSION['user']['id']];
    $arrFields['title'] = ['title'=>$oLang->get('Title'),'type'=>'text','required'=>'required','value'=>$this->title];
    $iSort = $this->sort ? $this->sort : 100;
    $arrFields['sort'] = ['title'=>$oLang->get('Sort'),'type'=>'number','value'=>$iSort];
    $sColor = $this->color ? $this->color : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) );
    $arrFields['color'] = ['title'=>$oLang->get('Color'),'type'=>'color','value'=>$sColor];
    $arrFields['active'] = ['title'=>$oLang->get('Active'),'type'=>'checkbox','value'=>$this->active];

    return $arrFields;
  }

  function __construct( $iCtegoryId = 0 )
  {
    $this->table = 'categories_configs';

    if ( $iCtegoryId ) {
      $mySql = "SELECT * FROM `" . $this->table . "`";
      $mySql .= " WHERE `category_id` = '" . $iCtegoryId . "'";
      $mySql .= " AND `user_id` = '" . $_SESSION["user"]["id"] . "'";
      $arrCategoryConfg = db::query($mySql);

      if ( isset($arrCategoryConfg['id']) ) {
        $this->id = $arrCategoryConfg['id'];
        $this->title = $arrCategoryConfg['title'];
        $this->sort = $arrCategoryConfg['sort'];
        $this->active = $arrCategoryConfg['active'];
        $this->color = $arrCategoryConfg['color'];
        $this->user_id = $arrCategoryConfg['user_id'];
        $this->category_id = $arrCategoryConfg['category_id'];
      }
      else {
        $this->category_id = $iCtegoryId;
      }
    }
    else{
      $this->user_id = $_SESSION['user']['id'];
    }
  }
}
