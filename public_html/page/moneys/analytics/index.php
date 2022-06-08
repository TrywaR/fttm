<section class="row block_moneys">
  <div class="col col-12 pt-4 pb-1">
    <div class="jumbotron jumbotron-fluid">
      <div class="container">
        <h1 class="display-4 sub_title">Moneys trip</h1>
      </div>
    </div>
  </div>

  <div class="col-12">
    <h2>Yesterday</h2>
    <div class="block_analitycs">
      <div class="_prev">
        <div class="_icon">
          <i class="fas fa-minus"></i>
        </div>
        <div class="_title">
          Costs
        </div>
        <div class="_value" id="block_analitycs_daysum">
        </div>
      </div>

      <div class="_prev">
        <div class="_icon">
          <i class="fas fa-plus"></i>
        </div>
        <div class="_title">
          Wages
        </div>
        <div class="_value" id="block_analitycs_dayplus">
        </div>
      </div>
    </div>
  </div>

  <div class="col-12">
    <h2>Month</h2>
    <!-- Фильтр -->
    <form class="content_filter month_filter pb-4 __no_ajax" action="">
      <div class="input-group mb-2">
        <span class="input-group-text">
          <i class="far fa-calendar-alt"></i>
        </span>

        <select name="year" class="form-select">
          <option value="" selected>Current year</option>
          <?for ($i=date('Y'); $i > date('Y') - 3; $i--) {?>
            <option value="<?=$i?>"><?=$i?></option>
          <?}?>
        </select>

        <select name="month" class="form-select">
          <option value="" selected>Current month</option>
          <?for ($i=1; $i < 13; $i++) {?>
            <option value="<?=$i?>"><?=date("F", strtotime(date('Y') . "-" . sprintf("%02d", $i)))?></option>
          <?}?>
        </select>

        <button class="btn btn-dark" type="submit">
          <!-- <span class="icon">
            <i class="fas fa-plus"></i>
          </span> -->
          Go
        </button>
      </div>
    </form>

    <div class="block_analitycs">
      <div class="_prev">
        <div class="_icon">
          <i class="fas fa-minus"></i>
        </div>
        <div class="_title">
          Costs
        </div>
        <div class="_value" id="block_analitycs_monthsum">
        </div>
      </div>

      <div class="_prev">
        <div class="_icon">
          <i class="fas fa-plus"></i>
        </div>
        <div class="_title">
          Weges
        </div>
        <div class="_value" id="block_analitycs_monthplus">
        </div>
      </div>
    </div>
  </div>

  <div class="col-12">
    <h2>Month result</h2>
    <div class="block_analitycs">
      <div class="_prev">
        <div class="_icon">
          <i class="fas fa-wallet"></i>
        </div>
        <div class="_title">
          Balance
        </div>
        <div class="_value" id="block_analitycs_balance">
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).find('.month_filter').on ('submit', function(){
      var
      iYear = $(this).find('[name="year"]').val(),
      iMonth = $(this).find('[name="month"]').val()

      bAnalyticsShow = false
      analytics_show( iYear, iMonth )

      return false
    })

    var bAnalyticsShow = false
    function analytics_show( iYear, iMonth ) {
      if ( ! bAnalyticsShow ) {
        // Получаем данные
        $.when(
          content_download( {
            'action': 'moneys',
            'form': 'analytics',
            'year': iYear,
            'month': iMonth,
          }, 'text', false )
        ).then( function( resultData ){
          if ( ! resultData ) return false
          var oData = $.parseJSON( resultData )

          if ( oData.success ) {
            if ( oData.success.iDaySumm ) $(document).find('#block_analitycs_daysum').html( oData.success.iDaySumm )
            if ( oData.success.iDaySummPlus ) $(document).find('#block_analitycs_dayplus').html( oData.success.iDaySummPlus )
            if ( oData.success.iMonthSumm ) $(document).find('#block_analitycs_monthsum').html( oData.success.iMonthSumm )
            if ( oData.success.iMonthSummSalary ) $(document).find('#block_analitycs_monthplus').html( oData.success.iMonthSummSalary )
            if ( oData.success.balance ) $(document).find('#block_analitycs_balance').html( oData.success.balance )

            if ( parseInt( oData.success.balance ) > 0 ) $(document).find('#block_analitycs_balance').parents('._prev').addClass('__success').removeClass('__error')
            else $(document).find('#block_analitycs_balance').parents('._prev').addClass('__error').removeClass('__success')

            bAnalyticsShow = true
          }
        })
      }
    }
    analytics_show()
  </script>
</section>
