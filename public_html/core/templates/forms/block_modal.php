<?
// $arrTemplateParams = [];
// $arrTemplateParams['id'] = '';
// $arrTemplateParams['title'] = '';
// $arrTemplateParams['content'] = '';
// $arrTemplateParams['button'] = '';
?>

<!-- <div class="modal" tabindex="-1"> -->
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg modal-fullscreen-lg-down" id="block_modal">
    <form class="modal-content" id="<?=$arrTemplateParams['id']?>" method="post">
      <?php if ( $arrTemplateParams['title'] != '' ): ?>
        <div class="modal-header">
          <h5 class="modal-title">
            <?=$arrTemplateParams['title']?>
          </h5>
          <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
      <?php endif; ?>

      <div class="modal-body">
        <div class="row">
          <? if ( $arrTemplateParams['content'] ): ?>
            <?=$arrTemplateParams['content']?>
          <?php endif; ?>

          <? if ( $arrTemplateParams['html'] ): ?>
            <?=$arrTemplateParams['html']?>
          <? endif; ?>
        </div>
      </div>

      <div class="modal-footer">

        <button type="button" class="btn form_reset"><i class="fas fa-window-close"></i> <?=$olang->get('Clear')?></button>
        <!-- <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
          <label class="form-check-label" for="flexSwitchCheckChecked">Not reset</label>
        </div> -->
        <button class="button btn btn-dark" type="submit"><i class="fas fa-save"></i> <?=$olang->get($arrTemplateParams['button'])?></button>
      </div>
    </form>
  </div>
<!-- </div> -->
