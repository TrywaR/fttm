<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод
    // if ( $_SESSION['user'] ) {
    //   $oNav = new nav();
    //   $arrNav = $oNav->get();
    //   notification::send($arrNav);
    // }
    break;

  case 'form_set_password': # Вывод формы для создания пароля
    $arrResults = [];
    $oForm = new form();

    $oForm->arrFields['form'] = ['value'=>'set_password','type'=>'hidden'];
    $oForm->arrFields['action'] = ['value'=>'protect','type'=>'hidden'];
    $oForm->arrFields['app'] = ['value'=>'app','type'=>'hidden'];
    $oForm->arrFields['session'] = ['value'=>$_SESSION['session'],'type'=>'hidden'];

    // Настройки шаблона
    $oForm->arrTemplateParams['id'] = 'content_loader_save';
    $oForm->arrTemplateParams['title'] = $oLang->get('UserPasswordEdit');
    $oForm->arrTemplateParams['button'] = 'Save';
    $sFormHtml = $oForm->show();

    // Вывод результата
    $arrResults['form'] = $sFormHtml;
    $arrResults['data'] = (array)$oUser;

    $arrResults['action'] = 'users';
    notification::send($arrResults);
    break;
}
