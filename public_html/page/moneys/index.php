<main class="container pt-4 pb-4" id="container">
  <section class="row mb-4">
    <div class="col-12">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Moneys</h1>
          <p class="lead">
            <span class="icon">
              <i class="far fa-folder"></i>
            </span>
            <a href="/moneys/data/cards/">Cards</a>
            <span class="text_seporator">,</span> <a href="/moneys/data/categories/">Moneys spend categories</a>
            <span class="text_seporator">,</span> <a href="/projects/">Projects</a>
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
      <div class="card animate__animated animate__pulse mb-4">
        <div class="card-body">
          <!-- <h5 class="card-title">Новый затрат</h5> -->
          <!-- <a href="#" class="btn btn-primary">Добавить</a> -->

          <!-- <div class="card-body"> -->
          <div class="accordion accordion-flush" id="accordionFlushExampleZero">
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingZero">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseZero" aria-expanded="false" aria-controls="flush-collapseZero">
                    Spend
                  </button>
                </h2>
                <div id="flush-collapseZero" class="accordion-collapse collapse" aria-labelledby="flush-headingZero" data-bs-parent="#accordionFlushExampleZero">
                  <div class="accordion-body">
                    <form class="content_loader_form" action="" method="post" data-content_download_edit_type="0" data-content_loader_to="#content_loader_to" data-content_loader_template=".template_money">
                      <input type="hidden" name="app" value="app">
                      <input type="hidden" name="action" value="moneys">
                      <input type="hidden" name="form" value="save">
                      <input type="hidden" name="type" value="0">
                      <input type="hidden" name="id" value="">

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputCardIdZero" class="col-form-label">Card</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <select name="card" class="form-select" size="3" aria-label="size 3 select example">
                            <option value="0" selected>Наличные</option>
                            <?
                            $oCard = new card();
                            $arrCards = $oCard->get();
                            ?>
                            <?php foreach ($arrCards as $iIndex => $arrCard): ?>
                              <?php if ( ! $iIndex ): ?>
                                <option value="<?=$arrCard['id']?>"><?=$arrCard['title']?></option>
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
                            <?
                            $oMoneyCategory = new moneys_category();
                            $arrMoneysCategorise = $oMoneyCategory->get();
                            ?>
                            <?php foreach ($arrMoneysCategorise as $iIndex => $arrMoneyCategory): ?>
                              <?php if ( ! $iIndex ): ?>
                                <option selected value="<?=$arrMoneyCategory['id']?>"><?=$arrMoneyCategory['title']?></option>
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
                            <option value="0" selected>Не работа</option>
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
                        <button type="button" class="btn form_reset"><i class="fas fa-window-close"></i> Clear</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-plus-square"></i> Add</button>
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
      <div class="card animate__animated animate__pulse mb-4 animate__delay-1s">
        <div class="card-body">
          <!-- <h5 class="card-title">Новый приход</h5> -->
          <!-- <a href="#" class="btn btn-primary">Добавить</a> -->

          <!-- <div class="card-body"> -->
          <div class="accordion accordion-flush" id="accordionFlushExample">
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    Replenish
                  </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">
                    <form class="content_loader_form" action="" method="post"  data-content_download_edit_type="1" data-content_loader_to="#content_loader_to" data-content_loader_template=".template_money">
                      <input type="hidden" name="app" value="app">
                      <input type="hidden" name="action" value="moneys">
                      <input type="hidden" name="form" value="save">
                      <input type="hidden" name="type" value="1">
                      <input type="hidden" name="id" value="">

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputProjectId" class="col-form-label">Project id</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <select name="project_id" class="form-select" size="3" aria-label="size 3 select example">
                            <option value="0" selected>Левый приход</option>
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
                          <label for="inputCardId" class="col-form-label">Card</label>
                        </div>
                        <div class="col-12 col-md-8">
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
                        <button type="button" class="btn form_reset"><i class="fas fa-window-close"></i> Clear</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-plus-square"></i> Add</button>
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

    <div class="col col-12 col-md-7 animate__animated animate__bounceInRight animate__delay-2s">
      <?
      // $sQuery  = "SELECT * FROM `clients`";
      // $sQuery .= " WHERE `active` > 0";
      // $sQuery .= " ORDER BY `sort` ASC";
      // $sQuery .= " LIMIT 20";

      // $arrMoneys = $db->query_all($sQuery);

      $oMoney = new money();
      $oMoney->limit = 10;
      $oMoney->sort = 'date';
      $oMoney->sortDir = 'DESC';
      $arrMoneys = $oMoney->get_money();

      if ( ! count( $arrMoneys ) ) echo 'Нет затрат или поступлений';
      ?>
      <div class="content_manager_buttons _hide_ d-flex justify-content-end mb-4" data-content_manager_action="moneys" data-content_manager_block="#content_loader_to" data-content_manager_item=".list-group-item">
        <button type="button" name="button" class="btn del">
          <i class="fas fa-folder-minus"></i>
        </button>
      </div>
      <ol class="list-group list-group-numbered block_content_loader" id="content_loader_to" style="max-height: 80vh; overflow: auto;">
      <?
      // Прикручиваем рейтинги
      foreach ($arrMoneys as &$arrMoney) {
        ?>
        <li class="list-group-item money d-flex justify-content-between align-items-start _type_<?=$arrMoney['type']?>_" data-content_manager_item_id="<?=$arrMoney['id']?>"  data-content_loader_item_id="<?=$arrMoney['id']?>">
          <div class="ms-2 me-auto">
            <div class="fw-bold mb-1"><?=$arrMoney['title']?></div>
            <div class="badge bg-primary " style="font-size: 1rem; font-weight: normal;">
              <?=$arrMoney['price']?>₽
            </div>
            <span style="opacity: .5; font-size: .8rem; margin-right: 1rem">
              <?=$arrMoney['date']?>
            </span>
            <i class="fas fa-credit-card"></i> <?=$arrMoney['card']?>
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
            <a href="#" class="btn content_download" data-id="<?=$arrMoney['id']?>" data-action="moneys" data-elem=".list-group-item" data-form="edit" data-animate_class="animate__flipInY">
              <i class="fas fa-pen-square"></i>
            </a>
            <a href="#" class="btn content_download" data-id="<?=$arrMoney['id']?>" data-action="moneys" data-form="del" data-elem=".list-group-item" data-animate_class="animate__fadeOutRightBig"><i class="fas fa-minus-square"></i></a>
          </span>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
          </div>
        </li>
        <?
      }
      ?>
      </ol>
      <div class="mt-4 text-center">
        <button type="button" class="btn btn-primary btn-sm content_loader" data-content_loader_action="moneys" data-content_loader_form="show" data-content_loader_to="#content_loader_to" data-content_loader_from="10" data-content_loader_limit="10" data-content_loader_template=".template_money" data-content_loader_position="1">Load</button>
      </div>
    </div>
  </section>

  <section class="block_template">
    <div class="template_money list-group">
      <div class="list-group-item money d-flex justify-content-between align-items-start animate__animated animate__bounceInRight _type_{{type}}_" data-content_manager_item_id="{{id}}"  data-content_loader_item_id="{{id}}">
        <div class="ms-2 me-auto">
          <div class="fw-bold mb-1">{{title}}</div>
          <div class="badge bg-primary" style="font-size: 1rem; font-weight: normal;">
            {{price}}₽
          </div>
          <span style="opacity: .5; font-size: .8rem; margin-right: 1rem">
            {{date}}
          </span>
          <i class="fas fa-credit-card"></i> {{card}}
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
      </div>
    </div>
  </section>
</main>
