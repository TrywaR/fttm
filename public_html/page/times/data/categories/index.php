<?
// Получаем категории
// $arrTimes = $db->query_all($sQuery);

$oTimesCategory = new times_category();
$oTimesCategory->limit = 0;
$oTimesCategory->sort = 'sort';
$arrTimesCategories = $oTimesCategory->get();

$dCurrentDate = date('Y-m');

$arrTimesCategoriesName = [];

foreach ($arrTimesCategories as &$arrTimesCategory) {
  // Собираем данные по категории
  // $oMoney = new time();
  // $oMoney->where = "`category` = '" . $arrTimesCategory['id'] . "' AND `date` LIKE '" . $dCurrentDate . "%' AND `type` = '0'";
  // $arrTimes = $oMoney->get();
  // $iCategorySum = 0;
  // foreach ($arrTimes as &$arrMoney) {
  //   $arrTimesCategory['items'][] = $arrMoney;
  //   $iCategorySum = $iCategorySum + (int)$arrMoney['price'];
  // }
  // $arrTimesCategory['sum'] = $iCategorySum;
  // $arrTimesCategoriesName[$arrTimesCategory] = $arrTimesCategory['title'];
}
?>
<main class="container pt-4 pb-4">
  <div class="row mb-4">
    <div class="col-12">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Times categories</h1>
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
                    Add type
                  </button>
                </h2>
                <div id="flush-collapseZero" class="accordion-collapse collapse" aria-labelledby="flush-headingZero" data-bs-parent="#accordionFlushExampleZero">
                  <div class="accordion-body">
                    <form class="reload_page" action="" method="post">
                      <input type="hidden" name="app" value="app">
                      <input type="hidden" name="action" value="times_categories">
                      <input type="hidden" name="form" value="save">

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

    <div class="col col-12 col-md-6">
      <?if ( ! count( $arrTimesCategories ) ) echo 'Нет типов затрат';?>
      <ol class="list-group list-group-numbered">
      <?
      // Прикручиваем рейтинги
      foreach ($arrTimesCategories as & $arrTimesCategory) {
        ?>
        <li class="list-group-item d-flex justify-content-between align-items-start">
          <div class="ms-2 me-auto">
            <div class="fw-bold"><?=$arrTimesCategory['title']?></div>
          </div>
          <div class="badge bg-primary" style="background: <?=$arrTimesCategory['color']?>!important">
            <?=$arrTimesCategory['color'] ? $arrTimesCategory['color'] : 'random'?>
          </div>
          <span class="rounded-pill">
            <?/*
            <a href="#" class="btn">
              <i class="far fa-square"></i>
              <!-- <i class="fas fa-square"></i> -->
            </a>
            <a href="#" class="btn"><i class="fas fa-pen-square"></i></a>
            */?>
            <a href="#" class="btn content_download" data-id="<?=$arrTimesCategory['id']?>" data-action="times_categories" data-form="del" data-elem=".list-group-item"><i class="fas fa-minus-square"></i></a>
          </span>
        </li>
        <?
      }
      ?>
      </ol>
    </div>
  </div>
</main>
