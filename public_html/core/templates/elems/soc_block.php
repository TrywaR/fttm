<?/*
<?include 'core/templates/elems/soc_block.php'?>
*/?>

<?
// load lang
switch ($oLang->sUserLang) {
  case 'ru':
    ?>
    <div class="_social block_social">
      <a class="_item" href="https://t.me/u0life_ru" target="_blank">
        <i class="fa-brands fa-telegram"></i>
      </a>
      <a class="_item" href="https://www.instagram.com/u0life_ru/" target="_blank">
        <i class="fa-brands fa-instagram"></i>
      </a>
      <a class="_item" href="https://www.tiktok.com/@u0life_ru" target="_blank">
        <i class="fa-brands fa-tiktok"></i>
      </a>
    </div>
    <?
    break;
  case 'en':
    ?>
    <div class="_social block_social">
      <a class="_item" href="https://t.me/u0life" target="_blank">
        <i class="fa-brands fa-telegram"></i>
      </a>
      <a class="_item" href="https://www.instagram.com/u0life/" target="_blank">
        <i class="fa-brands fa-instagram"></i>
      </a>
      <a class="_item" href="https://www.tiktok.com/@u0life" target="_blank">
        <i class="fa-brands fa-tiktok"></i>
      </a>
    </div>
    <?
    break;
}
?>
