<?
// $arrTemplateParams = [];
// $arrTemplateParams['title'] = '';
// $arrTemplateParams['name'] = '';
// $arrTemplateParams['value'] = '';
// $arrTemplateParams['options'] = '';
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
    <?php if ( isset($arrTemplateParams['icon']) ): ?>
      <span class="_icon">
        <?=$arrTemplateParams['icon']?>
      </span>
    <?php endif; ?>
    <?php if ( isset($arrTemplateParams['title']) ): ?>
      <span class="_text" title="<?=$arrTemplateParams['title']?>">
        <?=$arrTemplateParams['title']?>
      </span>
    <?php endif; ?>
  </span>

  <select
    class="input form-control"
    placeholder="<?=$arrTemplateParams['name']?>"
    id="form_input_<?=$arrTemplateParams['name']?>"
    name="<?=$arrTemplateParams['name']?>"
    <?if ( $arrTemplateParams['disabled'] ) echo 'disabled="disabled"'?>>
    <?php foreach ($arrTemplateParams['options'] as $arrOption): ?>
      <option value="<?=$arrOption['id']?>" <?if($arrTemplateParams['value'] == $arrOption['id']) {echo 'selected';}?>><?=$arrOption['name']?></option>
    <?php endforeach; ?>
  </select>
</div>
