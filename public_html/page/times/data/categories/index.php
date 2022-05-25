<main class="container animate__animated animate__fadeIn">
  <div class="row">
    <div class="col-12 mb-4">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Times categories</h1>
          <p class="lead">
            <span class="icon">
              <i class="fas fa-arrow-left"></i>
            </span>
            <a href="/times/">Times</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12 col-md-6 mb-4">
      <!-- Карты -->
      <div class="card">
        <div class="card-body">
          <!-- <h5 class="card-title">Новый тип</h5> -->

          <!-- <div class="card-body"> -->
          <div class="accordion accordion-flush" id="accordionFlushExampleZero">
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingZero">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseZero" aria-expanded="false" aria-controls="flush-collapseZero">
                    Add type
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
                      data-content_loader_template=".template_times_categories"
                    >
                      <input type="hidden" name="app" value="app">
                      <input type="hidden" name="action" value="times_categories">
                      <input type="hidden" name="form" value="save">
                      <input type="hidden" name="user_id" value="<?=$_SESSION['user']['id']?>">
                      <input type="hidden" name="id" value="">

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputCardIdZero" class="col-form-label">Type</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <input name="title" type="text" id="inputCardIdZero" class="form-control">
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputPriceIdZero" class="col-form-label">Priority</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <input name="priority" type="number" id="inputPriceIdZero" class="form-control">
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputColorZero" class="col-form-label">Color</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <input type="color" id="inputColorZero" name="color" value="<?=sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) )?>">
                        </div>
                      </div>

                      <div class="row align-items-center mb-1">
                        <div class="col-12 col-md-4">
                          <label for="inputTitleZero" class="col-form-label">Sort</label>
                        </div>
                        <div class="col-12 col-md-8">
                          <input name="sort" type="number" id="inputTitleZero" class="form-control">
                        </div>
                      </div>

                      <div class="form-check mt-2">
                        <input class="form-check-input" name="active" type="checkbox" value="" id="flexCheckChecked" checked>
                        <label class="form-check-label" for="flexCheckChecked">
                          Active
                        </label>
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

    <div class="col-12 col-md-6 animate__animated animate__bounceInRight animate__delay-1s">
      <div id="content_manager_buttons" class="content_manager_buttons _hide_ d-flex justify-content-end mb-4" data-content_manager_action="times_categories" data-content_manager_block="#times_categories" data-content_manager_item=".times_categoriy" data-content_manager_button=".content_manager_switch">
        <button type="button" name="button" class="btn del">
          <i class="fas fa-folder-minus"></i>
        </button>
      </div>

        <ol
          id="times_categories"
          class="block_times_categories block_elems block_content_loader list-group list-group-numbered"
          data-content_loader_table="times_categories"
          data-content_loader_form="show"
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
          data-content_loader_scroll_block="#times_categories"
          data-content_loader_show_class="animate__bounceInRight _show_"
          style="max-height: 50vh; overflow: auto; overflow-x: hidden;"
        >
      </ol>
      <script>
        $(function(){
          $(document).find('#times_categories').content_loader()
          $(document).find('#content_manager_buttons').content_manager()
        })
      </script>
    </div>
  </div>

  <div class="block_template">
    <li class="list-group-item d-flex _elem times_categoriy justify-content-between align-items-start progress_block animate__animated animate__bounceInRight _edit_show_{{edit_show}}" data-content_manager_item_id="{{id}}"  data-id="{{id}}">
      <div class="ms-2 me-auto">
        <div class="fw-bold">{{title}}</div>
      </div>
      <div class="badge bg-primary" style="background: {{color}}!important">
        {{color}}
      </div>
      <div class="rounded-pill">
        <a href="#" class="btn content_manager_switch switch_icons _select">
          <div class="">
            <i class="far fa-square"></i>
          </div>
          <div class="">
            <i class="fas fa-square"></i>
          </div>
        </a>
        <a href="#" class="btn content_download _edit" data-id="{{id}}" data-action="times_categories" data-elem=".list-group-item" data-form="edit" data-animate_class="animate__flipInY">
          <i class="fas fa-pen-square"></i>
        </a>
        <a href="#" class="btn content_download _del" data-id="{{id}}" data-action="times_categories" data-form="del" data-elem=".list-group-item">
          <i class="fas fa-minus-square"></i>
        </a>
      </div>

      <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
      </div>
    </li>
  </div>
</main>
