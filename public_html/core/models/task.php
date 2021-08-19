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
    }
  }
}
