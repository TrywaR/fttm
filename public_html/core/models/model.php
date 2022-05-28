<?
/**
 * model
 */
class model
{
  public static $id = '';
  public static $table = '';
  public static $sort = '';
  public static $active = 0;
  public static $creator_id = 0;
  public static $parents = 0; # Для вычисления родителя
  public static $arrAddFields = [];

  // Вывод
  public function get($id='')
  {
    // Параметры
    $id = $id ? $id : $this->id; // id элемента
    $arrResult = ''; // Результат
    // Общие параметры для запросов
    $mySqlSalt = '';
    $mySqlShowSalt = '';
    // $mySqlSalt .= " ORDER BY  `sort` ASC";
    // Пагинация
    $iLimit = $this->limit ? $this->limit : 0; // Пагинация, количество элементов
    $iFrom = $this->from ? $this->from : 0; // Пагинация, от
    // Уникальаня выборка
    $sQuery = $this->query ? $this->query : '';
    // Сортировка
    // Сортировка mySql
    $sSort = $this->sort ? $this->sort : '';
    $sSortDir = $this->sortDir ? $this->sortDir : 'ASC';
    // Сортировка php
    $sUSort = $this->usort ? $this->usort : '';

    // Если 1 элемент
    if ( $id ) {
      // Ограничение по активности
      if ( $this->active ) $mySqlSalt = " AND `active` > 0";
      // Ограничение по родителю
      if ( $this->parents ) $mySqlSalt .= ' AND `parents` = ' . $this->parents;
      // Уникальаня выборка
      if ( $sQuery ) $mySqlShowSalt .= $sQuery;

      if ( $this->show_query ) return "SELECT * FROM `" . $this->table . "` WHERE `id` = " . $id . $mySqlSalt;

      $arrResult = db::query("SELECT * FROM `" . $this->table . "` WHERE `id` = " . $id . $mySqlSalt);
    }
    // Если список элементов
    else {
      // Ограничение по родителю
      if ( $this->parents ) $mySqlShowSalt .= ' AND `parents` = ' . $this->parents;
      if ( $this->active ) $mySqlShowSalt .= " AND `active` > 0";

      // Уникальаня выборка
      if ( $sQuery ) $mySqlShowSalt .= $sQuery;

      // Сортировка mySql
      if ( $sSort ) $mySqlShowSalt .= " ORDER BY  `" . $sSort . "` " . $sSortDir;

      // Пагинация
      if ( $iLimit ) $mySqlShowSalt .= ' LIMIT ' . $iLimit;
      if ( $iLimit && $iFrom ) $mySqlShowSalt .= ' OFFSET ' . $iFrom;

      if ( $this->show_query ) return "SELECT * FROM `" . $this->table . "` WHERE `id` != 0 " . $mySqlShowSalt;

      // Получаем элементы
      // die("SELECT * FROM `" . $this->table . "` WHERE `id` != 0 " . $mySqlShowSalt);
      $arrResult = db::query_all("SELECT * FROM `" . $this->table . "` WHERE `id` != 0 " . $mySqlShowSalt);

      // Сортировка php
      if ( $sUSort )
        usort($arrResult, function($a, $b){
          return -($a[$sUSort] - $b[$sUSort]);
        });

      // Переворачиваем выдачу для пагинации
      if ( $iLimit && $iFrom ) array_reverse($arrResultPag);
    }

    // Обрабатываем данные в зависимости от типа данных
    // Собираем поля которые можно редактировать
    $arrFields = db::query_all("SHOW COLUMNS FROM " . $this->table);
    $arrFieldsTypes = [];
    if ( ! $arrFields ) notification::error( 'Error while executing request: ' . mysql_error() );
    foreach ($arrFields as $arrField) $arrFieldsTypes[$arrField['Field']] = $arrField['Type'];
    if ( $id ) {
      foreach ( $arrResult as $key => &$value ) {
        switch ( $arrFieldsTypes[$key] ) {
          case 'longtext':
            $value = base64_decode($value);
            break;
          default:
            break;
        }
      }
    }
    else {
      foreach ( $arrResult as &$arrRestultitem ) {
        foreach ( $arrRestultitem as $key => &$value ) {
          switch ( $arrFieldsTypes[$key] ) {
            case 'longtext':
              $value = base64_decode($value);
              break;
            default:
              break;
          }
        }
      }
    }

    // Выводим результат
    return $arrResult;
    // if ( is_array($arrResult) ) notification::send( , false );
    // else notification::error('Ничего не найдено');
  }

  // Добавление
  public function add()
  {
    // Параметры
    $arrResult = []; // Результат
    $mySql = ''; // Запрос для вывода ячеек в таблице
    $arrFields = []; // Столбцы таблицы в базе
    // $this->arrAddFields = []; // Значения для столбцов
    $mySqlAdd = ''; // Запрос на добавление
    $mySqlAddSeporator = ''; // Разделитель для запроса

    // Проверяем наличие парамтеров
    if ( ! count($this->arrAddFields) ) {
      if ( $this->name || $this->title || $this->user_id ) foreach ($this as $key => $value) $this->arrAddFields[$key] = $value;
      else notification::error( 'There is no data to fill in, add the name parameter or the arrAddFields array with parameters!' );
    }

    // Собираем поля которые можно редактировать
    $arrFields = db::query_all("SHOW COLUMNS FROM " . $this->table);
    if ( ! $arrFields ) notification::error( 'Error while executing request: ' . mysql_error() );

    // foreach ($arrFields as $arrField) $arrFields[$arrField['Field']] = $arrField;
    // print_r($arrField);
    // [Field] => id
    // [Type] => int(7)
    // [Null] =>
    // [Key] => PRI
    // [Default] =>
    // [Extra] => auto_increment

    // Собираем заголовки запрос на добавление
    $mySqlAdd  .= "INSERT INTO `" . $this->table . "` (";
    foreach ($arrFields as $arrField) {
      $mySqlAdd .= $mySqlAddSeporator . '`' . $arrField['Field'] . '`';
      $mySqlAddSeporator = ", ";
    }
    $mySqlAdd  .= ") VALUES ";
    $mySqlAdd  .= "(";

    // Собираем значения в запрос на добавление из доп поля
    $mySqlAddSeporator = '';
    foreach ($arrFields as $arrField){
      $mySqlAdd .= $mySqlAddSeporator;
      switch ( $arrField['Type'] ) {
        case 'mediumtext':
          $mySqlAdd .= "'" . $this->arrAddFields[$arrField['Field']] . "'";
          break;
        case 'longtext':
          $mySqlAdd .= "'" . base64_encode($this->arrAddFields[$arrField['Field']]) . "'";
          break;
        case 'init':
          $mySqlAdd .= "'" . $this->arrAddFields[$arrField['Field']] . "'";
          break;
        case 'datetime':
          if ( $this->arrAddFields[$arrField['Field'] . '_date'] )
          $mySqlSave .= "'" . $this->arrAddFields[$arrField['Field'] . '_date'] . ' ' . $this->arrAddFields[$arrField['Field'] . '_time'] . "'";
          else $mySqlAdd .= "'" . $this->arrAddFields[$arrField['Field']] . "'";
          break;
        default:
          $mySqlAdd .= "'" . $this->arrAddFields[$arrField['Field']] . "'";
          break;
      }
      $mySqlAddSeporator = ", ";
    }
    $mySqlAdd .= ")";

    // Добавляем
    // die($mySqlAdd);
    $this->id = db::insert($mySqlAdd);
    // if ( $iNewTableElemId ) notification::success( 'Успешное добавление!' );
    if ( $this->id ) return $this->id;
    else notification::error( 'Add error!' );
  }

  // Сохранение
  public function save($id='')
  {
    // Параметры
    $arrResult = []; // Результат
    $mySql = ''; // Запрос для вывода ячеек в таблице
    $arrFields = ''; // Столбцы таблицы в базе
    // $arrEditFields = ''; // Новые значения для столбцов
    $mySqlSave = ''; // Запрос на редактирование
    $mySqlSaveSeporator = ''; // Разделитель для запроса
    $id = $id ? $id : $this->id; // id элемента

    // Проверяем наличие парамтеров
    if ( ! count($this->arrAddFields) ) {
      if ( $this->name || $this->title ) foreach ($this as $key => $value) $this->arrAddFields[$key] = $value;
      else notification::error( 'There is no data to fill, add the name parameter or the arrAddFields array with parameters!' );
    }
    else {
      foreach ($this as $key => &$value)
        if ( $this->arrAddFields[$key] ) $value = $this->arrAddFields[$key];
    }

    // Собираем поля которые можно редактировать
    $arrFields = db::query_all("SHOW COLUMNS FROM " . $this->table);
    if ( ! $arrFields ) notification::error( 'Error while executing request: ' . mysql_error() );

    // foreach ($arrFields as $arrField) $arrFields[$arrField['Field']] = $arrField;
    // print_r($arrField);
    // [Field] => id
    // [Type] => int(7)
    // [Null] =>
    // [Key] => PRI
    // [Default] =>
    // [Extra] => auto_increment

    // Собираем запрос на редактирование
    $mySqlSave .= "UPDATE `" . $this->table . "` SET ";
    foreach ($arrFields as $arrField) {
      $mySqlSave .= $mySqlSaveSeporator . "`" . $arrField['Field'] . "` = ";
      switch ( trim(preg_replace('/\s*\([^)]*\)/', '', $arrField['Type'])) ) {
        case 'mediumtext':
          $mySqlSave .= "'" . $this->arrAddFields[$arrField['Field']] . "'";
          break;
        case 'longtext':
          $mySqlSave .= "'" . base64_encode($this->arrAddFields[$arrField['Field']]) . "'";
          break;
        case 'tinyint':
          $mySqlSave .= isset($this->arrAddFields[$arrField['Field']]) ? 1 : 0;
          break;
        case 'init':
          $mySqlSave .= "'" . $this->arrAddFields[$arrField['Field']] . "'";
          break;
        case 'datetime':
          if ( $this->arrAddFields[$arrField['Field'] . '_date'] )
          $mySqlSave .= "'" . $this->arrAddFields[$arrField['Field'] . '_date'] . ' ' . $this->arrAddFields[$arrField['Field'] . '_time'] . "'";
          else $mySqlSave .= "'" . $this->arrAddFields[$arrField['Field']] . "'";
          break;
        default:
          $mySqlSave .= "'" . $this->arrAddFields[$arrField['Field']] . "'";
          break;
      }
      $mySqlSaveSeporator = ", ";
    }
    $mySqlSave .= " WHERE `id` = " . $id;
    if ( $this->show_query ) die($mySqlSave);
    // Редактируем
    if ( db::query($mySqlSave) ) notification::error( 'Error edit' );
    // if ( ! db::query($mySqlSave) ) notification::success( 'Изменения сохранены!' );
    // else notification::error( 'Ошибка редактирования!' );
  }

  // Удаление
  public function del($id='')
  {
    $id = $id ? $id : $this->id;
    $mySqlDel = "DELETE FROM `" . $this->table . "`";
    $mySqlDel .= " WHERE `id` = '" . $id . "'";

    // Удаляем
    if ( ! db::query($mySqlDel) ) notification::success( 'Delete success!' );
    else notification::error( 'Error delete!' );
  }

  // function __construct()
  // {
  //   // $this->$id = '';
  //   // $this->$table = '';
  // }
}
