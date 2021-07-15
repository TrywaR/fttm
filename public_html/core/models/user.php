<?
/**
 * User
 */
class user extends model
{
  public static $table = ''; # Таблица в bd
  public static $id = '';

  function __construct( $money_id = 0 )
  {
    $this->table = 'users';

    if ( $money_id ) {
      $mySql = "SELECT * FROM `" . $this->table . "`";
      $mySql .= " WHERE `id` = '" . $money_id . "'";
      $arrClient = db::query($mySql);

      $this->id = $arrClient['id'];
    }
  }
}
