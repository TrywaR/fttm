<?
include_once 'header.php';
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
include_once 'footer.php';