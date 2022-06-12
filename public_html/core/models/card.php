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
  public static $date_update = ''; # Last update
  public static $service = '';
  public static $commission = '';
  public static $percent = '';
  public static $date_service = '';
  public static $date_commission = '';
  public static $free_days_limit = '';

  // Пополнение баланса карты
  function balance_add( $floatSum ){
    $this->balance = (float)$this->balance + (float)$floatSum;
    $this->date_update = date("Y-m-d H:i:s");
    $this->save();
    return $this->balance;
  }

  // Саписание баланса карты
  function balance_remove( $floatSum ){
    $this->balance = (float)$this->balance - (float)$floatSum;
    $this->date_update = date("Y-m-d H:i:s");
    $this->save();
    return $this->balance;
  }

  // Пересчёт баланса карты
  function balance_reload(){
    $this->balance = $this->limit;

    // Если кридитка, считаем комиссии
    if ( (float)$this->limit > 0 ) $this->commission = $this->commission_reload();

    // Анализируем затраты
    $oMoney = new money();
    $oMoney->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $oMoney->query .= ' AND `card` = ' . $this->id;
    $oMoney->query .= ' AND `type` = 0';
    $arrMoneys = $oMoney->get_money();
    foreach ($arrMoneys as $arrMoney) $this->balance = (float)$this->balance - (float)$arrMoney['price'];

    // Анализируем поступления
    $oMoney = new money();
    $oMoney->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $oMoney->query .= ' AND `card` = ' . $this->id;
    $oMoney->query .= ' AND `type` = 1';
    $arrMoneys = $oMoney->get_money();
    foreach ($arrMoneys as $arrMoney) $this->balance = (float)$this->balance + (float)$arrMoney['price'];

    // Анализируем поступления с других карт
    $oMoney = new money();
    $oMoney->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $oMoney->query .= ' AND `to_card` = ' . $this->id;
    $oMoney->query .= ' AND `type` = 0';
    $arrMoneys = $oMoney->get_money();
    foreach ($arrMoneys as $arrMoney) $this->balance = (float)$this->balance + (float)$arrMoney['price'];

    $this->date_update = date("Y-m-d H:i:s");
    $this->save();
    return $this->balance;
  }

  // Пополнение комиссии карты
  function commission_add( $floatSum ){
    $this->commission = (float)$this->commission + (float)$floatSum;
    $this->date_update = date("Y-m-d H:i:s");
    $this->save();
    return $this->commission;
  }

  // Саписание комиссии карты
  function commission_remove( $floatSum ){
    $this->commission = (float)$this->commission - (float)$floatSum;
    $this->date_update = date("Y-m-d H:i:s");
    $this->save();
    return $this->commission;
  }

  // Пересчёт комиссий
  function commission_reload(){
    $this->commission = 0;

    // Анализируем затраты
    $oMoneyCommission = new money();
    $oMoneyCommission->query .= ' AND `card` = ' . $this->id;
    $oMoneyCommission->query .= ' AND `category` = 1';
    $arrMoneysCommissions = $oMoneyCommission->get_money();
    foreach ($arrMoneysCommissions as $arrMoneyCommission) $this->commission = (float)$this->commission + (float)$arrMoneyCommission['price'];
    return $this->commission;
  }

  // Вывод карты
  function get_card(){
    $arrCard = (array)$this;

    // Проверка последней оплаты, если не сходится обнавляем баланс
    $oMoney = new money();
    $oMoney->query .= ' AND `card` = ' . $arrCard['id'];
    $oMoney->query .= ' AND `user_id` = ' . $arrCard['user_id'];
    $oMoney->query .= ' ORDER BY `date` ASC LIMIT 1';
    $arrMoneys = $oMoney->get_money();
    $iLastMoney = strtotime($arrMoneys[0]['date']);
    $iLastUpdateCard = strtotime($arrCard['date_update']);
    if ( $iLastMoney > $iLastUpdateCard ) $arrCard['balance'] = $this->balance_reload();

    // Обработка данных
    $arrCard['balance'] = substr($arrCard['balance'], 0, -2);
    $arrCard['limit'] = substr($arrCard['limit'], 0, -2);
    $arrCard['commission'] = substr($arrCard['commission'], 0, -2);
    if ( (float)$arrCard['commission'] > 0 ) $arrCard['commission_show'] = 'true';

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
      $this->service = $arrCard['service'];
      $this->commission = $arrCard['commission'];
      $this->percent = $arrCard['percent'];
      $this->date_service = $arrCard['date_service'];
      $this->date_comismsion = $arrCard['date_commission'];
      $this->free_days_limit = $arrCard['free_days_limit'];
    }
  }
}
