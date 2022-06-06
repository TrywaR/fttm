<section class="row">
  <div class="col col-12 pt-4 pb-1">
    <div class="jumbotron jumbotron-fluid">
      <div class="container">
        <h1 class="display-4 sub_title">Clients</h1>
      </div>
    </div>
  </div>

  <div class="col-12 mb-4">
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
                  >
                    <input type="hidden" name="app" value="app">
                    <input type="hidden" name="action" value="clients">
                    <input type="hidden" name="form" value="save">
                    <input type="hidden" name="id" value="">
                    <input type="hidden" name="user_id" value="<?=$_SESSION['user']['id']?>">

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
                      <button type="button" class="btn form_reset"><i class="fas fa-window-close"></i> <?=$olang->get('Clear')?></button>
                      <button type="submit" class="btn btn-dark"><i class="fas fa-plus-square"></i> <?=$olang->get('Add')?></button>
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

  <div class="col-12 animate__animated animate__bounceInRight animate__delay-1s">
      <div id="content_manager_buttons" class="content_manager_buttons _hide_ d-flex justify-content-end mb-4" data-content_manager_action="clients" data-content_manager_block="#clients" data-content_manager_item=".client" data-content_manager_button=".content_manager_switch">
        <button type="button" name="button" class="btn del">
          <i class="fas fa-folder-minus"></i>
        </button>
      </div>

      <div
        id="clients"
        class="block_clients block_elems block_content_loader row"
        data-content_loader_table="clients"
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
        data-content_loader_scroll_block="#clients"
        data-content_loader_show_class="animate__bounceInRight _show_"
      >
      </div>
      <script>
        $(function(){
          $(document).find('#clients').content_loader()
          $(document).find('#content_manager_buttons').content_manager()
        })
      </script>
    </div>

  <div class="block_template">
    <div class="col-12 mb-4 _elem client progress_block animate__animated animate__bounceInRight" data-content_manager_item_id="{{id}}"  data-id="{{id}}">
      <div class="card">
        <div class="card-body">
          <small>№{{sort}}</small>
          <small>#{{id}}</small>
          <h5 class="card-title">{{title}}</h5>
          <p class="card-text">{{description}}</p>

          <div class="btn-group mt-2 w-100" role="group">
            <a href="#" class="btn content_manager_switch switch_icons">
              <div class="">
                <i class="far fa-square"></i>
              </div>
              <div class="">
                <i class="fas fa-square"></i>
              </div>
            </a>
            <a href="#" class="btn content_download" data-id="{{id}}" data-action="clients" data-elem=".client" data-form="edit" data-animate_class="animate__flipInY">
              <i class="fas fa-pen-square"></i>
            </a>
            <a href="#" class="btn content_download" data-id="{{id}}" data-elem=".client" data-action="clients" data-form="del" data-animate_class="animate__fadeOutRightBig">
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
</section>
