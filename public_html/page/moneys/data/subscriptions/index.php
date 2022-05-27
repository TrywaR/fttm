<?
$oCard = new card();
$oCard->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
$arrCards = $oCard->get();

$oMoneyCategory = new moneys_category();
$oMoneyCategory->sort = 'sort';
$oMoneyCategory->sortDir = 'ASC';
$oMoneyCategory->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
$arrMoneysCategories = $oMoneyCategory->get_categories();
?>

<main class="animate__animated animate__fadeIn container pt-4 pb-4">
  <div class="row mb-4">
    <div class="col-12">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Moneys subscriptions</h1>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col col-12 col-md-6 mb-4">
      <!-- Карты -->
      <div class="card">
        <div class="card-body">
          <!-- <h5 class="card-title">Новый тип</h5> -->

          <!-- <div class="card-body"> -->
          <div class="accordion accordion-flush" id="accordionFlushExampleZero">
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingZero">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseZero" aria-expanded="false" aria-controls="flush-collapseZero">
                  Add
                </button>
              </h2>
              <div id="flush-collapseZero" class="accordion-collapse collapse" aria-labelledby="flush-headingZero" data-bs-parent="#accordionFlushExampleZero">
                <div class="accordion-body">
                  <form
                    class="content_loader_form"
                    action=""
                    method="post"
                    data-content_download_edit_type="1, 0"
                    data-content_loader_to="#content_loader_to"
                    data-content_loader_template=".template_moneys_subscriptions"
                  >
                    <input type="hidden" name="app" value="app">
                    <input type="hidden" name="action" value="moneys_subscriptions">
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
                        <label for="inputPrice" class="col-form-label">Price</label>
                      </div>
                      <div class="col-12 col-md-8">
                        <input name="price" type="number" step="any" lang="en" id="inputPrice" class="form-control">
                      </div>
                    </div>

                    <div class="row align-items-center mb-1">
                      <div class="col-12 col-md-4">
                        <label for="inputSum" class="col-form-label">Sum total</label>
                      </div>
                      <div class="col-12 col-md-8">
                        <input name="sum" type="number" id="inputSum" class="form-control">
                      </div>
                    </div>

                    <div class="row align-items-center mb-1">
                      <div class="col-12 col-md-4">
                        <label for="inputType" class="col-form-label">Type</label>
                      </div>
                      <div class="col-12 col-md-8">
                        <select name="type" class="form-select" id="inputType" size="1" aria-label="size 3 select example">
                          <option value="0" selected>Every month</option>
                        </select>
                      </div>
                    </div>

                    <div class="row align-items-center mb-1">
                      <div class="col-12 col-md-4">
                        <label for="inputPriceIdZero" class="col-form-label">Payment day</label>
                      </div>
                      <div class="col-12 col-md-8">
                        <input name="day" type="number" step="any" lang="en" id="inputPriceIdZero" class="form-control">
                      </div>
                    </div>

                    <div class="row align-items-center mb-1">
                      <div class="col-12 col-md-4">
                        <label for="inputCard" class="col-form-label">From card</label>
                      </div>
                      <div class="col-12 col-md-8">
                        <select name="card" class="form-select" id="inputCard" size="3" aria-label="size 3 select example">
                          <option value="0" selected><?=$olang->get('Cash')?></option>
                          <?php foreach ($arrCards as $iIndex => $arrCard): ?>
                            <option value="<?=$arrCard['id']?>"><?=$arrCard['title']?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="row align-items-center mb-1">
                      <div class="col-12 col-md-4">
                        <label for="inputCategory" class="col-form-label">Category</label>
                      </div>
                      <div class="col-12 col-md-8">
                        <select name="category" id="inputCategory" class="form-select" size="3" aria-label="size 3 select example">
                          <option value="0" selected><?=$olang->get('NoCategory')?></option>
                          <?php foreach ($arrMoneysCategorise as $iIndex => $arrMoneyCategory): ?>
                            <option value="<?=$arrMoneyCategory['id']?>"><?=$arrMoneyCategory['title']?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="row align-items-center mb-1">
                      <div class="col-12 col-md-4">
                        <label for="inputSort" class="col-form-label">Sort</label>
                      </div>
                      <div class="col-12 col-md-8">
                        <input name="sort" type="number" id="inputSort" class="form-control">
                      </div>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input" name="active" type="checkbox" value="" id="flexCheckActive" checked>
                      <label class="form-check-label" for="flexCheckActive">
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
          <!-- </div> -->
        </div>
      </div>
    </div>

    <div class="col col-12 col-md-6">
      <div id="content_manager_buttons" class="content_manager_buttons _hide_ d-flex justify-content-end mb-4" data-content_manager_action="moneys_subscriptions" data-content_manager_block="#moneys_subscriptions" data-content_manager_item=".money_subscription" data-content_manager_button=".content_manager_switch">
        <button type="button" name="button" class="btn del">
          <i class="fas fa-folder-minus"></i>
        </button>
      </div>

      <ol
        id="moneys_subscriptions"
        class="block_moneys_subscriptions block_elems block_content_loader list-group list-group-numbered"
        data-content_loader_table="moneys_subscriptions"
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
        data-content_loader_scroll_block="#moneys_subscriptions"
        data-content_loader_show_class="animate__bounceInRight _show_"
        style="max-height: 50vh; overflow: auto; overflow-x: hidden;"
        >
      </ol>
      <script>
        $(function(){
          $(document).find('#moneys_subscriptions').content_loader()
          $(document).find('#content_manager_buttons').content_manager()
        })
      </script>
    </div>
  </div>

  <div class="block_template">
    <li class="list-group-item d-flex _elem money_subscription justify-content-between align-items-start progress_block animate__animated animate__bounceInRight _card_show_{{card_show}} _paid_show_{{paid_show}}" data-content_manager_item_id="{{id}}"  data-id="{{id}}">
      <div class="ms-2 me-auto">
        <div class="fw-bold">
          {{title}}<br/>

          <small class="_card">
            <i class="fas fa-credit-card"></i>
            {{card_val.title}} <br/>
          </small>

          <small class="_paid">
            <i class="fas fa-check"></i>
            {{paid.date}}
          </small>
        </div>
      </div>

      <div class="badge bg-primary">
        {{price}}
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

        <a href="#" class="btn content_download" data-id="{{id}}" data-action="moneys_subscriptions" data-elem=".list-group-item" data-form="edit" data-animate_class="animate__flipInY">
          <i class="fas fa-pen-square"></i>
        </a>

        <a href="#" class="btn content_download" data-id="{{id}}" data-action="moneys_subscriptions" data-form="del" data-elem=".list-group-item">
          <i class="fas fa-minus-square"></i>
        </a>
      </span>

      <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
      </div>
    </li>
  </div>
</main>
