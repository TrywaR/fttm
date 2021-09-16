<?
/**
 * db
 */
class db extends config
{
  // Простой запрос к базе
  static function query($sQuery){
    if ( $sQuery ) {
      // - Подключаемся
      $PDO = new PDO('mysql:host='.config::$host.';dbname='.config::$db, config::$user, config::$password);

      // - Выполняем запрос
      $arrResult = $PDO->query($sQuery)->fetch(PDO::FETCH_ASSOC);

      // - Отключаемся
      $PDO = null;

      // - Возвращяем результат
      return $arrResult;
    }
  }

  // Вывод массива данных
  public function query_all($sQuery){
    if ( $sQuery ) {
      // - Подключаемся
      $PDO = new PDO('mysql:host='.config::$host.';dbname='.config::$db, config::$user, config::$password);

      // - Выполняем запрос
      $arrResult = $PDO->query($sQuery)->fetchAll(PDO::FETCH_ASSOC);

      // - Отключаемся
      $PDO = null;

      // - Возвращяем результат
      return $arrResult;
    }
  }

  // Добавление в базу
  public function insert($sQuery){
    if ( $sQuery ) {
      // - Подключаемся
      $PDO = new PDO('mysql:host='.config::$host.';dbname='.config::$db, config::$user, config::$password);

      // - Выполняем запрос
      $PDO->query($sQuery)->fetch(PDO::FETCH_ASSOC);
      $arrResult = $PDO->lastInsertId();

      // - Отключаемся
      $PDO = null;

      // - Возвращяем результат
      return $arrResult;
    }
  }

  function __construct()
  {
    // Подтягиваем конфигурации
    // $mySql = "SELECT * FROM `app_config`";
    // $arrConfig = db::query_all($mySql);
    // foreach ($arrConfig as $arrConfigItem)
    // config::$arrConfig[$arrConfigItem['option']] = $arrConfigItem['value'];
    //
    // // Подтягиваем права доступов
    // $mySql = "SELECT * FROM `app_users_groups`";
    // $arrUsersGroups = db::query_all($mySql);
    // foreach ($arrUsersGroups as $arrUsersGroup)
    // config::$arrUsersGroups[$arrUsersGroup['id']] = $arrUsersGroup;
  }
}
$db = new db();
