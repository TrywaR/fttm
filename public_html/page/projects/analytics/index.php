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

$oProject = new project( $_REQUEST['project_id'] );
$arrProject = $oProject->get();
$arrProject['color'] = $arrProject['color'] ? $arrProject['color'] : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) ) . "'";

$arrMounths = [];
for ($i=0; $i < 12; $i++) $arrMounths[$i]['name'] = date("F", strtotime(date("Y") . "-" . sprintf("%02d", $i)));
$arrYears = [];
for ($i=0; $i < 2; $i++) $arrYears[$iCurrentYear - $i]['name'] = $iCurrentYear - $i;

// Доходы (Уэйдейсы)
// Суммы по месяцам
for ($i=0; $i < 12; $i++) {
  $oMoney = new money();
  $oMoney->where = "`date` LIKE '" . date('Y') . '-' . sprintf("%02d", $i) . "%' AND `type` = '1' AND `project_id` = " . $arrProject['id'];
  $arrMoneys = $oMoney->get();
  $iMounthSum = 0;
  foreach ($arrMoneys as &$arrMoney) {
    $arrWagesMounths[$i]['projects'][$arrMoney['project_id']] = (int)$arrWagesMounths[$i]['projects'][$arrMoney['project_id']] + (int)$arrMoney['price'];
    $iMounthSum = $iMounthSum + (int)$arrMoney['price'];
  }
  $arrWagesMounths[$i]['sum'] = $iMounthSum;
}
// Суммы по годам
$arrWagesYears = [];
for ($i=0; $i < 2; $i++) {
  $oMoney = new money();
  $oMoney->where = "`date` LIKE '" . ( $iCurrentYear - $i ) . '-' . "%' AND `type` = '1' AND `project_id` = " . $arrProject['id'];
  $arrMoneys = $oMoney->get();
  $iYearSum = 0;
  foreach ($arrMoneys as &$arrMoney) {
    $arrYears[$iCurrentYear - $i]['projects'][$arrMoney['project_id']] = (int)$arrYears[$iCurrentYear - $i]['projects'][$arrMoney['project_id']] + (int)$arrMoney['price'];
    $iYearSum = $iYearSum + (int)$arrMoney['price'];
  }
  $arrWagesYears[$iCurrentYear - $i]['sum'] = $iYearSum;
  $arrWagesYears[$iCurrentYear - $i]['name'] = $iCurrentYear - $i;
}


// Расходы (Косты)
// Суммы по месяцам
$arrCostsMounths = [];
for ($i=0; $i < 12; $i++) {
  $oMoney = new money();
  $oMoney->where = "`date` LIKE '" . date('Y') . '-' . sprintf("%02d", $i) . "%' AND `type` = '0' AND `project_id` = " . $arrProject['id'];
  $arrMoneys = $oMoney->get();
  $iMounthSum = 0;
  foreach ($arrMoneys as &$arrMoney) {
    $arrCostsMounths[$i]['projects'][$arrMoney['project_id']] = (int)$arrCostsMounths[$i]['projects'][$arrMoney['project_id']] + (int)$arrMoney['price'];
    $iMounthSum = $iMounthSum + (int)$arrMoney['price'];
  }
  $arrCostsMounths[$i]['sum'] = $iMounthSum;
  $arrCostsMounths[$i]['name'] = date("F", strtotime(date("Y") . "-" . sprintf("%02d", $i)));
}
// Суммы по годам
$arrCostsYears = [];
for ($i=0; $i < 2; $i++) {
  $oMoney = new money();
  $oMoney->where = "`date` LIKE '" . ( $iCurrentYear - $i ) . '-' . "%' AND `type` = '0' AND `project_id` = " . $arrProject['id'];
  $arrMoneys = $oMoney->get();
  $iYearSum = 0;
  foreach ($arrMoneys as &$arrMoney) {
    $arrYears[$iCurrentYear - $i]['projects'][$arrMoney['project_id']] = (int)$arrYears[$iCurrentYear - $i]['projects'][$arrMoney['project_id']] + (int)$arrMoney['price'];
    $iYearSum = $iYearSum + (int)$arrMoney['price'];
  }
  $arrCostsYears[$iCurrentYear - $i]['sum'] = $iYearSum;
  $arrCostsYears[$iCurrentYear - $i]['name'] = $iCurrentYear - $i;
}

// Время на проект
// Суммы по месяцам
$arrTimesMounths = [];
for ($i=0; $i < 12; $i++) {
  $oTime = new time();
  $oTime->where = "`date` LIKE '" . date('Y') . '-' . sprintf("%02d", $i) . "%' AND `project_id` = " . $_REQUEST['project_id'];
  $arrTimes = $oTime->get();
  $iMounthSum = 0;
  foreach ($arrTimes as &$arrTime) {
    $dDateReally = new DateTime($arrTime['time_really']);
    $arrTime['time'] = $dDateReally->format('H.i');

    $arrTimesMounths[$i]['value'] = (float)$arrTimesMounths[$i]['value'] + (float)$arrTime['time'];
    $iMounthSum = $iMounthSum + (float)$arrTime['time'];
  }
  $arrTimesMounths[$i]['sum'] = $iMounthSum;
  $arrTimesMounths[$i]['name'] = date("F", strtotime(date("Y") . "-" . sprintf("%02d", $i)));
}
// Время по годам
$arrTimesYears = [];
for ($i=0; $i < 2; $i++) {
  $oTime = new time();
  $oTime->where = "`date` LIKE '" . ( $iCurrentYear - $i ) . '-' . "%' AND `project_id` = " . $arrProject['id'];
  $arrMoneys = $oTime->get();
  $iYearSum = 0;
  foreach ($arrMoneys as &$arrTime) {
    $arrYears[$iCurrentYear - $i]['projects'][$arrTime['project_id']] = (float)$arrYears[$iCurrentYear - $i]['projects'][$arrTime['project_id']] + (float)$arrTime['time'];
    $iYearSum = $iYearSum + (float)$arrTime['time'];
  }
  $arrTimesYears[$iCurrentYear - $i]['sum'] = $iYearSum;
  $arrTimesYears[$iCurrentYear - $i]['name'] = $iCurrentYear - $i;
}
?>
<main class="container pt-4 pb-4">
  <div class="row mb-4">
    <div class="col-12">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4"><?=$arrProject['title']?></h1>
        </div>
      </div>
    </div>
  </div>

  <div class="row mb-4 animate__animated animate__bounceInRight">
    <div class="col d-flex flex-column justify-content-center align-items-center">
      <h2>Движ денежег за год (<?=date("Y")?>)</h2>
      <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.0/dist/chart.min.js"></script>
      <canvas id="bar-chart" width="100" height="400px" style="max-height: 400px;"></canvas>
      <script>
        var myBar = new Chart(document.getElementById("bar-chart"), {
          type: 'line',
          data: {
            labels: [<?foreach ($arrMounths as $key => $arrMounth) {
              if ( $key ) echo ", '";
              else echo "'";
              echo $arrMounth['name'] . "'";
            }?>],
            datasets:
              [
                {
                  label: 'Приходы (Уэйджейсы)',
                  data: [<?foreach ($arrWagesMounths as $iIndex => &$arrMounth) {
                    if ( $iIndex ) echo ", ";
                    else echo "";
                    echo $arrMounth['projects'][$arrProject['id']] ? $arrMounth['projects'][$arrProject['id']] : '0';
                  }?>],
                  borderColor: [<?foreach ($arrWagesMounths as $iIndex => &$arrMounth) {
                    if ( $iIndex ) echo ", '";
                    else echo "'";
                    echo '#00ffff';
                    echo "'";
                  }?>],
                  backgroundColor: [<?foreach ($arrWagesMounths as $iIndex => &$arrMounth) {
                    if ( $iIndex ) echo ", '";
                    else echo "'";
                    echo '#00ffff';
                    echo "'";
                  }?>]
                },
                {
                  label: 'Расходы (Косты)',
                  data: [<?foreach ($arrCostsMounths as $iIndex => &$arrMounth) {
                    if ( $iIndex ) echo ", ";
                    else echo "";
                    echo $arrMounth['projects'][$arrProject['id']] ? $arrMounth['projects'][$arrProject['id']] : '0';
                  }?>],
                  borderColor: [<?foreach ($arrCostsMounths as $iIndex => &$arrMounth) {
                    if ( $iIndex ) echo ", '";
                    else echo "'";
                    echo '#00ff00';
                    echo "'";
                  }?>],
                  backgroundColor: [<?foreach ($arrCostsMounths as $iIndex => &$arrMounth) {
                    if ( $iIndex ) echo ", '";
                    else echo "'";
                    echo '#00ff00';
                    echo "'";
                  }?>]
                },
              ],
          },
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

  <div class="row mb-4 animate__animated animate__bounceInRight">
    <div class="col d-flex flex-column justify-content-center align-items-center">
      <h2>Время за год (<?=date("Y")?>)</h2>
      <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.0/dist/chart.min.js"></script>
      <canvas id="bar-chart-time" width="100" height="400px" style="max-height: 400px;"></canvas>
      <script>
        var myBarTime = new Chart(document.getElementById("bar-chart-time"), {
          type: 'line',
          data: {
            labels: [<?foreach ($arrMounths as $key => $arrMounth) {
              if ( $key ) echo ", '";
              else echo "'";

              $fPrice = (float)$arrWagesMounths[$key]['projects'][$_REQUEST['project_id']] - (float)$arrCostsMounths[$key]['projects'][$_REQUEST['project_id']];
              $fTime = (float)$arrTimesMounths[$key]['value'];
              $fPriceForHour = $fTime > 0 ? $fPrice / $fTime : 0;
              $fPriceForHour = (float)$fPriceForHour > 0 ? $fPriceForHour : 0;

              // echo $arrMounth['name'] . " (" .  . ")'";
              echo $arrMounth['name'] . " (" . number_format($fPriceForHour, 2, '.', ' ') . "₽)'";
            }?>],
            datasets:
              [
                {
                  label: 'Время (Тиме)',
                  data: [<?foreach ($arrTimesMounths as $iIndex => &$arrMounth) {
                    if ( $iIndex ) echo ", ";
                    else echo "";
                    echo $arrMounth['value'] ? $arrMounth['value'] : '0';
                  }?>],
                  borderColor: [<?foreach ($arrTimesMounths as $iIndex => &$arrMounth) {
                    if ( $iIndex ) echo ", '";
                    else echo "'";
                    echo '#ff0000';
                    echo "'";
                  }?>],
                  backgroundColor: [<?foreach ($arrTimesMounths as $iIndex => &$arrMounth) {
                    if ( $iIndex ) echo ", '";
                    else echo "'";
                    echo '#ff0000';
                    echo "'";
                  }?>]
                },
              ],
          },
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
          myBarTime.resize(600, 600);
        });
        window.addEventListener('afterprint', () => {
          myBarTime.resize();
        });
      </script>
    </div>
  </div>

  <div class="row mb-4 animate__animated animate__bounceInRight animate__delay-1s">
    <div class="col-12">
      <p class="text-center">
        Пришло <?=number_format($arrWagesYears[$iCurrentYear]['sum'], 2, '.', ' ')?>₽ <br/>
        Ушло <?=number_format($arrCostsYears[$iCurrentYear]['sum'], 2, '.', ' ')?>₽ <br/>

        <?
        $fPrice = (float)$arrWagesYears[$iCurrentYear]['sum'] - (float)$arrCostsYears[$iCurrentYear]['sum'];
        $fTime = (float)$arrTimesYears[$iCurrentYear]['sum'];
        $fPriceForHour = $fTime > 0 ? $fPrice / $fTime : 0;
        $fPriceForHour = (float)$fPriceForHour > 0 ? $fPriceForHour : 0;
        ?>
        <small>За час <?=number_format($fPriceForHour, 2, '.', ' ')?>₽</small>
      </p>
      <h2 class="text-center">
        <?
        $iYearProjectSum = (int)$arrWagesYears[$iCurrentYear]['sum'] - (int)$arrCostsYears[$iCurrentYear]['sum'];
        ?>
        <?=number_format($iYearProjectSum, 2, '.', ' ')?>₽
      </h2>
    </div>
  </div>

  <div class="row mb-4 animate__animated animate__bounceInRight animate__delay-1s">
    <div class="col">
      <h2>Расходы</h2>
    </div>
    <div class="list-group mb-4">
      <?
      $oMoney = new money();
      $oMoney->where = "`date` LIKE '" . date('Y-') . "%' AND `type` = '0' AND `project_id` = " . $arrProject['id'];
      $arrMoneys = $oMoney->get();
      ?>
      <?php foreach ($arrMoneys as $arrMoney): ?>
        <div class="list-group-item money d-flex justify-content-between align-items-start animate__animated animate__bounceInRight _type_{{type}}_" data-content_manager_item_id="{{id}}"  data-content_loader_item_id="{{id}}">
          <div class="ms-2 me-auto">
            <div class="fw-bold mb-1"><?=$arrMoney['title']?></div>
            <div class="badge bg-primary" style="font-size: 1rem; font-weight: normal;">
              <?=number_format($arrMoney['price'], 2, '.', ' ')?>₽
            </div>
            <span style="opacity: .5; font-size: .8rem; margin-right: 1rem">
              <?=$arrMoney['date']?>
            </span>
            <i class="fas fa-credit-card"></i> <?=$arrMoney['card']?>
          </div>
          <span class="rounded-pill">
            <!-- <a href="#" class="btn content_manager_switch switch_icons">
              <div class="">
                <i class="far fa-square"></i>
              </div>
              <div class="">
                <i class="fas fa-square"></i>
              </div>
            </a>
            <a href="#" class="btn content_download" data-id="{{id}}" data-action="moneys" data-form="edit" data-elem=".list-group-item" data-animate_class="animate__flipInY">
              <i class="fas fa-pen-square"></i>
            </a>
            <a href="#" class="btn content_download" data-id="{{id}}" data-action="moneys" data-form="del" data-elem=".list-group-item" data-animate_class="animate__fadeOutRightBig"><i class="fas fa-minus-square"></i></a> -->
          </span>

          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="col">
      <h2>Приходы</h2>
    </div>
    <div class="list-group">
      <?
      $oMoney = new money();
      $oMoney->where = "`date` LIKE '" . date('Y-') . "%' AND `type` = '1' AND `project_id` = " . $arrProject['id'];
      $arrMoneys = $oMoney->get();
      ?>
      <?php foreach ($arrMoneys as $arrMoney): ?>
        <div class="list-group-item money d-flex justify-content-between align-items-start animate__animated animate__bounceInRight _type_{{type}}_" data-content_manager_item_id="{{id}}"  data-content_loader_item_id="{{id}}">
          <div class="ms-2 me-auto">
            <div class="fw-bold mb-1"><?=$arrMoney['title']?></div>
            <div class="badge bg-primary" style="font-size: 1rem; font-weight: normal;">
              <?=number_format($arrMoney['price'], 2, '.', ' ')?>₽
            </div>
            <span style="opacity: .5; font-size: .8rem; margin-right: 1rem">
              <?=$arrMoney['date']?>
            </span>
            <i class="fas fa-credit-card"></i> <?=$arrMoney['card']?>
          </div>
          <span class="rounded-pill">
            <!-- <a href="#" class="btn content_manager_switch switch_icons">
              <div class="">
                <i class="far fa-square"></i>
              </div>
              <div class="">
                <i class="fas fa-square"></i>
              </div>
            </a>
            <a href="#" class="btn content_download" data-id="{{id}}" data-action="moneys" data-form="edit" data-elem=".list-group-item" data-animate_class="animate__flipInY">
              <i class="fas fa-pen-square"></i>
            </a>
            <a href="#" class="btn content_download" data-id="{{id}}" data-action="moneys" data-form="del" data-elem=".list-group-item" data-animate_class="animate__fadeOutRightBig"><i class="fas fa-minus-square"></i></a> -->
          </span>

          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</main>
