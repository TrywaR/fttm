<?
/**
 * Card
 */
class card extends model
{
  public static $table = ''; # Таблица в bd
  public static $id = '';
  public static $title = '';
  public static $balance = '';
  public static $limit = '';
  public static $sort = '';
  public static $active = '';
  public static $user_id = '';

  function __construct( $card_id = 0 )
  {
    $this->table = 'cards';

    if ( $card_id ) {
      $mySql = "SELECT * FROM `" . $this->table . "`";
      $mySql .= " WHERE `id` = '" . $card_id . "'";
      $arrCard = db::query($mySql);

      $this->id = $arrCard['id'];
      $this->title = $arrCard['name'];
      $this->balance = $arrCard['balance'];
      $this->limit = $arrCard['limit'];
      $this->sort = $arrCard['sort'];
      $this->active = $arrCard['active'];
      $this->user_id = $arrCard['user_id'];
    }
  }
}
