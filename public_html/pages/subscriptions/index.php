<?
$oCard = new card();
$oCard->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
$arrCards = $oCard->get();

$oCategory = new category();
$oCategory->sort = 'sort';
$oCategory->sortDir = 'ASC';
$oCategory->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
$arrCategories = $oCategory->get_categories();
?>

<div class="main_jumbotron">
  <div class="_block_title">
    <h1 class="sub_title _value">
      <?=$oLang->get('Subscriptions')?>
    </h1>

    <div class="_buttons btn-group">
      <a class="btn" target="_blank" href="/info/docs/subscriptions/">
        <i class="fa-solid fa-circle-info"></i>
      </a>
    </div>
  </div>
</div>

<div class="main_content">
  <div id="content_manager_buttons" class="content_manager_buttons _hide_" data-content_manager_action="subscriptions" data-content_manager_block="#subscriptions" data-content_manager_item=".money_subscription" data-content_manager_button=".content_manager_switch">
    <button type="button" name="button" class="btn btn-danger del">
      <i class="fas fa-folder-minus"></i>
    </button>
  </div>

  <ol
    id="subscriptions"
    class="block_subscriptions block_elems block_content_loader list-group list-group-numbered"
    data-content_loader_table="subscriptions"
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
    data-content_loader_scroll_block="#subscriptions"
    data-content_loader_show_class="_show_"
    >
  </ol>
  <script>
    $(function(){
      $(document).find('#subscriptions').content_loader()
      $(document).find('#content_manager_buttons').content_manager()
      $(document).find('#footer_actions').content_actions( {'action':'subscriptions'} )
    })
  </script>
</div>

<div class="block_template">
    <li class="list-group-item _elem d-flex subscription progress_block _card_show_{{card_show}} _paid_show_{{paid_show}} _paid_need_show_{{paid_need_show}}" data-content_manager_item_id="{{id}}"  data-id="{{id}}">
      <span class="d-flex w-100 row">
        <span class="col-12 col-md-6 mb-2">
          <span class="d-flex flex-column">
            <span class="_head">
              <span class="_price">
                {{price}}
              </span>

              <span class="_title">
                {{title}}
              </span>
            </span>

            <div class="_subs">
              <span class="_item _card">
                <span class="_icon">
                  <i class="fas fa-credit-card"></i>
                </span>
                <span class="_text">
                  {{card_val.title}}
                </span>
              </span>

              <span class="_item _paid">
                <span class="_icon">
                  <i class="fas fa-check"></i>
                </span>
                <span class="_text">
                  <span class="_sum">
                    {{paid_sum}}
                  </span>
                  <span class="_need">
                    {{paid_need}}
                  </span>
                </span>
              </span>
            </div>
          </span>
        </span>

        <span class="col-12 col-md-6 d-flex justify-content-end align-items-center">
          <span class="btn-group">
            <a href="#" class="btn btn-dark content_manager_switch switch_icons">
              <span class="">
                <i class="far fa-square"></i>
              </span>

              <span class="">
                <i class="fas fa-square"></i>
              </span>
            </a>

            <a data-action="subscriptions" data-animate_class="animate__flipInY" data-id="{{id}}" data-elem=".money_subscription" data-form="form" href="javascript:;" class="btn btn-dark content_loader_show _edit">
              <i class="fas fa-pen-square"></i>
            </a>

            <a href="#" class="btn btn-dark content_download" data-id="{{id}}" data-action="subscriptions" data-form="del" data-elem=".list-group-item">
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
