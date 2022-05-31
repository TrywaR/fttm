<?
$oTask = new task();

$oProject = new project();
$oProject->sort = 'sort';
$oProject->sortDir = 'ASC';
$oProject->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
$arrProjects = $oProject->get();
?>
<main class="container pt-4 pb-4">
  <div class="row">
    <div class="col-12  mb-4">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Tasks</h1>

          <p class="lead">
            <span class="icon">
              <i class="far fa-folder"></i>
            </span>
            <a href="/clients/">Clients</a>
            <span class="text_seporator">,</span> <a href="/projects/">Projects</a>
          </p>
        </div>
      </div>
    </div>
  <div>
  <div class="row">
    <div class="col-12 col-md-5">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">New tasks</h5>
          <!-- <a href="#" class="btn btn-primary">Добавить</a> -->

          <div class="card-body">
            <div class="accordion accordion-flush" id="accordionFlushExample">
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    Add tasks
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
                      data-content_loader_template=".template_task"
                    >
                      <input type="hidden" name="app" value="app">
                      <input type="hidden" name="action" value="tasks">
                      <input type="hidden" name="form" value="save">
                      <input type="hidden" name="user_id" value="<?=$_SESSION['user']['id']?>">
                      <input type="hidden" name="id">

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputProject" class="col-form-label">Project id</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <select name="project_id" id="inputProject" class="form-select" size="3" aria-label="size 3 select example">
                            <option value="0" selected><?=$olang->get('NoProject')?></option>
                            <?php foreach ($arrProjects as $iIndex => $arrProject): ?>
                              <option value="<?=$arrProject['id']?>"><?=$arrProject['title']?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputStatus" class="col-form-label">Status</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <select name="status" class="form-select" size="3" aria-label="size 3 select example">
                            <?php foreach ($oTask->arrStatus as $arrStatus): ?>
                              <option value="<?=$arrStatus['id']?>"><?=$arrStatus['name']?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>

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
                          <label for="inputSort" class="col-form-label">Sort</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <input name="sort" type="number" id="inputSort" class="form-control">
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputPricePlanned" class="col-form-label">Price planned</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <input name="price_planned" type="number" lang="en" id="inputPricePlanned" class="form-control">
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputTimePlanned" class="col-form-label">Time planned</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <input name="time_planned" type="time" id="inputTimePlanned" class="form-control">
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
      <form class="content_filter __no_ajax" action="" id="content_filter" data-content_filter_block="#tasks">
        <div class="input-group mb-4">
          <span class="input-group-text">
            <i class="far fa-folder"></i>
          </span>
          <select name="project_id" class="form-select">
            <option value="" selected>Project</option>
            <?php foreach ($arrProjects as $iIndex => $arrProject): ?>
              <option value="<?=$arrProject['id']?>"><?=$arrProject['title']?></option>
            <?php endforeach; ?>
          </select>

          <span class="input-group-text">
            <i class="fas fa-spinner"></i>
          </span>
          <select name="status" class="form-select">
            <?php foreach ($oTask->arrStatus as $arrStatus): ?>
              <option value="<?=$arrStatus['id']?>"><?=$arrStatus['name']?></option>
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

      <div id="content_manager_buttons" class="content_manager_buttons _hide_ d-flex justify-content-end mb-4" data-content_manager_action="tasks" data-content_manager_block="#tasks" data-content_manager_item=".task" data-content_manager_button=".content_manager_switch">
        <button type="button" name="button" class="btn del">
          <i class="fas fa-folder-minus"></i>
        </button>
      </div>

      <div
        id="tasks"
        class="block_tasks block_elems row block_content_loader"
        data-content_loader_table="tasks"
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
        data-content_loader_scroll_block="#tasks"
        data-content_loader_show_class="animate__bounceInRight _show_"
        style="max-height: 60vh; overflow: auto; overflow-x: hidden;"
      ></div>

      <script>
        $(function(){
          $(document).find('#tasks').content_loader()
          $(document).find('#content_filter').content_filter()
          $(document).find('#content_manager_buttons').content_manager()
        })
      </script>
    </div>

    <section class="block_template">
      <div class="col-12 task _elem progress_block animate__animated _time_show_{{time_show}}  _money_show_{{money_show}} _status_show_{{status_show}} _project_show_{{project_show}}" data-content_manager_item_id="{{id}}"  data-id="{{id}}">
        <div class="card w-100 mb-2">
          <div class="card-header position-relative">
            <div class="row">
              <div class="col-6">
                <span class="_title">
                  {{title}}
                </span>

                <div class="badge bg-primary _status">
                  {{status_val}}
                </div>

                <div class="_project">
                  {{project.title}}
                </div>
              </div>

              <div class="col-6 d-flex justify-content-end">
                <a href="#" class="btn content_manager_switch switch_icons">
                  <div class="">
                    <i class="far fa-square"></i>
                  </div>
                  <div class="">
                    <i class="fas fa-square"></i>
                  </div>
                </a>
                <a href="#" class="btn content_download" data-id="{{id}}" data-action="tasks" data-form="edit" data-elem=".task" data-animate_class="animate__flipInY">
                  <i class="fas fa-pen-square"></i>
                </a>
                <a href="#" class="btn content_download" data-id="{{id}}" data-action="tasks" data-form="del" data-elem=".task" data-animate_class="animate__fadeOutRightBig"><i class="fas fa-minus-square"></i></a>
              </div>
            </div>

            <div class="progress">
              <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
            </div>
          </div>

          <div class="card-body">
            <div class="col-12 _sub">
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
            </div>
            <div class="col-12">
              <div class="_description_prev">
                {{description_prev}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</main>
