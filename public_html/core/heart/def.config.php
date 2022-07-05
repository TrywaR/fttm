<?
/**
 * config
 */
class config
{
  static $user = 'db_login';
  static $password = 'pass';
  static $host = 'localhost';
  static $db = 'db_login';
  static $site_url = 'url.com';
  static $site_root = '/root/';
  static $arrConfig = [];
  static $arrLeng = [];
  static $arrUsersGroups = [];

  function __construct(){
  }
}
$config = new config();
config::$arrConfig = [
  'name' => 'FTTM',
  'email_to' => 'send@trywar.ru',
  'email_from' => 'fttm@trywar.ru',
  'telegram_api_key' => 'FTTM',
  'telegram_chat_id' => 'FTTM',
];
