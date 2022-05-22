<?
switch ($_REQUEST['form']) {
  case 'new': # Новая сессия
    $arrResult = [];
    $oSession = new session();
    $iSessionId = $oSession->add();
    $arrResult['session'] = $_SESSION['session'] = $oSession->session;
    notification::success($arrResult);
    break;

  case 'continue': # Продолжение
    $arrResult = [];
    $bReload = false; # Нужно ли перезагрузить страницу
    if ( ! $_SESSION['session'] ) $bReload = true;
    // Получаем сессию
    $oSession = new session( 0, $_REQUEST['session'] );
    $arrSession = $oSession->get_session();
    // Сессия есть в базе
    if ( is_array( $arrSession ) && $arrSession['session'] ) {
      // Получаем пользователя, если есть
      if ( $arrSession['user_id'] ) {
        $oUser = new user( $arrSession['user_id'] );
        $arrUser = $oUser->get_user();
        $arrResult['user'] = $_SESSION['user'] = $arrUser;
      }
      // Восстанавливаем сессиию
      $oSession->session = $arrSession['session'];
      // Обновляем значения
      $oSession->update();
      // Сохраняем новую сессию в сессии 0_о
      $arrResult['session'] = $_SESSION['session'] = $oSession->session;
      // Если нужно перезагрузить страницу
      if ( $bReload ) $arrResult['location'] = '/';
      notification::success($arrResult);
    }
    else notification::error("Man, can't you see we're having lunch.");
    break;
}
