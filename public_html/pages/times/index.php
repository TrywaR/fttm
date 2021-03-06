<?
$oProject = new project();
$oProject->sort = 'sort';
$oProject->sortDir = 'ASC';
$oProject->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
$arrProjects = $oProject->get();
$arrProjectsIds = [];
foreach ($arrProjects as $arrProject) $arrProjectsIds[$arrProject['id']] = $arrProject;

$oTask = new task();
$oTask->sort = 'sort';
$oTask->sortDir = 'ASC';
$oTask->query .= ' AND `user_id` = ' . $_SESSION['user']['id'];
$oTask->query .= ' AND `status` = 2';
$arrTasks = $oTask->get();
$arrTaskId = [];
foreach ($arrTasks as $arrTask) $arrTaskId[$arrTask['id']] = $arrTask;

$oCategory = new category();
$oCategory->sort = 'sort';
$oCategory->sortDir = 'ASC';
$oCategory->query .= ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
$arrCategories = $oCategory->get_categories();
$arrCategoriesIds = [];
foreach ($arrCategories as $arrCategory) $arrCategoriesIds[$arrCategory['id']] = $arrCategory;
?>

<div class="main_jumbotron">
  <div class="_block_title">
    <h1 class="sub_title _value">
      <?=$oLang->get('Times')?>
    </h1>

    <div class="_buttons btn-group">
      <a class="btn" target="_blank" href="/info/docs/times/">
        <i class="fa-solid fa-circle-info"></i>
      </a>
      <?include 'core/templates/elems/filter_button.php'?>
    </div>
  </div>

  <div class="_block_content" id="shower">
    <!-- Фильтр -->
    <form class="content_filter __no_ajax" action="" id="content_filter" data-content_filter_block="#times" data-content_filter_status="#content_filter_show">
      <div class="input-group mb-2">
        <span class="input-group-text">
          <i class="far fa-folder"></i>
        </span>
        <select name="project_id" class="form-select">
          <option value="" selected><?=$oLang->get('Project')?></option>
          <option value="0"><?=$olang->get('NoProject')?></option>
          <?php foreach ($arrProjects as $iIndex => $arrProject): ?>
            <option value="<?=$arrProject['id']?>"><?=$arrProject['title']?></option>
          <?php endforeach; ?>
        </select>

        <span class="input-group-text">
          <i class="far fa-calendar-alt"></i>
        </span>
        <input type="date" name="date" class="form-control" placeholder="<?=$olang->get('Date')?>" value="">
      </div>

      <div class="input-group">
        <span class="input-group-text">
          <i class="fas fa-list-ul"></i>
        </span>
        <select name="category_id" class="form-select">
          <option value="" selected><?=$oLang->get('Category')?></option>
          <?php foreach ($arrCategories as $iIndex => $arrCategory): ?>
            <option value="<?=$arrCategory['id']?>"><?=$arrCategory['title']?></option>
          <?php endforeach; ?>
        </select>

        <span class="input-group-text">
          <i class="fas fa-list-ul"></i>
        </span>
        <select name="task_id" class="form-select">
          <option value="" selected><?=$oLang->get('Task')?></option>
          <?php foreach ($arrTasks as $iIndex => $arrTask): ?>
            <option value="<?=$arrTask['id']?>"><?=$arrTask['title']?></option>
          <?php endforeach; ?>
        </select>

        <button class="btn btn-dark" type="submit">
          Go
        </button>
      </div>
    </form>
  </div>
</div>

<div class="main_content">
  <div id="content_manager_buttons" class="content_manager_buttons _hide_" data-content_manager_action="times" data-content_manager_block="#times" data-content_manager_item=".list-group-item" data-content_manager_button=".content_manager_switch">
    <button type="button" name="button" class="btn btn-danger del">
      <i class="fas fa-folder-minus"></i>
    </button>
  </div>

  <ol
    id="times"
    class="block_times block_elems list-group list-group-numbered block_content_loader"
    data-content_loader_table="times"
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
    data-content_loader_scroll_block="#times"
    data-content_loader_show_class="_show_"
  ></ol>
  <script>
    $(function(){
      // $(document).find('#times').content_loader()
      $(document).find('#content_filter').content_filter()
      $(document).find('#content_manager_buttons').content_manager()
      $(document).find('#footer_actions').content_actions( {'action':'times'} )
    })
  </script>

</div>

<div class="block_template">
    <li class="list-group-item _elem time progress_block _category_show_{{category_show}} _project_show_{{project_show}} _task_show_{{task_show}}" data-content_manager_item_id="{{id}}"  data-id="{{id}}">
      <div class="ms-2 me-auto">
        <div class="fw-bold">
          <small class="_date">{{date}}</small>
        </div>
        <div class="_subs">
          <small class="_category">{{category.title}}</small>
          <small class="_project">{{project.title}}</small>
          <small class="_task">> {{task.title}}</small>
        </div>
        <div class="badge bg-primary _time" style="font-size: 1rem; font-weight: normal; background: {{category.color}} ! important; margin-right:.5rem;">
          {{time}}
        </div>
        <span class="_title">{{title}}</span>
      </div>

      <span class="btn-group">
        <a href="#" class="btn btn-dark content_manager_switch switch_icons">
          <div class="">
            <i class="far fa-square"></i>
          </div>
          <div class="">
            <i class="fas fa-square"></i>
          </div>
        </a>

        <!-- <a href="#" class="btn content_download" data-id="{{id}}" data-action="times" data-elem=".list-group-item" data-form="edit" data-animate_class="animate__flipInY">
          <i class="fas fa-pen-square"></i>
        </a> -->

        <a data-action="times" data-animate_class="animate__flipInY" data-id="{{id}}" data-elem=".time" data-form="form" href="javascript:;" class="btn btn-dark content_loader_show" title="Time edit">
          <i class="fas fa-pen-square"></i>
        </a>

        <a href="#" class="btn btn-dark content_download" data-id="{{id}}" data-action="times" data-form="del" data-elem=".list-group-item" data-animate_class="animate__fadeOutRightBig"><i class="fas fa-minus-square"></i></a>
      </span>

      <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
      </div>
    </li>
  </div>
