<main class="container animate__animated animate__fadeIn">
  <div class="row mb-4">
    <div class="col-12">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Moneys trip</h1>
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

  <section class="row">
    <div class="col-12 mt-4 mb-4">
      <?

      // Категории которые не отнимать
      $oMoneysCategory = new moneys_category();
      $oMoneysCategory->limit = 0;
      $oMoneysCategory->sort = 'sort';
      $oMoneysCategory->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
      $oMoneysCategory->query .= " AND `type` = 0";
      $arrMoneysCategories = $oMoneysCategory->get();
      $arrMoneysCategoriesIds = [];
      foreach ($arrMoneysCategories as $arrMoneysCategory) $arrMoneysCategoriesIds[$arrMoneysCategory['id']] = $arrMoneysCategory;

      // Потрачено
      // За день
      $oMoney = new money();
      $oMoney->sort = 'date';
      // $dCurrentDate = date('Y-m-d');
      $dCurrentDate = date("Y-m-d", strtotime("-1 DAY"));
      $oMoney->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
      $oMoney->query .= " AND `date` LIKE '" . $dCurrentDate . "%' AND `type` = '0' ";
      $arrMoneys = $oMoney->get_money();
      $iDaySumm = 0;
      foreach ($arrMoneys as $arrMoney) if ( isset($arrMoneysCategoriesIds[$arrMoney['category']]) ) $iDaySumm = (int)$arrMoney['price'] + (int)$iDaySumm;

      // За месяц
      $oMoney = new money();
      $oMoney->sort = 'date';
      $dCurrentDate = date('Y-m');
      $oMoney->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
      $oMoney->query .= " AND `date` LIKE '" . $dCurrentDate . "%' AND `type` = '0' ";
      $arrMoneys = $oMoney->get_money();
      $iMonthSumm = 0;
      foreach ($arrMoneys as $arrMoney) if ( isset($arrMoneysCategoriesIds[$arrMoney['category']]) ) $iMonthSumm = (int)$arrMoney['price'] + (int)$iMonthSumm;

      // Заработанно
      $oMoney = new money();
      $oMoney->sort = 'date';
      $dCurrentDate = date('Y-m');
      $oMoney->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
      $oMoney->query .= " AND `date` LIKE '" . $dCurrentDate . "%' AND `type` = '1' ";
      $arrMoneys = $oMoney->get_money();
      $iMonthSummSalary = 0;
      foreach ($arrMoneys as $arrMoney) $iMonthSummSalary = (int)$arrMoney['price'] + (int)$iMonthSummSalary;

      // Пришло
      // За день
      $oMoney = new money();
      $oMoney->sort = 'date';
      // $dCurrentDate = date('Y-m-d');
      $dCurrentDate = date("Y-m-d", strtotime("-1 DAY"));
      $oMoney->query = ' AND `user_id` = ' . $_SESSION['user']['id'];
      $oMoney->query .= " AND `date` LIKE '" . $dCurrentDate . "%' AND `type` = '1' ";
      $arrMoneys = $oMoney->get_money();
      $iDaySummPlus = 0;
      foreach ($arrMoneys as $arrMoney) $iDaySummPlus = (int)$arrMoney['price'] + (int)$iDaySummPlus;
      ?>
        <div class="row">
          <div class="col-12">
            <h2>Yesterday</h2>
            <div class="block_analitycs">
              <div class="_circle">
                <div class="_title">
                  Costs
                </div>
                <div class="_value">
                  <?=number_format($iDaySumm, 2, '.', ' ')?>₽
                </div>
              </div>

              <div class="_circle">
                <div class="_title">
                  Wages
                </div>
                <div class="_value">
                  <?=number_format($iDaySummPlus, 2, '.', ' ')?>₽
                </div>
              </div>
            </div>
          </div>

          <div class="col-12">
            <h2><?=date("F")?></h2>
            <div class="block_analitycs">
              <div class="_circle">
                <div class="_title">
                  Costs
                </div>
                <div class="_value">
                  <?=number_format($iMonthSumm, 2, '.', ' ')?>₽
                </div>
              </div>

              <div class="_circle">
                <div class="_title">
                  Weges
                </div>
                <div class="_value">
                  <?=number_format($iMonthSummSalary, 2, '.', ' ')?>₽
                </div>
              </div>
            </div>
          </div>

          <div class="col-12">
            <h2><?=date("F")?> result</h2>
            <div class="block_analitycs">
              <?
              $sResultClass = '__success';
              if ( !$iMonthSummSalary-$iMonthSumm ) $sResultClass = '__error';
              ?>
              <div class="_circle <?=$sResultClass?>">
                <div class="_title">
                  Balance
                </div>
                <div class="_value">
                  <?=number_format($iMonthSummSalary-$iMonthSumm, 2, '.', ' ')?>₽
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
