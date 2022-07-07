<?
/**
 * Page
 */
class page
{
  function get_title () {
    $oLocation = new location();
    return $oLocation->get_title();
  }

  function get_description () {
    $oLocation = new location();
    return $oLocation->get_description();
  }

  function get_micromark (){
    $sResultHtml = '';
    $sResultHtml .= '<meta property="og:title" content="' . page::get_title() . '" />';
  	$sResultHtml .= '<meta property="og:type" content="website" />';
  	$sResultHtml .= '<meta property="og:url" content="' . config::$site_url . $_SERVER['REQUEST_URI'] . '" />';
  	$sResultHtml .= '<meta property="og:image" content="' . config::$site_url . '/core/src/img/logo/logo.svg" />';
    return $sResultHtml;
  }

  function __construct() {
  }
}
$page = new page();
