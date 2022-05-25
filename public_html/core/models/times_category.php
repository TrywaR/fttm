<?
/**
 * Times_category
 */
class times_category extends model
{
  public static $table = ''; # Таблица в bd
  public static $id = '';
  public static $title = '';
  public static $sort = '';
  public static $active = '';
  public static $color = '';
  public static $user_id = '';

  function get_category(){
    $arrResult = [];
    $arrCategory = $this->get();
    if ( (int)$arrCategory['user_id'] ) $arrCategory['edit_show'] = 'true';
    // translate
    $oLang = new lang();
    if ( $arrCategory['title'] ) $arrCategory['title'] = $oLang->get($arrCategory['title']);
    $arrResult = $arrCategory;
    return $arrResult;
  }

  function get_categories(){
    $arrResults = [];
    $arrTimesCategories = $this->get();
    foreach ($arrTimesCategories as $arrTimeCategory) {
      $oCategory = new times_category( $arrTimeCategory['id'] );
      $arrResults[] = $oCategory->get_category();
    }
    return $arrResults;
  }

  function __construct( $times_category_id = 0 )
  {
    $this->table = 'times_categories';

    if ( $times_category_id ) {
      $mySql = "SELECT * FROM `" . $this->table . "`";
      $mySql .= " WHERE `id` = '" . $times_category_id . "'";
      $arrCard = db::query($mySql);

      $this->id = $arrCard['id'];
      $this->title = $arrCard['title'];
      $this->sort = $arrCard['sort'];
      $this->active = $arrCard['active'];
      $this->color = $arrCard['color'];
      $this->user_id = $arrCard['user_id'];
    }
  }
}
