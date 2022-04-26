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
      <?php if ( $arrTemplateParams['title'] != '' ): ?>
        <h2 class="_form_title">
          <?=$arrTemplateParams['title']?>
        </h2>
      <?php endif; ?>
    </div>

    <? if ( $arrTemplateParams['content'] ): ?>
      <div class="block_sections">
        <?=$arrTemplateParams['content']?>
        <!-- <div class="block_section">
        </div> -->

        <!-- <div class="block_section _40">
        </div>

        <div class="block_section _60">
        </div> -->
      </div>
    <? endif; ?>

    <? if ( $arrTemplateParams['html'] ): ?>
      <div class="block_sections">
        <div class="block_section _100">
          <?=$arrTemplateParams['html']?>
        </div>
      </div>
    <? endif; ?>

    <div class="block_footer">
      <div class="form_status"></div>

      <div class="block_buttons">
        <button type="button" class="btn form_reset"><i class="fas fa-window-close"></i> Clear</button>
        <button class="button btn btn-primary" type="submit"><i class="fas fa-save"></i> <?=$arrTemplateParams['button']?></button>
      </div>
    </div>
  </form>
</div>
