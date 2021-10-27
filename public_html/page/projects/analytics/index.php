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
      <h2>Движ за год (<?=date("Y")?>)</h2>
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
                    echo $arrProject['color'] ? $arrProject['color'] . "'" : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) ) . "'";
                  }?>],
                  backgroundColor: [<?foreach ($arrWagesMounths as $iIndex => &$arrMounth) {
                    if ( $iIndex ) echo ", '";
                    else echo "'";
                    echo $arrProject['color'] ? $arrProject['color'] . "'" : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) ) . "'";
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
                    echo $arrProject['color'] ? $arrProject['color'] . "'" : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) ) . "'";
                  }?>],
                  backgroundColor: [<?foreach ($arrCostsMounths as $iIndex => &$arrMounth) {
                    if ( $iIndex ) echo ", '";
                    else echo "'";
                    echo $arrProject['color'] ? $arrProject['color'] . "'" : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) ) . "'";
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
  <div class="row mb-4 animate__animated animate__bounceInRight animate__delay-1s">
    <div class="col-12">
      <p class="text-center">
        Пришло <?=number_format($arrWagesYears[$iCurrentYear]['sum'], 2, '.', ' ')?>₽ <br/>
        Ушло <?=number_format($arrCostsYears[$iCurrentYear]['sum'], 2, '.', ' ')?>₽
      </p>
      <h2 class="text-center">
        <?
        $iYearProjectSum = (int)$arrWagesYears[$iCurrentYear]['sum'] - (int)$arrCostsYears[$iCurrentYear]['sum'];
        ?>
        <?=number_format($iYearProjectSum, 2, '.', ' ')?>₽
      </h2>
    </div>
  </div>
</main>
