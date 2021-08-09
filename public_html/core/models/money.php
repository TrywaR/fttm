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
  public static $type = ''; # хз пока что
  public static $value = ''; # minus - затраты
  public static $user_id = '';

  function prep_money( $arrMoney ){
    $arrDate = explode(' ', $arrMoney['date']);
    $arrMoney['date'] = $arrDate[0];
    $arrMoney['price'] = substr($arrMoney['price'], 0, -2);
    return $arrMoney;
  }

  function get_money(){
    $arrMoneys = $this->get();
    if ( $arrMoneys['id'] ) $arrMoneys = $this->prep_money( $arrMoneys );
    else foreach ($arrMoneys as &$arrMoney) $arrMoney = $this->prep_money($arrMoney);

    return $arrMoneys;
  }

  function __construct( $money_id = 0 )
  {
    $this->table = 'moneys';

    if ( $money_id ) {
      $mySql = "SELECT * FROM `" . $this->table . "`";
      $mySql .= " WHERE `id` = '" . $money_id . "'";
      $arrMoney = db::query($mySql);

      $this->id = $arrMoney['id'];
      $this->title = $arrMoney['title'];
      $this->project_id = $arrMoney['project_id'];
      $this->tasks_id = $arrMoney['tasks_id'];
      $this->price = $arrMoney['price'];
      $this->card = $arrMoney['card'];
      $this->date = $arrMoney['date'];
      $this->type = $arrMoney['type'];
      $this->value = $arrMoney['value'];
      $this->user_id = $arrMoney['user_id'];
    }
  }
}
