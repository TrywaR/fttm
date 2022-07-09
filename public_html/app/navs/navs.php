<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод
    $oNav = new nav();
    $arrNav = $oNav->get();
    notification::send($arrNav);
    break;
}
