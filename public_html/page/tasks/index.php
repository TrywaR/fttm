<main class="container pt-4 pb-4">
  <div class="row">
    <div class="col-12  mb-4">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Tasks</h1>
          <p class="lead">Задачи по проектам</p>
        </div>
      </div>
    </div>
  <div>
  <div class="row">
    <div class="col-12 col-md-5">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Новый таск</h5>
          <!-- <a href="#" class="btn btn-primary">Добавить</a> -->

          <div class="card-body">
            <div class="accordion accordion-flush" id="accordionFlushExample">
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    Добавить таск
                  </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">
                    <form class="" action="" method="post" data-content_download_edit_type="0" data-content_loader_to="#content_loader_to" data-content_loader_template=".template_money">
                      <input type="hidden" name="app" value="app">
                      <input type="hidden" name="action" value="tasks">
                      <input type="hidden" name="form" value="save">

                      <div class="row g-3 align-items-center">
                        <div class="col-auto">
                          <label for="inputProjectId" class="col-form-label">Project id</label>
                        </div>
                        <div class="col-auto">
                          <select name="project_id" class="form-select" size="3" aria-label="size 3 select example">
                            <option value="0" selected>Без проекта</option>
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

                      <div class="row g-3 align-items-center">
                        <div class="col-auto">
                          <label for="inputStatus" class="col-form-label">Status</label>
                        </div>
                        <div class="col-auto">
                          <select name="status" class="form-select" size="3" aria-label="size 3 select example">
                            <option value="0" selected>В планах</option>
                            <option value="1">В работе</option>
                            <option value="2">Сделанно</option>
                          </select>
                        </div>
                      </div>

                      <div class="row g-3 align-items-center">
                        <div class="col-auto">
                          <label for="inputSort" class="col-form-label">Sort</label>
                        </div>
                        <div class="col-auto">
                          <input name="sort" type="number" id="inputSort" class="form-control">
                        </div>
                      </div>

                      <div class="row g-3 align-items-center">
                        <div class="col-auto">
                          <label for="inputTitle" class="col-form-label">Title</label>
                        </div>
                        <div class="col-auto">
                          <input name="title" type="text" id="inputTitle" class="form-control">
                        </div>
                      </div>

                      <div class="row g-3 align-items-center">
                        <div class="col-auto">
                          <label for="inputPricePlanned" class="col-form-label">Price planned</label>
                        </div>
                        <div class="col-auto">
                          <input name="prace_planned" type="number" lang="en" id="inputPricePlanned" class="form-control">
                        </div>
                      </div>

                      <div class="row g-3 align-items-center">
                        <div class="col-auto">
                          <label for="inputPriceReally" class="col-form-label">Price really</label>
                        </div>
                        <div class="col-auto">
                          <input name="prace_really" type="number" lang="en" id="inputPriceReally" class="form-control">
                        </div>
                      </div>

                      <div class="row g-3 align-items-center">
                        <div class="col-auto">
                          <label for="inputTimePlanned" class="col-form-label">Time planned</label>
                        </div>
                        <div class="col-auto">
                          <input name="time_planned" type="time" id="inputTimePlanned" class="form-control">
                        </div>
                      </div>

                      <div class="row g-3 align-items-center">
                        <div class="col-auto">
                          <label for="inputTimeReally" class="col-form-label">Time really</label>
                        </div>
                        <div class="col-auto">
                          <input name="time_really" type="time" id="inputTimeReally" class="form-control">
                        </div>
                      </div>

                      <div class="row g-3 align-items-center">
                        <div class="col-auto">
                          <label for="inputDescription" class="col-form-label">Description</label>
                        </div>
                        <div class="col-auto">
                          <textarea name="description" rows="8" cols="80" class="form-control"></textarea>
                        </div>
                      </div>

                      <button type="submit" class="btn btn-primary mt-4"><i class="fas fa-plus-square"></i> Добавить</button>
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
      <?
      $oTask = new task();
      $arrTasks = $oTask->get();

      // Прикручиваем рейтинги
      if ( ! count($arrTasks) ) echo 'Пусто!';
      foreach ($arrTasks as &$arrTask) {
        ?>
        <div class="card" data-content_manager_item_id="<?=$arrTask['id']?>"  data-content_loader_item_id="<?=$arrTask['id']?>">
          <div class="card-body">
            <small>№<?=$arrTask['sort']?></small>
            <small>#<?=$arrTask['id']?></small>
            <h5 class="card-title"><?=$arrTask['title']?></h5>
            <p class="card-text"><?=$arrTask['description']?></p>
            <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
            <a href="#" class="btn">
              <i class="far fa-square"></i>
              <!-- <i class="fas fa-square"></i> -->
            </a>
            <a href="#" class="btn"><i class="fas fa-external-link-square-alt"></i></a>
            <a href="#" class="btn"><i class="fas fa-chart-area"></i></a>
            <a href="#" class="btn content_download" data-id="<?=$arrTask['id']?>" data-action="tasks" data-elem=".card" data-form="edit" data-animate_class="animate__flipInY">
              <i class="fas fa-pen-square"></i>
            </a>
            <a href="#" class="btn content_download" data-id="<?=$arrTask['id']?>" data-action="tasks" data-form="del" data-elem=".card"><i class="fas fa-minus-square"></i></a>
          </div>
        </div>
        <?
      }
      ?>
    </div>
  </div>
</main>
