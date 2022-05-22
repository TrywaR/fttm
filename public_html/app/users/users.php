<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод элементов
    // $oUser = new user( $_REQUEST['id'] );
    //
    // if ( $_REQUEST['from'] ) $oUser->from = $_REQUEST['from'];
    // if ( $_REQUEST['limit'] ) $oUser->limit = $_REQUEST['limit'];
    //
    // $oUser->sort = 'sort';
    // $oUser->sortDir = 'DESC';
    // $oUser->query .= ' AND `user_id` = ' . $_SESSION['user']['id'];
    //
    // if ( $_REQUEST['id'] ) $arrCard = $oUser->get_user();
    // else $arrCard = $oUser->get_cards();
    //
    // notification::send($arrCard);
    break;

  case 'edit': # Сохранение изменений
  case 'save': # Сохранение изменений
    $arrResult = [];
    $arrResult['text'] = '';
    $oUser = $_REQUEST['id'] ? new user( $_REQUEST['id'] ) : new user();
    $oUser->arrAddFields = $_REQUEST;

    // Обработка данных
    foreach ($oUser->arrAddFields as $key => $value) {
      switch ($key) {
        case 'new_password':
          if ( $_REQUEST['new_password'] != '' ) {
            // Проверка текущего пароля
            // Кодируем пасс
            $sOldPassword = hash( 'ripemd128', $_REQUEST['edit_password'] );
            $arrUser = db::query("SELECT * FROM `users` WHERE `login` = '". $_REQUEST['login'] ."' AND `password` = '". $sOldPassword . "'");
            if ( $arrUser ) {
              // Если пароли не совпадают
              if ( $_REQUEST['password'] != $_REQUEST['edit_password_confirm'] ) notification::error('Passwords do not match.');
              $sNewPassword = hash( 'ripemd128', $value );
              // Записываем новый пароль
              $oUser->arrAddFields['password'] = $sNewPassword;
              $arrResult['text'] = 'Password change! ';
            }
            else {
              notification::error('Password not valid!');
            }
          }
          break;
        case 'login':
          // Если поменялся логин
          if ( $_REQUEST['login'] != $_SESSION['user']['login'] ) {
            $arrUser = db::query("SELECT * FROM `users` WHERE `login` = '". $_REQUEST['login'] ."'");
            if ( is_array($arrUser) ) notification::error('This login is already taken.');
          }
          break;
        case 'email':
          // Если поменялась почта
          if ( $_REQUEST['email'] != $_SESSION['user']['email'] ) {
            $arrUser = db::query("SELECT * FROM `users` WHERE `email` = '". $_REQUEST['email'] ."'");
            if ( is_array($arrUser) ) notification::error('This email is already taken.');
          }
          break;
      }
    }

    // Чтобы не затереть данные
    if ( $_REQUEST['password'] == '' && $_REQUEST['new_password'] == ''  ) $oUser->arrAddFields['password'] = $_SESSION['user']['password'];
    if ( $_REQUEST['date_registration'] == '' ) $oUser->arrAddFields['date_registration'] = $_SESSION['user']['date_registration'];

    if ( $_REQUEST['id'] ) $oUser->save();
    else $oUser->add();

    $arrResult['data'] = $_SESSION['user'] = $oUser->get();
    $arrResult['location_reload'] = true;

    if ( $_REQUEST['id'] ) $arrResult['event'] = 'save';
    else $arrResult['event'] = 'add';

    $arrResult['text'] .= 'Changes saved';
    notification::success($arrResult);
    break;

  case 'del': # Удаление
    $oUser = new user( $_REQUEST['id'] );
    $oUser->del();
    break;
}
