<?
// Получаем категории
$oTimesCategory = new times_category();
$oTimesCategory->limit = 0;
$oTimesCategory->sort = 'sort';
$oTimesCategory->query = ' AND ( `user_id` = ' . $_SESSION['user']['id'] . '  OR `user_id` = 0)';
$arrTimesCategories = $oTimesCategory->get();
foreach ($arrTimesCategories as &$arrTimesCategory) $arrTimesCategoriesIds[$arrTimesCategory['id']] = $arrTimesCategory;

// Считаем неделю
$arrWeek = [];
$dDateStart = $dDateCurrent = date('Y-m-d', strtotime('monday this week'));
$dDateStop = date('Y-m-d', strtotime('sunday this week'));

// Перебираем дни недели
$iIndex = 1;
while (strtotime($dDateCurrent) < strtotime($dDateStop)) {
  if ( $iIndex > 1 ) $dDateCurrent = date('Y-m-d', strtotime('+1 day', strtotime($dDateCurrent)));

  // Заполняем данные
  $arrWeek['days'][$iIndex]['title'] = $dDateCurrent;

  // Подготавливаем категории
  foreach ($arrTimesCategoriesIds as $key => $arrTimesCategory) {
    $arrWeek['days'][$iIndex]['categories'][$key]['title'] = $arrTimesCategory['title'];
    $arrWeek['days'][$iIndex]['categories'][$key]['color'] = $arrTimesCategory['color'];
    $arrWeek['days'][$iIndex]['categories'][$key]['id'] = $arrTimesCategory['id'];
    $arrWeek['days'][$iIndex]['categories'][$key]['value'] = 0;
  }

  // Собираем потраченное время
  $oTime = new time();
  $oTime->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
  $oTime->query .= " AND `date` = '" . $dDateCurrent . "'";
  $arrTimes = $oTime->get();
  $iDaySum = 0;

  // Записываем данные по категориям за неделю
  foreach ($arrTimes as $arrTime) {
    $dDateReally = new DateTime($arrTime['time_really']);
    $arrTime['time'] = $dDateReally->format('H.i');
    $arrWeek['days'][$iIndex]['categories'][$arrTime['category_id']]['value'] = (float)$arrWeek['days'][$iIndex]['categories'][$arrTime['category_id']]['value'] + (float)$arrTime['time'];
    $iDaySum = $iDaySum + (float)$arrTime['time'];
  }

  $arrWeek['days'][$iIndex]['sum'] = $iDaySum;
  $arrWeek['sum'] = (float)$arrWeek['sum'] + (float)$iDaySum;

  $iIndex++;
}
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.0/dist/chart.min.js"></script>

<main class="container animate__animated animate__fadeIn">
  <div class="row mb-4">
    <div class="col-12">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Times trip</h1>
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
    <div class="col-12">
      <!-- Week -->
      <div class="tab-pane fade show active" id="pills-week" role="tabpanel" aria-labelledby="pills-week-tab">
        <div class="row mb-4 animate__animated animate__bounceInRight">
          <div class="col mb-4 d-flex flex-column justify-content-center align-items-center">
            <h2>Time spent for week</h2>
            <small><?=$dDateStart?>, <?=$dDateStop?></small>
            <canvas id="week-chart" width="100" height="400px" style="max-height: 400px;"></canvas>
            <script>
              var myLineWeek = new Chart(document.getElementById("week-chart"), {
                type: 'line',
                data: {
                  labels: [<?
                    foreach ($arrWeek['days'] as $iIndex => $arrDay) {
                      if ( $iIndex > 1 ) echo ", '";
                      else echo "'";
                      echo $arrDay['title'];
                      echo "'";
                    }
                  ?>],
                  datasets: [
                    <?foreach ($arrTimesCategoriesIds as $iIndexCategory => &$arrTimesCategory) {?>
                      {
                        label: "<?=$arrTimesCategory['title']?>",
                        data: [<?
                          foreach ($arrWeek['days'] as $iIndexDay => $arrDay) {
                            if ( $iIndexDay > 1 ) echo ", '";
                            else echo "'";
                            echo $arrWeek['days'][$iIndexDay]['categories'][$iIndexCategory]['value'];
                            echo "'";
                          }
                        ?>],
                        borderColor: [<?
                          foreach ($arrWeek['days'] as $iIndexDay => $arrDay) {
                            if ( $iIndexDay > 1 ) echo ", '";
                            else echo "'";
                            echo $arrWeek['days'][$iIndexDay]['categories'][$iIndexCategory]['color'];
                            echo "'";
                          }
                        ?>],
                        backgroundColor: [<?
                          foreach ($arrWeek['days'] as $iIndexDay => $arrDay) {
                            if ( $iIndexDay > 1 ) echo ", '";
                            else echo "'";
                            echo $arrWeek['days'][$iIndexDay]['categories'][$iIndexCategory]['color'];
                            echo "'";
                          }
                        ?>],
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
            <div class="col-12">
              <h2 class="text-center">
                <?=$arrWeek['sum']?>ч
              </h2>
            </div>
          </div>
        </div>

        <div class="row mb-4 animate__animated animate__bounceInRight animate__delay-1s">
          <div class="col mb-4 d-flex flex-column justify-content-center align-items-center">
            <h2>Effeciency</h2>
            <small><?=$dDateStart?>, <?=$dDateStop?></small>
            <canvas id="week-ef-chart" width="100" height="400px" style="max-height: 400px;"></canvas>
          </div>

          <script>
            var myLineWeekEf = new Chart(document.getElementById("week-ef-chart"), {
              type: 'line',
              data: {
                labels: [<?
                  foreach ($arrWeek['days'] as $iIndex => $arrDay) {
                    if ( $iIndex > 1 ) echo ", '";
                    else echo "'";
                    echo $arrDay['title'];
                    echo "'";
                  }
                ?>],
                datasets: [
                  {
                    label: 'Credited',
                    data: [<?
                      foreach ($arrWeek['days'] as $iIndex => $arrDay) {
                        if ( $iIndex > 1 ) echo ", '";
                        else echo "'";
                        echo $arrDay['sum'];
                        echo "'";
                      }
                    ?>],
                    borderColor: [<?
                      foreach ($arrWeek['days'] as $iIndex => $arrDay) {
                        if ( $iIndex > 1 ) echo ", '";
                        else echo "'";
                        echo '#00ff00';
                        echo "'";
                      }
                    ?>],
                    backgroundColor: [<?
                      foreach ($arrWeek['days'] as $iIndex => $arrDay) {
                        if ( $iIndex > 1 ) echo ", '";
                        else echo "'";
                        echo '#00ff00';
                        echo "'";
                      }
                    ?>]
                  }
                ]
              },
              options: {
                responsive: true,
                plugins: {
                  legend: false,
                  title: {
                    display: false
                  }
                },
                scales: {
                  y: {
                    min: 0,
                    max: 24,
                  }
                }
              },
            })
            window.addEventListener('beforeprint', () => {
              myLineWeekEf.resize(600, 600);
            });
            window.addEventListener('afterprint', () => {
              myLineWeekEf.resize();
            });
          </script>
        </div>
      </div>
    </div>
  </div>
</main>
