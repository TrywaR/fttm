<?
/**
 * Session
 */
class session extends model
{
  public static $table = 'sessions'; # Таблица в bd
  public static $id = '';
  public static $user_id = '';
  public static $data = '';
  public static $sSession = '';
  public static $date = '';
  public static $ip = '';
  public static $push = '';

  // Обновление сессии
  function update() {
    // Обновляем дату
    $this->date = date("Y-m-d H:i:s");
    // Если ip поменялся, новая запись
    if ( $this->ip != $_SERVER['REMOTE_ADDR'] ) {
      $this->id = 0;
      $this->ip = $_SERVER['REMOTE_ADDR'];
      $this->add();
    }
    // Если старый, обновляем дату
    else $this->save();
  }

  // Удаление всех сессий по хэшу
  function del_session( $sSession = '' ) {
    // Берём сессию
    if ( ! $sSession ) $sSession = $this->session;
    if ( $sSession ) {
      // Вытаскиваем все сессии по хэшу
      $mySqlDel = "DELETE FROM `" . $this->table . "`";
      $mySqlDel .= " WHERE `session` = '" . $sSession . "'";
      // Удаляем
      if ( db::query($mySqlDel) ) notification::error( 'Ошибка удаления!' );
    }
  }

  // Get session
  function get_session( $sSession = '' ) {
    if ( $sSession ) {
      $mySQL = "SELECT * FROM " . $this->table . " WHERE `session` = '" . $sSession . "'";
      $arrSession = db::query($mySQL);
      return $arrSession;
    }
    if ( $this->session ) {
      $mySQL = "SELECT * FROM " . $this->table . " WHERE `session` = '" . $this->session . "'";
      $arrSession = db::query($mySQL);
      return $arrSession;
    }
    return $this->get();
  }

  function __construct( $iSessionId = 0, $sSessionSession = '' )
  {
    $bNewSession = true;
    $this->table = 'sessions';
    $this->name = 'sessions';
    // Если передан id сессии
    if ( $iSessionId ) {
      $mySql = "SELECT * FROM `" . $this->table . "`";
      $mySql .= " WHERE `id` = '" . $iSessionId . "'";
      $arrSession = db::query($mySql);
    }

    // Если передан хэш сессии
    if ( ! $iSessionId && $sSessionSession ) {
      $mySql = "SELECT * FROM `" . $this->table . "`";
      $mySql .= " WHERE `session` = '" . $sSessionSession . "'";
      $arrSession = db::query($mySql);
    }

    // Если вытащили сессию, подставляем значения
    if ( is_array($arrSession) && $arrSession['session'] ) {
      $this->id = $arrSession['id'];
      $this->user_id = $arrSession['user_id'];
      $this->data = base64_decode($arrSession['data']);
      $this->date = $arrSession['date'];
      $this->ip = $arrSession['ip'];
      $this->push = $arrSession['push'];
      $this->session = $arrSession['session'];
      $bNewSession = false;
    }

    // Если нет, создаём сессию основываясь на данных пользователя
    if ( $bNewSession ) {
      // Параметры
      $iUserId = $_SESSION['user'] ? $_SESSION['user']['id'] : 0;
      // Записываем параметры
      $this->name = 'session';
      $this->user_id = $iUserId;
      $this->date = date("Y-m-d H:i:s");
      $this->data = $_SERVER['HTTP_USER_AGENT'];
      $this->ip = $_SERVER['REMOTE_ADDR'];
      $this->push = $_REQUEST['push'] ? $_REQUEST['push'] : '';
      $this->session = hash( 'ripemd128', date(BydmGis) . rand(100, 999) );// Генерируем хэш
    }
  }
}
