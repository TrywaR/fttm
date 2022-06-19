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


  function get_task( $arrTask = [] ) {
    if ( ! $arrTask['id'] ) $arrTask = $this->get();

    // Status
    if ( (int)$arrTask['status'] ) {
      $arrTask['status_show'] = 'true';
      foreach ($this->arrStatus as $arrStatus)
        if ( $arrStatus['id'] === (int)$arrTask['status'] ) {
          $arrTask['status_val'] = $arrStatus['name'];
          $arrTask['status_color'] = $arrStatus['color'];
        }
    }

    // Project
    if ( (int)$arrTask['project_id'] ) {
      $oProject = new project( $arrTask['project_id'] );
      $arrTask['project'] = (array)$oProject;
      $arrTask['project_show'] = 'true';
    }

    // time
    if ( $arrTask['time_planned'] != '00:00:00' ) {
      $arrTask['time_planned'] = date('H:i', strtotime($arrTask['time_planned']));
      $arrTask['time_really'] = '00:00';
      $arrTask['time_show'] = 'true';

      $oTime = new time();
      $oTime->query .= ' AND `task_id` = ' . $arrTask['id'];
      $arrTimes = $oTime->get();

      if ( count($arrTimes) ) {
        $arrTimesResult = [];
        foreach ($arrTimes as $arrTime) $arrTimesResult[] = $arrTime['time_really'];
        $arrTask['time_really'] = $oTime->get_sum( $arrTimesResult );
      }
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
            case 1: # Траты
            $iMoneySum = $iMoneySum - $arrMoney['price'];
            break;

            case 2: # Приход
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
      $arrTask['description_show'] = 'true';
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
    $arrTasks = $this->get();
    if ( $arrTasks['id'] ) $arrTasks = $this->get_task( $arrTasks );
    else foreach ($arrTasks as &$arrTask) $arrTask = $this->get_task( $arrTask );
    return $arrTasks;
  }


  public function fields() # Поля для редактирования
  {
    $oLang = new lang();

    $arrFields = [];
    $arrFields['id_show'] = ['title'=>'ID','type'=>'number','disabled'=>'disabled','value'=>$this->id]; # Для отображения пользователю
    $arrFields['id'] = ['title'=>'ID','type'=>'hidden','disabled'=>'disabled','value'=>$this->id]; # Для передачи в параметры
    $arrFields['user_id'] = ['title'=>$oLang->get('User'),'type'=>'hidden','value'=>$_SESSION['user']['id']];

    $arrFields['title'] = ['title'=>$oLang->get('Title'),'type'=>'text','required'=>'required','value'=>$this->title];
    $arrFields['description'] = ['title'=>$oLang->get('Description'),'type'=>'textarea','value'=>$this->description];

    $oProject = new project();
    $oProject->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $arrProjects = $oProject->get();
    $arrProjectsFilter = [];
    $arrProjectsFilter[] = array('id'=>0,'name'=>'...');
    foreach ($arrProjects as $arrProject) $arrProjectsFilter[] = array('id'=>$arrProject['id'],'name'=>$arrProject['title']);
    $arrFields['project_id'] = ['title'=>$oLang->get('Project'),'type'=>'select','options'=>$arrProjectsFilter,'value'=>$this->project_id];

    $arrFields['sort'] = ['title'=>$oLang->get('Sort'),'type'=>'number','value'=>$this->sort];
    $arrFields['time_planned'] = ['title'=>$oLang->get('TimesPlanned'),'type'=>'time','section'=>2,'value'=>$this->time_planned];
    $arrFields['price_planned'] = ['title'=>$oLang->get('PricePlanned'),'type'=>'number','section'=>2,'value'=>substr($this->price_planned, 0, -2),'step'=>'0.01'];

    $arrFields['date_create'] = ['title'=>$oLang->get('DateCreate'),'type'=>'date_time','disabled'=>'disabled','value'=>$this->date_create];
    $arrFields['date_update'] = ['title'=>$oLang->get('LastUpdate'),'type'=>'date_time','disabled'=>'disabled','value'=>$this->date_update];

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
      $this->description = base64_decode($arrProject['description']);
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

    $oLang = new lang();
    $this->arrStatus = [
      array('id'=>0,'color'=>'','name'=>$oLang->get('NoStatus')),
      array('id'=>1,'color'=>'#3a487d','name'=>$oLang->get('Planned')),
      array('id'=>2,'color'=>'#ce5f5f','name'=>$oLang->get('InWork')),
      array('id'=>3,'color'=>'#3a7d61','name'=>$oLang->get('Complited'))
    ];
  }
}
