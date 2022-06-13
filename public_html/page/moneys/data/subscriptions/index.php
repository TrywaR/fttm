<?
$oCard = new card();
$oCard->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
$arrCards = $oCard->get();

$oMoneyCategory = new moneys_category();
$oMoneyCategory->sort = 'sort';
$oMoneyCategory->sortDir = 'ASC';
$oMoneyCategory->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
$arrMoneysCategories = $oMoneyCategory->get_categories();
?>

<section class="row block_jumbotron block_moneys">
  <div class="col col-12">
    <div class="_block_title">
      <h1 class="sub_title _value">
        <?$oLang = new lang()?>
        <?=$oLang->get('Subscriptions')?>
      </h1>
    </div>
  </div>
</section>

<section class="row block_moneys">
  <div class="col col-12">
    <div id="content_manager_buttons" class="content_manager_buttons _hide_" data-content_manager_action="moneys_subscriptions" data-content_manager_block="#moneys_subscriptions" data-content_manager_item=".money_subscription" data-content_manager_button=".content_manager_switch">
      <button type="button" name="button" class="btn btn-danger del">
        <i class="fas fa-folder-minus"></i>
      </button>
    </div>

    <ol
      id="moneys_subscriptions"
      class="block_moneys_subscriptions block_elems block_content_loader list-group list-group-numbered"
      data-content_loader_table="moneys_subscriptions"
      data-content_loader_form="show_all"
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
      data-content_loader_scroll_block="#moneys_subscriptions"
      data-content_loader_show_class="animate__bounceInRight _show_"
      style="max-height: 50vh; overflow: auto; overflow-x: hidden;"
      >
    </ol>
    <script>
      $(function(){
        $(document).find('#moneys_subscriptions').content_loader()
        $(document).find('#content_manager_buttons').content_manager()
        $(document).find('#footer_actions').content_actions( {'action':'moneys_subscriptions'} )
      })
    </script>
  </div>


  <div class="block_template">
    <li class="list-group-item _elem d-flex money_subscription progress_block animate__animated _card_show_{{card_show}} _paid_show_{{paid_show}}" data-content_manager_item_id="{{id}}"  data-id="{{id}}">
      <span class="d-flex w-100 row">
        <span class="col-6 col-xl-6 mb-2">
          <span class="d-flex flex-column">
            {{title}}<br/>

            <small class="_card">
              <i class="fas fa-credit-card"></i>
              {{card_val.title}}
            </small>

            <small class="_paid">
              <i class="fas fa-check"></i>
              {{paid.date}}
            </small>
          </span>

          <div class="badge bg-primary">
            {{price}}
          </div>
        </span>

        <span class="col-6 col-xl-6 d-flex justify-content-end">
          <span class="btn-group">
            <a href="#" class="btn btn-dark content_manager_switch switch_icons">
              <span class="">
                <i class="far fa-square"></i>
              </span>

              <span class="">
                <i class="fas fa-square"></i>
              </span>
            </a>

            <a data-action="moneys_subscriptions" data-animate_class="animate__flipInY" data-id="{{id}}" data-elem=".money_subscription" data-form="form" href="javascript:;" class="btn btn-dark content_loader_show _edit">
              <i class="fas fa-pen-square"></i>
            </a>

            <a href="#" class="btn btn-dark content_download" data-id="{{id}}" data-action="moneys_subscriptions" data-form="del" data-elem=".list-group-item">
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
</section>
