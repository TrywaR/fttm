<?
/**
 * Money
 */
class money extends model
{
  public static $table = ''; # Таблица в bd
  public static $id = '';
  public static $title = '';
  public static $project_id = '';
  public static $tasks_id = '';
  public static $price = '';
  public static $card = '';
  public static $date = '';
  public static $user_id = '';

  function __construct( $money_id = 0 )
  {
    $this->table = 'moneys';

    if ( $money_id ) {
      $mySql = "SELECT * FROM `" . $this->table . "`";
      $mySql .= " WHERE `id` = '" . $money_id . "'";
      $arrClient = db::query($mySql);

      $this->id = $arrClient['id'];
      $this->title = $arrClient['title'];
      $this->project_id = $arrClient['project_id'];
      $this->tasks_id = $arrClient['tasks_id'];
      $this->price = $arrClient['price'];
      $this->card = $arrClient['card'];
      $this->date = $arrClient['date'];
      $this->user_id = $arrClient['user_id'];
    }
  }
}
