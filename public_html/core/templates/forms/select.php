<?
// $arrTemplateParams = [];
// $arrTemplateParams['title'] = '';
// $arrTemplateParams['name'] = '';
// $arrTemplateParams['value'] = '';
// $arrTemplateParams['options'] = '';
// $arrTemplateParams['required'] = '';
// $arrTemplateParams['class'] = '';
?>
<div class="block_input <?=$arrTemplateParams['class']?>">
  <label>
    <p class="label">
      <?=$arrTemplateParams['title']?>
    </p>
    <select class="input" name="<?=$arrTemplateParams['name']?>">
      <?php foreach ($arrTemplateParams['options'] as $arrOption): ?>
        <option value="<?=$arrOption['id']?>" <?if($arrTemplateParams['value'] == $arrOption['id']) {echo 'selected';}?>><?=$arrOption['name']?></option>
      <?php endforeach; ?>
    </select>
  </label>
</div>