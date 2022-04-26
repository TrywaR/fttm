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
    <p class="label"><?=$arrTemplateParams['title']?></p>
    <input
      type="date"
      class="input form-control"
      name="<?=$arrTemplateParams['name']?>"
      value="<?=$arrTemplateParams['value']?>"
      <?if ( $arrTemplateParams['required'] ) echo 'required="required"'?>
      <?if ( $arrTemplateParams['disabled'] ) echo 'disabled="disabled"'?>
    >
  </label>
</div>
