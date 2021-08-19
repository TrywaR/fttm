<main class="container pt-4 pb-4">
  <div class="row">
    <div class="col-12  mb-4">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Projects</h1>
          <p class="lead">Проекты</p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col col-md-4 mb-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Новый проект</h5>
          <!-- <a href="#" class="btn btn-primary">Добавить</a> -->

          <div class="card-body">
            <div class="accordion accordion-flush" id="accordionFlushExample">
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    Новый проект
                  </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">
                    <form class="" action="" method="post">
                      <input type="hidden" name="app" value="app">
                      <input type="hidden" name="action" value="projects">
                      <input type="hidden" name="form" value="save">

                      <div class="row g-3 align-items-center">
                        <div class="col-auto">
                          <label for="inputClientId" class="col-form-label">Client id</label>
                        </div>
                        <div class="col-auto">
                          <input name="client_id" type="number" id="inputClientId" class="form-control">
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

    <?
    // $sQuery  = "SELECT * FROM `clients`";
    // $sQuery .= " WHERE `active` > 0";
    // $sQuery .= " ORDER BY `sort` ASC";
    // $sQuery .= " LIMIT 20";

    // $arrProjects = $db->query_all($sQuery);

    $oProject = new project();
    $arrProjects = $oProject->get();

    // Прикручиваем рейтинги
    foreach ($arrProjects as &$arrProject) {
      ?>
      <div class="col col-md-4 mb-4">
        <div class="card">
          <div class="card-body">
            <small>№<?=$arrProject['sort']?></small>
            <small>#<?=$arrProject['id']?></small>
            <h5 class="card-title"><?=$arrProject['title']?></h5>
            <p class="card-text"><?=$arrProject['description']?></p>
            <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
            <a href="#" class="btn">
              <i class="far fa-square"></i>
              <!-- <i class="fas fa-square"></i> -->
            </a>
            <a href="#" class="btn"><i class="fas fa-external-link-square-alt"></i></a>
            <a href="#" class="btn"><i class="fas fa-chart-area"></i></a>
            <a href="#" class="btn content_download" data-id="<?=$arrProject['id']?>" data-action="projects" data-form="del" data-elem=".col">
              <i class="fas fa-minus-square"></i>
            </a>
          </div>
        </div>
      </div>
      <?
    }
    ?>
  </div>
</main>
