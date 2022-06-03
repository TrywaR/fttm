<?
/**
 * Moneys_category
 */
class moneys_category extends model
{
  public static $table = ''; # Таблица в bd
  public static $id = '';
  public static $title = '';
  public static $sort = '';
  public static $priority = '';
  public static $color = '';
  public static $active = '';
  public static $type = '';
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
    $arrMoneysCategories = $this->get();
    foreach ($arrMoneysCategories as $arrMoneyCategory) {
      $oCategory = new moneys_category( $arrMoneyCategory['id'] );
      $arrResults[] = $oCategory->get_category();
    }
    return $arrResults;
  }

  function __construct( $moneys_category_id = 0 )
  {
    $this->table = 'moneys_categories';

    if ( $moneys_category_id ) {
      $mySql = "SELECT * FROM `" . $this->table . "`";
      $mySql .= " WHERE `id` = '" . $moneys_category_id . "'";
      $arrCategory = db::query($mySql);

      $this->id = $arrCategory['id'];
      $this->title = $arrCategory['title'];
      $this->sort = $arrCategory['sort'];
      $this->priority = $arrCategory['priority'];
      $this->active = $arrCategory['active'];
      $this->color = $arrCategory['color'];
      $this->type = $arrCategory['type'];
      $this->user_id = $arrCategory['user_id'];
    }
  }
}
