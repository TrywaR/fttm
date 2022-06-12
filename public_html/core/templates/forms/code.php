<?
// $arrTemplateParams = [];
// $arrTemplateParams['name'] = '';
// $arrTemplateParams['value'] = '';
// $arrTemplateParams['type'] = '';
// $arrTemplateParams['title'] = '';
?>

<!-- <div class="input-group mb-2"> -->
<div class="mb-2">
  <label class="form-label" for="form_input_<?=$arrTemplateParams['name']?>">
    <?=$arrTemplateParams['title']?>
  </label>

  <!-- <span class="input-group-text" >
    <?=$arrTemplateParams['title']?>
  </span> -->

  <div data-name="<?=$arrTemplateParams['name']?>" class="code_editor" data-type="<?=$arrTemplateParams['lang']?>">
    <?=$arrTemplateParams['value']?>
  </div>

  <textarea id="form_input_<?=$arrTemplateParams['name']?>" style="display:none;" name="<?=$arrTemplateParams['name']?>" rows="8" cols="80" <?if ( $arrTemplateParams['disabled'] ) echo 'disabled="disabled"'?>><?=$arrTemplateParams['value']?></textarea>
</div>
