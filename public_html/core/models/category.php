<?
/**
 * Category
 */
class category extends model
{
  public static $table = ''; # Таблица в bd
  public static $id = '';
  public static $title = '';
  public static $sort = '';
  public static $color = '';
  public static $active = '';
  public static $user_id = '';

  // Поиск в списке категорий нужной, если нет, добавляем
  function ckeck_categories ( $iCategoryId = 0, $arrCategories = [] ){
    foreach ( $arrCategories as $arrCategory )
      if ( $arrCategory['id'] == $iCategoryId ) return $arrCategories;

    $oCategory = new category( $iCategoryId );
    $arrCategory = $oCategory->get_categories();
    $arrCategories[] = $arrCategory;

    return $arrCategories;
  }

  function get_category( $arrCategory = [] ) {
    if ( ! $arrCategory['id'] ) $arrCategory = $this->get();

    // Конфиги пользователя
    if ( (int)$arrCategory['user_id'] ) {
      $arrCategory['edit_show'] = 'true';
    }
    // Кастомные
    else {
      $arrCategory['custom_edit_show'] = 'true';
      $oCategoryConf = new category_config( $arrCategory['id'] );
      $arrCategoryConf = $oCategoryConf->get_categories_configs();
      if ( isset($arrCategoryConf['id']) ) {
        $arrCategory['sort'] = $arrCategoryConf['sort'];
        $arrCategory['title'] = $arrCategoryConf['title'];
        $arrCategory['active'] = $arrCategoryConf['active'];
        $arrCategory['color'] = $arrCategoryConf['color'];
      }
    }

    if ( (int)$arrCategory['active'] ) $arrCategory['active_show'] = 'true';
    else $arrCategory['active_show'] = 'false';

    // translate
    $oLang = new lang();
    if ( $arrCategory['title'] ) $arrCategory['title'] = $oLang->get($arrCategory['title']);

    return $arrCategory;
  }

  function get_categories(){
    $arrCategories = $this->get();
    if ( $arrCategories['id'] ) $arrCategories = $this->get_category( $arrCategories );
    else foreach ($arrCategories as &$arrCategory) $arrCategory = $this->get_category($arrCategory);
    return $arrCategories;
  }

  public function fields() # Поля для редактирования
  {
    $oLang = new lang();

    $arrFields = [];
    $arrFields['id_val'] = ['title'=>'ID','type'=>'number','disabled'=>'disabled','value'=>$this->id]; # Для отображения пользователю
    $arrFields['id'] = ['title'=>'ID','type'=>'hidden','disabled'=>'disabled','value'=>$this->id]; # Для передачи в параметры
    $arrFields['user_id'] = ['title'=>$oLang->get('User'),'type'=>'hidden','value'=>$_SESSION['user']['id']];

    $arrFields['title'] = ['title'=>$oLang->get('Title'),'type'=>'text','required'=>'required','value'=>$this->title];

    // $iSort = $this->sort ? $this->sort : 100;
    $arrFields['sort'] = ['title'=>$oLang->get('Sort'),'type'=>'number','value'=>$this->sort];

    $sColor = $this->color ? $this->color : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) );
    $arrFields['color'] = ['title'=>$oLang->get('Color'),'type'=>'color','value'=>$sColor];

    $arrFields['active'] = ['title'=>$oLang->get('Active'),'type'=>'checkbox','value'=>$this->active];

    return $arrFields;
  }

  function __construct( $iCategoryId = 0 )
  {
    $this->table = 'categories';

    if ( $iCategoryId ) {
      $mySql = "SELECT * FROM `" . $this->table . "`";
      $mySql .= " WHERE `id` = '" . $iCategoryId . "'";
      $arrCategory = db::query($mySql);

      $this->id = $arrCategory['id'];
      $this->title = $arrCategory['title'];
      $this->sort = $arrCategory['sort'];
      $this->active = $arrCategory['active'];
      $this->color = $arrCategory['color'];
      $this->user_id = $arrCategory['user_id'];
    }
  }
}
