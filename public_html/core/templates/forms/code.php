<?
// $arrTemplateParams = [];
// $arrTemplateParams['name'] = '';
// $arrTemplateParams['value'] = '';
// $arrTemplateParams['type'] = '';
// $arrTemplateParams['title'] = '';
?>

<div class="mb-2">
  <label class="form-label" for="form_input_<?=$arrTemplateParams['name']?>">
    <?php if ( isset($arrTemplateParams['icon']) ): ?>
      <span class="_icon">
        <?=$arrTemplateParams['icon']?>
      </span>
    <?php endif; ?>
    <?php if ( isset($arrTemplateParams['title']) ): ?>
      <span class="_text" title="<?=$arrTemplateParams['title']?>">
        <?=$arrTemplateParams['title']?>
      </span>
    <?php endif; ?>
  </label>

  <div data-name="<?=$arrTemplateParams['name']?>" class="code_editor" data-type="<?=$arrTemplateParams['lang']?>"><?=$arrTemplateParams['value']?></div>
  <textarea class="__no_editor" id="form_input_<?=$arrTemplateParams['name']?>" style="display:none;" name="<?=$arrTemplateParams['name']?>" rows="8" cols="80" <?if ( $arrTemplateParams['disabled'] ) echo 'disabled="disabled"'?>><?=$arrTemplateParams['value']?></textarea>
</div>
