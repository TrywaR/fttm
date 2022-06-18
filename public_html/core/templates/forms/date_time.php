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
<div class="input-group mb-2 <?=$arrTemplateParams['class']?> input-date_time">
  <!-- <label class="form-label"><?=$arrTemplateParams['title']?></label> -->

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

  <? if ($_REQUEST['client'] == 'admin'): ?>
    <button type="button" name="date_time_clear" class="btn date_time_clear" title="Удалить дату и время">
      <i class="far fa-calendar-times"></i>
    </button>
  <? endif; ?>
</div>
