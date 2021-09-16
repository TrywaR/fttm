<?
/**
 * notification
 */
class notification
{
  // Отправка ответа приложению
  public function send( $arrData ){
    $sResult = json_encode( $arrData );
    die( $sResult );
  }

  // Добавление уведомления приложению
  public function alert( $sAlert ){
    $arrData['alert'] = $sAlert;
    notification::send( $arrData );
  }

  // Добавление ошибки приложению
  public function error( $sError ){
    $arrData['error'] = $sError;
    notification::send( $arrData );
  }

  // Успешное выполнение
  public function success( $sSuccess ){
    $arrData['success'] = $sSuccess;
    notification::send( $arrData );
  }

  // Пуш уведомление
  // public function push( $arrData, $arrTo ){
  //   // Параметры отправки
  //   $sUrl = 'https://fcm.googleapis.com/fcm/send';
  //
  //   // Собираем сообщение
  //   $arrNotification = array(
  //     'title'     => $arrData['title'],
  //     'body'      => strip_tags($arrData['body']),
  //     'icon'      => 'notification_icon',
  //   );
  //
  //   $arrFields = array(
  //     'registration_ids' => $arrTo,
  //     'data' => $arrData,
  //     'notification' => $arrNotification
  //   );
  //
  //   $arrHeaders = array(
  //     'Authorization: key=' . config::$arrConfig['firebase_api'],
  //     'Content-Type: application/json'
  //   );
  //
  //   // Отправляем сообщение
  //   $ch = curl_init();
  //   curl_setopt( $ch,CURLOPT_URL,$sUrl);
  //   curl_setopt( $ch,CURLOPT_POST,true);
  //   curl_setopt( $ch,CURLOPT_HTTPHEADER,$arrHeaders);
  //   curl_setopt( $ch,CURLOPT_RETURNTRANSFER,true);
  //   curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER,false);
  //   curl_setopt( $ch,CURLOPT_POSTFIELDS,json_encode($arrFields));
  //   $sResult = curl_exec($ch);
  //   curl_close($ch);
  //
  //   // Обрабатываем результат
  //   $response = curl_exec($ch);
  //   if ($sResult === FALSE) $arrResult['error'] = 'FCM Send Error: ' . curl_error($ch);
  //   $arrResult['success'] = $sResult;
  //
  //   // // Сохраняем отправку
  //   // $sQuery  = "UPDATE `app_notifications` SET ";
  //   // $sQuery .= "`status` = '" . json_encode($arrResult) . "'";
  //   // $sQuery .= " WHERE `id` = " . $arrData['id'];
  //   // db::query($sQuery);
  //
  //   // Выводим результат
  //   return $arrResult;
  //   // notification::send( $arrResult );
  // }

  // // Уведомление на почту
  // public function email( $arrMessage, $arrToEmail ) {
  //   $mailNew = new mail();
  //   $mailNew::$subject .= $arrMessage['title'];
  //   $mailNew::$message .= $arrMessage['body'];
  //
  //   foreach ($arrToEmail as $sEmail) {
  //     $mailNew::$to = $sEmail;
  //     $mailNew::send();
  //   }
  // }
}
$notification = new notification();
