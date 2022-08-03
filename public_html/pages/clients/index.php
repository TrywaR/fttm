<div class="main_jumbotron">
  <div class="_block_title">
    <h1 class="sub_title _value">
      <?=$oLang->get('Clients')?>
    </h1>
  </div>
</div>

<div class="main_content">
  <div id="content_manager_buttons" class="content_manager_buttons _hide_" data-content_manager_action="clients" data-content_manager_block="#clients" data-content_manager_item=".client" data-content_manager_button=".content_manager_switch">
    <button type="button" name="button" class="btn btn-danger del">
      <i class="fas fa-folder-minus"></i>
    </button>
  </div>

  <div
    id="clients"
    class="block_clients block_elems block_content_loader"
    data-content_loader_table="clients"
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
    data-content_loader_scroll_block="#clients"
    data-content_loader_show_class="_show_"
    ></div>

  <script>
    $(function(){
      $(document).find('#clients').content_loader( 'start' )
      $(document).find('#content_manager_buttons').content_manager()
      $(document).find('#footer_actions').content_actions( {'action':'clients'} )
    })
  </script>
</div>

<div class="block_template">
  <div class="client _elem progress_block" data-content_manager_item_id="{{id}}"  data-id="{{id}}">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-xl-6">
            <small>№{{sort}}</small>
            <small>#{{id}}</small>
            <h5 class="card-title">{{title}}</h5>
            <p class="card-text">{{description}}</p>
          </div>
          <div class="col-12 col-xl-6 d-flex justify-content-end align-items-start">
            <div class="btn-group" role="group">
              <a href="#" class="btn content_manager_switch switch_icons">
                <div class="">
                  <i class="far fa-square"></i>
                </div>
                <div class="">
                  <i class="fas fa-square"></i>
                </div>
              </a>

              <a data-action="clients" data-animate_class="animate__flipInY" data-id="{{id}}" data-elem=".client" data-form="form" href="javascript:;" class="btn content_loader_show">
                <i class="fas fa-pen-square"></i>
              </a>

              <a href="#" class="btn content_download" data-id="{{id}}" data-elem=".client" data-action="clients" data-form="del" data-animate_class="animate__fadeOutRightBig">
                <i class="fas fa-minus-square"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
      </div>
    </div>
  </div>
</div>
