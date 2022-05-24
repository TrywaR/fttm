<?
/**
 * config
 */
class config
{
  static $user = 'trywar4y_fttm';
  static $password = 't4pQRJs*';
  static $host = 'localhost';
  static $db = 'trywar4y_fttm';
  static $site_url = 'fttm.trywar.ru';
  static $site_root = '/home/t/trywar4y/fttm.trywar.ru/public_html/';
  static $arrConfig = [];
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
