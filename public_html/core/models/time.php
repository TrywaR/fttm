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

  function get_time(){
    $arrTimes = [];
    if ( $this->id ) {
      $arrTimes = $this->get();
      $oCategory = new times_category( $this->category_id );
      $arrTimes['category_title'] = $oCategory->title;
      $arrTimes['category_color'] = $oCategory->color;
      $oProject = new project( $arrTimes['project_id'] );
      $arrTimes['project_title'] = $oProject->title;
      $arrTimes['project_color'] = $oProject->color;

      $dDateReally = new DateTime($arrTimes['time_really']);
      $arrTimes['time_really'] = $dDateReally->format('H:i');
    }
    else {
      $arrTimes = $this->get();
      foreach ($arrTimes as &$arrTime) {
        $oCategory = new times_category( $arrTime['category_id'] );
        $arrTime['category_title'] = $oCategory->title;
        $arrTime['category_color'] = $oCategory->color;
        $oProject = new project( $arrTime['project_id'] );
        $arrTime['project_title'] = $oProject->title;
        $arrTime['project_color'] = $oProject->color;

        $dDateReally = new DateTime($arrTime['time_really']);
        $arrTime['time_really'] = $dDateReally->format('H:i');
      }
    }

    return $arrTimes;
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
