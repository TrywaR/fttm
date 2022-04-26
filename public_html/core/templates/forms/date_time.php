<?
// $arrTemplateParams = [];
// $arrTemplateParams['title'] = '';
// $arrTemplateParams['name'] = '';
// $arrTemplateParams['value'] = '';
// $arrTemplateParams['disabled'] = '';
// $arrTemplateParams['required'] = '';
// $arrTemplateParams['class'] = '';

$arrTemplateParams['values'] = explode(' ', $arrTemplateParams['value']);
?>
<div class="block_input <?=$arrTemplateParams['class']?>">
  <label>
    <p class="label"><?=$arrTemplateParams['title']?></p>
    <input
      type="date"
      class="input form-control"
      name="<?=$arrTemplateParams['name']?>_date"
      value="<?=$arrTemplateParams['values'][0]?>"
      <?if ( $arrTemplateParams['disabled'] ) echo 'disabled="disabled"'?>
      <?if ( $arrTemplateParams['required'] ) echo 'required="required"'?>
    >
    <input
      type="time"
      class="input form-control"
      name="<?=$arrTemplateParams['name']?>_time"
      value="<?=$arrTemplateParams['values'][1]?>"
      <?if ( $arrTemplateParams['disabled'] ) echo 'disabled="disabled"'?>
      <?if ( $arrTemplateParams['required'] ) echo 'required="required"'?>
    >
  </label>

  <? if ($_REQUEST['client'] == 'admin'): ?>
    <button type="button" name="date_time_clear" class="date_time_clear button _icon" title="Удалить дату и время">
      <i class="far fa-calendar-times"></i>
    </button>
  <? endif; ?>
</div>
