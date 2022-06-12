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
  public static $subscription = ''; # на подписку

  function prep_money( $arrMoney = [] ){
    $arrDate = explode(' ', $arrMoney['date']);
    $arrMoney['date'] = $arrDate[0];
    $arrMoney['price'] = substr($arrMoney['price'], 0, -2);

    if ( (int)$arrMoney['card'] ) {
      $oCard = new card( $arrMoney['card'] );
      $arrMoney['card_val'] = (array)$oCard;
      $arrMoney['card_show'] = 'true';
    }

    if ( (int)$arrMoney['to_card'] ) {
      $oCardTo = new card( $arrMoney['to_card'] );
      $arrMoney['cardto_val'] = (array)$oCardTo;
      $arrMoney['cardto_show'] = 'true';
    }

    if ( (int)$arrMoney['category'] ) {
      $arrMoney['category_show'] = 'true';
      $oMoneyCategory = new moneys_category( $arrMoney['category'] );
      $arrMoney['categroy_val'] = [];
      $arrMoneysCategory = (array)$oMoneyCategory;
      $arrMoney['categroy_val']['title'] = $arrMoneysCategory['title'];
      $arrMoney['categroy_val']['color'] = $arrMoneysCategory['color'];
    }

    if ( (int)$arrMoney['project_id'] ) {
      $arrMoney['project_show'] = 'true';
      $oProject = new project( $arrMoney['project_id'] );
      $arrMoney['project_val'] = [];
      $arrProject = (array)$oProject;
      $arrMoney['project_val']['title'] = $arrProject['title'];
      $arrMoney['project_val']['color'] = $arrProject['color'];
    }

    if ( (int)$arrMoney['task_id'] ) {
      $arrMoney['task_show'] = 'true';
      $oTask = new task( $arrMoney['task_id'] );
      $arrMoney['task'] = $oTask->get_task();
    }

    if ( (int)$arrMoney['subscription'] ) {
      $oMoneysSubscription = new moneys_subscriptions( $arrMoney['subscription'] );
      $arrMoney['subscription_val'] = [];
      $arrMoneysSubscription = (array)$oMoneysSubscription;
      $arrMoney['subscription_val']['title'] = $arrMoneysSubscription['title'];
      $arrMoney['subscription_val']['color'] = $arrMoneysSubscription['color'];
      $arrMoney['subscription_show'] = 'true';
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
    $arrFields['price'] = ['title'=>'Стоимость','type'=>'number','value'=>$this->price];
    $arrFields['date'] = ['title'=>'Дата','type'=>'date','value'=>$this->date];
    $arrFields['type'] = ['title'=>'Тип','type'=>'number','value'=>$this->type];

    // $oCard = new card();
    // $oCard->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    // $oCard->sort = 'sort';
    // $oCard->sortDir = 'ASC';
    // $arrCards = $oCard->get();
    // $arrCardsFilter = [];
    // foreach ($arrCards as $arrCard) $arrCardsFilter[] = array('id'=>$arrCard['id'],'name'=>$arrCard['title']);
    // $arrFields['card'] = ['title'=>'Карту','type'=>'select','options'=>$arrCardsFilter,'value'=>$this->card];
    // $arrFields['to_card'] = ['title'=>'На карту','type'=>'select','options'=>$arrCardsFilter,'value'=>$this->to_card];

    // $arrFields['subscription'] = ['title'=>'Подписка','type'=>'number','disabled'=>'disabled','value'=>$this->subscription];

    // $oMoneyCategory = new moneys_category();
    // $oMoneyCategory->sort = 'sort';
    // $oMoneyCategory->sortDir = 'ASC';
    // $oMoneyCategory->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    // $arrMoneysCategories = $oMoneyCategory->get_categories();
    // $arrMoneysCategoriesFilter = [];
    // foreach ($arrMoneysCategories as $arrMoneysCategory) $arrMoneysCategoriesFilter[] = array('id'=>$arrMoneysCategory['id'],'name'=>$arrMoneysCategory['title']);
    // $arrFields['category_id'] = ['title'=>'Категория','type'=>'select','options'=>$arrMoneysCategoriesFilter,'value'=>$this->category_id];

    // $oProject = new project();
    // $oProject->sort = 'sort';
    // $oProject->sortDir = 'ASC';
    // $oProject->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    // $arrProjects = $oProject->get();
    // // $arrProjectsFilter[] = array('id'=>0,'name'=>$olang->get('NoCategory'));
    // foreach ($arrProjects as $arrProject) $arrProjectsFilter[] = array('id'=>$arrProject['id'],'name'=>$arrProject['title']);
    // $arrFields['project_id'] = ['title'=>'Проект','type'=>'select','options'=>$arrProjectsFilter,'value'=>$this->project_id];

    // $oTask = new task();
    // $oTask->sort = 'sort';
    // $oTask->sortDir = 'ASC';
    // $oTask->query .= ' AND `user_id` = ' . $_SESSION['user']['id'];
    // $arrTasks = $oTask->get();
    // $arrTaskId = [];
    // foreach ($arrTasks as $arrTask) $arrTasksFilter[] = array('id'=>$arrTask['id'],'name'=>$arrTask['title']);
    // $arrFields['tasks_id'] = ['title'=>'Задача','type'=>'select','options'=>$arrTasksFilter,'value'=>$this->tasks_id];

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
      $this->subscription = $arrMoney['subscription'];
    }
  }
}
