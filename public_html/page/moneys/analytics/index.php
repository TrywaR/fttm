<main class="container pt-4 pb-4">
  <div class="row mb-4">
    <div class="col-12">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Moneys trip</h1>
          <p class="lead">Мой месячный трип</p>
          <p class="lead">
            <a href="/moneys/analytics/costs/">Расходы</a>
            , <a href="/moneys/analytics/wages/">Приходы</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <section class="row animate__animated animate__flipInY">
    <div class="col-12 mt-4 mb-4">
      <?

      // Потрачено
      // За день
      $oMoney = new money();
      $oMoney->sort = 'date';
      // $dCurrentDate = date('Y-m-d');
      $dCurrentDate = date("Y-m-d", strtotime("-1 DAY"));
      $oMoney->where = "`date` LIKE '" . $dCurrentDate . "%' AND `type` = '0' ";
      $arrMoneys = $oMoney->get_money();
      $iDaySumm = 0;
      foreach ($arrMoneys as $arrMoney) $iDaySumm = (int)$arrMoney['price'] + (int)$iDaySumm;

      // За месяц
      $oMoney = new money();
      $oMoney->sort = 'date';
      $dCurrentDate = date('Y-m');
      $oMoney->where = "`date` LIKE '" . $dCurrentDate . "%' AND `type` = '0' ";
      $arrMoneys = $oMoney->get_money();
      $iMonthSumm = 0;
      foreach ($arrMoneys as $arrMoney) $iMonthSumm = (int)$arrMoney['price'] + (int)$iMonthSumm;

      // Заработанно
      $oMoney = new money();
      $oMoney->sort = 'date';
      $dCurrentDate = date('Y-m');
      $oMoney->where = "`date` LIKE '" . $dCurrentDate . "%' AND `type` > 0 ";
      $arrMoneys = $oMoney->get_money();
      $iMonthSummSalary = 0;
      foreach ($arrMoneys as $arrMoney) $iMonthSummSalary = (int)$arrMoney['price'] + (int)$iMonthSummSalary;

      ?>
      <div class="block_analitycs">
        <div class="_circle">
          <div class="_title">
            Расходы вчера
          </div>
          <div class="_value">
            <?=number_format($iDaySumm, 2, '.', ' ')?>₽
          </div>
        </div>

        <div class="_circle">
          <div class="_title">
            Расходы (<?=date("F")?>)
          </div>
          <div class="_value">
            <?=number_format($iMonthSumm, 2, '.', ' ')?>₽
          </div>
        </div>

        <div class="_circle">
          <div class="_title">
            Доходы (<?=date("F")?>)
          </div>
          <div class="_value">
            <?=number_format($iMonthSummSalary, 2, '.', ' ')?>₽
          </div>
        </div>

        <div class="_circle">
          <div class="_title">
            Баланс (<?=date("F")?>)
          </div>
          <div class="_value">
            <?=number_format($iMonthSummSalary-$iMonthSumm, 2, '.', ' ')?>₽
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
