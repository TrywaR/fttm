<?
// $arrTemplateParams = [];
// $arrTemplateParams['title'] = '';
// $arrTemplateParams['name'] = '';
// $arrTemplateParams['value'] = '';
// $arrTemplateParams['disabled'] = '';
// $arrTemplateParams['required'] = '';
// $arrTemplateParams['class'] = '';
?>
<div class="input_checkbox <?=$arrTemplateParams['class']?>">
  <input
    type="checkbox"
    name="<?=$arrTemplateParams['name']?>"
    <?if ( $arrTemplateParams['disabled'] ) echo 'disabled="disabled"'?>
    <?if ( $arrTemplateParams['required'] ) echo 'required="required"'?>
    <?php if ($arrTemplateParams['value']): ?>
      checked
    <?php endif; ?>
    value="<?=$arrTemplateParams['value']?>"
    id="checkbox_<?=$arrTemplateParams['name']?>"
  >
  <label for="checkbox_<?=$arrTemplateParams['name']?>">
    <?=$arrTemplateParams['title']?>
  </label>
</div>
