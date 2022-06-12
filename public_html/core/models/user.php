<?
/**
 * User
 */
class user extends model
{
  public static $table = ''; # Таблица в bd
  public static $id = '';

  public static $login = '';
  public static $email = '';
  public static $phone = '';
  public static $password = '';
  public static $date_registration = '';
  public static $theme = '';
  public static $lang = '';
  public static $role = '';
  public static $referal = '';

  public function get_user() {
    $arrUser = db::query("SELECT * FROM `users` WHERE `id` = '". $this->id . "'");
    return $arrUser;
  }


  public function fields() # Поля для редактирования
  {
    $oLang = new lang();

    $arrFields = [];
    $arrFields['id'] = ['title'=>'ID','type'=>'number','disabled'=>'disabled','value'=>$this->id]; # Для отображения пользователю
    $arrFields['id'] = ['title'=>'ID','type'=>'hidden','disabled'=>'disabled','value'=>$this->id]; # Для передачи в параметры

    $arrLangFilter = [
      array('id'=>'en','name'=>'English'),
      array('id'=>'ru','name'=>'Russian'),
    ];
    $arrFields['lang'] = ['title'=>$oLang->get('Lang'),'type'=>'select','options'=>$arrLangFilter,'value'=>$this->lang];

    $arrThemeFilter = [
      array('id'=>0,'name'=>'Auto'),
      array('id'=>1,'name'=>'Dark'),
      array('id'=>2,'name'=>'Light'),
    ];
    $arrFields['theme'] = ['title'=>$oLang->get('Theme'),'type'=>'select','options'=>$arrThemeFilter,'value'=>$this->theme];

    $arrFields['login'] = ['title'=>$oLang->get('Login'),'type'=>'text','value'=>$this->login];
    $arrFields['phone'] = ['title'=>$oLang->get('Phone'),'type'=>'text','value'=>$this->phone];
    $arrFields['email'] = ['title'=>$oLang->get('Email'),'type'=>'text','value'=>$this->email];
    $arrFields['date_registration'] = ['title'=>$oLang->get('DateRegistration'),'type'=>'datetime','disabled'=>'disabled','value'=>$this->date_registration];

    // $arrFields['price'] = ['title'=>$oLang->get('Price'),'type'=>'number','value'=>substr($this->price, 0, -2)];
    // $arrFields['date'] = ['title'=>$oLang->get('Date'),'type'=>'date','value'=>$this->date];

    return $arrFields;
  }

  function __construct( $user_id = 0 )
  {
    $this->table = 'users';

    if ( $user_id ) {
      $mySql = "SELECT * FROM `" . $this->table . "`";
      $mySql .= " WHERE `id` = '" . $user_id . "'";
      $arrUser = db::query($mySql);

      $this->id = $arrUser['id'];
      $this->login = $arrUser['login'];
      $this->email = $arrUser['email'];
      $this->phone = $arrUser['phone'];
      $this->password = $arrUser['password'];
      $this->date_registration = $arrUser['date_registration'];
      $this->theme = $arrUser['theme'];
      $this->lang = $arrUser['lang'];
      $this->role = $arrUser['role'];
      $this->referal = $arrUser['referal'];
    }
    else {
      $this->lang = 'en';
    }
  }
}
