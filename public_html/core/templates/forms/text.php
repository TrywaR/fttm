<?
// $arrTemplateParams = [];
// $arrTemplateParams['title'] = '';
// $arrTemplateParams['name'] = '';
// $arrTemplateParams['value'] = '';
// $arrTemplateParams['required'] = '';
// $arrTemplateParams['class'] = '';
?>
<div class="input-group mb-2 <?=$arrTemplateParams['class']?>">
  <!-- <label class="form-label" for="form_input_<?=$arrTemplateParams['name']?>">
    <?=$arrTemplateParams['title']?>
  </label> -->

  <span class="input-group-text" for="form_input_<?=$arrTemplateParams['name']?>">
    <?=$arrTemplateParams['title']?>
  </span>

  <input
    type="text"
    class="input form-control"
    id="form_input_<?=$arrTemplateParams['name']?>"
    name="<?=$arrTemplateParams['name']?>"
    placeholder="<?=$arrTemplateParams['name']?>"
    value="<?=$arrTemplateParams['value']?>"
    <?if ( $arrTemplateParams['disabled'] ) echo 'disabled="disabled"'?>
    <?if ( $arrTemplateParams['required'] ) echo 'required="required"'?>
  >
</div>
