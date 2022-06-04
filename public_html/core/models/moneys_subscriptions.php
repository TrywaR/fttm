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
  public static $sDateQuery = '';

  function get_month(){
    // $arrResult = [];
    // $arrSubscription = $this->get();

    // За месяц
    $oMoney = new money();
    $dCurrentDate = $this->sDateQuery != '' ? $this->sDateQuery : date('Y-m');
    // $dCurrentDate = $this->sDateQuery;
    $oMoney->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $oMoney->query .= " AND `date` LIKE '" . $dCurrentDate . "%'";
    $oMoney->query .= " AND `type` = '0'";
    $oMoney->query .= " AND `subscription` = '" . $this->id . "'";
    // return $oMoney->get_money();
    $arrMoneys = $oMoney->get_money();
    // return $arrMoney;

    $iMonthSum = 0;
    foreach ($arrMoneys as $arrMoney) $iMonthSum = (int)$arrMoney['price'] + (int)$iMonthSum;
    return $iMonthSum;
  }

  function get_subscription(){
    $arrResult = [];
    $arrSubscription = $this->get();
    if ( (int)$arrSubscription['user_id'] ) $arrSubscription['edit_show'] = 'true';

    if ( (int)$arrSubscription['card'] ) {
      $oCard = new card( $arrSubscription['card'] );
      $arrSubscription['card_val'] = (array)$oCard;
      $arrSubscription['card_show'] = 'true';
    }

    $arrSubscription['price'] = substr($arrSubscription['price'], 0, -2);
    $arrSubscription['sum'] = substr($arrSubscription['sum'], 0, -2);

    $bMoneysSum = $this->get_month();
    $arrSubscription['paid_sum'] = $bMoneysSum;
    $arrSubscription['paid_need'] = (int)$arrSubscription['price'] - (int)$bMoneysSum;

    if ( (int)$bMoneysSum >= (int)$arrSubscription['price'] ) {
      $arrSubscription['paid'] = true;
      $arrSubscription['paid_show'] = 'true';
    }

    $arrResult = $arrSubscription;
    return $arrResult;
  }

  function get_subscriptions(){
    $arrResults = [];
    $arrMoneysSubscriptions = $this->get();
    foreach ($arrMoneysSubscriptions as $arrSubscription) {
      $oMoneysSubscription = new moneys_subscriptions( $arrSubscription['id'] );
      if ( $this->sDateQuery ) $oMoneysSubscription->sDateQuery = $this->sDateQuery;
      $arrResults[] = $oMoneysSubscription->get_subscription();
    }
    return $arrResults;
  }

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
