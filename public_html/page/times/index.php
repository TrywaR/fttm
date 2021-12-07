<?
$oProject = new project();
$arrProjects = $oProject->get();
$arrProjectsIds = [];
foreach ($arrProjects as $arrProject) $arrProjectsIds[$arrProject['id']] = $arrProject;

$oCategory = new times_category();
$arrCategories = $oCategory->get();
$arrCategoriesIds = [];
foreach ($arrCategories as $arrCategory) $arrCategoriesIds[$arrCategory['id']] = $arrCategory;
?>

<main class="container pt-4 pb-4">
  <div class="row">
    <div class="col-12 mb-4">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Times</h1>

          <p class="lead">
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
            <div class="accordion accordion-flush" id="accordionFlushExample">
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    Spend
                  </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">
                    <form class="" action="" method="post" data-content_download_edit_type="0" data-content_loader_to="#content_loader_to" data-content_loader_template=".template_time">
                      <input type="hidden" name="app" value="app">
                      <input type="hidden" name="action" value="times">
                      <input type="hidden" name="form" value="save">

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
                            <option value="0" selected>No category</option>
                            <?
                            $oTimesCategory = new times_category();
                            $arrTimesCategories = $oTimesCategory->get();
                            // print_r($arrTimesCategories);
                            // die();
                            ?>
                            <?php foreach ($arrTimesCategories as $iIndex => $arrTimesCategory): ?>
                              <?php if ( ! $iIndex ): ?>
                                <option value="<?=$arrTimesCategory['id']?>"><?=$arrTimesCategory['title']?></option>
                              <?php else: ?>
                                <option value="<?=$arrTimesCategory['id']?>"><?=$arrTimesCategory['title']?></option>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>

                      <!-- <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputTimePlanned" class="col-form-label">Time planned</label>
                        </div>
                        <div class="col-12 col-md-4">
                          <input name="time_planned" type="time" lang="en" id="inputTimePlanned" class="form-control">
                        </div>
                      </div> -->

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
                          <label for="inputDate" class="col-form-label">Date</label>
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
                          <select name="project_id" class="form-select" size="3" aria-label="size 3 select example">
                            <option value="0" selected>No project</option>
                            <?
                            $oProject = new project();
                            $arrProjects = $oProject->get();
                            ?>
                            <?php foreach ($arrProjects as $iIndex => $arrProject): ?>
                              <?php if ( ! $iIndex ): ?>
                                <option value="<?=$arrProject['id']?>"><?=$arrProject['title']?></option>
                              <?php else: ?>
                                <option value="<?=$arrProject['id']?>"><?=$arrProject['title']?></option>
                              <?php endif; ?>
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
                        <button type="button" class="btn form_reset"><i class="fas fa-window-close"></i> Clear</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-plus-square"></i> Add</button>
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
      <h2>
        <?
        $dDateReally = new \DateTime();
        echo $dDateReally->format('F j');
        ?>
        <small><?=$dDateReally->format('l')?></small>
      </h2>

      <ol class="list-group list-group-numbered block_content_loader" id="content_loader_to" style="max-height: 80vh; overflow: auto;">
      <?
      $oTime = new time();
      $oTime->where = "`date` LIKE '" . date('Y') . '-' . date('m') . '-' . date('d') . "%'";
      $arrTimes = $oTime->get();

      // Прикручиваем рейтинги
      if ( ! count($arrTimes) ) echo 'Пусто!';
      else foreach ($arrTimes as &$arrTime) {
        ?>
        <li class="list-group-item money d-flex justify-content-between align-items-start" data-content_manager_item_id="<?=$arrTime['id']?>"  data-content_loader_item_id="<?=$arrTime['id']?>">
          <div class="ms-2 me-auto">
            <div class="fw-bold mb-1"><?=$arrTime['title']?></div>
            <div class="badge bg-primary " style="font-size: 1rem; font-weight: normal; background: <?=$arrCategoriesIds[$arrTime['category_id']]['color']?> ! important;">
              <?
              $dDateReally = new DateTime($arrTime['time_really']);
              echo $dDateReally->format('H:i');
              ?>
            </div>
            <small><?=$arrCategoriesIds[$arrTime['category_id']]['title']?> | <?=$arrProjectsIds[$arrTime['project_id']]['title']?></small>
          </div>
          <span class="rounded-pill">
            <?/*
            <a href="#" class="btn content_manager_switch switch_icons">
              <div class="">
                <i class="far fa-square"></i>
              </div>
              <div class="">
                <i class="fas fa-square"></i>
              </div>
            </a>
            <a href="#" class="btn content_download" data-id="<?=$arrTime['id']?>" data-action="moneys" data-elem=".list-group-item" data-form="edit" data-animate_class="animate__flipInY">
              <i class="fas fa-pen-square"></i>
            </a>
            */?>
            <a href="#" class="btn content_download" data-id="<?=$arrTime['id']?>" data-action="times" data-form="del" data-elem=".list-group-item" data-animate_class="animate__fadeOutRightBig"><i class="fas fa-minus-square"></i></a>
          </span>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
          </div>
        </li>
      <?}?>
      </ol>


      <h2 class="mt-4">
        <?
        $dDateReally = new \DateTime( date('d.m.Y',strtotime("-1 days")) );
        echo $dDateReally->format('F j');
        ?>
        <small><?=$dDateReally->format('l')?></small>
      </h2>

      <ol class="list-group list-group-numbered block_content_loader" id="content_loader_to" style="max-height: 80vh; overflow: auto;">
      <?
      $oTime = new time();
      $oTime->where = "`date` LIKE '" . date('Y') . '-' . date('m') . '-' . date('d', strtotime("-1 days")) . "%'";
      $arrTimesУesterday = $oTime->get();

      // Прикручиваем рейтинги
      if ( ! count($arrTimesУesterday) ) echo 'Пусто!';
      else foreach ($arrTimesУesterday as &$arrTime) {
        ?>
        <li class="list-group-item money d-flex justify-content-between align-items-start" data-content_manager_item_id="<?=$arrTime['id']?>"  data-content_loader_item_id="<?=$arrTime['id']?>">
          <div class="ms-2 me-auto">
            <div class="fw-bold mb-1"><?=$arrTime['title']?></div>
            <div class="badge bg-primary " style="font-size: 1rem; font-weight: normal; background: <?=$arrCategoriesIds[$arrTime['category_id']]['color']?> ! important;">
              <?
              $dDateУesterdayReally = new DateTime($arrTime['time_really']);
              echo $dDateУesterdayReally->format('H:i');
              ?>
            </div>
            <small><?=$arrCategoriesIds[$arrTime['category_id']]['title']?> | <?=$arrProjectsIds[$arrTime['project_id']]['title']?></small>
          </div>
          <span class="rounded-pill">
            <?/*
            <a href="#" class="btn content_manager_switch switch_icons">
              <div class="">
                <i class="far fa-square"></i>
              </div>
              <div class="">
                <i class="fas fa-square"></i>
              </div>
            </a>
            <a href="#" class="btn content_download" data-id="<?=$arrTime['id']?>" data-action="moneys" data-elem=".list-group-item" data-form="edit" data-animate_class="animate__flipInY">
              <i class="fas fa-pen-square"></i>
            </a>
            */?>
            <a href="#" class="btn content_download" data-id="<?=$arrTime['id']?>" data-action="times" data-form="del" data-elem=".list-group-item" data-animate_class="animate__fadeOutRightBig"><i class="fas fa-minus-square"></i></a>
          </span>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
          </div>
        </li>
      <?}?>
      </ol>
    </div>
  </div>

  <?/*
  <div class="row">
    <div class="col-12 col-md-5">
      <h2>Добавление</h2>
      <div class="_data">


      </div>
    </div>

    <div id="times_list" class="col-12 col-md-7">
      <h2>Список</h2>
      <div class="_data">
        <!-- Список элементов -->
      </div>
      <div class="_template">
        <!-- Пример элемента -->
      </div>
      <script>
        $(content_loader_init())
      </script>
    </div>
  </div>
  */?>
</main>
