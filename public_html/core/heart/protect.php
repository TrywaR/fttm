<?
/**
 * Protect
 */
class protect
{
  public static $id = ''; # Req
  public static $table = ''; # Req
  public static $protect = '';
  public static $sSecretKey = ''; # Req
  public static $mySqlSalt = '';
  public static $arrElem = '';

  /**
  * simple method to encrypt or decrypt a plain text string
  * initialization vector(IV) has to be the same when encrypting and decrypting
  *
  * @param string $action: can be 'encrypt' or 'decrypt'
  * @param string $string: string to encrypt or decrypt
  *
  * @return string
  * https://gist.github.com/joashp/a1ae9cb30fa533f4ad94
  */
  function protector( $bAction, $string ) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = $this->sSecretKey;
    $secret_iv = 'FTTM';
    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ( $bAction ) {
      $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
      $output = base64_encode($output);
    }
    else {
      $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
  }

  // Получить защищённые данные
  public function decode( $arrElem = [] ){
    // Берём колонки из базы
    $sProtect = $arrElem['protect'];

    // Дешефровываем
    $protectProtect = $this->protector( false, $sProtect );

    // Декодируем
    $jsonProtect = json_encode( $protectProtect );

    // Вставляем данные
    foreach ( $jsonProtect as $key => $value ) $arrElem[$key] = $value;

    return $arrElem;
  }

  // Защитить даныне
  public function encode(){
    // $arrResult - Данные из базы
    // $arrProtect - Данные для шифровыки
    // $jsonProtect - Данные для шифровки в json
    // $protectProtect - Данные зашифрованыне

    // Берём колонки из базы
    $arrResult = db::query("SELECT * FROM `" . $this->table . "` WHERE `id` = " . $this->id . $this->mySqlSalt);
    $arrProtect = [];
    foreach ($arrResult as $key => $value) {
      switch ( $key ) {
        case 'id':
        case 'protect':
          continue;
          break;

        default:
          $arrProtect[$key] = $value;
          break;
      }
    }
    $jsonProtect = json_encode( $arrProtect );

    // Записываем в одну строку
    $protectProtect = $this->protector( true, $jsonProtect );

    // Сохраняем
    db::query("UPDATE `" . $this->table . "` SET `protect` = '" . $protectProtect . "' WHERE `id` = '" . $this->id . "'");

    return true;
  }

  function __construct( $iProtectId = 0 )
  {
    // code...
  }
}
