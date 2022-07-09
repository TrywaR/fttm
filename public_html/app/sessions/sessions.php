<?
switch ($_REQUEST['form']) {
  case 'theme': # Переключение темы в сессии
    $arrResult = [];
    $arrResult['theme'] = $_SESSION['theme'] = $_REQUEST['theme'];
    if ( isset($_SESSION['user']) ) {
      $_SESSION['user']['theme'] = $arrResult['theme'];
      db::query("UPDATE `users` SET `theme` = '" . $arrResult['theme'] . "' WHERE `id` = '" . $_SESSION['user']['id'] . "'");
    }
    notification::success($arrResult);
    break;

  case 'lang': # Переключение языка в сессии
    $arrResult = [];
    $arrResult['lang'] = $_SESSION['lang'] = $_REQUEST['lang'];
    if ( isset($_SESSION['user']) ) {
      $_SESSION['user']['lang'] = $arrResult['lang'];
      db::query("UPDATE `users` SET `lang` = '" . $arrResult['lang'] . "' WHERE `id` = '" . $_SESSION['user']['id'] . "'");
    }
    notification::success($arrResult);
    break;

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
        if ( $arrUser['id'] ) {
          $arrResult['user'] = $_SESSION['user'] = $arrUser;
          $_SESSION['theme'] = $_SESSION['user']['theme'];
          $_SESSION['lang'] = $_SESSION['user']['lang'];
        }
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
