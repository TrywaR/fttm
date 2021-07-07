<?
session_start();
include_once 'core/core.php'; # Основные настройки

if ( $_REQUEST['app'] ) {
  include_once 'app/app.php';
  die();
}

include_once 'header.php'; # Шапка

if ($_SERVER['REQUEST_URI']!='/') {
 if (file_exists('page'.$_SERVER['REQUEST_URI'].'index.php')) {
   include_once 'page'.$_SERVER['REQUEST_URI'].'index.php';
   # code...
 }
}else{
 if (file_exists('page/home.php')) {
   include_once 'page/home.php';
   # code...
 }
}

include_once 'footer.php'; # Подвал
