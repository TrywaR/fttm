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
  public static $password = '';
  public static $date_registration = '';

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
      $this->password = $arrUser['password'];
      $this->date_registration = $arrUser['date_registration'];
    }
  }
}
