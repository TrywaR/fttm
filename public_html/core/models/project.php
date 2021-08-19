<?
/**
 * Project
 */
class project extends model
{
  public static $table = ''; # Таблица в bd
  public static $id = '';
  public static $title = '';
  public static $description = '';
  public static $sort = '';
  public static $active = '';
  public static $client_id = '';
  public static $user_Id = '';

  function __construct( $project_id = 0 )
  {
    $this->table = 'projects';

    if ( $project_id ) {
      $mySql = "SELECT * FROM `" . $this->table . "`";
      $mySql .= " WHERE `id` = '" . $project_id . "'";
      $arrProject = db::query($mySql);

      $this->id = $arrProject['id'];
      $this->title = $arrProject['title'];
      $this->description = $arrProject['description'];
      $this->sort = $arrProject['sort'];
      $this->active = $arrProject['active'];
      $this->client_id = $arrProject['client_id'];
      $this->user_Id = $arrProject['user_Id'];
    }
  }
}
