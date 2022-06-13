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
  public static $type = '';
  public static $arrTypes = '';
  public static $color = '';
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

    $oMoney = new money();
    $oMoney->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $oMoney->query .= ' AND `to_card` = ' . $this->id;
    $oMoney->query .= ' AND `type` = 3';
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
    $oMoneyCommission->query .= ' AND `category` = 2';
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


  public function fields() # Поля для редактирования
  {
    $oLang = new lang();

    $arrFields = [];
    $arrFields['id'] = ['title'=>'ID','type'=>'number','disabled'=>'disabled','value'=>$this->id]; # Для отображения пользователю
    $arrFields['id'] = ['title'=>'ID','type'=>'hidden','disabled'=>'disabled','value'=>$this->id]; # Для передачи в параметры
    $arrFields['user_id'] = ['title'=>$oLang->get('User'),'type'=>'hidden','value'=>$_SESSION['user']['id']];

    $arrFields['type'] = ['class'=>'switch','title'=>$oLang->get('Type'),'type'=>'select','options'=>$this->arrTypes,'value'=>$this->type];

    $arrFields['title'] = ['title'=>$oLang->get('Title'),'type'=>'text','required'=>'required','value'=>$this->title];

    $sColor = $this->color ? $this->color : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) );
    $arrFields['color'] = ['title'=>$oLang->get('Color'),'type'=>'color','value'=>$sColor];

    $arrFields['sort'] = ['title'=>$oLang->get('Sort'),'type'=>'number','value'=>$this->sort];

    $arrFields['limit'] = ['class'=>'switch_values switch_type-1','title'=>$oLang->get('Limit'),'type'=>'number','value'=>substr($this->limit, 0, -2),'step'=>'0.01'];
    $arrFields['percent'] = ['class'=>'switch_values switch_type-1 switch_type-2','title'=>$oLang->get('Percent'),'type'=>'number','value'=>substr($this->percent, 0, -2),'step'=>'0.01'];
    // $arrFields['price'] = ['title'=>$oLang->get('Price'),'type'=>'number','value'=>substr($this->price, 0, -2),'step'=>'0.01'];

    $arrFields['service'] = ['class'=>'switch_values switch_type-1','title'=>$oLang->get('CardService'),'type'=>'number','value'=>substr($this->service, 0, -2),'step'=>'0.01'];
    $arrFields['date_service'] = ['class'=>'switch_values switch_type-1','title'=>$oLang->get('CardServiceDate'),'type'=>'date','value'=>$this->date_service];

    $arrFields['free_days_limit'] = ['class'=>'switch_values switch_type-1','title'=>$oLang->get('CardFreeDaysLimit'),'type'=>'number','value'=>$this->free_days_limit];
    $arrFields['date_commission'] = ['class'=>'switch_values switch_type-1','title'=>$oLang->get('CardDateCommissions'),'type'=>'date','value'=>$this->date_commission];
    $arrFields['date_bill_percent'] = ['class'=>'switch_values switch_type-2','title'=>$oLang->get('CardDateBillPercent'),'type'=>'date','value'=>$this->date_bill_percent];

    // $arrFields['active'] = ['title'=>$oLang->get('Active'),'type'=>'hidden','value'=>$this->active];

    return $arrFields;
  }

  function __construct( $card_id = 0 )
  {
    $oLang = new lang();
    $this->table = 'cards';

    if ( $card_id ) {
      $mySql = "SELECT * FROM `" . $this->table . "`";
      $mySql .= " WHERE `id` = '" . $card_id . "'";
      $arrCard = db::query($mySql);

      $this->id = $arrCard['id'];
      $this->title = $arrCard['title'];
      $this->balance = $arrCard['balance'];
      $this->type = $arrCard['type'];
      $this->color = $arrCard['color'];
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

    $this->arrTypes = [
      array('id'=>0,'name'=>$oLang->get('CardDebit')),
      array('id'=>1,'name'=>$oLang->get('CardCredit')),
      array('id'=>2,'name'=>$oLang->get('CardBill')),
    ];
  }
}
