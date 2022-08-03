<div class="main_jumbotron">
  <div class="_block_title">
    <h1 class="sub_title _value">
      <?=$oLang->get('Cards')?>
    </h1>
  </div>
</div>

<div class="main_content">
  <!-- Карты -->
  <div id="content_manager_buttons" class="content_manager_buttons _hide_" data-content_manager_action="cards" data-content_manager_block="#cards" data-content_manager_item=".card_item" data-content_manager_button=".content_manager_switch">
    <button type="button" name="button" class="btn btn-danger del">
      <i class="fas fa-folder-minus"></i>
    </button>
  </div>

  <div
    id="cards"
    class="block_cards block_elems block_content_loader"
    data-content_loader_table="cards"
    data-content_loader_form="show"
    data-content_loader_limit="15"
    data-content_loader_scroll_nav="0"
    <?php if ($_REQUEST['sort']): ?>
      data-content_loader_sort="<?=$_REQUEST['sort']?>"
      data-content_loader_sortdir="<?=$_REQUEST['sortdir']?>"
    <?php endif; ?>
    <?php if ($_REQUEST['filter']): ?>
      data-content_loader_parents="<?=$_REQUEST['filter_value']?>"
    <?php endif; ?>
    data-content_loader_template_selector=".block_template"
    data-content_loader_scroll_block="#cards"
    data-content_loader_show_class="_show_"
    >
  </div>

  <script>
    $(function(){
      $(document).find('#cards').content_loader()
      $(document).find('#content_manager_buttons').content_manager()
      $(document).find('#footer_actions').content_actions( {'action':'cards'} )
    })
  </script>
</div>

<div class="block_template">
  <div class="card_item _elem progress_block" data-content_manager_item_id="{{id}}"  data-id="{{id}}">
    <div class="block_card _commission_show_{{commission_show}} _edit_show_{{edit_show}}">
      <div class="_card_head">
        <div class="_title">
          {{title}}
        </div>

        <div class="_update" title="<?=$oLang->get('LastUpdate')?>">
          <div class="_icon">
            <i class="fas fa-clock"></i>
          </div>
          <div class="_val">
            {{date_update}}
          </div>
        </div>

        <div class="badge bg-primary _balance" title="Balance">
          {{balance}} / <small>{{limit}}</small>
        </div>

        <div class="badge bg-warning text-dark _commission" title="Commission">
          {{commission}}
        </div>
      </div>

      <div class="_card_footer">
        <div class="btn-group" role="group">
          <a href="#" class="btn btn-dark content_manager_switch switch_icons _select">
            <div class="">
              <i class="far fa-square"></i>
            </div>
            <div class="">
              <i class="fas fa-square"></i>
            </div>
          </a>

          <a href="#" title="<?=$oLang->get('CardReloadBalanceBtn')?>" class="btn btn-dark content_download _reload" data-id="{{id}}" data-action="cards" data-elem=".card_item" data-form="reload" data-animate_class="animate__flipInY">
            <i class="fas fa-retweet"></i>
          </a>

          <a data-action="cards" data-animate_class="animate__flipInY" data-id="{{id}}" data-elem=".card_item" data-form="form" href="javascript:;" class="btn btn-dark content_loader_show _edit">
            <i class="fas fa-pen-square"></i>
          </a>

          <a href="#" class="btn btn-dark content_download _del" data-id="{{id}}" data-action="cards" data-form="del" data-elem=".card_item">
            <i class="fas fa-minus-square"></i>
          </a>
        </div>
      </div>

      <div class="_card_background">
        <div class="_color" style="background: radial-gradient({{color}},rgba(0,0,0,0))"></div>
      </div>

      <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
      </div>
    </div>
  </div>
</div>
