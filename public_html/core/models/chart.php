<?
/**
 * Chart
 */
class chart extends model
{
  public static $sHash = '';
  public static $arrDataset = '';
  public static $arrCategories = '';
  public static $sChartType = '';
  public static $sChartTypeSum = '';
  public static $sChartScaleX = '';
  public static $sChartScaleY = '';
  public static $sChartScaleStackedX = '';
  public static $sChartScaleStackedY = '';
  public static $sResult = '';

  public function hash() {
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
    while($max--) $this->sHash.=$chars[rand(0,$size)];
  }

  public function show()
  {
    $this->hash();

    $arrDataset = $this->arrDataset; # Данные
    $arrCategories = $this->arrCategories; # Категории
    $sChartType = $this->sChartType ? $this->sChartType : 'line'; # Тип графика

    ob_start();
    ?>
    <canvas id="<?=$this->sHash?>" width="100%" height="400px" style="max-height: 400px;"></canvas>
    <script>
      var <?=$this->sHash?> = new Chart(document.getElementById("<?=$this->sHash?>"), {
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
        },
        options: {
          responsive: true,
          plugins: {
            title: {
              display: false
            },
          },
          scales: {
            x: {
              <?if ( $this->sChartScaleX ) {?>
                min: <?=$this->sChartScaleX?>,
              <?}?>
              <?if ( $this->sChartScaleStackedX ) {?>
                stacked: true,
              <?}?>
            },
            y: {
              <?if ( $this->sChartScaleY ) {?>
                min: <?=$this->sChartScaleY?>,
              <?}?>
              <?if ( $this->sChartScaleStackedY ) {?>
                stacked: true,
              <?}?>
            }
          }
        },
      })

      window.addEventListener('beforeprint', () => {
        <?=$this->sHash?>.resize(600, 600)
      })
      window.addEventListener('afterprint', () => {
        <?=$this->sHash?>.resize(600, 600)
      })
    </script>
    <?

    $this->sResult = ob_get_contents();
    ob_end_clean();

    return $this->sResult;
  }

  public function show_sum()
  {
    $this->hash();

    $arrDataset = $this->arrDataset; # Данные
    $arrCategories = $this->arrCategories; # Категории
    $sChartTypeSum = $this->sChartTypeSum ? $this->sChartTypeSum : 'line'; # Тип графика

    ob_start();
    ?>
    <canvas id="<?=$this->sHash?>_sum" width="100" height="400px" style="max-height: 400px;"></canvas>
    <script>
      var <?=$this->sHash?>_sum = new Chart(document.getElementById("<?=$this->sHash?>_sum"), {
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
                  echo '#4a8e61';
                  echo "'";
                }
              ?>],
              backgroundColor: [<?
                foreach ($arrDataset as $iIndex => $arrData) {
                  if ( $iIndex > 1 ) echo ", '";
                  else echo "'";
                  echo '#4a8e61';
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
            x: {
              <?if ( $this->sChartScaleX ) {?>
                min: <?=$this->sChartScaleX?>,
              <?}?>
              <?if ( $this->sChartScaleStackedX ) {?>
                stacked: true,
              <?}?>
            },
            y: {
              <?if ( $this->sChartScaleY ) {?>
                min: <?=$this->sChartScaleY?>,
              <?}?>
              <?if ( $this->sChartScaleStackedY ) {?>
                stacked: true,
              <?}?>
            }
          }
        },
      })

      window.addEventListener('beforeprint', () => {
        <?=$this->sHash?>_sum.resize(600, 600)
      })
      window.addEventListener('afterprint', () => {
        <?=$this->sHash?>_sum.resize()
      })
    </script>
    <?

    $this->sResult = ob_get_contents();
    ob_end_clean();

    return $this->sResult;
  }
}
