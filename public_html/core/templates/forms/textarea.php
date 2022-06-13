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

  <!-- <span class="input-group-text" >
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
  </span> -->

  <textarea
    class="textarea form-control"
    id="form_input_<?=$arrTemplateParams['name']?>"
    name="<?=$arrTemplateParams['name']?>"
    <?if ( $arrTemplateParams['disabled'] ) echo 'disabled="disabled"'?>
    <?if ( $arrTemplateParams['required'] ) echo 'required="required"'?>
  >
    <?if ( $arrTemplateParams['value'] ) echo $arrTemplateParams['value']?>
  </textarea>
</div>
