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
