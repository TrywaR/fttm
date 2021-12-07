<?
// Получаем категории
// $arrMoneys = $db->query_all($sQuery);

$oMoneysCategory = new moneys_category();
$oMoneysCategory->limit = 0;
$oMoneysCategory->sort = 'sort';
$arrMoneysCategories = $oMoneysCategory->get();

$oCards = new card();
$oCards->limit = 0;
$oCards->sort = 'sort';
$arrCards = $oCards->get();
foreach ($arrCards as $arrCard) $arrCardsIds[$arrCard['id']] = $arrCard;

$dCurrentDate = date('Y-m');
$iCurrentMonth = date('m');
$iCurrentYear = date('Y');

$arrMoneysCategoriesName = [];
$arrMoneysCategoriesIds = [];

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
  $arrMoneysCategoriesName[$arrMoneysCategory['id']] = $arrMoneysCategory['title'];
  $arrMoneysCategoriesIds[$arrMoneysCategory['id']] = $arrMoneysCategory;
}

// Неделя
$arrWeeks = [];
$dDate1 = date('Y-m-d', strtotime('monday this week'));
$dDate2 = date('Y-m-d', strtotime('sunday this week'));
// prev
if ( $_REQUEST['date_start'] != '' && $_REQUEST['date_stop'] != '' ) {
  $dDate1 = date('Y-m-d', strtotime($_REQUEST['date_start']));
  $dDate2 = date('Y-m-d', strtotime($_REQUEST['date_stop']));
}
// $dDate1 = date('Y-m-d', strtotime('-8 day', strtotime('monday this week')));
// $dDate2 = date('Y-m-d', strtotime('-1 day', strtotime('monday this week')));
// $dDate2 = date('Y-m-d', strtotime('sunday this week'));
$dDateCurrent = $dDate1;

for ($i=1; $i < 3; $i++) {
  $arrDays = [];
  $iIndex = 1;
  while (strtotime($dDateCurrent) < strtotime($dDate2)) {
    if ( $iIndex > 1 ) $dDateCurrent = date('Y-m-d', strtotime('+1 day', strtotime($dDateCurrent)));
    $arrWeeks[$i]['days'][$iIndex]['title'] = $dDateCurrent;

    $oMoney = new money();
    $oMoney->where = "`date` = '" . $dDateCurrent . "'";
    $arrMoneys = $oMoney->get();
    $iDaySum = 0;

    foreach ($arrMoneysCategoriesIds as $key => $arrMoneysCategory) {
      $arrWeeks[$i]['days'][$iIndex]['categories'][$key]['title'] = $arrMoneysCategory['title'];
      $arrWeeks[$i]['days'][$iIndex]['categories'][$key]['value'] = 0;
      $arrWeeks[$i]['days'][$iIndex]['categories'][$key]['color'] = $arrMoneysCategory['color'];
    }

    foreach ($arrMoneys as &$arrMoney) {
      // $dDateReally = new DateTime($arrMoney['time_really']);
      // $arrMoney['price'] = $dDateReally->format('H.i');
      $arrWeeks[$i]['days'][$iIndex]['categories'][$arrMoney['category']]['price'] = (float)$arrWeeks[$i]['days'][$iIndex]['categories'][$arrMoney['category']]['price'] + (float)$arrMoney['price'];
      // $iDaySum = $iDaySum + (float)$arrMoney['price'];

      // $arrWeeks[$i]['categories'][$arrMoney['category']] = (int)$arrWeeks[$i]['categories'][$arrMoney['category']] + (int)$arrMoney['price'];
      // $arrMoneysCategory['items'][] = $arrMoney;
      // $arrMounths[$i+1]['items'][] = $arrMoney;
      $iDaySum = $iDaySum + (int)$arrMoney['price'];
    }
    $arrWeeks[$i]['days'][$iIndex]['sum'] = $iDaySum;
    $arrWeeks[$i]['sum'] = (float)$arrWeeks[$i]['sum'] + (float)$iDaySum;
    $iIndex++;
  }
}

// Суммы по месяцам
$arrMounths = [];
for ($i=1; $i < 13; $i++) {
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

// Суммы по годам
$arrYears = [];
for ($i=0; $i < 3; $i++) {
  $oMoney = new money();
  $oMoney->where = "`date` LIKE '" . ( $iCurrentYear - $i ) . '-' . "%' AND `type` = '0'";
  $arrMoneys = $oMoney->get();
  $iYearSum = 0;
  foreach ($arrMoneys as &$arrMoney) {
    $arrYears[$iCurrentYear - $i]['categories'][$arrMoney['category']] = (int)$arrYears[$iCurrentYear - $i]['categories'][$arrMoney['category']] + (int)$arrMoney['price'];
    // $arrMoneysCategory['items'][] = $arrMoney;
    // $arrYears[$i+1]['items'][] = $arrMoney;
    $iYearSum = $iYearSum + (int)$arrMoney['price'];
  }
  $arrYears[$iCurrentYear - $i]['sum'] = $iYearSum;
  $arrYears[$iCurrentYear - $i]['name'] = $iCurrentYear - $i;
  // $arrYears[$i+1] = $iMounthSum;
  // $arrYears[$i]['categories'] = [];

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
          <h1 class="display-4">Moneys costs</h1>
          <p class="lead">
            <span class="icon">
              <i class="fas fa-arrow-left"></i>
            </span>
            <a href="/moneys/">Moneys</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="pills-week-tab" data-bs-toggle="pill" data-bs-target="#pills-week" type="button" role="tab" aria-controls="pills-week" aria-selected="true">Week</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="pills-month-tab" data-bs-toggle="pill" data-bs-target="#pills-month" type="button" role="tab" aria-controls="pills-month" aria-selected="true">Mounth</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="pills-yaer-tab" data-bs-toggle="pill" data-bs-target="#pills-yaer" type="button" role="tab" aria-controls="pills-yaer" aria-selected="false">Year</button>
    </li>
  </ul>
  <div class="tab-content" id="pills-tabContent">
    <!-- Week -->
    <div class="tab-pane fade show active" id="pills-week" role="tabpanel" aria-labelledby="pills-week-tab">
      <div class="row mb-4 animate__animated animate__bounceInRight">
        <div class="col-12 mb-4">
          <h3 class="text-center">Money interval</h3>
          <form class="__no_ajax" action="" method="get">
            <div class="row text-center">
              <div class="col-12">
                <input type="date" name="date_start" value="<?=$_REQUEST['date_start']?>">
                <input type="date" name="date_stop" value="<?=$_REQUEST['date_stop']?>">
                <button type="submit" name="button" class="btn"><i class="far fa-paper-plane"></i></button>
              </div>
            </div>
          </form>
        </div>

        <div class="col mb-4 d-flex flex-column justify-content-center align-items-center">
          <h2>Spent money for categories</h2>
          <small><?=$dDate1?>, <?=$dDate2?></small>
          <canvas id="week-chart" width="100" height="400px" style="max-height: 400px;"></canvas>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.0/dist/chart.min.js"></script>

        <script>
          var myLineWeek = new Chart(document.getElementById("week-chart"), {
            type: 'line',
            data: {
              labels: [<?foreach ($arrWeeks as $arrWeek) {
                foreach ($arrWeek['days'] as $iIndex => $arrDay) {
                  if ( $iIndex > 1 ) echo ", '";
                  else echo "'";
                  echo $arrDay['title'];
                  echo "'";
                }
              }?>],
              datasets: [
                <?foreach ($arrMoneysCategoriesIds as $iIndexCategory => &$arrMoneysCategory) {?>
                  {
                    label: "<?=$arrMoneysCategory['title']?>",
                    data: [<?foreach ($arrWeeks as $arrWeek) {
                      foreach ($arrWeek['days'] as $iIndexDay => $arrDay) {
                        if ( $iIndexDay > 1 ) echo ", '";
                        else echo "'";
                        echo $arrWeek['days'][$iIndexDay]['categories'][$iIndexCategory]['price'];
                        echo "'";
                      }
                    }?>],
                    borderColor: [<?foreach ($arrWeeks as $arrWeek) {
                      foreach ($arrWeek['days'] as $iIndexDay => $arrDay) {
                        if ( $iIndexDay > 1 ) echo ", '";
                        else echo "'";
                        echo $arrWeek['days'][$iIndexDay]['categories'][$iIndexCategory]['color'];
                        echo "'";
                      }
                    }?>],
                    backgroundColor: [<?foreach ($arrWeeks as $arrWeek) {
                      foreach ($arrWeek['days'] as $iIndexDay => $arrDay) {
                        if ( $iIndexDay > 1 ) echo ", '";
                        else echo "'";
                        echo $arrWeek['days'][$iIndexDay]['categories'][$iIndexCategory]['color'];
                        echo "'";
                      }
                    }?>],
                  },
                <?}?>
              ]
            }
          })
          window.addEventListener('beforeprint', () => {
            myLineWeek.resize(600, 600);
          });
          window.addEventListener('afterprint', () => {
            myLineWeek.resize();
          });
        </script>
      </div>
      <div class="row mb-4 animate__animated animate__bounceInRight animate__delay-1s">
        <div class="col-12">
          <h2 class="text-center">
            <?=number_format($arrWeeks[1]['sum'], 2, '.', ' ')?>₽
          </h2>
        </div>
      </div>
    </div>

    <!-- Month -->
    <div class="tab-pane fade" id="pills-month" role="tabpanel" aria-labelledby="pills-month-tab">
      <div class="row mb-4 animate__animated animate__bounceInRight">
        <div class="col mb-4 d-flex flex-column justify-content-center align-items-center">
          <h2>Costs for month (<?=date("F")?>)</h2>
          <canvas id="doughnut-chart" width="100" height="400px" style="max-height: 400px;"></canvas>
        </div>
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
        foreach ($arrMoneysCategories as &$arrMoneysCategory) {
        ?>
        <div class="col-12 mb-4 moneys_category animate__animated animate__bounceInRight animate__delay-1s">
          <div class="moneys_category-name">
            <h2>
              <span class="badge bg-primary" style="background: <?=$arrMoneysCategory['color']?>!important">
                <?=$arrMoneysCategory['title']?>
              </span>
              <small>
                <?=number_format($arrMoneysCategory['sum'], 2, '.', ' ')?>₽
              </small>
            </h2>
          </div>
          <div class="moneys_category-data">
            <ol class="list-group list-group-numbered block_content_loader">
            <?
            // Прикручиваем рейтинги
            foreach ($arrMoneysCategory['items'] as &$arrMoney) {
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

            <div class="moneys_category-data_bg" style="background: <?=$arrMoneysCategory['color']?>!important"></div>
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
          <h2>Costs for year (<?=date("Y")?>)</h2>
          <canvas id="bar-chart" width="100" height="400px" style="max-height: 400px;"></canvas>
          <script>
            var myBar = new Chart(document.getElementById("bar-chart"), {
              type: 'line',
              data: {
                labels: [<?foreach ($arrMounths as $key => $arrMounth) {
                  if ( $key > 1 ) echo ", '";
                  else echo "'";
                  echo $arrMounth['name'] . " (" . $arrMounth['sum'] . ")'";
                }?>],
                datasets:
                  [
                    <?foreach ($arrMoneysCategories as $iIndex => &$arrMoneysCategory) {?>
                    {
                      label: "<?=$arrMoneysCategory['title']?>",
                      data: [<?foreach ($arrMounths as $iIndex => &$arrMounth) {
                        if ( $iIndex > 1 ) echo ", ";
                        else echo "";

                        echo $arrMounth['categories'][$arrMoneysCategory['id']] ? $arrMounth['categories'][$arrMoneysCategory['id']] : '0';
                        // if ( count($arrMounth['categories']) ) echo $arrMounth['categories'][$arrMoneysCategory['id']] . "";
                        // else echo $arrMounth['sum'] . "";
                      }?>],
                      borderColor: [<?foreach ($arrMounths as $iIndex => &$arrMounth) {
                        if ( $iIndex > 1 ) echo ", '";
                        else echo "'";
                        // echo $arrMounth['color'] ? $arrMounth['color'] . "'" : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) ) . "'";
                        echo $arrMoneysCategory['color'] ? $arrMoneysCategory['color'] . "'" : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) ) . "'";
                      }?>],
                      backgroundColor: [<?foreach ($arrMounths as $iIndex => &$arrMounth) {
                        if ( $iIndex > 1 ) echo ", '";
                        else echo "'";
                        // echo $arrMounth['color'] ? $arrMounth['color'] . "'" : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) ) . "'";
                        echo $arrMoneysCategory['color'] ? $arrMoneysCategory['color'] . "'" : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) ) . "'";
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
          <? foreach ($arrYear['categories'] as $iCategiryId => $iCategorySum): ?>
            <h3>
              <span class="badge bg-primary" style="background: <?=$arrMoneysCategoriesIds[$iCategiryId]['color']?>!important">
                <?=$arrMoneysCategoriesIds[$iCategiryId]['title']?>
              </span>

              <?=$iCategorySum ? number_format($iCategorySum, 2, '.', ' ') : '0' ?>₽
            </h3>
          <? endforeach; ?>
        <? endforeach; ?>

        <div class="col col-12">
          <?/*
          <?foreach ($arrMoneysCategories as $iIndex => &$arrMoneysCategory) {?>
            <h2>
              <span class="badge bg-primary" style="background: <?=$arrMoneysCategory['color']?>!important">
                <?=$arrMoneysCategory['title']?>
              </span>

              <?=$arrMoneysCategory['sum'] ? number_format($arrMoneysCategory['sum'], 2, '.', ' ') : '0' ?>₽
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
</main>
