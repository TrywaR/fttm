<?
// $arrTemplateParams = [];
// $arrTemplateParams['name'] = '';
// $arrTemplateParams['value'] = '';
// $arrTemplateParams['type'] = '';
// $arrTemplateParams['title'] = '';
?>

<div class="block_input">
  <label>
    <p class="label">
      <?=$arrTemplateParams['title']?>
    </p>
    <div data-name="<?=$arrTemplateParams['name']?>" class="code_editor" data-type="<?=$arrTemplateParams['lang']?>">
      <?=$arrTemplateParams['value']?>
    </div>
    <textarea style="display:none;" name="<?=$arrTemplateParams['name']?>" rows="8" cols="80" <?if ( $arrTemplateParams['disabled'] ) echo 'disabled="disabled"'?>><?=$arrTemplateParams['value']?></textarea>
  </label>
</div>
