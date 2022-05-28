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
$arrTasks = $oTask->get();
$arrTaskId = [];
foreach ($arrTasks as $arrTask) $arrTaskId[$arrTask['id']] = $arrTask;

$oCategory = new times_category();
$oCategory->sort = 'sort';
$oCategory->sortDir = 'ASC';
$oCategory->query .= ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
$arrCategories = $oCategory->get_categories();
$arrCategoriesIds = [];
foreach ($arrCategories as $arrCategory) $arrCategoriesIds[$arrCategory['id']] = $arrCategory;
?>

<main class="container animate__animated animate__fadeIn">
  <div class="row">
    <?
    // $oSession = new session();
    // // print_r($oSession);
    // // $oSession->set();
    // $arrSes = $oSession->get('226bd87432ceeb480216294e896890a5');
    ?>
    <div class="col-12 mb-4">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Times</h1>

          <p class="lead">
            <h2>
              <?
              $dDateReally = new \DateTime();
              echo $dDateReally->format('F j');
              ?>
              <small><?=$dDateReally->format('l')?></small>
            </h2>
            <span class="icon">
              <i class="far fa-folder"></i>
            </span>
            <a href="/clients/">Clients</a>
            <span class="text_seporator">,</span> <a href="/projects/">Projects</a>
            <span class="text_seporator">,</span> <a href="/times/data/categories/">Times spend categories</a>
            <!--, <a href="/tasks/">задачи</a>. -->
          </p>

          <p class="lead">
            <span class="icon">
              <i class="far fa-chart-bar"></i>
            </span>
            <a href="/times/analytics/costs/">Time spent</a>
            <span class="text_seporator">,</span> <a href="/times/analytics/new/">Time spent (beta)</a>
            <!-- , <a href="/times/analytics/wages/">Приходы времени по категориям</a> -->
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12 col-md-5 mb-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Time</h5>
          <!-- <a href="#" class="btn btn-primary">Добавить</a> -->

          <div class="card-body">
            <!-- <a data-action="times" data-animate_class="animate__flipInY" data-elem=".table_row" data-form="form" href="javascript:;" class="button _icon content_loader_show" title="Потратить время">
              <i class="fas fa-plus-circle"></i>
              <span class="badge badge-warning">Beta</span>
            </a> -->
            <div class="accordion accordion-flush" id="accordionFlushExample">
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    Spend
                  </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">
                    <form
                      class="content_loader_form"
                      action=""
                      method="post"
                      data-content_download_edit_type="0"
                      data-content_loader_to="#content_loader_to"
                      data-content_loader_template=".template_time"
                    >
                      <input type="hidden" name="app" value="app">
                      <input type="hidden" name="action" value="times">
                      <input type="hidden" name="form" value="save">
                      <input type="hidden" name="user_id" value="<?=$_SESSION['user']['id']?>">
                      <input type="hidden" name="id" value="">

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputTitle" class="col-form-label">Title</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <input name="title" type="text" id="inputTitle" class="form-control">
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputDescription" class="col-form-label">Description</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <textarea name="description" rows="8" cols="80" class="form-control"></textarea>
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputProjectId" class="col-form-label">Category id</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <select name="category_id" class="form-select" size="3" aria-label="size 3 select example">
                            <option value="0" selected><?=$olang->get('NoCategory')?></option>
                            <?php foreach ($arrCategories as $iIndex => $arrCategory): ?>
                              <option value="<?=$arrCategory['id']?>"><?=$arrCategory['title']?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputTimeReally" class="col-form-label">Time really</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <input name="time_really" type="time" lang="en" id="inputTimeReally" class="form-control">
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputDate" class="col-form-label"><?=$olang->get('Date')?></label>
                        </div>
                        <div class="col-12 col-md-8">
                          <input name="date" type="date" lang="en" id="inputDate" class="form-control" value="<?=date('Y-m-d')?>">
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputProjectId" class="col-form-label">Project id</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <select name="project_id" id="inputProjectId" class="form-select" size="3">
                            <option value="0" selected><?=$olang->get('NoProject')?></option>
                            <?php foreach ($arrProjects as $iIndex => $arrProject): ?>
                              <option value="<?=$arrProject['id']?>"><?=$arrProject['title']?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputTaskId" class="col-form-label">Task id</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <select name="task_id" id="inputTaskId" class="form-select" size="3" aria-label="size 3 select example">
                            <option value="0" selected><?=$olang->get('NoTask')?></option>
                            <?php foreach ($arrTasks as $iIndex => $arrTask): ?>
                              <option value="<?=$arrTask['id']?>"><?=$arrTask['title']?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputSort" class="col-form-label">Sort</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <input name="sort" type="number" id="inputSort" class="form-control">
                        </div>
                      </div>

                      <div class="d-flex justify-content-between mt-3">
                        <button type="button" class="btn form_reset"><i class="fas fa-window-close"></i> <?=$olang->get('Clear')?></button>
                        <button type="submit" class="btn btn-dark"><i class="fas fa-plus-square"></i> <?=$olang->get('Add')?></button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-7">
      <!-- Фильтр -->
      <form class="content_filter __no_ajax" action="" id="content_filter" data-content_filter_block="#times">
        <div class="input-group mb-2">
          <span class="input-group-text">
            <i class="far fa-folder"></i>
          </span>
          <select name="project_id" class="form-select">
            <option value="" selected>Project</option>
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

        <div class="input-group mb-4">
          <span class="input-group-text">
            <i class="fas fa-list-ul"></i>
          </span>
          <select name="category_id" class="form-select">
            <option value="" selected>Category</option>
            <option value="0"><?=$olang->get('NoCategory')?></option>
            <?php foreach ($arrCategories as $iIndex => $arrCategory): ?>
              <option value="<?=$arrCategory['id']?>"><?=$arrCategory['title']?></option>
            <?php endforeach; ?>
          </select>

          <span class="input-group-text">
            <i class="fas fa-list-ul"></i>
          </span>
          <select name="task_id" class="form-select">
            <option value="" selected>Task</option>
            <?php foreach ($arrTasks as $iIndex => $arrTask): ?>
              <option value="<?=$arrTask['id']?>"><?=$arrTask['title']?></option>
            <?php endforeach; ?>
          </select>

          <button class="btn btn-dark" type="submit">
            <!-- <span class="icon">
              <i class="fas fa-plus"></i>
            </span> -->
            Go
          </button>
        </div>
      </form>

      <div id="content_manager_buttons" class="content_manager_buttons _hide_ d-flex justify-content-end mb-4" data-content_manager_action="times" data-content_manager_block="#times" data-content_manager_item=".list-group-item" data-content_manager_button=".content_manager_switch">
        <button type="button" name="button" class="btn del">
          <i class="fas fa-folder-minus"></i>
        </button>
      </div>

      <ol
        id="times"
        class="block_times block_elems list-group list-group-numbered block_content_loader"
        data-content_loader_table="times"
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
        data-content_loader_scroll_block="#times"
        data-content_loader_show_class="animate__bounceInRight _show_"
        style="max-height: 50vh; overflow: auto; overflow-x: hidden;"
      ></ol>
      <script>
        $(function(){
          $(document).find('#times').content_loader()
          $(document).find('#content_filter').content_filter()
          $(document).find('#content_manager_buttons').content_manager()
        })
      </script>

      <div class="block_template">
        <li class="list-group-item _elem time progress_block animate__animated _category_show_{{category_show}} _project_show_{{project_show}} _task_show_{{task_show}}" data-content_manager_item_id="{{id}}"  data-id="{{id}}">
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
              {{time_really}}
            </div>
            <span class="_title">{{title}}</span>
          </div>

          <span class="rounded-pill">
            <a href="#" class="btn content_manager_switch switch_icons">
              <div class="">
                <i class="far fa-square"></i>
              </div>
              <div class="">
                <i class="fas fa-square"></i>
              </div>
            </a>
            <a href="#" class="btn content_download" data-id="{{id}}" data-action="times" data-elem=".list-group-item" data-form="edit" data-animate_class="animate__flipInY">
              <i class="fas fa-pen-square"></i>
            </a>
            <a href="#" class="btn content_download" data-id="{{id}}" data-action="times" data-form="del" data-elem=".list-group-item" data-animate_class="animate__fadeOutRightBig"><i class="fas fa-minus-square"></i></a>
          </span>

          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
          </div>
        </li>
      </div>
    </div>
  </div>
</main>
