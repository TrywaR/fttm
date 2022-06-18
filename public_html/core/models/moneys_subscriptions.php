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
  public static $arrTypes = '';
  public static $day = '';
  public static $category = '';
  public static $card = '';
  public static $active = '';
  public static $user_id = '';
  public static $sDateQuery = '';

  public function get_subscription( $arrSubscription = [] ){
    if ( ! $arrCategory['id'] ) $arrCategory = $this->get();

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
    
    return $arrSubscription;
  }

  function get_subscriptions(){
    $arrSubscriptions = $this->get();
    if ( $arrSubscriptions['id'] ) $arrSubscriptions = $this->get_subscription( $arrSubscriptions );
    else foreach ($arrSubscriptions as &$arrSubscription) $arrSubscription = $this->get_subscription($arrSubscription);
    return $arrSubscriptions;
  }

  public function get_month(){
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
    $arrMoneys = $oMoney->get_moneys();
    // return $arrMoney;

    $iMonthSum = 0;
    foreach ($arrMoneys as $arrMoney) $iMonthSum = (int)$arrMoney['price'] + (int)$iMonthSum;
    return $iMonthSum;
  }

  public function fields() # Поля для редактирования
  {
    $oLang = new lang();

    $arrFields = [];
    $arrFields['id'] = ['title'=>'ID','type'=>'number','disabled'=>'disabled','value'=>$this->id]; # Для отображения пользователю
    $arrFields['id'] = ['title'=>'ID','type'=>'hidden','disabled'=>'disabled','value'=>$this->id]; # Для передачи в параметры
    $arrFields['user_id'] = ['title'=>$oLang->get('User'),'type'=>'hidden','value'=>$_SESSION['user']['id']];

    $arrFields['type'] = ['class'=>'switch','title'=>$oLang->get('Type'),'type'=>'select','options'=>$this->arrTypes,'value'=>$this->type];
    $arrFields['day'] = ['title'=>$oLang->get('PaymentDay'),'type'=>'number','value'=>$this->day];

    $oCard = new card();
    $oCard->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $oCard->sort = 'sort';
    $oCard->sortDir = 'ASC';
    $arrCards = $oCard->get();
    $arrCardsFilter = [];
    $arrCardsFilter[] = array('id'=>0,'name'=>'...');
    foreach ($arrCards as $arrCard) $arrCardsFilter[] = array('id'=>$arrCard['id'],'name'=>$arrCard['title']);
    $arrFields['card'] = ['class'=>'switch_values switch_type-0','title'=>$oLang->get('FromCard'),'type'=>'select','options'=>$arrCardsFilter,'value'=>$this->card];

    $oMoneyCategory = new moneys_category();
    $oMoneyCategory->sort = 'sort';
    $oMoneyCategory->sortDir = 'ASC';
    $oMoneyCategory->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . ' OR `user_id` = 0)';
    $arrMoneysCategories = $oMoneyCategory->get_categories();
    $arrMoneysCategoriesFilter = [];
    foreach ($arrMoneysCategories as $arrMoneysCategory) $arrMoneysCategoriesFilter[] = array('id'=>$arrMoneysCategory['id'],'name'=>$arrMoneysCategory['title']);
    $arrFields['category'] = ['title'=>$oLang->get('Category'),'type'=>'select','options'=>$arrMoneysCategoriesFilter,'value'=>$this->category];

    $arrFields['title'] = ['title'=>$oLang->get('Title'),'type'=>'text','required'=>'required','value'=>$this->title];
    $arrFields['sort'] = ['title'=>$oLang->get('Sort'),'type'=>'number','value'=>$this->sort];

    // $arrFields['sum'] = ['title'=>$oLang->get('Sum'),'type'=>'number','value'=>$this->sum];
    $arrFields['price'] = ['title'=>$oLang->get('Payment'),'type'=>'number','value'=>substr($this->price, 0, -2),'step'=>'0.01'];
    $arrFields['sum'] = ['title'=>$oLang->get('Sum'),'type'=>'number','value'=>substr($this->sum, 0, -2),'step'=>'0.01'];

    // $sColor = $this->color ? $this->color : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) );
    // $arrFields['color'] = ['title'=>$oLang->get('Color'),'type'=>'color','value'=>$sColor];

    // $arrFields['active'] = ['title'=>$oLang->get('Active'),'type'=>'hidden','value'=>$this->active];

    return $arrFields;
  }

  function __construct( $moneys_subscriptions_id = 0 )
  {
    $oLang = new lang();
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

    $this->arrTypes = [
      array('id'=>0,'name'=>$oLang->get('EveryMonth')),
    ];
  }
}
