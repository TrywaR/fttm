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
  public static $user_id = '';

  function get_project( $arrProject = [] ) {
    if ( ! $arrProject['id'] ) $arrProject = $this->get();

    return $arrProject;
  }

  function get_projects(){
    $arrProjects = $this->get();
    if ( $arrProjects['id'] ) $arrProjects = $this->get_project( $arrProjects );
    else foreach ($arrProjects as &$arrProject) $arrProject = $this->get_project($arrProject);
    return $arrProjects;
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

    $oClient = new client();
    $oClient->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
    $arrClients = $oClient->get();
    $arrClientsFilter = [];
    foreach ($arrClients as $arrClient) $arrClientsFilter[] = array('id'=>$arrClient['id'],'name'=>$arrClient['title']);
    $arrFields['client_id'] = ['title'=>$oLang->get('Client'),'type'=>'select','options'=>$arrClientsFilter,'value'=>$this->client_id];

    $arrFields['sort'] = ['title'=>$oLang->get('Sort'),'type'=>'number','value'=>$this->sort];

    // $arrFields['active'] = ['title'=>$oLang->get('Active'),'type'=>'hidden','value'=>$this->active];

    return $arrFields;
  }

  function __construct( $project_id = 0 )
  {
    $this->table = 'projects';

    if ( $project_id ) {
      $mySql = "SELECT * FROM `" . $this->table . "`";
      $mySql .= " WHERE `id` = '" . $project_id . "'";
      $arrProject = db::query($mySql);

      $this->id = $arrProject['id'];
      $this->title = $arrProject['title'];
      $this->description = base64_decode($arrProject['description']);
      $this->sort = $arrProject['sort'];
      $this->active = $arrProject['active'];
      $this->client_id = $arrProject['client_id'];
      $this->user_id = $arrProject['user_id'];
    }
  }
}
