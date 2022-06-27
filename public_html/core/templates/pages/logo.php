<?/*
$arrLogoParam['class'];
// 'class': '_white',

<?include 'core/templates/pages/logo.php';?>
*/?>
<?
$sY = $_SESSION['user'] ? $_SESSION['user']['login']{0} : 'Y';
if ( empty($arrLogoParam) ) {
  $arrLogoParam = [
    'class' => ''
  ];
}
?>
<div class="block_logo <?=$arrLogoParam['class']?>">
  <?php if ( $_SERVER['REQUEST_URI']!='/' ): ?>
    <a class="_value" href="/">
      FT
      <span class="_seporator">[</span>
      <span class="_nickname"><?=$sY?></span>
      <span class="_seporator">]</span>
      M
    </a>
  <?php else: ?>
    <span class="_value">
      FT
      <span class="_seporator">[</span>
      <span class="_nickname"><?=$sY?></span>
      <span class="_seporator">]</span>
      M
    </span>
  <?php endif; ?>
</div>
