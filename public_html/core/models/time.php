<?
/**
 * Time
 */
class time extends model
{
  public static $table = ''; # Таблица в bd
  public static $id = '';
  public static $title = '';
  public static $description = '';
  public static $sort = '';
  public static $active = '';
  public static $project_id = '';
  public static $task_id = '';
  public static $user_id = '';
  public static $time_planned = '';
  public static $time_really = '';
  public static $date = '';
  public $date_update = '';
  public static $category_id = '';
  public static $status = '';
  public static $category = '';

  function get_sum( $arrTimes = [] ){
    $i = 0;
    foreach ($arrTimes as $time) {
        sscanf($time, '%d:%d', $hour, $min);
        $i += $hour * 60 + $min;
    }
    if ($h = floor($i / 60)) {
        $i %= 60;
    }
    return sprintf('%02d:%02d', $h, $i);

    // $sum = strtotime('00:00:00');
    // $totaltime = 0;
    //
    // foreach( $arrTimes as $element ) {
    //     // Converting the time into seconds
    //     $timeinsec = strtotime($element) - $sum;
    //
    //     // Sum the time with previous value
    //     $totaltime = $totaltime + $timeinsec;
    // }
    //
    // // Totaltime is the summation of all
    // // time in seconds
    //
    // // Hours is obtained by dividing
    // // totaltime with 3600
    // $h = intval($totaltime / 3600);
    //
    // $totaltime = $totaltime - ($h * 3600);
    //
    // // Minutes is obtained by dividing
    // // remaining total time with 60
    // $m = intval($totaltime / 60);
    //
    // // Remaining value is seconds
    // $s = $totaltime - ($m * 60);
    //
    // // Обработка данных
    // $h = sprintf("%02d", $h);
    // $m = sprintf("%02d", $m);
    // $s = sprintf("%02d", $s);
    //
    // // Printing the result
    // return $h.':'.$m.':'.$s;
    // echo $sMask;
    // return date($sMask, strtotime($h.':'.$m.':'.$s));
  }

  function get_time( $arrTime = [] ){
    if ( ! $arrTime['id'] ) $arrTime = $this->get();

    if ( (int)$arrTime['category_id'] ) {
      $oCategory = new times_category( $arrTime['category_id'] );
      $arrTime['category'] = $oCategory->get_category();
      $arrTime['category_show'] = 'true';
    }

    if ( (int)$arrTime['project_id'] ) {
      $oProject = new project( $arrTime['project_id'] );
      $arrTime['project'] = (array)$oProject;
      $arrTime['project_show'] = 'true';
    }

    // time
    $dDateReally = new DateTime($arrTime['time_really']);
    $arrTime['time_really'] = $dDateReally->format('H:i');

    // task
    if ( (int)$arrTime['task_id'] > 0 ) {
      $arrTime['task_show'] = 'true';
      $oTask = new task( $arrTime['task_id'] );
      $arrTime['task'] = $oTask->get_task();
    }

    return $arrTime;
  }

  function get_times(){
    $arrTimes = $this->get();
    if ( $arrTimes['id'] ) $arrTimes = $this->get_time( $arrTimes );
    else foreach ($arrTimes as &$arrTime) $arrTime = $this->get_time( $arrTime );
    return $arrTimes;
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

    // $arrFields['sort'] = ['title'=>'Сортировка','type'=>'number','value'=>$this->sort];
    // $arrFields['type'] = ['class'=>'switch','title'=>'Тип чата','type'=>'select','options'=>$arrTypes,'value'=>$this->type];

    $oTimeCategory = new times_category();
    $oTimeCategory->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
    $arrTimeCategories = $oTimeCategory->get_categories();
    $arrTimeCategoriesFilter = [];
    $arrTimeCategoriesFilter[] = array('id'=>0,'name'=>'...');
    foreach ($arrTimeCategories as $arrTimeCategory) $arrTimeCategoriesFilter[] = array('id'=>$arrTimeCategory['id'],'name'=>$arrTimeCategory['title']);
    $arrFields['category_id'] = ['title'=>$oLang->get('Category'),'type'=>'select','options'=>$arrTimeCategoriesFilter,'value'=>$this->category_id];

    $oProject = new project();
    $oProject->query = ' AND `user_id` = ' . $_SESSION['user']['id'];

    $arrProjects = $oProject->get();
    $arrProjectsFilter = [];
    $arrProjectsFilter[] = array('id'=>0,'name'=>'...');
    foreach ($arrProjects as $arrProject) $arrProjectsFilter[] = array('id'=>$arrProject['id'],'name'=>$arrProject['title']);
    $arrFields['project_id'] = ['title'=>$oLang->get('Project'),'type'=>'select','options'=>$arrProjectsFilter,'value'=>$this->project_id];

    $oTask = new task();
    $oTask->sort = 'sort';
    $oTask->sortDir = 'ASC';
    $oTask->query .= ' AND `user_id` = ' . $_SESSION['user']['id'];
    $oTask->query .= ' AND `status` = 2';
    $arrTasks = $oTask->get_tasks();

    $arrTasksFilter = [];
    $arrTasksFilter[] = array('id'=>0,'name'=>'...');
    $arrTaskCurrent = [];
    if ( (int)$this->task_id ) {
      $oTaskCurrent = new task( $this->task_id );
      $arrTaskCurrent = $oTaskCurrent->get_tasks();
      $arrTasksFilter[] = array('id'=>$arrTaskCurrent['id'],'name'=>$arrTaskCurrent['title']);
    }
    foreach ( $arrTasks as $arrTask ) {
      if ( $arrTaskCurrent['id'] && $arrTaskCurrent['id'] == $arrTask['id'] ) continue;
      $arrTasksFilter[] = array('id'=>$arrTask['id'],'name'=>$arrTask['title']);
    }
    $arrFields['task_id'] = ['title'=>$oLang->get('Task'),'type'=>'select','options'=>$arrTasksFilter,'value'=>$this->task_id];

    $arrFields['date'] = ['title'=>$oLang->get('Date'),'type'=>'date','section'=>2,'value'=>$this->date];
    $arrFields['date_update'] = ['title'=>$oLang->get('LastUpdate'),'type'=>'date_time','disabled'=>'disabled','value'=>$this->date_update];

    $arrFields['time_planned'] = ['title'=>$oLang->get('TimesPlanned'),'type'=>'hidden','section'=>2,'value'=>$this->time_planned];
    $arrFields['time_really'] = ['title'=>$oLang->get('TimesReally'),'type'=>'timer','section'=>2,'value'=>$this->time_really];
    // $arrFields['status'] = ['title'=>'Статус','type'=>'time','value'=>$this->status];

    // $arrFields['active'] = ['title'=>'Активность','type'=>'hidden','value'=>$this->active];

    return $arrFields;
  }

  function __construct( $time_id = 0 )
  {
    $this->table = 'times';

    if ( $time_id ) {
      $mySql = "SELECT * FROM `" . $this->table . "`";
      $mySql .= " WHERE `id` = '" . $time_id . "'";
      $arrTime = db::query($mySql);

      $this->id = $arrTime['id'];
      $this->title = $arrTime['title'];
      $this->description = base64_decode($arrTime['description']);
      $this->sort = $arrTime['sort'];
      $this->active = $arrTime['active'];
      $this->project_id = $arrTime['project_id'];
      $this->task_id = $arrTime['task_id'];
      $this->user_id = $arrTime['user_id'];
      $this->time_planned = $arrTime['time_planned'];
      $this->time_really = $arrTime['time_really'];
      $this->date = $arrTime['date'];
      $this->date_update = $arrTime['date_update'];
      $this->category_id = $arrTime['category_id'];
      $this->status = $arrTime['status'];
    }
    else {
      $this->date_update = date("Y-m-d H:i:s");
    }
  }
}
