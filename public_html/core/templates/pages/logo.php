<?/*
$arrLogoParam['class'];
// 'class': '_white',

<?include 'core/templates/pages/logo.php';?>
*/?>
<?
$sY = $_SESSION['user'] ? $_SESSION['user']['login']{0} : '0';
if ( empty($arrLogoParam) ) {
  $arrLogoParam = [
    'class' => ''
  ];
}
?>
<div class="block_logo <?=$arrLogoParam['class']?>">
  <?php if ( $_SERVER['REQUEST_URI']!='/' ): ?>
    <a class="_value" href="/">
      <span class="_start">u</span>
      <span class="_seporator">[</span>
      <span class="_nickname"><?=$sY?></span>
      <span class="_seporator">]</span>
      <span class="_stop">lif<i class="fa-solid fa-bars"></i></span>
    </a>
  <?php else: ?>
    <span class="_value">
      <span class="_start">u</span>
      <span class="_seporator">[</span>
      <span class="_nickname"><?=$sY?></span>
      <span class="_seporator">]</span>
      <span class="_stop">lif<i class="fa-solid fa-bars"></i></span>
    </span>
  <?php endif; ?>
</div>
