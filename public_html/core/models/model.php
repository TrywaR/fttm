<?
/**
 * model
 */
class model
{
  public static $id = '';
  public static $table = '';
  public static $where = '';
  public static $arrAddFields = [];

  // Вывод
  public function get($id='')
  {
    // Параметры
    $id = $id ? $id : $this->id; // id элемента
    $arrResult = []; // Результат
    // Общие параметры для запросов
    $mySqlShowSalt = '';
    // $mySqlSalt = " AND `active` > 0";
    // $mySqlSalt .= " ORDER BY  `sort` ASC";
    // Пагинация
    $iFrom = $this->from ? $this->from : 0; // Пагинация, от
    $iLimit = $this->limit ? $this->limit : 0; // Пагинация, количество элементов
    // Сортировка
    // Сортировка mySql
    $sSort = $this->sort ? $this->sort : '';
    $sSortDir = $this->sortDir ? $this->sortDir : 'ASC';
    // Сортировка php
    $sUSort = $this->usort ? $this->usort : '';

    // Если 1 элемент
    if ( $id ) {
      // Видно только своё
      $mySqlShowSalt .= ' AND `user_id` = ' . $_SESSION['user']['id'];
      $arrResult = db::query("SELECT * FROM `" . $this->table . "` WHERE `id` = " . $id . $mySqlShowSalt);
    }
    // Если список элементов
    else {
      // Видно только своё
      // Если есть условие вывода
      if ( $this->where ) {
        $mySqlShowSalt .= ' WHERE ' . $this->where . ' AND `user_id` = ' . $_SESSION['user']['id'];
      }
      else {
        $mySqlShowSalt .= ' WHERE `user_id` = ' . $_SESSION['user']['id'];
      }

      // Сортировка mySql
      if ( $sSort ) $mySqlShowSalt .= ' ORDER BY  `' . $sSort . '` ' . $sSortDir;

      // Пагинация
      if ( $iFrom ) $mySqlShowSalt .= ' LIMIT ' . $iFrom;
      if ( $iFrom && $iLimit ) $mySqlShowSalt .= ', ' . $iLimit;
      if ( ! $iFrom && $iLimit ) $mySqlShowSalt .= ' LIMIT ' . $iLimit;

      // Получаем элементы
      $arrResult = db::query_all("SELECT * FROM `" . $this->table . "`" . $mySqlShowSalt);

      // Сортировка php
      if ( $sUSort )
      usort($arrResult, function($a, $b){
        return -($a[$sUSort] - $b[$sUSort]);
      });

      // Переворачиваем выдачу для пагинации
      if ( $iLimit && $iFrom ) array_reverse($arrResultPag);
    }

    // Выводим результат
    // if ( is_array($arrResult) ) notification::send( $arrResult );
    // else notification::error('Ничего не найдено');
    return $arrResult;
  }

  // Добавление
  public function add()
  {
    // Параметры
    $mySql = ''; // Запрос для вывода ячеек в таблице
    $arrFields = []; // Столбцы таблицы в базе
    // $this->arrAddFields = []; // Значения для столбцов
    $mySqlAdd = ''; // Запрос на добавление
    $mySqlAddSeporator = ''; // Разделитель для запроса

    // Проверяем наличие парамтеров
    if ( ! count($this->arrAddFields) ) {
      if ( $this->name ) foreach ($this as $key => $value) $this->arrAddFields[$key] = $value;
      else notification::error( 'Нет данных для заполнения, добавьте параметр name или массив arrAddFields с параметрами!' );
    }

    // Собираем поля которые можно редактировать
    $arrFields = db::query_all("SHOW COLUMNS FROM " . $this->table);

    if ( ! $arrFields ) notification::error( 'Ошибка при выполнении запроса: ' . mysql_error() );

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
      if ($arrField['Field'] == 'id') continue;
      $mySqlAdd .= $mySqlAddSeporator . '`' . $arrField['Field'] . '`';
      $mySqlAddSeporator = ", ";
    }
    $mySqlAdd  .= ") VALUES ";
    $mySqlAdd  .= "(";

    // Проверяем прикручен ли пользователь
    if ( empty($this->arrAddFields['user_id']) ) $this->arrAddFields['user_id'] = $_SESSION['user']['id'];

    // Собираем значения в запрос на добавление из доп поля
    $mySqlAddSeporator = '';
    foreach ($arrFields as $arrField){
      if ($arrField['Field'] == 'id') continue;
      $mySqlAdd .= $mySqlAddSeporator . "'" . $this->arrAddFields[$arrField['Field']] . "'";
      $mySqlAddSeporator = ", ";
    }
    $mySqlAdd .= ")";

    // Добавляем
    $iNewTableElemId = db::insert($mySqlAdd);
    $this->id = $iNewTableElemId;
    return $this->get();
    // if ( $iNewTableElemId ) notification::success( 'Изменения сохранены!' );
    // else notification::error( 'Ошибка добавления!' );
  }

  // Сохранение
  public function save($id='')
  {
    // Параметры
    $mySql = ''; // Запрос для вывода ячеек в таблице
    $arrFields = ''; // Столбцы таблицы в базе
    $arrEditFields = ''; // Новые значения для столбцов
    $mySqlSave = ''; // Запрос на редактирование
    $mySqlSaveSeporator = ''; // Разделитель для запроса
    $id = $id ? $id : $this->id; // id элемента

    // Проверяем наличие парамтеров
    if ( ! count($this->arrAddFields) ) {
      if ( $this->name ) foreach ($this as $key => $value) $this->arrAddFields[$key] = $value;
      else notification::error( 'Нет данных для заполнения, добавьте параметр name или массив arrAddFields с параметрами!' );
    }

    // Собираем поля которые можно редактировать
    $arrFields = db::query_all("SHOW COLUMNS FROM " . $this->table);
    if ( ! $arrFields ) notification::error( 'Ошибка при выполнении запроса: ' . mysql_error() );

    // foreach ($arrFields as $arrField) $arrFields[$arrField['Field']] = $arrField;
    // print_r($arrField);
    // [Field] => id
    // [Type] => int(7)
    // [Null] =>
    // [Key] => PRI
    // [Default] =>
    // [Extra] => auto_increment

    // Проверяем прикручен ли пользователь
    if ( empty($this->arrAddFields['user_id']) ) $this->arrAddFields['user_id'] = $_SESSION['user']['id'];

    // Собираем запрос на редактирование
    $mySqlSave .= "UPDATE `" . $this->table . "` SET ";
    foreach ($arrFields as $arrField) {
      $mySqlSave .= $mySqlSaveSeporator . "`" . $arrField['Field'] . "` = '" . $this->arrAddFields[$arrField['Field']] . "'";
      $mySqlSaveSeporator = ", ";
    }
    $mySqlSave .= " WHERE `id` = " . $id;
    // die($mySqlSave);

    // Редактируем
    if ( ! db::query($mySqlSave) ) return $this->get();
    else notification::error( 'Ошибка редактирования!' );
  }

  // Удаление
  public function del($id='')
  {
    $id = $id ? $id : $this->id;
    $mySqlDel = "DELETE FROM `" . $this->table . "`";
    $mySqlDel .= " WHERE `id` = '" . $id . "'";

    // Удаляем
    if ( ! db::query($mySqlDel) ) notification::success( 'Успешное удаление!' );
    else notification::error( 'Ошибка удаления!' );
  }

  // function __construct()
  // {
  //   // $this->$id = '';
  //   // $this->$table = '';
  // }
}
