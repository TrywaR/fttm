<?
/**
 * Lock
 */
class lock
{
  public static $iUserRole = 0; # Уровень доступа пользователя
  public static $arrAccess = []; # Массив со что куда

  // Проверка доступа
  function check( $sAccess = '' ){
    if ( empty($this->arrAccess[$sAccess]) ) return true;
    if ( (int)$this->arrAccess[$sAccess] > (int)$this->iUserRole ) return false;
    else return true;
  }

  // Возврат html если надо
  function get( $sAccess = '' ) {
    if ( ! $this->check($sAccess) )
    return include 'core/templates/elems/lock.php';
  }

  // Возврат html если надо
  function get_attr( $sAccess = '', $sAttr = '' ) {
    if ( $this->check($sAccess) )
    return $sAttr;
  }

  // Возврат html если надо
  function get_class( $sAccess = '' ) {
    if ( ! $this->check($sAccess) )
    return 'disabled';
  }

  // Массив доступов
  function arrAccessInit(){
    $this->arrAccess = [
      'CategoryAnalyticYear' => 1,
    ];
  }

  function __construct(){
    $this->iUserRole = 0;
    if ( $_SESSION['user'] && (int)$_SESSION['user']['role'] ) $this->iUserRole = $_SESSION['user']['role'];
    $this->arrAccessInit();
  }
}
