<?
// Получаем категории
// $arrMoneys = $db->query_all($sQuery);

$oProject = new project();
$oProject->limit = 0;
$oProject->sort = 'sort';
$arrProjects = $oProject->get();

$dCurrentDate = date('Y-m');
$iCurrentMonth = date('m');
$iCurrentYear = date('Y');

$arrProjectsName = [];
$arrProjectsIds = [];

foreach ($arrProjects as &$arrProject) {
    $oMoney = new money();
    $oMoney->where = "`project_id` = '" . $arrProject['id'] . "' AND `date` LIKE '" . $dCurrentDate . "%' AND `type` > '0'";
    $arrMoneys = $oMoney->get();
    $iProjectSum = 0;
    foreach ($arrMoneys as &$arrMoney) {
      $arrProject['items'][] = $arrMoney;
      $iProjectSum = $iProjectSum + (int)$arrMoney['price'];
    }
    $arrProject['sum'] = $iProjectSum;
    $arrProjectsName[$arrProject['id']] = $arrProject['title'];
    $arrProjectsIds[$arrProject['id']] = $arrProject;
}

// Суммы по месяцам
$arrMounths = [];
for ($i=0; $i < 12; $i++) {
  $oMoney = new money();
  $oMoney->where = "`date` LIKE '" . date('Y') . '-' . sprintf("%02d", $i) . "%' AND `type` = '1'";
  $arrMoneys = $oMoney->get();
  $iMounthSum = 0;
  foreach ($arrMoneys as &$arrMoney) {
    $arrMounths[$i]['projects'][$arrMoney['project_id']] = (int)$arrMounths[$i]['projects'][$arrMoney['project_id']] + (int)$arrMoney['price'];
    // $arrProject['items'][] = $arrMoney;
    // $arrMounths[$i+1]['items'][] = $arrMoney;
    $iMounthSum = $iMounthSum + (int)$arrMoney['price'];
  }
  $arrMounths[$i]['sum'] = $iMounthSum;
  $arrMounths[$i]['name'] = date("F", strtotime(date("Y") . "-" . sprintf("%02d", $i)));
  // $arrMounths[$i+1] = $iMounthSum;
  // $arrMounths[$i]['categories'] = [];

  // foreach ($arrProjects as &$arrProject) {
  //   // code...
  // }
}

// Суммы по годам
$arrYears = [];
for ($i=0; $i < 2; $i++) {
  $oMoney = new money();
  $oMoney->where = "`date` LIKE '" . ( $iCurrentYear - $i ) . '-' . "%' AND `type` = '1'";
  $arrMoneys = $oMoney->get();
  $iYearSum = 0;
  foreach ($arrMoneys as &$arrMoney) {
    $arrYears[$iCurrentYear - $i]['projects'][$arrMoney['project_id']] = (int)$arrYears[$iCurrentYear - $i]['projects'][$arrMoney['project_id']] + (int)$arrMoney['price'];
    // $arrProject['items'][] = $arrMoney;
    // $arrYears[$i+1]['items'][] = $arrMoney;
    $iYearSum = $iYearSum + (int)$arrMoney['price'];
  }
  $arrYears[$iCurrentYear - $i]['sum'] = $iYearSum;
  $arrYears[$iCurrentYear - $i]['name'] = $iCurrentYear - $i;
  // $arrYears[$i+1] = $iMounthSum;
  // $arrYears[$i]['categories'] = [];

  // foreach ($arrProjects as &$arrProject) {
  //   // code...
  // }
}
?>
<main class="container pt-4 pb-4">
  <div class="row mb-4">
    <div class="col-12">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Moneys trip</h1>
          <p class="lead">Мои приходы за месяц</p>
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
          <h2>Приходы по проектам (<?=date("F")?>)</h2>
          <canvas id="doughnut-chart" width="100" height="400px" style="max-height: 400px;"></canvas>

          <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.0/dist/chart.min.js"></script>

          <script>
            var myChart = new Chart(document.getElementById("doughnut-chart"), {
              type: 'doughnut',
              data: {
                labels: [<?foreach ($arrProjects as $iIndex => &$arrProject) {
                  if ( $iIndex) echo ", '";
                  else echo "'";
                  echo $arrProject['title'] . "'";
                }?>],
                datasets: [
                  {
                    label: "Population (millions)",
                    data: [<?foreach ($arrProjects as $iIndex => &$arrProject) {
                      if ( $iIndex) echo ", '";
                      else echo "'";
                      echo $arrProject['sum'] . "'";
                    }?>],
                    backgroundColor: [<?foreach ($arrProjects as $iIndex => &$arrProject) {
                      if ( $iIndex) echo ", '";
                      else echo "'";
                      echo $arrProject['color'] ? $arrProject['color'] . "'" : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) ) . "'";
                    }?>]
                  }
                ]
              }
            })
            window.addEventListener('beforeprint', () => {
              myChart.resize(600, 600)
            })
            window.addEventListener('afterprint', () => {
              myChart.resize()
            })
          </script>
        </div>
        <div class="row mb-4 animate__animated animate__bounceInRight animate__delay-1s">
          <div class="col-12">
            <h2 class="text-center">
              <?=number_format($arrMounths[$iCurrentMonth]['sum'], 2, '.', ' ')?>₽
            </h2>
          </div>
        </div>
        <!-- Items -->
        <div class="row animate__animated animate__bounceInRight animate__delay-2s">
          <?
          foreach ($arrProjects as &$arrProject) {
          ?>
          <div class="col-12 mb-4 moneys_category animate__animated animate__bounceInRight animate__delay-1s">
            <div class="moneys_category-name">
              <h2>
                <span class="badge bg-primary" style="background: <?=$arrProject['color']?>!important">
                  <?=$arrProject['title']?>
                </span>
                <small>
                  <?=number_format($arrProject['sum'], 2, '.', ' ')?>₽
                </small>
              </h2>
            </div>
            <div class="moneys_category-data">
              <ol class="list-group list-group-numbered block_content_loader">
              <?
              // Прикручиваем рейтинги
              foreach ($arrProject['items'] as &$arrMoney) {
                ?>
                <li class="list-group-item money d-flex justify-content-between align-items-start _type_<?=$arrMoney['type']?>_" data-content_manager_item_id="<?=$arrMoney['id']?>"  data-content_loader_item_id="<?=$arrMoney['id']?>">
                  <div class="ms-2 me-auto">
                    <div class="fw-bold mb-1"><?=$arrMoney['title']?></div>
                    <div class="badge bg-primary " style="font-size: 1rem; font-weight: normal;">
                      <?=round($arrMoney['price'])?>₽
                    </div>
                    <span style="opacity: .5; font-size: .8rem; margin-right: 1rem">
                      <?
                      $date = new \DateTime($arrMoney['date']);
                      echo $date->format('Y-m-d');
                      ?>
                    </span>
                    <i class="fas fa-credit-card"></i> <small>#<?=$arrMoney['card']?></small> <?=$arrCardsIds[$arrMoney['card']]['title']?>
                  </div>
                </li>
                <?
              }
              ?>
              </ol>

              <div class="moneys_category-data_bg" style="background: <?=$arrProject['color']?>!important"></div>
            </div>
          </div>
          <?
          }
          ?>
        </div>
      </div>
    </div>
    <!-- Year -->
    <div class="tab-pane fade" id="pills-yaer" role="tabpanel" aria-labelledby="pills-yaer-tab">
      <div class="row mb-4 animate__animated animate__bounceInRight">
        <div class="col d-flex flex-column justify-content-center align-items-center">
          <h2>Приходы за год (<?=date("Y")?>)</h2>
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
                    <?foreach ($arrProjects as $iIndex => &$arrProject) {?>
                    {
                      label: "<?=$arrProject['title']?>",
                      data: [<?foreach ($arrMounths as $iIndex => &$arrMounth) {
                        if ( $iIndex ) echo ", ";
                        else echo "";

                        echo $arrMounth['projects'][$arrProject['id']] ? $arrMounth['projects'][$arrProject['id']] : '0';
                        // if ( count($arrMounth['categories']) ) echo $arrMounth['categories'][$arrProject['id']] . "";
                        // else echo $arrMounth['sum'] . "";
                      }?>],
                      borderColor: [<?foreach ($arrMounths as $iIndex => &$arrMounth) {
                        if ( $iIndex ) echo ", '";
                        else echo "'";
                        // echo $arrMounth['color'] ? $arrMounth['color'] . "'" : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) ) . "'";
                        echo $arrProject['color'] ? $arrProject['color'] . "'" : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) ) . "'";
                      }?>],
                      backgroundColor: [<?foreach ($arrMounths as $iIndex => &$arrMounth) {
                        if ( $iIndex ) echo ", '";
                        else echo "'";
                        // echo $arrMounth['color'] ? $arrMounth['color'] . "'" : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) ) . "'";
                        echo $arrProject['color'] ? $arrProject['color'] . "'" : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) ) . "'";
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
            <?=number_format($arrYears[$iCurrentYear]['sum'], 2, '.', ' ')?>₽
          </h2>
        </div>
      </div>
      <div class="row animate__animated animate__bounceInRight animate__delay-2s">
        <? foreach ($arrYears as & $arrYear): ?>
          <? if ( $arrYear['name'] ): ?>
            <h2>
              <?=$arrYear['name']?>
              <small>
                <?=number_format($arrYear['sum'], 2, '.', ' ')?>₽
              </small>
            </h2>
          <? endif; ?>
          <? foreach ($arrYear['projects'] as $iProjectId => $iProjectSum): ?>
            <h3>
              <span class="badge bg-primary" style="background: <?=$arrProjectsIds[$iProjectId]['color']?>!important">
                <?=$arrProjectsIds[$iProjectId]['title']?$arrProjectsIds[$iProjectId]['title']:'Без проекта'?>
              </span>

              <?=$iProjectSum ? number_format($iProjectSum, 2, '.', ' ') : '0' ?>₽
            </h3>
          <? endforeach; ?>
        <? endforeach; ?>

        <div class="col col-12">
          <?/*
          <?foreach ($arrProjects as $iIndex => &$arrProject) {?>
            <h2>
              <span class="badge bg-primary" style="background: <?=$arrProject['color']?>!important">
                <?=$arrProject['title']?>
              </span>

              <?=$arrProject['sum'] ? number_format($arrProject['sum'], 2, '.', ' ') : '0' ?>₽
            </h2>
            <ol class="list-group list-group-numbered block_content_loader">

            </ol>
          <?}?>
          */?>
        </div>
      </div>
    </div>
  </div>
</main>
