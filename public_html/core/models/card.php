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
  public static $date_update = '';

  // Пересчёт баланса
  function reload_balance( $iCardId = 0 ){
    if ( ! $iCardId ) $iCardId = $this->id;

    $oCard = new card( $iCardId );
    $oCard->balance = $oCard->limit ? $oCard->limit : 0;
    $arrCard = $oCard->get();

    $oMoney = new money();
    $oMoney->query .= ' AND `card` = ' . $iCardId;
    $oMoney->query .= ' AND `user_id` = ' . $_SESSION['user']['id'];
    $arrMoneys = $oMoney->get_money();

    foreach ($arrMoneys as $arrMoney) {
      $oMoneyCategory = new moneys_category( $arrMoney['categroy'] );
      switch ( (int)$oMoneyCategory->type ) {
        case 0: # no categroy
          switch ( (int)$arrMoney['type'] ) {
            case 0: # Minus
              $oCard->balance = $oCard->balance - $arrMoney['price'];
            case 1: # Plus
              $oCard->balance = $oCard->balance + $arrMoney['price'];
              break;
          }
          break;
        case 1: # Not minus
          // code...
          break;
        case 2: # Plus
          $oCard->balance = $oCard->balance + $arrMoney['price'];
          break;
      }
    }

    $oCard->date_update = date("Y-m-d H:i:s");
    $oCard->save();

    return $arrCard;
  }

  // Вывод карты
  function get_card( $iCardId = 0 ){
    if ( ! $iCardId ) $iCardId = $this->id;

    $oCard = new card( $iCardId );
    $arrCard = $oCard->get();

    // Проверка последней оплаты, если не сходится обнавляем баланс
    $oMoney = new money();
    $oMoney->query .= ' AND `card` = ' . $iCardId;
    $oMoney->query .= ' AND `user_id` = ' . $_SESSION['user']['id'];
    $oMoney->query .= ' ORDER BY `date` ASC LIMIT 1';
    $arrMoneys = $oMoney->get_money();

    $iLastMoney = strtotime($arrMoneys[0]['date']);
    $iLastUpdateCard = strtotime($arrCard['date_update']);

    if ( $iLastMoney > $iLastUpdateCard ) $oCard->reload_balance();

    $arrCard['balance'] = substr($arrCard['balance'], 0, -2);
    $arrCard['limit'] = substr($arrCard['limit'], 0, -2);

    return $arrCard;
  }

  // Вывод карт
  function get_cards(){
    $arrResults = [];
    $arrCards = $this->get();

    foreach ( $arrCards as $arrCard ) {
      $oCard = new card( $arrCard['id'] );
      $oCard->query = $this->query;
      $arrResults[] = $oCard->get_card();
    }

    return $arrResults;
  }

  function __construct( $card_id = 0 )
  {
    $this->table = 'cards';

    if ( $card_id ) {
      $mySql = "SELECT * FROM `" . $this->table . "`";
      $mySql .= " WHERE `id` = '" . $card_id . "'";
      $arrCard = db::query($mySql);

      $this->id = $arrCard['id'];
      $this->title = $arrCard['title'];
      $this->balance = $arrCard['balance'];
      $this->limit = $arrCard['limit'];
      $this->sort = $arrCard['sort'];
      $this->active = $arrCard['active'];
      $this->user_id = $arrCard['user_id'];
      $this->date_update = $arrCard['date_update'];
    }
  }
}
