<div class="main_jumbotron">
  <div class="_block_title">
    <h1 class="sub_title _value">
      <?=$oLang->get('Categories')?>
    </h1>
  </div>
</div>

<div class="main_content">
  <div id="content_manager_buttons" class="content_manager_buttons _hide_" data-content_manager_action="categories" data-content_manager_block="#categories" data-content_manager_item=".money_category" data-content_manager_button=".content_manager_switch">
    <button type="button" name="button" class="btn btn-danger del">
      <i class="fas fa-folder-minus"></i>
    </button>
  </div>

  <ul
    id="categories"
    class="block_moneys_categories block_elems block_content_loader list-group list-group-numbered"
    data-content_loader_table="categories"
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
    data-content_loader_scroll_block="#categories"
    data-content_loader_show_class="animate__bounceInRight _show_"
    >
  </ul>
  <script>
    $(function(){
      $(document).find('#categories').content_loader()
      $(document).find('#content_manager_buttons').content_manager()
      $(document).find('#footer_actions').content_actions( {'action':'categories'} )
    })
  </script>
</div>

<div class="block_template">
    <li class="list-group-item d-flex _elem money_category progress_block animate__animated  _edit_show_{{edit_show}}" data-content_manager_item_id="{{id}}"  data-id="{{id}}">
      <span class="row d-flex w-100 justify-content-between align-items-start">
        <span class="col-12 col-xl-6 mb-2">
          <span class="d-flex">
            {{title}}
          </span>
          <span class="badge" style="background: {{color}}!important">
            {{color}}
          </span>
        </span>

        <span class="col-12 col-xl-6 d-flex justify-content-end">
          <span class="btn-group">
            <a href="#" class="btn btn-dark content_manager_switch switch_icons _select">
              <div class="">
                <i class="far fa-square"></i>
              </div>
              <div class="">
                <i class="fas fa-square"></i>
              </div>
            </a>

            <a data-action="categories" data-animate_class="animate__flipInY" data-id="{{id}}" data-elem=".money_category" data-form="form" href="javascript:;" class="btn btn-dark content_loader_show _edit">
              <i class="fas fa-pen-square"></i>
            </a>

            <a href="#" class="btn btn-dark content_download _del" data-id="{{id}}" data-action="categories" data-form="del" data-elem=".money_category">
              <i class="fas fa-minus-square"></i>
            </a>
          </span>
        </span>
      </span>

      <span class="progress">
        <span class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></span>
      </span>
    </li>
  </div>