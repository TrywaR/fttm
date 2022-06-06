<?
/**
 * location
 */
class location
{
  public static $arrLocations = []; # Данные страниц

  // public function get_title () {
  //   $oLocation = new location();
  //   $arrUrl = explode('/',$_SERVER['REDIRECT_URL']);
  //   $sUrlPrev = '';
  //   $sTitleFull = '';
  //   $sUrlFull = '/';
  //
  //   $iIndex = 0;
  //   foreach ($arrUrl as $sUrl) {
  //     if ( ! $sUrl ) continue;
  //
  //     if ( $sUrlFull != '/' ) {
  //       if ( $oLocation->arrLocations[$sUrlFull] ) $sTitleFull .= ' > ' . $oLocation->arrLocations[$sUrlFull]['name'];
  //
  //       if ( $iIndex )
  //       // else $sTitleFull .= ' > ' . $sUrl;
  //     }
  //
  //     $sUrlFull .= $sUrl . '/';
  //     $sUrlPrev = $sUrl;
  //     $iIndex++;
  //   }
  //
  //   return $sTitleFull;
  // }
  //
  // public function get_elem_title () {
  //   $arrUrl = explode('/',$_SERVER['REDIRECT_URL']);
  //   $sCurrentUrl = $arrUrl[count($arrUrl)-2];
  //   switch ($sCurrentUrl) {
  //     case 'course':
  //       if ( $_REQUEST['id'] ) {
  //         $oCourse = new course( $_REQUEST['id'] );
  //         return 'Курс: ' . $oCourse->name;
  //       }
  //       break;
  //     case 'theme':
  //       if ( $_REQUEST['id'] ) {
  //         $oTheme = new theme( $_REQUEST['id'] );
  //         return 'Тема: '. $oTheme->name;
  //       }
  //       break;
  //     case 'collection':
  //       if ( $_REQUEST['id'] ) {
  //         $oCollection = new collection( $_REQUEST['id'] );
  //         return 'Коллекция' . $oCollection->name;
  //       }
  //       break;
  //   }
  // }

  // public static $_SESSION['location'] = ''; # Ссылка
  // Получить url
  // public function get(){
  //   $sSiteUrl = '/';
  //   if ( $_SESSION['location'] ) {
  //     $sSiteUrl = $_SESSION['location'];
  //   }
  //   return $sSiteUrl;
  // }
  //
  // // Задать значение
  // public function set( $sSiteUrl = '' ){
  //   if ( $sSiteUrl ) $_SESSION['location'] = $sSiteUrl;
  // }
  //
  // // Стартовая страница для приложения
  // public function set_app( $sSiteUrl = '', $iUserId = 0 ){
  //   // Берём парамтеры из базы
  //   if ( $iUserId && $sSiteUrl ) {
  //     $oUserSetting = new user_setting( $iUserId );
  //     // Обрабатываем параметры
  //     $arrNewSettings = (array)$oUserSetting;
  //     $arrNewSettings['start_page'] = $sSiteUrl;
  //
  //     // foreach ($oUserSetting as $key => $value) {
  //     //   if ( $arrRequestSettings[$key] ) {
  //     //     if ( $arrRequestSettings[$key] == 'start_page' ) $arrNewSettings[$key] = $sSiteUrl;
  //     //   }
  //     //   else {
  //     //     if ( $key == 'start_page' && $value == '' ) $arrNewSettings[$key] = $sSiteUrl;
  //     //     else $arrNewSettings[$key] = 0;
  //     //   }
  //     // }
  //
  //     $sQuery = "UPDATE `app_users_settings` SET ";
  //     $sQuery .= "`settings` = '" . json_encode($arrNewSettings) . "' ";
  //     $sQuery .= " WHERE `user_id` = " . $iUserId;
  //     $arrResult = db::query($sQuery);
  //   }
  // }

  // public function breadcrumbs () {
  //   $oLocation = new location();
  //   $arrUrl = explode('/',$_SERVER['REDIRECT_URL']);
	// 	$sUrlPrev = '';
	// 	$sUrlFull = '/';
	// 	$sUrlResultHtml = '';
  //
	// 	foreach ($arrUrl as $sUrl) {
	// 		if ( ! $sUrl ) continue;
  //
	// 		// Добавляем ссылку
	// 		if ( $sUrlFull != '/' ) {
	// 			$sUrlResultHtml .= '<a href="' . $sUrlFull . '">';
	// 			if ( $oLocation->arrLocations[$sUrlFull] ) $sUrlResultHtml .= $oLocation->arrLocations[$sUrlFull]['name'];
	// 			else $sUrlResultHtml .= $sUrlPrev;
	// 			$sUrlResultHtml .= '</a>';
	// 		}
  //
	// 		$sUrlFull .= $sUrl . '/';
	// 		$sUrlPrev = $sUrl;
	// 	}
  //
	// 	if ( $oLocation->arrLocations[$sUrlFull] ) $sUrlResultHtml .= '<span>' . $oLocation->arrLocations[$sUrlFull]['name'] . '</span>';
  //   else {
  //     $sTitle = $oLocation->get_elem_title();
  //     if ( $sTitle ) $sUrlResultHtml .= '<span>' . $sTitle . '</span>';
  //     else $sUrlResultHtml .= '<span>' . $sUrlPrev . '</span>';
  //   }
  //
	// 	return $sUrlResultHtml;
  // }
  //
  // // Перейти
  // public function go( $sSiteUrl = '' ){
  //   if ( $_SESSION['location'] ) {
  //     $sSiteUrl = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SESSION['location'];
  //     unset($_SESSION['location']);
  //   }
  //
  //   if ( $sSiteUrl ) exit("<meta http-equiv='refresh' content='0; url= " . $sSiteUrl . "'>");
  // }

  function __construct(){
    $this->arrLocations = []; # Поля в форму
    $oNav = new nav();
    $this->arrLocations = $oNav->get();
  }
}
