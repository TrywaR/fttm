<?
// Получаем категории
// $arrMoneys = $db->query_all($sQuery);

$oProject = new project();
$oProject->limit = 0;
$oProject->sort = 'sort';
$arrProjects = $oProject->get();

$dCurrentDate = date('Y-m');

foreach ($arrProjects as &$arrProject) {
    $oMoney = new money();
    $oMoney->where = "`project_id` = '" . $arrProject['id'] . "' AND `date` LIKE '" . $dCurrentDate . "%' AND `type` > '0'";
    $arrMoneys = $oMoney->get();
    $iProjectSum = 0;
    foreach ($arrMoneys as &$arrMoney) $iProjectSum = $iProjectSum + (int)$arrMoney['price'];
    $arrProject['sum'] = $iProjectSum;
}
?>
<main class="container pt-4 pb-4">
  <div class="row mb-4">
    <div class="col-12">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Moneys trip</h1>
          <p class="lead">Мои приходы</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Analitycs -->
  <div class="row">
    <div class="col mb-4 d-flex flex-column justify-content-center align-items-center">
      <h2>Приходы по проектам (<?=date("F")?>)</h2>
      <canvas id="doughnut-chart" width="100" height="400px" style="max-height: 400px;"></canvas>
    </div>
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
