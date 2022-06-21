<?
$oCard = new card();
$oCard->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
$arrCards = $oCard->get();

$oTask = new task();
$oTask->sort = 'sort';
$oTask->sortDir = 'ASC';
$oTask->query .= ' AND `user_id` = ' . $_SESSION['user']['id'];
$oTask->query .= ' AND `status` = 2';
$arrTasks = $oTask->get();
$arrTaskId = [];
foreach ($arrTasks as $arrTask) $arrTaskId[$arrTask['id']] = $arrTask;

$oMoneyCategory = new category();
$oMoneyCategory->sort = 'sort';
$oMoneyCategory->sortDir = 'ASC';
$oMoneyCategory->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
$arrMoneysCategories = $oMoneyCategory->get_categories();

$oProject = new project();
$oProject->sort = 'sort';
$oProject->sortDir = 'ASC';
$oProject->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
$arrProjects = $oProject->get();


$oMoneysSubscriptions = new moneys_subscriptions();
$oMoneysSubscriptions->sort = 'sort';
$oMoneysSubscriptions->sortDir = 'ASC';
$oMoneysSubscriptions->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
$arrMoneysSubscriptions = $oMoneysSubscriptions->get_subscriptions();

$arrTypes = [
  array('id'=>1,'title'=>$oLang->get('Spend')),
  array('id'=>2,'title'=>$oLang->get('Replenish')),
];
?>

<div class="main_jumbotron">
  <div class="_block_title">
    <h1 class="sub_title _value">
      <?=$oLang->get('Moneys')?>
    </h1>

    <div class="_buttons btn-group">
      <?include 'core/templates/elems/filter_button.php'?>
    </div>
  </div>

  <div class="_block_content" id="shower">
    <!-- Фильтр -->
    <form class="content_filter __no_ajax" action="" id="content_filter" data-content_filter_block="#moneys" data-content_filter_status="#content_filter_show">
      <div class="input-group mb-2">
        <span class="input-group-text">
          <span class="_icon">
            <i class="fas fa-wallet"></i>
          </span>
        </span>
        <select name="type" class="form-select">
          <option value=""><?=$oLang->get('Type')?></option>
          <?php foreach ($arrTypes as $iIndex => $arrType): ?>
            <option value="<?=$arrType['id']?>"><?=$arrType['title']?></option>
          <?php endforeach; ?>
        </select>

        <span class="input-group-text">
          <span class="_icon">
            <i class="far fa-credit-card"></i>
          </span>
        </span>
        <select name="card" class="form-select">
          <option value=""><?=$oLang->get('Card')?></option>
          <?php foreach ($arrCards as $iIndex => $arrCard): ?>
            <option value="<?=$arrCard['id']?>"><?=$arrCard['title']?></option>
          <?php endforeach; ?>
        </select>

        <span class="input-group-text">
          <span class="_icon">
            <i class="fas fa-list-ul"></i>
          </span>
        </span>
        <select name="category" class="form-select">
          <option value=""><?=$oLang->get('Category')?></option>
          <?php foreach ($arrMoneysCategories as $iIndex => $arrMoneyCategory): ?>
            <option value="<?=$arrMoneyCategory['id']?>"><?=$arrMoneyCategory['title']?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="input-group">
        <span class="input-group-text">
          <span class="_icon">
            <i class="far fa-folder"></i>
          </span>
        </span>
        <select name="project_id" class="form-select">
          <option value=""><?=$oLang->get('Project')?></option>
          <option value="0"><?=$olang->get('NoProject')?></option>
          <?php foreach ($arrProjects as $iIndex => $arrProject): ?>
            <option value="<?=$arrProject['id']?>"><?=$arrProject['title']?></option>
          <?php endforeach; ?>
        </select>

        <span class="input-group-text">
          <i class="fas fa-wrench"></i>
        </span>
        <select name="task_id" class="form-select">
          <option value=""><?=$oLang->get('Task')?></option>
          <?php foreach ($arrTasks as $iIndex => $arrTask): ?>
            <option value="<?=$arrTask['id']?>"><?=$arrTask['title']?></option>
          <?php endforeach; ?>
        </select>

        <span class="input-group-text">
          <span class="_icon">
            <i class="far fa-calendar-alt"></i>
          </span>
        </span>
        <input type="date" name="date" class="form-control" placeholder="<?=$olang->get('Date')?>" value="">

        <button class="btn btn-dark" type="submit">
          Go
        </button>
      </div>
    </form>
  </div>
</div>

<div class="main_content">
  <div id="content_manager_buttons" class="content_manager_buttons _hide_" data-content_manager_action="moneys" data-content_manager_block="#moneys" data-content_manager_item=".list-group-item" data-content_manager_button=".content_manager_switch">
    <button type="button" name="button" class="btn btn-danger del">
      <i class="fas fa-folder-minus"></i>
    </button>
  </div>

  <ol
    id="moneys"
    class="block_moneys block_elems list-group list-group-numbered block_content_loader"
    data-content_loader_table="moneys"
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
    data-content_loader_scroll_block="#moneys"
    data-content_loader_show_class="animate__bounceInRight _show_"
  ></ol>
  <script>
    $(function(){
      // $(document).find('#moneys').content_loader()
      $(document).find('#content_filter').content_filter()
      $(document).find('#content_manager_buttons').content_manager()
      $(document).find('#footer_actions').content_actions( {'action':'moneys'} )
    })
  </script>
</div>

<div class="block_template">
  <li class="list-group-item money _elem progress_block animate__animated _type_{{type}}_ _category_show_{{category_show}} _project_show_{{project_show}} _task_show_{{task_show}} _card_show_{{card_show}} _cardto_show_{{cardto_show}} _subscription_show_{{subscription_show}}" data-content_manager_item_id="{{id}}"  data-id="{{id}}">
    <div class="ms-2 me-auto">
      <div class="fw-bold mb-1 d-flex">
        <span class="_date">
          {{date}}
        </span>

        <span class="_card">
          <i class="fas fa-credit-card"></i> {{card_val.title}}
          <span class="_cardto"> <small>></small> <i class="fas fa-credit-card"></i> {{cardto_val.title}}</span>
          <span class="_subscription"> <small>></small> <i class="fas fa-check"></i> {{subscription_val.title}}</span>
        </span>
      </div>

      <div class="fw-bold d-flex align-items-center">
        <div class="badge bg-primary _price" style="font-size: 1rem; font-weight: normal; background: {{categroy_val.color}} ! important; margin-right:.5rem;">
          {{price}}
        </div>

        <span class="_title">
          {{title}}
        </span>

        <div class="_sub">
          <small class="_category">{{categroy_val.title}}</small>
          <small class="_project">> {{project_val.title}}</small>
          <small class="_task">> {{task_val.title}}</small>
        </div>
      </div>
    </div>

    <div class="btn-group">
      <a href="#" class="btn btn-dark content_manager_switch switch_icons">
        <div class="">
          <i class="far fa-square"></i>
        </div>
        <div class="">
          <i class="fas fa-square"></i>
        </div>
      </a>

      <a data-action="moneys" data-animate_class="animate__flipInY" data-id="{{id}}" data-elem=".money" data-form="form" href="javascript:;" class="btn btn-dark content_loader_show _edit">
        <i class="fas fa-pen-square"></i>
      </a>

      <a href="#" class="btn btn-dark content_download" data-id="{{id}}" data-action="moneys" data-form="del" data-elem=".money" data-animate_class="animate__fadeOutRightBig"><i class="fas fa-minus-square"></i></a>
    </div>

    <div class="progress">
      <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
    </div>
  </li>
</div>
