<main class="container pt-4 pb-4">
  <div class="row mb-4">
    <div class="col-12">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Cards</h1>
          <p class="lead">Карты</p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col col-12 col-md-6 mb-4">
      <!-- Добавление карты -->
      <div class="card">
        <div class="card-body">
          <!-- <h5 class="card-title">Новый карт</h5> -->
          <!-- <a href="#" class="btn btn-primary">Добавить</a> -->

          <!-- <div class="card-body"> -->
          <div class="accordion accordion-flush" id="accordionFlushExampleZero">
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingZero">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseZero" aria-expanded="false" aria-controls="flush-collapseZero">
                    Добавить картень
                  </button>
                </h2>
                <div id="flush-collapseZero" class="accordion-collapse collapse" aria-labelledby="flush-headingZero" data-bs-parent="#accordionFlushExampleZero">
                  <div class="accordion-body">
                    <form class="reload_page" action="" method="post">
                      <input type="hidden" name="app" value="app">
                      <input type="hidden" name="action" value="cards">
                      <input type="hidden" name="form" value="save">

                      <!-- <div class="row g-3 align-items-center">
                        <div class="col-auto">
                          <label for="inputProjectIdZero" class="col-form-label">Project id</label>
                        </div>
                        <div class="col-auto">
                          <input name="project_id" type="number" id="inputProjectIdZero" class="form-control">
                        </div>
                      </div>

                      <div class="row g-3 align-items-center">
                        <div class="col-auto">
                          <label for="inputTasksIdZero" class="col-form-label">Client id</label>
                        </div>
                        <div class="col-auto">
                          <input name="tasks_id" type="number" id="inputTasksIdZero" class="form-control">
                        </div>
                      </div> -->

                      <div class="row g-3 align-items-center">
                        <div class="col-auto">
                          <label for="inputCardIdZero" class="col-form-label">Card</label>
                        </div>
                        <div class="col-auto">
                          <input name="title" type="text" id="inputCardIdZero" class="form-control">
                        </div>
                      </div>

                      <div class="row g-3 align-items-center">
                        <div class="col-auto">
                          <label for="inputPriceIdZero" class="col-form-label">Balance</label>
                        </div>
                        <div class="col-auto">
                          <input name="balance" type="number" id="inputPriceIdZero" class="form-control">
                        </div>
                      </div>

                      <div class="row g-3 align-items-center">
                        <div class="col-auto">
                          <label for="inputDateZero" class="col-form-label">Limit</label>
                        </div>
                        <div class="col-auto">
                          <input name="limit" type="number" id="inputDateZero" class="form-control">
                        </div>
                      </div>

                      <div class="row g-3 align-items-center">
                        <div class="col-auto">
                          <label for="inputTitleZero" class="col-form-label">sort</label>
                        </div>
                        <div class="col-auto">
                          <input name="sort" type="number" id="inputTitleZero" class="form-control">
                        </div>
                      </div>

                      <div class="form-check">
                        <input class="form-check-input" name="active" type="checkbox" value="" id="flexCheckChecked" checked>
                        <label class="form-check-label" for="flexCheckChecked">
                          Активность
                        </label>
                      </div>

                      <button type="submit" class="btn btn-primary mt-4"><i class="fas fa-plus-square"></i> Добавить</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          <!-- </div> -->
        </div>
      </div>
    </div>

    <div class="col col-12 col-md-6">
      <!-- Карты -->
      <?
        // $sQuery  = "SELECT * FROM `clients`";
        // $sQuery .= " WHERE `active` > 0";
        // $sQuery .= " ORDER BY `sort` ASC";
        // $sQuery .= " LIMIT 20";

        // $arrMoneys = $db->query_all($sQuery);

        $oCard = new card();
        $arrCards = $oCard->get();

        if ( ! count( $arrCards ) ) echo 'Нет карт';
      ?>
      <ol class="list-group list-group-numbered">
      <?
      // Прикручиваем рейтинги
      foreach ($arrCards as &$arrCard) {
        ?>
        <li class="list-group-item d-flex justify-content-between align-items-start">
          <div class="ms-2 me-auto">
            <div class="fw-bold"><?=$arrCard['title']?></div>
            <div class="badge bg-primary ">
              <?=$arrCard['balance']?>₽
            </div>
            <?=$arrCard['limit']?>
          </div>
          <span class="rounded-pill">
            <?/*
            <a href="#" class="btn">
              <i class="far fa-square"></i>
              <!-- <i class="fas fa-square"></i> -->
            </a>
            <a href="#" class="btn"><i class="fas fa-pen-square"></i></a>
            */?>
            <a href="#" class="btn content_download" data-id="<?=$arrCard['id']?>" data-action="cards" data-form="del" data-elem=".list-group-item"><i class="fas fa-minus-square"></i></a>
          </span>
        </li>
        <?
      }
      ?>
      </ol>
    </div>
  </div>
</main>