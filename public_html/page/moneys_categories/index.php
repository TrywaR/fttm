<?
// Получаем категории
// $arrMoneys = $db->query_all($sQuery);

$oMoneysCategory = new moneys_category();
$oMoneysCategory->limit = 0;
$oMoneysCategory->sort = 'sort';
$arrMoneysCategories = $oMoneysCategory->get();

$dCurrentDate = date('Y-m');

$arrMoneysCategoriesName = [];

foreach ($arrMoneysCategories as &$arrMoneysCategory) {
  // Собираем данные по категории
  $oMoney = new money();
  $oMoney->where = "`category` = '" . $arrMoneysCategory['id'] . "' AND `date` LIKE '" . $dCurrentDate . "%' AND `type` = '0'";
  $arrMoneys = $oMoney->get();
  $iCategorySum = 0;
  foreach ($arrMoneys as &$arrMoney) {
    $arrMoneysCategory['items'][] = $arrMoney;
    $iCategorySum = $iCategorySum + (int)$arrMoney['price'];
  }
  $arrMoneysCategory['sum'] = $iCategorySum;
  $arrMoneysCategoriesName[$arrMoneysCategory] = $arrMoneysCategory['title'];
}

// Суммы по месяцам
$arrMounths = [];
for ($i=0; $i < 12; $i++) {
  $oMoney = new money();
  $oMoney->where = "`date` LIKE '" . date('Y') . '-' . sprintf("%02d", $i) . "%' AND `type` = '0'";
  $arrMoneys = $oMoney->get();
  $iMounthSum = 0;
  foreach ($arrMoneys as &$arrMoney) {
    $arrMounths[$i]['categories'][$arrMoney['category']] = (int)$arrMounths[$i]['categories'][$arrMoney['category']] + (int)$arrMoney['price'];
    // $arrMoneysCategory['items'][] = $arrMoney;
    // $arrMounths[$i+1]['items'][] = $arrMoney;
    $iMounthSum = $iMounthSum + (int)$arrMoney['price'];
  }
  $arrMounths[$i]['sum'] = $iMounthSum;
  $arrMounths[$i]['name'] = date("F", strtotime(date("Y") . "-" . sprintf("%02d", $i)));
  // $arrMounths[$i+1] = $iMounthSum;
  // $arrMounths[$i]['categories'] = [];

  // foreach ($arrMoneysCategories as &$arrMoneysCategory) {
  //   // code...
  // }
}

?>
<main class="container pt-4 pb-4">
  <div class="row mb-4">
    <div class="col-12">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Moneys categories</h1>
          <p class="lead">Типы затрат</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Analitycs -->
  <div class="row">
    <div class="col mb-4 d-flex flex-column justify-content-center align-items-center">
      <h2>Затраты по категориям (<?=date("F")?>)</h2>
      <canvas id="doughnut-chart" width="100" height="400px" style="max-height: 400px;"></canvas>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.0/dist/chart.min.js"></script>

    <script>
      var myChart = new Chart(document.getElementById("doughnut-chart"), {
        type: 'doughnut',
        data: {
          labels: [<?foreach ($arrMoneysCategories as $iIndex => &$arrMoneysCategory) {
            if ( $iIndex) echo ", '";
            else echo "'";
            echo $arrMoneysCategory['title'] . "'";
          }?>],
          datasets: [
            {
              label: "Population (millions)",
              data: [<?foreach ($arrMoneysCategories as $iIndex => &$arrMoneysCategory) {
                if ( $iIndex) echo ", '";
                else echo "'";
                echo $arrMoneysCategory['sum'] . "'";
              }?>],
              backgroundColor: [<?foreach ($arrMoneysCategories as $iIndex => &$arrMoneysCategory) {
                if ( $iIndex) echo ", '";
                else echo "'";
                echo $arrMoneysCategory['color'] ? $arrMoneysCategory['color'] . "'" : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) ) . "'";
              }?>]
            }
          ]
        }
      })
      window.addEventListener('beforeprint', () => {
  myChart.resize(600, 600);
});
window.addEventListener('afterprint', () => {
  myChart.resize();
});
    </script>
  </div>

  <!-- Год -->
  <div class="row mb-5">
    <div class="col mt-5 mb-4 d-flex flex-column justify-content-center align-items-center">
      <h2>Затраты за год (<?=date("Y")?>)</h2>
      <canvas id="bar-chart" width="100" height="400px" style="max-height: 400px;"></canvas>
      <script>
        var myBar = new Chart(document.getElementById("bar-chart"), {
          type: 'line',
          data: {
            labels: [<?foreach ($arrMounths as $key => $arrMounth) {
              if ( $key ) echo ", '";
              else echo "'";
              echo $arrMounth['name'] . " (" . $arrMounth['sum'] . ")'";
            }?>],
            datasets:
              [
                <?foreach ($arrMoneysCategories as $iIndex => &$arrMoneysCategory) {?>
                {
                  label: "<?=$arrMoneysCategory['title']?>",
                  data: [<?foreach ($arrMounths as $iIndex => &$arrMounth) {
                    if ( $iIndex ) echo ", ";
                    else echo "";

                    if ( count($arrMounth['categories']) ) echo $arrMounth['categories'][$arrMoneysCategory['id']] . "";
                    else echo $arrMounth['sum'] . "";
                  }?>],
                  borderColor: [<?foreach ($arrMounths as $iIndex => &$arrMounth) {
                    if ( $iIndex ) echo ", '";
                    else echo "'";
                    echo $arrMounth['color'] ? $arrMounth['color'] . "'" : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) ) . "'";
                  }?>],
                  backgroundColor: [<?foreach ($arrMounths as $iIndex => &$arrMounth) {
                    if ( $iIndex ) echo ", '";
                    else echo "'";
                    echo $arrMounth['color'] ? $arrMounth['color'] . "'" : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) ) . "'";
                  }?>]
                },
                <?}?>
              ],
          },
          options: {
            plugins: {
              filler: {
                propagate: false
              },
              'samples-filler-analyser': {
                target: 'chart-analyser'
              }
            },
            interaction: {
              intersect: false,
            },
            responsive: true,
            scales: {
              x: {
                stacked: true,
              },
              y: {
                stacked: true
              }
            }
          }
        })

        window.addEventListener('beforeprint', () => {
          myBar.resize(600, 600);
        });
        window.addEventListener('afterprint', () => {
          myBar.resize();
        });
      </script>
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
                      <input type="hidden" name="action" value="moneys_categories">
                      <input type="hidden" name="form" value="save">

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
                          <label for="inputColorZero" class="col-form-label">Цвет</label>
                        </div>
                        <div class="col-auto">
                          <input type="color" id="inputColorZero" name="color" value="<?=sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) )?>">
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
      <?if ( ! count( $arrMoneysCategories ) ) echo 'Нет типов затрат';?>
      <ol class="list-group list-group-numbered">
      <?
      // Прикручиваем рейтинги
      foreach ($arrMoneysCategories as $arrMoneysCategory) {
        ?>
        <li class="list-group-item d-flex justify-content-between align-items-start">
          <div class="ms-2 me-auto">
            <div class="fw-bold"><?=$arrMoneysCategory['title']?></div>
            <div class="badge bg-primary ">
              <?=$arrMoneysCategory['priority']?>
            </div>
          </div>
          <span class="rounded-pill">
            <a href="#" class="btn">
              <i class="far fa-square"></i>
              <!-- <i class="fas fa-square"></i> -->
            </a>
            <a href="#" class="btn"><i class="fas fa-pen-square"></i></a>
            <a href="#" class="btn content_download" data-id="<?=$arrMoneysCategory['id']?>" data-action="moneys" data-form="del"><i class="fas fa-minus-square"></i></a>
          </span>
        </li>
        <?
      }
      ?>
      </ol>
    </div>
  </div>

  <?/*
  <!-- unic -->
  <div class="row">
    <h2>Unic</h2>
    <?
    $oMoney = new money();
    $oMoney->where = "`category` = '5' AND `project_id` = 3 AND `type` = '0'";
    $arrMoneys = $oMoney->get();
    foreach ($arrMoneys as $arrMoney) {
      ?>
      <div class="">
        <?=$arrMoney['price'] . ' - ' . $arrMoney['title'] . ' : ' . $arrMoney['date']?>
      </div>
      <?
    }
    ?>
  </div>
  */?>

  <!-- Items -->
  <div class="row">
    <div class="col">
      <?
      foreach ($arrMoneysCategories as &$arrMoneysCategory) {
      ?>
      <ol class="list-group list-group-numbered block_content_loader">
      <?
      // Прикручиваем рейтинги
      foreach ($arrMoneysCategory['items'] as &$arrMoney) {
        ?>
        <li class="list-group-item money d-flex justify-content-between align-items-start animate__animated animate__bounceInRight animate__delay-2s _type_<?=$arrMoney['type']?>_" data-content_manager_item_id="<?=$arrMoney['id']?>"  data-content_loader_item_id="<?=$arrMoney['id']?>">
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
        </li>
        <?
      }
      ?>
      </ol>
      <?
      }
      ?>
    </div>
  </div>
</main>
