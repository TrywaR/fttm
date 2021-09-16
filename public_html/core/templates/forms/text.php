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
      type="text"
      class="input"
      name="<?=$arrTemplateParams['name']?>"
      value="<?=$arrTemplateParams['value']?>"
      <?if ( $arrTemplateParams['required'] ) echo 'required="required"'?>
    >
  </label>
</div>
