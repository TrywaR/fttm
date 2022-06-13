<?
/**
 * Task
 */
class task extends model
{
  public static $table = ''; # Таблица в bd
  public static $id = '';
  public static $title = '';
  public static $description = '';
  public static $sort = '';
  public static $active = '';
  public static $project_id = '';
  public static $user_id = '';
  public static $price_planned = '';
  public static $time_planned = '';
  public static $status = '';
  public static $arrStatus = [];
  public static $date_create = '';
  public static $date_update = '';


  function get_task() {
    $arrTask = [];
    $arrTask = $this->get();

    // Status
    if ( (int)$arrTask['status'] ) {
      $arrTask['status_show'] = 'true';
      foreach ($this->arrStatus as $arrStatus)
        if ( $arrStatus['id'] === (int)$arrTask['status'] )
          $arrTask['status_val'] = $arrStatus['name'];
    }

    // Project
    if ( (int)$arrTask['project_id'] ) {
      $oProject = new project( $arrTask['project_id'] );
      $arrTask['project'] = (array)$oProject;
      $arrTask['project_show'] = 'true';
    }

    // time
    if ( $arrTask['time_planned'] != '00:00:00' ) {
      $arrTask['time_planned'] = date('H:i',$arrTask['time_planned']);
      $arrTask['time_show'] = 'true';

      $oTime = new time();
      $oTime->query .= ' AND `task_id` = ' . $arrTask['id'];
      $arrTimes = $oTime->get();

      $arrTimesResult = [];
      if ( count($arrTimes) ) foreach ($arrTimes as $arrTime) $arrTimesResult[] = $arrTime['time_really'];
      $arrTask['time_really'] = $oTime->get_sum( $arrTimesResult, 'H:i' );
    }

    // money
    if ( (int)$arrTask['price_planned'] ) {
      $arrTask['price_planned'] = substr($arrTask['price_planned'], 0, -5);
      $arrTask['money_show'] = 'true';
      $oMoney = new money();
      $oMoney->query = ' AND `task_id` = ' . $arrTask['id'];
      $arrMoneys = $oMoney->get();
      $iMoneySum = 0;
      if ( count($arrMoneys) ) {
        foreach ($arrMoneys as $arrMoney) {
          switch ( (int)$arrMoney['type'] ) {
            case 0: # Траты
            $iMoneySum = $iMoneySum - $arrMoney['price'];
            break;

            case 1: # Приход
            $iMoneySum = $iMoneySum + $arrMoney['price'];
            break;
          }
        }
      }
      $arrTask['price_really'] = $iMoneySum;
    }

    // Description
    $arrTask['description_prev'] = '';
    if ( $arrTask['description'] != '' ) {
      // Wiki mark
      // require_once("lib/Wiky.php-master/wiky.inc.php");
      // $oWiky = new wiky;
      // $arrTask['description_prev'] = $oWiky->parse( htmlspecialchars( $arrTask['description'] ) );

      require_once("lib/parsedown-master/Parsedown.php");
      $oParsedown = new Parsedown();
      $arrTask['description_prev'] = $oParsedown->text( $arrTask['description'] );
    }

    return $arrTask;
  }

  function get_tasks() {
    $arrResults = [];
    $arrTasks = $this->get();

    foreach ($arrTasks as $arrTask) {
      $oTask = new task( $arrTask['id'] );
      $arrResults[] = $oTask->get_task();
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

    $arrFields['title'] = ['title'=>$oLang->get('Title'),'type'=>'text','required'=>'required','value'=>$this->title];
    $arrFields['description'] = ['title'=>$oLang->get('Description'),'type'=>'textarea','value'=>$this->description];

    $oProject = new project();
    $oProject->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $arrProjects = $oProject->get();
    $arrProjectsFilter = [];
    foreach ($arrProjects as $arrProject) $arrProjectsFilter[] = array('id'=>$arrProject['id'],'name'=>$arrProject['title']);
    $arrFields['project_id'] = ['title'=>$oLang->get('Project'),'type'=>'select','options'=>$arrProjectsFilter,'value'=>$this->project_id];

    $arrFields['sort'] = ['title'=>$oLang->get('Sort'),'type'=>'number','value'=>$this->sort];
    $arrFields['time_planned'] = ['title'=>$oLang->get('TimesPlanned'),'type'=>'time','section'=>2,'value'=>$this->time_planned];
    $arrFields['price_planned'] = ['title'=>$oLang->get('PricePlanned'),'type'=>'number','section'=>2,'value'=>substr($this->price_planned, 0, -2),'step'=>'0.01'];

    $arrFields['status'] = ['title'=>$oLang->get('Status'),'type'=>'time','type'=>'select','options'=>$this->arrStatus,'value'=>$this->status];

    // $arrFields['active'] = ['title'=>$oLang->get('Active'),'type'=>'hidden','value'=>$this->active];

    return $arrFields;
  }

  function __construct( $task_id = 0 )
  {
    $this->table = 'tasks';

    if ( $task_id ) {
      $mySql = "SELECT * FROM `" . $this->table . "`";
      $mySql .= " WHERE `id` = '" . $task_id . "'";
      $arrProject = db::query($mySql);

      $this->id = $arrProject['id'];
      $this->title = $arrProject['title'];
      $this->description = $arrProject['description'];
      $this->sort = $arrProject['sort'];
      $this->active = $arrProject['active'];
      $this->project_id = $arrProject['project_id'];
      $this->user_id = $arrProject['user_id'];
      $this->price_planned = $arrProject['price_planned'];
      $this->time_planned = $arrProject['time_planned'];
      $this->status = $arrProject['status'];
      $this->date_create = $arrProject['date_create'];
      $this->date_update = $arrProject['date_update'];
    }
    else {
      $this->date_create = date("Y-m-d H:i:s");
    }

    $this->arrStatus = [
      array('id'=>0,'name'=>'No status'),
      array('id'=>1,'name'=>'Planned'),
      array('id'=>2,'name'=>'In work'),
      array('id'=>3,'name'=>'Complited')
    ];
  }
}
