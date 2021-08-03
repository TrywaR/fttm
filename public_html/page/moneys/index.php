<main class="container pt-4 pb-4">
  <div class="row">
    <div class="col-12">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Moneys</h1>
          <p class="lead">Финансы</p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col col-12 col-md-6">
      <div class="col col-md-12 mb-12">
        <!-- Получение -->
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Новый получ</h5>
            <!-- <a href="#" class="btn btn-primary">Добавить</a> -->

            <div class="card-body">
              <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                      Добавить получ
                    </button>
                  </h2>
                  <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                      <form class="" action="" method="post">
                        <input type="hidden" name="app" value="app">
                        <input type="hidden" name="action" value="moneys">
                        <input type="hidden" name="form" value="save">

                        <div class="row g-3 align-items-center">
                          <div class="col-auto">
                            <label for="inputProjectId" class="col-form-label">Project id</label>
                          </div>
                          <div class="col-auto">
                            <input name="project_id" type="number" id="inputProjectId" class="form-control">
                          </div>
                        </div>

                        <div class="row g-3 align-items-center">
                          <div class="col-auto">
                            <label for="inputTasksId" class="col-form-label">Client id</label>
                          </div>
                          <div class="col-auto">
                            <input name="tasks_id" type="number" id="inputTasksId" class="form-control">
                          </div>
                        </div>

                        <div class="row g-3 align-items-center">
                          <div class="col-auto">
                            <label for="inputCardId" class="col-form-label">Card</label>
                          </div>
                          <div class="col-auto">
                            <input name="card" type="number" id="inputCardId" class="form-control">
                          </div>
                        </div>

                        <div class="row g-3 align-items-center">
                          <div class="col-auto">
                            <label for="inputPriceId" class="col-form-label">Price</label>
                          </div>
                          <div class="col-auto">
                            <input name="price" type="number" id="inputPriceId" class="form-control">
                          </div>
                        </div>

                        <div class="row g-3 align-items-center">
                          <div class="col-auto">
                            <label for="inputDate" class="col-form-label">Date</label>
                          </div>
                          <div class="col-auto">
                            <input name="date" type="date" value="<?=date('Y-m-d')?>" id="inputDate" class="form-control">
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

    <div class="col col-12 col-md-6">
      <!-- Затраты -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Новый затрат</h5>
          <!-- <a href="#" class="btn btn-primary">Добавить</a> -->

          <div class="card-body">
            <div class="accordion accordion-flush" id="accordionFlushExampleZero">
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingZero">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseZero" aria-expanded="false" aria-controls="flush-collapseZero">
                    Добавить затрат
                  </button>
                </h2>
                <div id="flush-collapseZero" class="accordion-collapse collapse" aria-labelledby="flush-headingZero" data-bs-parent="#accordionFlushExampleZero">
                  <div class="accordion-body">
                    <form class="" action="" method="post">
                      <input type="hidden" name="app" value="app">
                      <input type="hidden" name="action" value="moneys">
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
                          <input name="card" type="number" id="inputCardIdZero" class="form-control">
                        </div>
                      </div>

                      <div class="row g-3 align-items-center">
                        <div class="col-auto">
                          <label for="inputPriceIdZero" class="col-form-label">Price</label>
                        </div>
                        <div class="col-auto">
                          <input name="price" type="number" id="inputPriceIdZero" class="form-control">
                        </div>
                      </div>

                      <div class="row g-3 align-items-center">
                        <div class="col-auto">
                          <label for="inputDateZero" class="col-form-label">Date</label>
                        </div>
                        <div class="col-auto">
                          <input name="date" type="date" value="<?=date('Y-m-d')?>" id="inputDateZero" class="form-control">
                        </div>
                      </div>

                      <div class="row g-3 align-items-center">
                        <div class="col-auto">
                          <label for="inputTitleZero" class="col-form-label">Title</label>
                        </div>
                        <div class="col-auto">
                          <input name="title" type="text" id="inputTitleZero" class="form-control">
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
  </div>
  <div class="row mt-4">
    <div class="col">
      <ol class="list-group list-group-numbered">
      <?
      // $sQuery  = "SELECT * FROM `clients`";
      // $sQuery .= " WHERE `active` > 0";
      // $sQuery .= " ORDER BY `sort` ASC";
      // $sQuery .= " LIMIT 20";

      // $arrMoneys = $db->query_all($sQuery);

      $oMoney = new money();
      $arrMoneys = $oMoney->get();

      // Прикручиваем рейтинги
      foreach ($arrMoneys as &$arrMoney) {
        ?>
        <li class="list-group-item d-flex justify-content-between align-items-start">
          <div class="ms-2 me-auto">
            <div class="fw-bold"><?=$arrMoney['title']?></div>
            <div class="badge bg-primary ">
              <?=$arrMoney['price']?>₽
            </div>
            <?=$arrMoney['date']?>
          </div>
          <span class="rounded-pill">
            <a href="#" class="btn btn-light">
              <i class="far fa-square"></i>
              <!-- <i class="fas fa-square"></i> -->
            </a>
            <a href="#" class="btn btn-light"><i class="fas fa-pen-square"></i></a>
            <a href="#" class="btn btn-light content_download" data-id="<?=$arrMoney['id']?>" data-action="moneys" data-form="del"><i class="fas fa-minus-square"></i></a>
          </span>
        </li>
        <?
      }
      ?>
      </ol>
    </div>
  </div>
</main>
