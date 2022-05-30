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
  public static $category_id = '';
  public static $status = '';
  public static $category = '';

  function get_sum( $arrTimes = [], $sMask = 'H:i:s' ){
    $sum = strtotime('00:00:00');
    $totaltime = 0;

    foreach( $arrTimes as $element ) {
        // Converting the time into seconds
        $timeinsec = strtotime($element) - $sum;

        // Sum the time with previous value
        $totaltime = $totaltime + $timeinsec;
    }

    // Totaltime is the summation of all
    // time in seconds

    // Hours is obtained by dividing
    // totaltime with 3600
    $h = intval($totaltime / 3600);

    $totaltime = $totaltime - ($h * 3600);

    // Minutes is obtained by dividing
    // remaining total time with 60
    $m = intval($totaltime / 60);

    // Remaining value is seconds
    $s = $totaltime - ($m * 60);

    // Printing the result
    return date($sMask, strtotime($h.':'.$m.':'.$s));
  }

  function get_time(){
    $arrTime = [];

    $arrTime = $this->get();

    if ( (int)$arrTime['category_id'] ) {
      $oCategory = new times_category( $arrTime['category_id'] );
      $arrTime['category'] = (array)$oCategory;
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
    $arrResults = [];
    $arrTimes = $this->get();

    foreach ($arrTimes as $arrTime) {
      $oTime = new time( $arrTime['id'] );
      $arrResults[] = $oTime->get_time();
    }

    return $arrResults;
  }

  public function fields() # Поля для редактирования
  {
    $arrFields = [];
    $arrFields['id'] = ['title'=>'ID','type'=>'number','disabled'=>'disabled','value'=>$this->id]; # Для отображения пользователю
    $arrFields['id'] = ['title'=>'ID','type'=>'hidden','disabled'=>'disabled','value'=>$this->id]; # Для передачи в параметры
    $arrFields['user_id'] = ['title'=>'Пользователь','type'=>'hidden','value'=>$_SESSION['user']['id']];

    $arrFields['title'] = ['title'=>'Название','type'=>'text','required'=>'required','value'=>$this->title];
    $arrFields['description'] = ['title'=>'Описание','type'=>'textarea','value'=>$this->description];

    // $arrFields['sort'] = ['title'=>'Сортировка','type'=>'number','value'=>$this->sort];
    // $arrFields['type'] = ['class'=>'switch','title'=>'Тип чата','type'=>'select','options'=>$arrTypes,'value'=>$this->type];

    $oTimeCategory = new times_category();
    $oTimeCategory->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $arrTimeCategories = $oTimeCategory->get();
    $arrTimeCategoriesFilter = [];
    foreach ($arrTimeCategories as $arrTimeCategory) $arrTimeCategoriesFilter[] = array('id'=>$arrTimeCategory['id'],'name'=>$arrTimeCategory['title']);
    $arrFields['category_id'] = ['title'=>'Категория','type'=>'select','options'=>$arrTimeCategoriesFilter,'value'=>$this->category_id];

    $oProject = new project();
    $oProject->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $arrProjects = $oProject->get();
    $arrProjectsFilter = [];
    foreach ($arrProjects as $arrProject) $arrProjectsFilter[] = array('id'=>$arrProject['id'],'name'=>$arrProject['title']);
    $arrFields['project_id'] = ['title'=>'Проект','type'=>'select','options'=>$arrProjectsFilter,'value'=>$this->project_id];

    // $arrFields['task_id'] = ['title'=>'Задача','type'=>'number','value'=>$this->task_id];

    $arrFields['time_planned'] = ['title'=>'Планируемое время','type'=>'hidden','section'=>2,'value'=>$this->time_planned];
    $arrFields['time_really'] = ['title'=>'Реальное время','type'=>'timer','section'=>2,'value'=>$this->time_really];
    $arrFields['date'] = ['title'=>'Дата','type'=>'date','section'=>2,'value'=>$this->date];
    // $arrFields['status'] = ['title'=>'Статус','type'=>'time','value'=>$this->status];

    $arrFields['active'] = ['title'=>'Активность','type'=>'hidden','value'=>$this->active];

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
      $this->description = $arrTime['description'];
      $this->sort = $arrTime['sort'];
      $this->active = $arrTime['active'];
      $this->project_id = $arrTime['project_id'];
      $this->task_id = $arrTime['task_id'];
      $this->user_id = $arrTime['user_id'];
      $this->time_planned = $arrTime['time_planned'];
      $this->time_really = $arrTime['time_really'];
      $this->date = $arrTime['date'];
      $this->category_id = $arrTime['category_id'];
      $this->status = $arrTime['status'];
    }
  }
}
