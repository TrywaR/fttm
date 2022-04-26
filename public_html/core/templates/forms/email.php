<?
// $arrTemplateParams = [];
// $arrTemplateParams['title'] = '';
// $arrTemplateParams['name'] = '';
// $arrTemplateParams['value'] = '';
// $arrTemplateParams['required'] = '';
// $arrTemplateParams['class'] = '';
?>
<div class="block_input <?=$arrTemplateParams['class']?>">
  <label>
    <p class="label">
      <?=$arrTemplateParams['title']?>
    </p>
    <input
      type="email"
      class="input form-control"
      name="<?=$arrTemplateParams['name']?>"
      value="<?=$arrTemplateParams['value']?>"
      <?if ( $arrTemplateParams['disabled'] ) echo 'disabled="disabled"'?>
      <?if ( $arrTemplateParams['required'] ) echo 'required="required"'?>
    >
  </label>
</div>
