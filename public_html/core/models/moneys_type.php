<?
/**
 * Moneys_type
 */
class moneys_type extends model
{
  public static $table = ''; # Таблица в bd
  public static $id = '';
  public static $title = '';
  public static $sort = '';
  public static $priority = '';
  public static $active = '';
  public static $user_id = '';

  function __construct( $moneys_type_id = 0 )
  {
    $this->table = 'moneys_types';

    if ( $moneys_type_id ) {
      $mySql = "SELECT * FROM `" . $this->table . "`";
      $mySql .= " WHERE `id` = '" . $moneys_type_id . "'";
      $arrCard = db::query($mySql);

      $this->id = $arrCard['id'];
      $this->title = $arrCard['title'];
      $this->sort = $arrCard['sort'];
      $this->priority = $arrCard['priority'];
      $this->active = $arrCard['active'];
      $this->user_id = $arrCard['user_id'];
    }
  }
}
