<?
/**
 * moneys_subscriptions
 */
class moneys_subscriptions extends model
{
  public static $table = ''; # Таблица в bd
  public static $id = '';
  public static $title = '';
  public static $sort = '';
  public static $price = '';
  public static $sum = '';
  public static $type = '';
  public static $day = '';
  public static $category = '';
  public static $card = '';
  public static $active = '';
  public static $user_id = '';

  function __construct( $moneys_subscriptions_id = 0 )
  {
    $this->table = 'moneys_subscriptions';

    if ( $moneys_subscriptions_id ) {
      $mySql = "SELECT * FROM `" . $this->table . "`";
      $mySql .= " WHERE `id` = '" . $moneys_subscriptions_id . "'";
      $arrCard = db::query($mySql);

      $this->id = $arrCard['id'];
      $this->title = $arrCard['title'];
      $this->sort = $arrCard['sort'];
      $this->price = $arrCard['price'];
      $this->sum = $arrCard['sum'];
      $this->type = $arrCard['type'];
      $this->day = $arrCard['day'];
      $this->category = $arrCard['category'];
      $this->card = $arrCard['card'];
      $this->active = $arrCard['active'];
      $this->user_id = $arrCard['user_id'];
    }
  }
}
