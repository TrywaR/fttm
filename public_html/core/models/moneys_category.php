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
      $arrCard = db::query($mySql);

      $this->id = $arrCard['id'];
      $this->title = $arrCard['title'];
      $this->sort = $arrCard['sort'];
      $this->priority = $arrCard['priority'];
      $this->active = $arrCard['active'];
      $this->type = $arrCard['type'];
      $this->user_id = $arrCard['user_id'];
    }
  }
}
