<?
/**
 * Client
 */
class client extends model
{
  public static $table = ''; # Таблица в bd
  public static $id = '';
  public static $title = '';
  public static $description = '';
  public static $sort = '';
  public static $active = '';
  public static $user_id = '';

  function get_project( $arrClient = [] ) {
    if ( ! $arrClient['id'] ) $arrClient = $this->get();

    return $arrClient;
  }

  function get_clients(){
    $arrClients = $this->get();
    if ( $arrClients['id'] ) $arrClients = $this->get_project( $arrClients );
    else foreach ($arrClients as &$arrClient) $arrClient = $this->get_project($arrClient);
    return $arrClients;
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

    $arrFields['sort'] = ['title'=>$oLang->get('Sort'),'type'=>'number','value'=>$this->sort];

    // $arrFields['active'] = ['title'=>$oLang->get('Active'),'type'=>'hidden','value'=>$this->active];

    return $arrFields;
  }

  function __construct( $client_id = 0 )
  {
    $this->table = 'clients';

    if ( $client_id ) {
      $mySql = "SELECT * FROM `" . $this->table . "`";
      $mySql .= " WHERE `id` = '" . $client_id . "'";
      $arrClient = db::query($mySql);

      $this->id = $arrClient['id'];
      $this->title = $arrClient['title'];
      $this->description = base64_decode($arrClient['description']);
      $this->sort = $arrClient['sort'];
      $this->active = $arrClient['active'];
      $this->user_id = $arrClient['user_id'];
    }
  }
}
