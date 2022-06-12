<?
// $arrTemplateParams = [];
// $arrTemplateParams['title'] = '';
// $arrTemplateParams['name'] = '';
// $arrTemplateParams['value'] = '';
// $arrTemplateParams['disabled'] = '';
// $arrTemplateParams['required'] = '';
// $arrTemplateParams['class'] = '';
?>
<div class="mb-2 <?=$arrTemplateParams['class']?>">
<!-- <div class="input-group mb-2 <?=$arrTemplateParams['class']?>"> -->
  <label
  for="form_input_<?=$arrTemplateParams['name']?>"
  class="form-label"
  >
    <?=$arrTemplateParams['title']?>
  </label>

  <!-- <span class="input-group-text" >
    <?=$arrTemplateParams['title']?>
  </span> -->

  <textarea
    class="textarea form-control"
    id="form_input_<?=$arrTemplateParams['name']?>"
    name="<?=$arrTemplateParams['name']?>"
    <?if ( $arrTemplateParams['disabled'] ) echo 'disabled="disabled"'?>
    <?if ( $arrTemplateParams['required'] ) echo 'required="required"'?>
  >
    <?if ( $arrTemplateParams['value'] ) echo base64_decode($arrTemplateParams['value'])?>
  </textarea>
</div>
