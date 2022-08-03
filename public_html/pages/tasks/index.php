<?
$oTask = new task();

$oProject = new project();
$oProject->sort = 'sort';
$oProject->sortDir = 'ASC';
$oProject->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
$arrProjects = $oProject->get();
?>

<div class="main_jumbotron">
  <div class="_block_title">
    <h1 class="sub_title _value">
      <?=$oLang->get('Tasks')?>
    </h1>

    <div class="_buttons btn-group">
      <a class="btn" target="_blank" href="/info/docs/tasks/">
        <i class="fa-solid fa-circle-info"></i>
      </a>
      <?include 'core/templates/elems/filter_button.php'; # Кнопка фильтрации?>
    </div>
  </div>

  <div class="_block_content" id="shower">
    <!-- Фильтр -->
    <form class="content_filter __no_ajax" action="" id="content_filter" data-content_filter_block="#tasks" data-content_filter_status="#content_filter_show">
      <div class="input-group">
        <span class="input-group-text">
          <i class="fa-solid fa-folder-tree"></i>
        </span>
        <select name="project_id" class="form-select">
          <option value="0" selected><?=$oLang->get('Project')?></option>
          <?php foreach ($arrProjects as $iIndex => $arrProject): ?>
            <?php if ( $_REQUEST['project_id'] && $_REQUEST['project_id'] == $arrProject['id'] ): ?>
              <option selected="selected" value="<?=$arrProject['id']?>"><?=$arrProject['title']?></option>
            <?php else: ?>
              <option value="<?=$arrProject['id']?>"><?=$arrProject['title']?></option>
            <?php endif; ?>
          <?php endforeach; ?>
        </select>

        <span class="input-group-text">
          <i class="fas fa-spinner"></i>
        </span>
        <select name="status" class="form-select">
          <?php foreach ($oTask->arrStatus as $arrStatus): ?>
            <?php if ( $_REQUEST['status'] && $_REQUEST['status'] == $arrStatus['id'] ): ?>
              <option selected="selected" value="<?=$arrStatus['id']?>"><?=$arrStatus['name']?></option>
            <?php else: ?>
              <option value="<?=$arrStatus['id']?>"><?=$arrStatus['name']?></option>
            <?php endif; ?>
          <?php endforeach; ?>
        </select>

        <button class="btn btn-dark" type="submit">
          Go
        </button>
      </div>
    </form>
  </div>
</div>

<section class="main_content">
  <div id="content_manager_buttons" class="content_manager_buttons _hide_" data-content_manager_action="tasks" data-content_manager_block="#tasks" data-content_manager_item=".task" data-content_manager_button=".content_manager_switch">
    <button type="button" name="button" class="btn btn-danger del">
      <i class="fas fa-folder-minus"></i>
    </button>
  </div>

  <div
    id="tasks"
    class="block_tasks block_elems block_content_loader"
    data-content_loader_table="tasks"
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
    data-content_loader_scroll_block="#tasks"
    data-content_loader_show_class="_show_"
  ></div>

  <script>
    $(function(){
      // $(document).find('#tasks').content_loader()
      $(document).find('#content_filter').content_filter()
      $(document).find('#content_manager_buttons').content_manager()
      $(document).find('#footer_actions').content_actions( {'action':'tasks'} )
    })
  </script>
</section>

<section class="block_template">
  <div class="task _elem progress_block _time_show_{{time_show}} _description_show_{{description_show}}  _money_show_{{money_show}} _status_show_{{status_show}} _project_show_{{project_show}}" data-content_manager_item_id="{{id}}"  data-id="{{id}}">
    <div class="card w-100">
      <div class="card-header position-relative">
        <div class="row">
          <div class="col-12 col-md-8 d-flex align-items-center">
            <span class="_title">
              {{title}}
              <small>
                #{{id}}
              </small>
            </span>
          </div>

          <div class="col-12 col-md-4 d-flex justify-content-end">
            <div class="btn-group">
              <a href="#" class="btn content_manager_switch switch_icons">
                <div class="">
                  <i class="far fa-square"></i>
                </div>
                <div class="">
                  <i class="fas fa-square"></i>
                </div>
              </a>

              <a data-action="tasks" data-animate_class="animate__flipInY" data-id="{{id}}" data-elem=".task" data-form="form" href="javascript:;" class="btn content_loader_show _edit">
                <i class="fas fa-pen-square"></i>
              </a>

              <a href="#" class="btn content_download" data-id="{{id}}" data-action="tasks" data-form="del" data-elem=".task" data-animate_class="animate__fadeOutRightBig"><i class="fas fa-minus-square"></i></a>
            </div>
          </div>
        </div>

        <div class="progress">
          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
        </div>
      </div>

      <div class="card-body">
        <div class="_sub">
          <div class="_status" style="background: {{status_color}}">
            {{status_val}}
          </div>

          <div class="_project">
            {{project.title}}
          </div>

          <div class="_time">
            <small><i class="fas fa-clock"></i></small>
            {{time_really}} <span>/</span>
            <small>{{time_planned}}</small>
          </div>

          <div class="_money">
            <small><i class="fas fa-wallet"></i></small>
            {{price_really}} <span>/</span>
            <small>{{price_planned}}</small>
          </div>

          <button type="button" class="btn _description_show" name="button" data-shower="#desc_{{id}}" data-shower_class="animate__fadeIn">
            <i class="fa-solid fa-align-left"></i>
          </button>
        </div>

        <div class="_description_prev animate__animated" id="desc_{{id}}">
          {{description_prev}}
        </div>
      </div>
    </div>
  </div>
</section>
