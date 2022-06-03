<main class="container animate__animated animate__fadeIn block_moneys">
  <div class="row">
    <div class="col-12 col-md-6 mb-4">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4 sub_title">Cards</h1>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 mb-4">
      <!-- Добавление карты -->
      <div class="card">
        <div class="card-body">
          <div class="accordion accordion-flush" id="accordionFlushExampleZero">
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingZero">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseZero" aria-expanded="false" aria-controls="flush-collapseZero">
                  <?=$olang->get('Add')?>
                </button>
              </h2>
              <div id="flush-collapseZero" class="accordion-collapse collapse" aria-labelledby="flush-headingZero" data-bs-parent="#accordionFlushExampleZero">
                <div class="accordion-body">
                  <form
                    class="content_loader_form"
                    action=""
                    method="post"
                    data-content_download_edit_type="0"
                    data-content_loader_to="#content_loader_to"
                  >
                    <input type="hidden" name="app" value="app">
                    <input type="hidden" name="action" value="cards">
                    <input type="hidden" name="form" value="save">
                    <input type="hidden" name="id" value="">
                    <input type="hidden" name="user_id" value="<?=$_SESSION['user']['id']?>">

                    <div class="row align-items-center mb-1">
                      <div class="col-12 col-md-4">
                        <label for="inputCardIdZero" class="col-form-label">Card</label>
                      </div>
                      <div class="col-12 col-md-8">
                        <input name="title" type="text" id="inputCardIdZero" class="form-control">
                      </div>
                    </div>

                    <div class="row align-items-center mb-1">
                      <div class="col-12 col-md-4">
                        <label for="inputPriceIdZero" class="col-form-label">Balance</label>
                      </div>
                      <div class="col-12 col-md-8">
                        <input name="balance" type="number" id="inputPriceIdZero" class="form-control">
                      </div>
                    </div>

                    <div class="row align-items-center mb-1">
                      <div class="col-12 col-md-4">
                        <label for="inputDateZero" class="col-form-label">Limit</label>
                      </div>
                      <div class="col-12 col-md-8">
                        <input name="limit" type="number" id="inputDateZero" class="form-control">
                      </div>
                    </div>

                    <div class="row align-items-center mb-1">
                      <div class="col-12 col-md-4">
                        <label for="inputDateZero" class="col-form-label">Percent</label>
                      </div>
                      <div class="col-12 col-md-8">
                        <input name="percent" type="number" id="inputDateZero" class="form-control">
                      </div>
                    </div>

                    <div class="row align-items-center mb-1">
                      <div class="col-12 col-md-4">
                        <label for="inputTitleZero" class="col-form-label">sort</label>
                      </div>
                      <div class="col-12 col-md-8">
                        <input name="sort" type="number" id="inputTitleZero" class="form-control">
                      </div>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input" name="active" type="checkbox" value="" id="flexCheckChecked" checked>
                      <label class="form-check-label" for="flexCheckChecked">
                        Active
                      </label>
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
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12 animate__animated animate__fadeIn animate__delay-1s">
      <!-- Карты -->
      <div id="content_manager_buttons" class="content_manager_buttons _hide_ d-flex justify-content-end mb-4" data-content_manager_action="cards" data-content_manager_block="#cards" data-content_manager_item=".card_item" data-content_manager_button=".content_manager_switch">
        <button type="button" name="button" class="btn del">
          <i class="fas fa-folder-minus"></i>
        </button>
      </div>

      <div
        id="cards"
        class="block_cards block_elems block_content_loader row"
        data-content_loader_table="cards"
        data-content_loader_form="show_all"
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
        data-content_loader_scroll_block="#cards"
        data-content_loader_show_class="animate__bounceInRight _show_"
        style="max-height: 50vh; overflow: auto; overflow-x: hidden;"
        >
      </div>

      <script>
        $(function(){
          $(document).find('#cards').content_loader()
          $(document).find('#content_manager_buttons').content_manager()
        })
      </script>
    </div>
  </div>

  <div class="block_template">
    <div class="col-12 col-md-4 mb-4 _elem card_item progress_block animate__animated animate__bounceInRight _commission_show_{{commission_show}} _noedit_show_{{noedit}}" data-content_manager_item_id="{{id}}"  data-id="{{id}}">
      <div class="card">
        <div class="card-body">
          <div class="ms-2 me-auto mb-2">
            <div class="fw-bold">{{title}}</div>
            <small style="opacity:.6" title="last update"><i class="fas fa-clock"></i> {{date_update}}</small>
          </div>

          <div class="badge bg-primary" title="Balance">
            {{balance}} / <small>{{limit}}</small>
          </div>

          <div class="badge bg-warning text-dark _commission" title="Commission">
            {{commission}}
          </div>

          <div class="btn-group mt-2 w-100" role="group">
            <a href="#" class="btn content_manager_switch switch_icons _select">
              <div class="">
                <i class="far fa-square"></i>
              </div>
              <div class="">
                <i class="fas fa-square"></i>
              </div>
            </a>
            <a href="#" title="Reload data" class="btn content_download _reload" data-id="{{id}}" data-action="cards" data-elem=".card_item" data-form="reload" data-animate_class="animate__flipInY">
              <i class="fas fa-retweet"></i>
            </a>
            <a href="#" class="btn content_download _edit" data-id="{{id}}" data-action="cards" data-elem=".card_item" data-form="edit" data-animate_class="animate__flipInY">
              <i class="fas fa-pen-square"></i>
            </a>
            <a href="#" class="btn content_download _del" data-id="{{id}}" data-action="cards" data-form="del" data-elem=".card_item">
              <i class="fas fa-minus-square"></i>
            </a>
          </div>
        </div>

        <div class="progress">
          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
        </div>
      </div>
    </div>
  </div>
</main>
