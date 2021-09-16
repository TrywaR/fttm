<?
// $arrTemplateParams = [];
// $arrTemplateParams['title'] = '';
// $arrTemplateParams['name'] = '';
// $arrTemplateParams['value'] = '';
// $arrTemplateParams['disabled'] = '';
// $arrTemplateParams['required'] = '';
// $arrTemplateParams['class'] = '';
?>
<div class="block_input <?=$arrTemplateParams['class']?>">
  <label>
    <p class="label">
      <?=$arrTemplateParams['title']?>
    </p>
    <textarea
      class="textarea"
      name="<?=$arrTemplateParams['name']?>"
      <?if ( $arrTemplateParams['disabled'] ) echo 'disabled="disabled"'?>
      <?if ( $arrTemplateParams['required'] ) echo 'required="required"'?>
    >
      <?if ( $arrTemplateParams['value'] ) echo base64_decode($arrTemplateParams['value'])?>
    </textarea>
  </label>
</div>
