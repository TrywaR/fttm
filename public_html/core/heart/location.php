<?
/**
 * location
 */
class location
{
  public static $arrLocations = []; # Данные страниц

  public function get_title () {
    $sTitleFull = $_SERVER['REDIRECT_URL'] != '' ? config::$arrConfig['name'] : '';
    $oNav = new nav();

    if ( count( $oNav->arrNavsPath ) ) {
      foreach ( $oNav->arrNavsPath as $arrPath ) {
        if ( $sTitleFull ) $sTitleFull .= ' > ' . $arrPath['name'];
        else $sTitleFull = $arrPath['name'];
      }
    }
    else {
      if ( $sTitleFull ) $sTitleFull .= ' > * ';
      else $sTitleFull = '';
    }

    return $sTitleFull;
  }

  public function get_description () {
    $sDescriptionFull = config::$arrConfig['name'];
    $oNav = new nav();

    $arrNavCurrent = end($oNav->arrNavsPath);
    if ( $arrNavCurrent['description'] ) $sDescriptionFull = $arrNavCurrent['description'];

		return $sDescriptionFull;
  }

  public function breadcrumbs () {
    $sUrlResultHtml = '';
    // $sUrlResultHtml = config::$arrConfig['name'];
    $oNav = new nav();

    // $sUrlResultHtml .= '<div class="_item"><div class="_link">';
    //   $sUrlResultHtml .= config::$arrConfig['name'];
    // $sUrlResultHtml .= '</div></div>';

    if ( count( $oNav->arrNavsPath ) ) {
      foreach ( $oNav->arrNavsPath as $arrPath ) {
        $sUrlResultHtml .= '<div class="_item"><div class="_link">';
          $sUrlResultHtml .= $arrPath['name'];
        $sUrlResultHtml .= '</div></div>';
      }
    }
    else {
      $sUrlResultHtml .= '<div class="_item"><div class="_link">';
        $sUrlResultHtml .= '*';
      $sUrlResultHtml .= '</div></div>';
    }

    return $sUrlResultHtml;
  }

  function __construct(){
  }
}
