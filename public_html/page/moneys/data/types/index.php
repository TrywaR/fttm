<main class="container animate__animated animate__fadeIn pt-4 pb-4">
  <div class="row mb-4">
    <div class="col-12">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Moneys types</h1>
          <p class="lead">Типы затрат</p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col col-12 col-md-6">
      <!-- Карты -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Новый тип</h5>

          <div class="card-body">
            <div class="accordion accordion-flush" id="accordionFlushExampleZero">
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingZero">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseZero" aria-expanded="false" aria-controls="flush-collapseZero">
                    Добавить тип
                  </button>
                </h2>
                <div id="flush-collapseZero" class="accordion-collapse collapse" aria-labelledby="flush-headingZero" data-bs-parent="#accordionFlushExampleZero">
                  <div class="accordion-body">
                    <form class="" action="" method="post">
                      <input type="hidden" name="app" value="app">
                      <input type="hidden" name="action" value="moneys_types">
                      <input type="hidden" name="form" value="save">
                      <input type="hidden" name="user_id" value="<?=$_SESSION['user']['id']?>">

                      <div class="row g-3 align-items-center">
                        <div class="col-auto">
                          <label for="inputCardIdZero" class="col-form-label">Тип</label>
                        </div>
                        <div class="col-auto">
                          <input name="title" type="text" id="inputCardIdZero" class="form-control">
                        </div>
                      </div>

                      <div class="row g-3 align-items-center">
                        <div class="col-auto">
                          <label for="inputPriceIdZero" class="col-form-label">Приоритет</label>
                        </div>
                        <div class="col-auto">
                          <input name="priority" type="number" id="inputPriceIdZero" class="form-control">
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
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- cards -->
  <div class="row mt-4">
    <div class="col">
      <?
        // $sQuery  = "SELECT * FROM `clients`";
        // $sQuery .= " WHERE `active` > 0";
        // $sQuery .= " ORDER BY `sort` ASC";
        // $sQuery .= " LIMIT 20";

        // $arrMoneys = $db->query_all($sQuery);

        $oMoneysType = new moneys_type();
        $oMoneysType->sort = 'sort';
        $arrMoneysTypes = $oMoneysType->get();

        if ( ! count( $arrMoneysTypes ) ) echo 'Нет типов затрат';
      ?>
      <ol class="list-group list-group-numbered">
      <?
      // Прикручиваем рейтинги
      foreach ($arrMoneysTypes as &$arrMoneysType) {
        ?>
        <li class="list-group-item d-flex justify-content-between align-items-start">
          <div class="ms-2 me-auto">
            <div class="fw-bold"><?=$arrMoneysType['title']?></div>
            <div class="badge bg-primary ">
              <?=$arrMoneysType['priority']?>
            </div>
          </div>
          <span class="rounded-pill">
            <a href="#" class="btn">
              <i class="far fa-square"></i>
              <!-- <i class="fas fa-square"></i> -->
            </a>
            <a href="#" class="btn"><i class="fas fa-pen-square"></i></a>
            <a href="#" class="btn content_download" data-id="<?=$arrMoneysType['id']?>" data-action="moneys" data-form="del"><i class="fas fa-minus-square"></i></a>
          </span>
        </li>
        <?
      }
      ?>
      </ol>
    </div>
  </div>
</main>
