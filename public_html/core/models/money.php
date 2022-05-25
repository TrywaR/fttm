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
  public static $category = '';
  public static $date = '';
  public static $type = ''; # хз пока что
  public static $value = ''; # minus - затраты
  public static $user_id = '';
  public static $to_card = ''; # на карту

  function prep_money( $arrMoney = [] ){
    $arrDate = explode(' ', $arrMoney['date']);
    $arrMoney['date'] = $arrDate[0];
    $arrMoney['price'] = substr($arrMoney['price'], 0, -2);

    if ( $arrMoney['card'] ) {
      $oCard = new card( $arrMoney['card'] );
      $arrMoney['card_val'] = (array)$oCard;
      $arrMoney['card_show'] = 'true';
    }

    if ( $arrMoney['to_card'] ) {
      $oCardTo = new card( $arrMoney['to_card'] );
      $arrMoney['cardto_val'] = (array)$oCardTo;
      $arrMoney['cardto_show'] = 'true';
    }

    if ( $arrMoney['category'] ) {
      $oMoneyCategory = new moneys_category( $arrMoney['category'] );
      $arrMoney['categroy_val'] = (array)$oMoneyCategory;
    }

    if ( $arrMoney['project_id'] ) {
      $oProject = new project( $arrMoney['project_id'] );
      $arrMoney['project_val'] = (array)$oProject;
    }

    return $arrMoney;
  }

  function get_money(){
    $arrMoneys = $this->get();
    if ( $arrMoneys['id'] ) $arrMoneys = $this->prep_money( $arrMoneys );
    else foreach ($arrMoneys as &$arrMoney) $arrMoney = $this->prep_money($arrMoney);
    return $arrMoneys;
  }

  public function fields() # Поля для редактирования
  {
    $arrFields = [];
    $arrFields['id'] = ['title'=>'ID','type'=>'number','disabled'=>'disabled','value'=>$this->id]; # Для отображения пользователю
    $arrFields['id'] = ['title'=>'ID','type'=>'hidden','disabled'=>'disabled','value'=>$this->id]; # Для передачи в параметры
    $arrFields['user_id'] = ['title'=>'Пользователь','type'=>'hidden','value'=>$_SESSION['user']['id']];

    $arrFields['title'] = ['title'=>'Название','type'=>'text','required'=>'required','value'=>$this->title];
    $arrFields['description'] = ['title'=>'Описание','type'=>'textarea','value'=>$this->description];
    // $arrFields['tasks_id'] = ['title'=>'Тикет','type'=>'textarea','value'=>$this->tasks_id];
    $arrFields['price'] = ['title'=>'Стоимость','type'=>'number','value'=>$this->price];
    $arrFields['date'] = ['title'=>'Дата','type'=>'date','value'=>$this->date];
    $arrFields['type'] = ['title'=>'Тип','type'=>'number','value'=>$this->type];

    $oMoneyCategory = new money_category();
    $oMoneyCategory->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $arrMoneyCategories = $oMoneyCategory->get();
    $arrMoneyCategoriesFilter = [];
    foreach ($arrMoneyCategories as $arrMoneyCategory) $arrMoneyCategoriesFilter[] = array('id'=>$arrMoneyCategory['id'],'name'=>$arrMoneyCategory['title']);
    $arrFields['category_id'] = ['title'=>'Категория','type'=>'select','options'=>$arrMoneyCategoriesFilter,'value'=>$this->category_id];

    $oProject = new project();
    $oProject->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $arrProjects = $oProject->get();
    $arrProjectsFilter = [];
    foreach ($arrProjects as $arrProject) $arrProjectsFilter[] = array('id'=>$arrProject['id'],'name'=>$arrProject['title']);
    $arrFields['project_id'] = ['title'=>'Проект','type'=>'select','options'=>$arrProjectsFilter,'value'=>$this->project_id];

    $oCard = new card();
    $oCard->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $arrCards = $oCard->get();
    $arrCardsFilter = [];
    foreach ($arrCards as $arrCard) $arrCardsFilter[] = array('id'=>$arrCard['id'],'name'=>$arrCard['title']);
    $arrFields['card'] = ['title'=>'Карту','type'=>'select','options'=>$arrCardsFilter,'value'=>$this->card];
    $arrFields['to_card'] = ['title'=>'На карту','type'=>'select','options'=>$arrCardsFilter,'value'=>$this->to_card];

    $arrFields['active'] = ['title'=>'Активность','type'=>'hidden','value'=>$this->active];

    return $arrFields;
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
      $this->category = $arrMoney['category'];
      $this->date = $arrMoney['date'];
      $this->type = $arrMoney['type'];
      $this->value = $arrMoney['value'];
      $this->user_id = $arrMoney['user_id'];
      $this->to_card = $arrMoney['to_card'];
    }
  }
}
