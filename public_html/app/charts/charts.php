<?
switch ($_REQUEST['form']) {
  case 'show': # Вывод элементов
    // Данные

    // Генерируем уникальный хэш для названия
    // Символы, которые будут использоваться в хэше.
    $chars="qazxswedcvfrtgbnhyujmkiolpQAZXSWEDCVFRTGBNHYUJMKIOLP";
    // Количество символов в хэше.
    $max=6;
    // Определяем количество символов в $chars
    $size=StrLen($chars)-1;
    // Определяем пустую переменную, в которую и будем записывать символы.
    $sHash=null;
    // Создаём хэше.
    while($max--) $sHash.=$chars[rand(0,$size)];

    $arrDataset = $_REQUEST['dataset']; # Данные
    $arrCategories = $_REQUEST['categories']; # Категории
    $sChartType = $_REQUEST['chart_type'] ? $_REQUEST['chart_type'] : 'line'; # Тип графика
    $sChartTypeSum = $_REQUEST['chart_type_sum'] ? $_REQUEST['chart_type_sum'] : 'line'; # Тип графика
    $arrResults = []; # Результат

    ob_start();
    ?>
    <canvas id="<?=$sHash?>" width="100%" height="400px" style="max-height: 400px;"></canvas>
    <script>
      var <?=$sHash?> = new Chart(document.getElementById("<?=$sHash?>"), {
        type: '<?=$sChartType?>',
        data: {
          labels: [<?
            foreach ($arrDataset as $iIndex => $arrData) {
              if ( $iIndex > 1 ) echo ", '";
              else echo "'";
              echo $arrData['title'];
              echo "'";
            }
          ?>],
          datasets: [
            <?foreach ($arrCategories as $iIndexCategory => &$arrCategory) {?>
              {
                label: "<?=$arrCategory['title']?>",
                data: [<?
                  foreach ($arrDataset as $iIndexData => $arrData) {
                    if ( $iIndexData > 1 ) echo ", '";
                    else echo "'";
                    echo $arrDataset[$iIndexData]['categories'][$iIndexCategory]['value'];
                    echo "'";
                  }
                ?>],
                borderColor: [<?
                  foreach ($arrDataset as $iIndexData => $arrData) {
                    if ( $iIndexData > 1 ) echo ", '";
                    else echo "'";
                    echo $arrCategories[$iIndexCategory]['color'];
                    echo "'";
                  }
                ?>],
                backgroundColor: [<?
                  foreach ($arrDataset as $iIndexData => $arrData) {
                    if ( $iIndexData > 1 ) echo ", '";
                    else echo "'";
                    echo $arrCategories[$iIndexCategory]['color'];
                    echo "'";
                  }
                ?>],
              },
            <?}?>
          ]
        }
      })
      window.addEventListener('beforeprint', () => {
        <?=$sHash?>.resize(600, 600)
      })
      window.addEventListener('afterprint', () => {
        <?=$sHash?>.resize(600, 600)
      })
    </script>
    <?
    $arrResults['data'] = ob_get_contents();
    ob_end_clean();

    ob_start();
    ?>
    <canvas id="<?=$sHash?>_sum" width="100" height="400px" style="max-height: 400px;"></canvas>
    <script>
      var <?=$sHash?>_sum = new Chart(document.getElementById("<?=$sHash?>_sum"), {
        type: '<?=$sChartTypeSum?>',
        data: {
          labels: [<?
            foreach ($arrDataset as $iIndex => $arrData) {
              if ( $iIndex > 1 ) echo ", '";
              else echo "'";
              echo $arrData['title'];
              echo "'";
            }
          ?>],
          datasets: [
            {
              label: 'Credited',
              data: [<?
                foreach ($arrDataset as $iIndex => $arrData) {
                  if ( $iIndex > 1 ) echo ", '";
                  else echo "'";
                  echo $arrData['sum'];
                  echo "'";
                }
              ?>],
              borderColor: [<?
                foreach ($arrDataset as $iIndex => $arrData) {
                  if ( $iIndex > 1 ) echo ", '";
                  else echo "'";
                  echo '#00ff00';
                  echo "'";
                }
              ?>],
              backgroundColor: [<?
                foreach ($arrDataset as $iIndex => $arrData) {
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
          // scales: {
          //   y: {
          //     min: 0,
          //     max: 24,
          //   }
          // }
        },
      })
      window.addEventListener('beforeprint', () => {
        <?=$sHash?>_sum.resize(600, 600)
      })
      window.addEventListener('afterprint', () => {
        <?=$sHash?>_sum.resize()
      })
    </script>
    <?
    $arrResults['data_sum'] = ob_get_contents();
    ob_end_clean();

    notification::success($arrResults);
    break;
}
