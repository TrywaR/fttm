<?
// $arrTemplateParams = [];
// $arrTemplateParams['id'] = '';
// $arrTemplateParams['title'] = '';
// $arrTemplateParams['content'] = '';
// $arrTemplateParams['button'] = '';
?>
<div class="block_modal" id="block_modal">
  <form class="modal_form" id="<?=$arrTemplateParams['id']?>" method="post">
    <div class="block_header">
      <h2 class="_form_title">
        <?=$arrTemplateParams['title']?>
      </h2>
    </div>

    <div class="block_sections">
      <?=$arrTemplateParams['content']?>
      <!-- <div class="block_section">
      </div> -->

      <!-- <div class="block_section _40">
      </div>

      <div class="block_section _60">
      </div> -->
    </div>

    <div class="block_footer">
      <div class="form_status"></div>

      <div class="block_buttons">
        <button class="button" type="submit"><?=$arrTemplateParams['button']?></button>
      </div>
    </div>
  </form>
</div>
