<?
/**
 * Client
 */
class client extends model
{
  public static $table = ''; # Таблица в bd
  public static $id = '';
  public static $title = '';
  public static $description = '';
  public static $sort = '';
  public static $active = '';
  public static $user_id = '';

  function __construct( $client_id = 0 )
  {
    $this->table = 'clients';

    if ( $client_id ) {
      $mySql = "SELECT * FROM `" . $this->table . "`";
      $mySql .= " WHERE `id` = '" . $client_id . "'";
      $arrClient = db::query($mySql);

      $this->id = $arrClient['id'];
      $this->title = $arrClient['name'];
      $this->description = $arrClient['description'];
      $this->sort = $arrClient['sort'];
      $this->active = $arrClient['active'];
      $this->user_id = $arrClient['user_id'];
    }
  }
}
