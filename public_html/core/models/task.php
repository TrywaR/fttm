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
  public static $user_Id = '';
  public static $date_create = '';

  function get_task( $arrTask = [] ) {
    switch ( (int)$arrTask['status'] ) {
      case 1:
        $arrTask['status_val'] = 'Planned';
        $arrTask['status_show'] = 'true';
        break;
      case 2:
        $arrTask['status_val'] = 'In work';
        $arrTask['status_show'] = 'true';
        break;
      case 3:
        $arrTask['status_val'] = 'Complited';
        $arrTask['status_show'] = 'true';
        break;
    }
    return $arrTask;
  }

  function get_tasks() {
    $arrTasks = $this->get();
    if ( $arrTasks['id'] ) $arrTasks = $this->get_task( $arrTasks );
    else foreach ($arrTasks as &$arrTask) $arrTask = $this->get_task( $arrTask );
    return $arrTasks;
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
      $this->user_Id = $arrProject['user_Id'];
      $this->date_create = $arrProject['date_create'];
    }
    else {
      $this->date_create = date("Y-m-d H:i:s");
    }
  }
}
