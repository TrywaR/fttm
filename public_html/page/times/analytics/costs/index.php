<?
// Получаем категории
$oTimesCategory = new times_category();
$oTimesCategory->limit = 0;
$oTimesCategory->sort = 'sort';
$arrTimesCategories = $oTimesCategory->get();

$dCurrentDate = date('Y-m');
$iCurrentMonth = date('m');
$iCurrentYear = date('Y');

$arrTimesCategoriesName = [];
$arrTimesCategoriesIds = [];
$arrTimesProjectsIds = [];

// Проекты
$oProject = new project();
$arrProjects = $oProject->get();
foreach ($arrProjects as &$arrProject) $arrTimesProjectsIds[$arrProject['id']] = $arrProject;

// Категории
foreach ($arrTimesCategories as &$arrTimesCategory) {
  // Собираем данные по категории
  $oTime = new time();
  $oTime->where = "`category_id` = '" . $arrTimesCategory['id'] . "' AND `date` LIKE '" . $dCurrentDate . "%'";
  $arrTimes = $oTime->get();
  $iCategorySum = 0;

  foreach ($arrTimes as &$arrTime) {
    $dDateReally = new DateTime($arrTime['time_really']);
    $arrTime['time'] = round($dDateReally->format('H.i'));

    $arrTimesCategory['items'][] = $arrTime;
    $iCategorySum = (int)$iCategorySum + (int)$arrTime['time'];
  }
  $arrTimesCategory['sum'] = $iCategorySum;
  $arrTimesCategoriesName[$arrTimesCategory['id']] = $arrTimesCategory['title'];
  $arrTimesCategoriesIds[$arrTimesCategory['id']] = $arrTimesCategory;
}

// Суммы по месяцам
$arrMounths = [];
for ($i=0; $i < 12; $i++) {
  $oTime = new time();
  $oTime->where = "`date` LIKE '" . date('Y') . '-' . sprintf("%02d", $i) . "%'";
  $arrTimes = $oTime->get();
  $iMounthSum = 0;
  foreach ($arrTimes as &$arrTime) {
    $dDateReally = new DateTime($arrTime['time_really']);
    $arrTime['time'] = round($dDateReally->format('H.i'));

    $arrMounths[$i]['categories'][$arrTime['category_id']] = (int)$arrMounths[$i]['categories'][$arrTime['category_id']] + (int)$arrTime['time'];
    $iMounthSum = $iMounthSum + (int)$arrTime['time'];
  }
  $arrMounths[$i]['sum'] = $iMounthSum;
  $arrMounths[$i]['name'] = date("F", strtotime(date("Y") . "-" . sprintf("%02d", $i)));
}

// Суммы по годам
$arrYears = [];
for ($i=0; $i < 2; $i++) {
  $oTime = new time();
  $oTime->where = "`date` LIKE '" . ( $iCurrentYear - $i ) . '-' . "%'";
  $arrTimes = $oTime->get();
  $iYearSum = 0;
  foreach ($arrTimes as &$arrTime) {
    $dDateReally = new DateTime($arrTime['time_really']);
    $arrTime['time'] = round($dDateReally->format('H.i'));

    $arrYears[$iCurrentYear - $i]['categories'][$arrTime['category_id']] = (int)$arrYears[$iCurrentYear - $i]['categories'][$arrTime['category_id']] + (int)$arrTime['time'];
    $iYearSum = $iYearSum + (int)$arrTime['time'];
  }
  $arrYears[$iCurrentYear - $i]['sum'] = $iYearSum;
  $arrYears[$iCurrentYear - $i]['name'] = $iCurrentYear - $i;
}

?>
<main class="container pt-4 pb-4">
  <div class="row mb-4">
    <div class="col-12">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Times categories</h1>
          <p class="lead">
            <a href="/times/">Times</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="pills-month-tab" data-bs-toggle="pill" data-bs-target="#pills-month" type="button" role="tab" aria-controls="pills-month" aria-selected="true">Mounth</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="pills-yaer-tab" data-bs-toggle="pill" data-bs-target="#pills-yaer" type="button" role="tab" aria-controls="pills-yaer" aria-selected="false">Year</button>
    </li>
  </ul>
  <div class="tab-content" id="pills-tabContent">
    <!-- Month -->
    <div class="tab-pane fade show active" id="pills-month" role="tabpanel" aria-labelledby="pills-month-tab">
      <div class="row mb-4 animate__animated animate__bounceInRight">
        <div class="col mb-4 d-flex flex-column justify-content-center align-items-center">
          <h2>Затраты по категориям (<?=date("F")?>)</h2>
          <canvas id="doughnut-chart" width="100" height="400px" style="max-height: 400px;"></canvas>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.0/dist/chart.min.js"></script>

        <script>
          var myChart = new Chart(document.getElementById("doughnut-chart"), {
            type: 'doughnut',
            data: {
              labels: [<?foreach ($arrTimesCategories as $iIndex => &$arrTimesCategory) {
                if ( $iIndex) echo ", '";
                else echo "'";
                echo $arrTimesCategory['title'] . "'";
              }?>],
              datasets: [
                {
                  label: "Population (millions)",
                  data: [<?foreach ($arrTimesCategories as $iIndex => &$arrTimesCategory) {
                    if ( $iIndex) echo ", '";
                    else echo "'";
                    echo $arrTimesCategory['sum'] . "'";
                  }?>],
                  backgroundColor: [<?foreach ($arrTimesCategories as $iIndex => &$arrTimesCategory) {
                    if ( $iIndex) echo ", '";
                    else echo "'";
                    echo $arrTimesCategory['color'] ? $arrTimesCategory['color'] . "'" : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) ) . "'";
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
      <div class="row mb-4 animate__animated animate__bounceInRight animate__delay-1s">
        <div class="col-12">
          <h2 class="text-center">
            <?=$arrMounths[$iCurrentMonth]['sum']?>ч
          </h2>
        </div>
      </div>
      <!-- Items -->
      <div class="row animate__animated animate__bounceInRight animate__delay-2s">
        <?
        foreach ($arrTimesCategories as &$arrTimesCategory) {
        ?>
        <div class="col-12 mb-4 times_category animate__animated animate__bounceInRight animate__delay-1s">
          <div class="times_category-name">
            <h2>
              <span class="badge bg-primary" style="background: <?=$arrTimesCategory['color']?>!important">
                <?=$arrTimesCategory['title']?>
              </span>
              <small>
                <?=$arrTimesCategory['sum']?>ч
              </small>
            </h2>
          </div>
          <div class="times_category-data">
            <ol class="list-group list-group-numbered block_content_loader">
            <?
            // Прикручиваем рейтинги
            foreach ($arrTimesCategory['items'] as &$arrTime) {
              ?>
              <li class="list-group-item money d-flex justify-content-between align-items-start _type_<?=$arrTime['type']?>_" data-content_manager_item_id="<?=$arrTime['id']?>"  data-content_loader_item_id="<?=$arrTime['id']?>">
                <div class="ms-2 me-auto">
                  <div class="fw-bold mb-1"><?=$arrTime['title']?></div>
                  <div class="badge bg-primary " style="font-size: 1rem; font-weight: normal; margin-right: 1rem">
                    <?=$arrTime['time_really']?>
                  </div>
                  <?php if ($arrTime['project_id']): ?>
                    <i class="fas fa-horse-head"></i> <small>#<?=$arrTimesProjectsIds[$arrTime['project_id']]['title']?></small>
                  <?php endif; ?>
                </div>
              </li>
              <?
            }
            ?>
            </ol>

            <div class="times_category-data_bg" style="background: <?=$arrTimesCategory['color']?>!important"></div>
          </div>
        </div>
        <?
        }
        ?>
      </div>
    </div>

    <!-- Year -->
    <div class="tab-pane fade" id="pills-yaer" role="tabpanel" aria-labelledby="pills-yaer-tab">
      <div class="row mb-4 animate__animated animate__bounceInRight">
        <div class="col d-flex flex-column justify-content-center align-items-center">
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
                    <?foreach ($arrTimesCategories as $iIndex => &$arrTimesCategory) {?>
                    {
                      label: "<?=$arrTimesCategory['title']?>",
                      data: [<?foreach ($arrMounths as $iIndex => &$arrMounth) {
                        if ( $iIndex ) echo ", ";
                        else echo "";

                        echo $arrMounth['categories'][$arrTimesCategory['id']] ? $arrMounth['categories'][$arrTimesCategory['id']] : '0';
                        // if ( count($arrMounth['categories']) ) echo $arrMounth['categories'][$arrTimesCategory['id']] . "";
                        // else echo $arrMounth['sum'] . "";
                      }?>],
                      borderColor: [<?foreach ($arrMounths as $iIndex => &$arrMounth) {
                        if ( $iIndex ) echo ", '";
                        else echo "'";
                        // echo $arrMounth['color'] ? $arrMounth['color'] . "'" : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) ) . "'";
                        echo $arrTimesCategory['color'] ? $arrTimesCategory['color'] . "'" : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) ) . "'";
                      }?>],
                      backgroundColor: [<?foreach ($arrMounths as $iIndex => &$arrMounth) {
                        if ( $iIndex ) echo ", '";
                        else echo "'";
                        // echo $arrMounth['color'] ? $arrMounth['color'] . "'" : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) ) . "'";
                        echo $arrTimesCategory['color'] ? $arrTimesCategory['color'] . "'" : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) ) . "'";
                      }?>]
                    },
                    <?}?>
                  ],
              },
              // options: {
              //   plugins: {
              //     filler: {
              //       propagate: false
              //     },
              //     'samples-filler-analyser': {
              //       target: 'chart-analyser'
              //     }
              //   },
              //   interaction: {
              //     intersect: false,
              //   },
              //   responsive: true,
              //   scales: {
              //     x: {
              //       stacked: true,
              //     },
              //     y: {
              //       stacked: true
              //     }
              //   }
              // }
              options: {
                responsive: true,
                plugins: {
                  legend: {
                    position: 'top',
                  },
                }
              },
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
      <div class="row mb-4 animate__animated animate__bounceInRight animate__delay-1s">
        <div class="col-12">
          <h2 class="text-center">
            <?=$arrYears[$iCurrentYear]['sum']?>ч
          </h2>
        </div>
      </div>
      <div class="row animate__animated animate__bounceInRight animate__delay-2s">
        <? foreach ($arrYears as & $arrYear): ?>
          <? if ( $arrYear['name'] ): ?>
            <h2>
              <?=$arrYear['name']?>
              <small>
                <?=$arrYear['sum']?>ч
              </small>
            </h2>
          <? endif; ?>
          <? foreach ($arrYear['categories'] as $iCategiryId => $iCategorySum): ?>
            <h3>
              <span class="badge bg-primary" style="background: <?=$arrTimesCategoriesIds[$iCategiryId]['color']?>!important">
                <?=$arrTimesCategoriesIds[$iCategiryId]['title']?>
              </span>
              <?=$iCategorySum ? $iCategorySum : '0' ?>ч
            </h3>
          <? endforeach; ?>
        <? endforeach; ?>

        <div class="col col-12">
          <?/*
          <?foreach ($arrTimesCategories as $iIndex => &$arrTimesCategory) {?>
            <h2>
              <span class="badge bg-primary" style="background: <?=$arrTimesCategory['color']?>!important">
                <?=$arrTimesCategory['title']?>
              </span>

              <?=$arrTimesCategory['sum'] ? number_format($arrTimesCategory['sum'], 2, '.', ' ') : '0' ?>₽
            </h2>
            <ol class="list-group list-group-numbered block_content_loader">

            </ol>
          <?}?>
          */?>
        </div>
      </div>
    </div>
  </div>

  <?/*
  <!-- unic -->
  <div class="row">
    <h2>Unic</h2>
    <?
    $oMoney = new time();
    $oMoney->where = "`category` = '5' AND `project_id` = 3";
    $arrTimes = $oMoney->get();
    foreach ($arrTimes as $arrTime) {
      ?>
      <div class="">
        <?=$arrTime['price'] . ' - ' . $arrTime['title'] . ' : ' . $arrTime['date']?>
      </div>
      <?
    }
    ?>
  </div>
  */?>
</main>
