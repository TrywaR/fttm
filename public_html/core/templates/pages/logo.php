<?/*
$arrLogoParam['class'];
// 'class': '_white',

<?include 'core/templates/pages/logo.php';?>
*/?>
<?
if ( empty($arrLogoParam) ) {
  $arrLogoParam = [
    'class' => ''
  ];
}
?>
<div class="block_logo <?=$arrLogoParam['class']?>">
  <?php if ( $_SERVER['REQUEST_URI']!='/' ): ?>
    <a class="_value" href="/">
      <img src="/template/imgs/logos/logo-dark.svg" alt="">
      <small class="_version"><?=$_SESSION['version']?></small>
    </a>
  <?php else: ?>
    <span class="_value">
      <img src="/template/imgs/logos/logo-dark.svg" alt="">
      <small class="_version"><?=$_SESSION['version']?></small>
    </span>
  <?php endif; ?>
</div>
