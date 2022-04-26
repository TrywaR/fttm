<main class="container pt-4 pb-4">
  <div class="row">
    <div class="col-12 col-md-6 mb-4">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Clients</h1>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 mb-4 animate__animated animate__bounceInLeft">
      <div class="card">
        <div class="card-body">
          <!-- <h5 class="card-title">Новая клиент</h5> -->
          <!-- <a href="#" class="btn btn-primary">Добавить</a> -->

          <!-- <div class="card-body"> -->
            <div class="accordion accordion-flush" id="accordionFlushExample">
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    Add client
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
                      data-content_loader_template=".template_clients"
                    >
                      <input type="hidden" name="app" value="app">
                      <input type="hidden" name="action" value="clients">
                      <input type="hidden" name="form" value="save">
                      <input type="hidden" name="id" value="">

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
  <div>

  <div class="row">
    <div class="col-12 animate__animated animate__bounceInRight animate__delay-1s">
      <div id="content_loader_to" class="row">
        <?
        // $sQuery  = "SELECT * FROM `clients`";
        // $sQuery .= " WHERE `active` > 0";
        // $sQuery .= " ORDER BY `sort` ASC";
        // $sQuery .= " LIMIT 20";

        // $arrClients = $db->query_all($sQuery);

        $oClient = new client();
        $arrClients = $oClient->get();

        // Прикручиваем рейтинги
        foreach ($arrClients as &$arrClient) {
          ?>
          <div class="col-12 col-md-4 mb-4 client progress_block" data-content_manager_item_id="<?=$arrClient['id']?>" data-content_loader_item_id="<?=$arrClient['id']?>">
            <div class="card">
              <div class="card-body">
                <small>№<?=$arrClient['sort']?></small>
                <small>#<?=$arrClient['id']?></small>
                <h5 class="card-title"><?=$arrClient['title']?></h5>
                <p class="card-text"><?=$arrClient['description']?></p>
                <?/*
                <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                <a href="#" class="btn">
                  <i class="far fa-square"></i>
                  <!-- <i class="fas fa-square"></i> -->
                </a>
                <a href="#" class="btn"><i class="fas fa-external-link-square-alt"></i></a>
                <a href="#" class="btn"><i class="fas fa-chart-area"></i></a>
                */?>
                <a href="#" class="btn content_download" data-id="<?=$arrClient['id']?>" data-action="clients" data-elem=".client" data-form="edit" data-animate_class="animate__flipInY">
                  <i class="fas fa-pen-square"></i>
                </a>
                <a href="#" class="btn content_download" data-id="<?=$arrClient['id']?>" data-elem=".client" data-action="clients" data-form="del" data-animate_class="animate__fadeOutRightBig">
                  <i class="fas fa-minus-square"></i>
                </a>
              </div>

              <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
              </div>
            </div>
          </div>
          <?
        }
        ?>
      </div>
    </div>
  </div>

  <div class="block_template">
    <div class="template_clients list-group">
      <div class="col-12 col-md-4 mb-4 client progress_block animate__animated animate__bounceInRight" data-content_manager_item_id="{{id}}"  data-content_loader_item_id="{{id}}">
        <div class="card">
          <div class="card-body">
            <small>№{{sort}}</small>
            <small>#{{id}}</small>
            <h5 class="card-title">{{title}}</h5>
            <p class="card-text">{{description}}</p>
            <?/*
            <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
            <a href="#" class="btn">
              <i class="far fa-square"></i>
              <!-- <i class="fas fa-square"></i> -->
            </a>
            <a href="#" class="btn"><i class="fas fa-external-link-square-alt"></i></a>
            <a href="#" class="btn"><i class="fas fa-chart-area"></i></a>
            */?>
            <a href="#" class="btn content_download" data-id="{{id}}" data-action="clients" data-elem=".client" data-form="edit" data-animate_class="animate__flipInY">
              <i class="fas fa-pen-square"></i>
            </a>
            <a href="#" class="btn content_download" data-id="{{id}}" data-elem=".client" data-action="clients" data-form="del" data-animate_class="animate__fadeOutRightBig">>
              <i class="fas fa-minus-square"></i>
            </a>
          </div>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
