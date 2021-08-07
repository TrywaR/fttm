<main class="container pt-4 pb-4" id="container">
  <div class="row mb-4">
    <div class="col-12">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Moneys</h1>
          <p class="lead">
            Финансы, <a href="/cards/">Карты</a>
          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col col-12 col-md-6">
      <div class="col col-md-12 mb-12">
        <!-- Получение -->
        <div class="card animate__animated animate__pulse">
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
                            <select name="card" class="form-select" size="3" aria-label="size 3 select example">
                              <?
                              $oCard = new card();
                              $arrCards = $oCard->get();
                              ?>
                              <?php foreach ($arrCards as $iIndex => $arrCard): ?>
                                <?php if ( ! $iIndex ): ?>
                                  <option selected value="<?=$arrCard['id']?>"><?=$arrCard['title']?></option>
                                <?php else: ?>
                                  <option value="<?=$arrCard['id']?>"><?=$arrCard['title']?></option>
                                <?php endif; ?>
                              <?php endforeach; ?>
                            </select>
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
                            <label for="inputPriceId" class="col-form-label">Price</label>
                          </div>
                          <div class="col-auto">
                            <input name="price" type="number" id="inputPriceId" class="form-control">
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
      <div class="card animate__animated animate__pulse animate__delay-1s">
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
                    <form class="content_loader_form" action="" method="post" data-content_loader_to="#content_loader_to" data-content_loader_template=".template_money">
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
                          <select name="card" class="form-select" size="3" aria-label="size 3 select example">
                            <?
                            $oCard = new card();
                            $arrCards = $oCard->get();
                            ?>
                            <?php foreach ($arrCards as $iIndex => $arrCard): ?>
                              <?php if ( ! $iIndex ): ?>
                                <option selected value="<?=$arrCard['id']?>"><?=$arrCard['title']?></option>
                              <?php else: ?>
                                <option value="<?=$arrCard['id']?>"><?=$arrCard['title']?></option>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          </select>
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
                          <label for="inputPriceIdZero" class="col-form-label">Price</label>
                        </div>
                        <div class="col-auto">
                          <input name="price" type="number" id="inputPriceIdZero" class="form-control">
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
      <?
      // $sQuery  = "SELECT * FROM `clients`";
      // $sQuery .= " WHERE `active` > 0";
      // $sQuery .= " ORDER BY `sort` ASC";
      // $sQuery .= " LIMIT 20";

      // $arrMoneys = $db->query_all($sQuery);

      $oMoney = new money();
      $oMoney->limit = 10;
      $oMoney->sort = 'id';
      $oMoney->sortDir = 'DESC';
      $arrMoneys = $oMoney->get();

      if ( ! count( $arrMoneys ) ) echo 'Нет затрат или поступлений';
      ?>
      <div class="content_manager_action d-flex justify-content-end mb-4">
        <button type="button" name="button" class="btn delete">
          <i class="fas fa-folder-minus"></i>
        </button>
      </div>
      <ol class="list-group list-group-numbered block_content_loader" id="content_loader_to">
      <?
      // Прикручиваем рейтинги
      foreach ($arrMoneys as &$arrMoney) {
        ?>
        <li class="list-group-item content_manager_item d-flex justify-content-between align-items-start animate__animated animate__bounceInRight animate__delay-2s" data-content_manager_id="<?=$arrMoney['id']?>">
          <div class="ms-2 me-auto">
            <div class="fw-bold"><?=$arrMoney['title']?></div>
            <div class="badge bg-primary ">
              <?=$arrMoney['price']?>₽
            </div>
            <?=$arrMoney['date']?>
          </div>
          <span class="rounded-pill">
            <!-- <a href="#" class="btn content_manager_switch">
              <div class="switch_icons">
                <div class="">
                  <i class="far fa-square"></i>
                </div>
                <div class="">
                  <i class="fas fa-square"></i>
                </div>
              </div>
            </a> -->
            <a href="#" class="btn">
              <i class="fas fa-pen-square"></i>
            </a>
            <a href="#" class="btn content_download" data-id="<?=$arrMoney['id']?>" data-action="moneys" data-form="del" data-elem=".list-group-item" data-animate_class="animate__fadeOutRightBig"><i class="fas fa-minus-square"></i></a>
          </span>
        </li>
        <?
      }
      ?>
      </ol>
      <div class="mt-4 text-center">
        <button type="button" class="btn btn-primary btn-sm content_loader" data-content_loader_action="moneys" data-content_loader_form="show" data-content_loader_to="#content_loader_to" data-content_loader_from="10" data-content_loader_limit="10" data-content_loader_template=".template_money" data-content_loader_position="1">Load</button>
      </div>
    </div>
  </div>

  <div class="block_template">
    <div class="template_money">
      <li class="list-group-item d-flex justify-content-between align-items-start animate__animated animate__bounceInRight">
        <div class="ms-2 me-auto">
          <div class="fw-bold">{{title}}</div>
          <div class="badge bg-primary">
            <span>{{price}}</span>₽
          </div>
          <span>{{date}}</span>
        </div>
        <span class="rounded-pill">
          <a href="#" class="btn">
            <i class="far fa-square"></i>
            <!-- <i class="fas fa-square"></i> -->
          </a>
          <a href="#" class="btn"><i class="fas fa-pen-square"></i></a>
          <a href="#" class="btn content_download" data-id="{{id}}" data-action="moneys" data-form="del" data-elem=".list-group-item" data-animate_class="animate__fadeOutRightBig"><i class="fas fa-minus-square"></i></a>
        </span>
      </li>
    </div>
  </div>
</main>
