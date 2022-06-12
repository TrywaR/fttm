<?
// $arrTemplateParams = [];
// $arrTemplateParams['title'] = '';
// $arrTemplateParams['name'] = '';
// $arrTemplateParams['value'] = '';
// $arrTemplateParams['required'] = '';
// $arrTemplateParams['class'] = '';
?>
<div class="input-group mb-2 <?=$arrTemplateParams['class']?>">
  <!-- <label
  for="form_input_<?=$arrTemplateParams['name']?>"
  class="form-label"
  >
    <?=$arrTemplateParams['title']?>
  </label> -->

  <span class="input-group-text" >
    <?=$arrTemplateParams['title']?>
  </span>

  <input
    type="password"
    class="input form-control"
    <?if ( $arrTemplateParams['disabled'] ) echo 'disabled="disabled"'?>
    id="form_input_<?=$arrTemplateParams['name']?>"
    name="<?=$arrTemplateParams['name']?>"
    value="<?=$arrTemplateParams['value']?>"
    <?if ( $arrTemplateParams['required'] ) echo 'required="required"'?>
  >
</div>
