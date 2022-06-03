<?
$oCard = new card();
$oCard->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
$arrCards = $oCard->get();

$oTask = new task();
$oTask->sort = 'sort';
$oTask->sortDir = 'ASC';
$oTask->query .= ' AND `user_id` = ' . $_SESSION['user']['id'];
$arrTasks = $oTask->get();
$arrTaskId = [];
foreach ($arrTasks as $arrTask) $arrTaskId[$arrTask['id']] = $arrTask;

$oMoneyCategory = new moneys_category();
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
?>

<main class="container animate__animated animate__fadeIn block_moneys" id="container">
  <section class="row mb-4">
    <div class="col-12">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4 sub_title">Moneys</h1>
          <p class="lead">
            <span class="icon">
              <i class="far fa-folder"></i>
            </span>
            <a href="/moneys/data/cards/">Cards</a>
            <span class="text_seporator">,</span> <a href="/moneys/data/categories/">Moneys spend categories</a>
            <span class="text_seporator">,</span> <a href="/projects/">Projects</a>
            <span class="text_seporator">,</span> <a href="/moneys/data/subscriptions/">Subscriptions</a>
          </p>
          <p class="lead">
            <span class="icon">
              <i class="far fa-chart-bar"></i>
            </span>
            <a href="/moneys/analytics/">Analytics</a>
            <span class="text_seporator">:</span>
            <a href="/moneys/analytics/costs/">Costs</a>
            <span class="text_seporator">,</span> <a href="/moneys/analytics/wages/">Wages</a>
          </p>
        </div>
      </div>
    </div>
  </section>

  <section class="row">
    <div class="col col-12 col-md-5">
      <!-- Затраты -->
      <div class="card mb-4">
        <div class="card-body">
          <!-- <h5 class="card-title">Новый затрат</h5> -->
          <!-- <a href="#" class="btn btn-primary">Добавить</a> -->

          <!-- <div class="card-body"> -->
          <div class="accordion accordion-flush" id="accordionFlushExampleZero">
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingZero">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseZero" aria-expanded="false" aria-controls="flush-collapseZero">
                    <?=$olang->get('Spend')?>
                  </button>
                </h2>
                <div id="flush-collapseZero" class="accordion-collapse collapse" aria-labelledby="flush-headingZero" data-bs-parent="#accordionFlushExampleZero">
                  <div class="accordion-body">
                    <form
                      class="content_loader_form"
                      action=""
                      method="post"
                      data-content_download_edit_type="0"
                    >
                      <input type="hidden" name="app" value="app">
                      <input type="hidden" name="action" value="moneys">
                      <input type="hidden" name="form" value="save">
                      <input type="hidden" name="type" value="0">
                      <input type="hidden" name="id" value="">
                      <input type="hidden" name="user_id" value="<?=$_SESSION['user']['id']?>">

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputCardIdZero" class="col-form-label">Card</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <select name="card" class="form-select" size="3" aria-label="size 3 select example">
                            <?php foreach ($arrCards as $iIndex => $arrCard): ?>
                              <?php if ( $iIndex == 0 ): ?>
                                <option selected="selected" value="<?=$arrCard['id']?>"><?=$arrCard['title']?></option>
                              <?php else: ?>
                                <option value="<?=$arrCard['id']?>"><?=$arrCard['title']?></option>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputTypeIdZero" class="col-form-label">Category</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <select name="category" class="form-select" size="3" aria-label="size 3 select example">
                            <?php foreach ($arrMoneysCategories as $iIndex => $arrMoneyCategory): ?>
                              <option value="<?=$arrMoneyCategory['id']?>"><?=$arrMoneyCategory['title']?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputCardId" class="col-form-label">To card</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <select name="to_card" class="form-select" size="3" aria-label="size 3 select example">
                            <option value="0" selected>...</option>
                            <?php foreach ($arrCards as $iIndex => $arrCard): ?>
                              <option value="<?=$arrCard['id']?>"><?=$arrCard['title']?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputProjectId" class="col-form-label">Project id</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <select name="project_id" class="form-select" size="3" aria-label="size 3 select example">
                            <option value="0" selected>...</option>
                            <?php foreach ($arrProjects as $iIndex => $arrProject): ?>
                              <option value="<?=$arrProject['id']?>"><?=$arrProject['title']?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputProjectId" class="col-form-label"><?=$olang->get('Subscription')?></label>
                        </div>
                        <div class="col-12 col-md-8">
                          <select name="subscription" class="form-select" size="3" aria-label="size 3 select example">
                            <option value="0" selected>...</option>
                            <?php foreach ($arrMoneysSubscriptions as $iIndex => $arrMoneysSubscription): ?>
                              <option value="<?=$arrMoneysSubscription['id']?>"><?=$arrMoneysSubscription['title']?></option>
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
                            <option value="0" selected>...</option>
                            <?php foreach ($arrTasks as $iIndex => $arrTask): ?>
                              <option value="<?=$arrTask['id']?>"><?=$arrTask['title']?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputDateZero" class="col-form-label">Date</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <input name="date" type="date" value="<?=date('Y-m-d')?>" id="inputDateZero" class="form-control">
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputPriceIdZero" class="col-form-label">Price</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <input name="price" type="number" step="any" lang="en" id="inputPriceIdZero" class="form-control">
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputTitleZero" class="col-form-label">Title</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <input name="title" type="text" id="inputTitleZero" class="form-control">
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
          <!-- </div> -->
        </div>
      </div>
      <!-- Получение -->
      <div class="card mb-4">
        <div class="card-body">
          <!-- <h5 class="card-title">Новый приход</h5> -->
          <!-- <a href="#" class="btn btn-primary">Добавить</a> -->

          <!-- <div class="card-body"> -->
          <div class="accordion accordion-flush" id="accordionFlushExample">
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    <?=$olang->get('Replenish')?>
                  </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">
                    <form
                      class="content_loader_form"
                      action=""
                      method="post"
                      data-content_download_edit_type="1"
                    >
                      <input type="hidden" name="app" value="app">
                      <input type="hidden" name="action" value="moneys">
                      <input type="hidden" name="form" value="save">
                      <input type="hidden" name="type" value="1">
                      <input type="hidden" name="id" value="">
                      <input type="hidden" name="user_id" value="<?=$_SESSION['user']['id']?>">

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputCardId" class="col-form-label">Card</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <select name="card" class="form-select" size="3" aria-label="size 3 select example">
                            <?php foreach ($arrCards as $iIndex => $arrCard): ?>
                              <?php if ( $iIndex == 0 ): ?>
                                <option selected="selected" value="<?=$arrCard['id']?>"><?=$arrCard['title']?></option>
                              <?php else: ?>
                                <option value="<?=$arrCard['id']?>"><?=$arrCard['title']?></option>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputTypeIdZero" class="col-form-label">Category</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <select name="category" class="form-select" size="3" aria-label="size 3 select example">
                            <?php foreach ($arrMoneysCategories as $iIndex => $arrMoneyCategory): ?>
                              <?php if ( $arrMoneyCategory['id'] == 5 ): ?>
                                <option selected="selected" value="<?=$arrMoneyCategory['id']?>"><?=$arrMoneyCategory['title']?></option>
                              <?php else: ?>
                                <option value="<?=$arrMoneyCategory['id']?>"><?=$arrMoneyCategory['title']?></option>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputProjectId" class="col-form-label">Project id</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <select name="project_id" class="form-select" size="3" aria-label="size 3 select example">
                            <option value="0" selected>...</option>
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
                            <option value="0" selected>...</option>
                            <?php foreach ($arrTasks as $iIndex => $arrTask): ?>
                              <option value="<?=$arrTask['id']?>"><?=$arrTask['title']?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputDate" class="col-form-label">Date</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <input name="date" type="date" value="<?=date('Y-m-d')?>" id="inputDate" class="form-control">
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputPriceId" class="col-form-label">Price</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <input name="price" type="number" step="any" lang="en" id="inputPriceId" class="form-control">
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

                      <div class="d-flex justify-content-between mt-3">
                        <button type="button" class="btn form_reset"><i class="fas fa-window-close"></i> <?=$olang->get('Clear')?></button>
                        <button type="submit" class="btn btn-dark"><i class="fas fa-plus-square"></i> <?=$olang->get('Add')?></button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          <!-- </div> -->
        </div>
      </div>
    </div>

    <div class="col col-12 col-md-7">
      <!-- Фильтр -->
      <form class="content_filter __no_ajax" action="" id="content_filter" data-content_filter_block="#moneys">
        <div class="input-group mb-2">
          <span class="input-group-text">
            <i class="fas fa-wallet"></i>
          </span>
          <select name="type" class="form-select">
            <option value="" selected>Type</option>
            <option value="0"><?=$olang->get('Spend')?></option>
            <option value="1"><?=$olang->get('Replenish')?></option>
          </select>

          <span class="input-group-text">
            <i class="far fa-credit-card"></i>
          </span>
          <select name="card" class="form-select">
            <option value="" selected>Card</option>
            <?php foreach ($arrCards as $iIndex => $arrCard): ?>
              <option value="<?=$arrCard['id']?>"><?=$arrCard['title']?></option>
            <?php endforeach; ?>
          </select>

          <span class="input-group-text">
            <i class="fas fa-list-ul"></i>
          </span>
          <select name="category" class="form-select">
            <option value="" selected>Category</option>
            <?php foreach ($arrMoneysCategories as $iIndex => $arrMoneyCategory): ?>
              <option value="<?=$arrMoneyCategory['id']?>"><?=$arrMoneyCategory['title']?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="input-group mb-4">
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
            <i class="fas fa-wrench"></i>
          </span>
          <select name="task_id" class="form-select">
            <option value="" selected>Task</option>
            <?php foreach ($arrTasks as $iIndex => $arrTask): ?>
              <option value="<?=$arrTask['id']?>"><?=$arrTask['title']?></option>
            <?php endforeach; ?>
          </select>

          <span class="input-group-text">
            <i class="far fa-calendar-alt"></i>
          </span>
          <input type="date" name="date" class="form-control" placeholder="<?=$olang->get('Date')?>" value="">

          <button class="btn btn-dark" type="submit">
            <!-- <span class="icon">
              <i class="fas fa-plus"></i>
            </span> -->
            Go
          </button>
        </div>
      </form>

      <div id="content_manager_buttons" class="content_manager_buttons _hide_ d-flex justify-content-end mb-4" data-content_manager_action="moneys" data-content_manager_block="#moneys" data-content_manager_item=".list-group-item" data-content_manager_button=".content_manager_switch">
        <button type="button" name="button" class="btn del">
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
        style="max-height: 50vh; overflow: auto; overflow-x: hidden;"
      ></ol>
      <script>
        $(function(){
          $(document).find('#moneys').content_loader()
          $(document).find('#content_filter').content_filter()
          $(document).find('#content_manager_buttons').content_manager()
        })
      </script>
    </div>
  </section>

  <section class="block_template">
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
            <small class="_task">> {{task.title}}</small>
          </div>
        </div>
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
        <a href="#" class="btn content_download" data-id="{{id}}" data-action="moneys" data-form="edit" data-elem=".list-group-item" data-animate_class="animate__flipInY">
          <i class="fas fa-pen-square"></i>
        </a>
        <a href="#" class="btn content_download" data-id="{{id}}" data-action="moneys" data-form="del" data-elem=".list-group-item" data-animate_class="animate__fadeOutRightBig"><i class="fas fa-minus-square"></i></a>
      </span>

      <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
      </div>
    </li>
  </section>
</main>
