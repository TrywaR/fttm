<?
// $arrTemplateParams = [];
// $arrTemplateParams['title'] = '';
// $arrTemplateParams['name'] = '';
// $arrTemplateParams['value'] = '';
// $arrTemplateParams['disabled'] = '';
// $arrTemplateParams['required'] = '';
// $arrTemplateParams['class'] = '';
?>
<div class="input_checkbox form-check mb-2 <?=$arrTemplateParams['class']?>">
  <input
    type="checkbox"
    class="form-check-input"
    name="<?=$arrTemplateParams['name']?>"
    <?if ( $arrTemplateParams['disabled'] ) echo 'disabled="disabled"'?>
    <?if ( $arrTemplateParams['required'] ) echo 'required="required"'?>
    <?php if ($arrTemplateParams['value']): ?>
      checked
    <?php endif; ?>
    value="<?=$arrTemplateParams['value']?>"
    id="checkbox_<?=$arrTemplateParams['name']?>"
  >
  <label class="form-check-label" for="checkbox_<?=$arrTemplateParams['name']?>">
    <?php if ( isset($arrTemplateParams['icon']) ): ?>
      <span class="_icon">
        <?=$arrTemplateParams['icon']?>
      </span>
    <?php endif; ?>
    <?php if ( isset($arrTemplateParams['title']) ): ?>
      <span class="_text">
        <?=$arrTemplateParams['title']?>
      </span>
    <?php endif; ?>
  </label>
</div>
