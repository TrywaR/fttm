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
  public static $price_planned = '';
  public static $price_really = '';
  public static $time_planned = '';
  public static $time_really = '';
  public static $status = '';
  public static $user_Id = '';

  function __construct( $task_id = 0 )
  {
    $this->table = 'tasks';

    if ( $task_id ) {
      $mySql = "SELECT * FROM `" . $this->table . "`";
      $mySql .= " WHERE `id` = '" . $task_id . "'";
      $arrTask = db::query($mySql);

      $this->id = $arrTask['id'];
      $this->title = $arrTask['title'];
      $this->description = $arrTask['description'];
      $this->sort = $arrTask['sort'];
      $this->active = $arrTask['active'];
      $this->project_id = $arrTask['project_id'];
      $this->price_planned = $arrTask['price_planned'];
      $this->price_really = $arrTask['price_really'];
      $this->time_planned = $arrTask['time_planned'];
      $this->time_really = $arrTask['time_really'];
      $this->status = $arrTask['status'];
      $this->user_Id = $arrTask['user_Id'];
    }
  }
}
