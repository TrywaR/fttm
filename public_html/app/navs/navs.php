<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод
    if ( $_SESSION['user'] ) {
      $oNav = new nav();
      $arrNav = $oNav->get();
      notification::send($arrNav);  
    }
    break;
}
