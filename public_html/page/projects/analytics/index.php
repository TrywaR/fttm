<?
$oLang = new lang();

$oProject = new project( $_REQUEST['project_id'] );
$arrProject = $oProject->get();
// $arrProject = $arrProject[0];
?>

<section class="row">
  <div class="col col-12 pt-4 pb-1">
    <div class="jumbotron jumbotron-fluid">
      <div class="container">
        <h1 class="display-4 sub_title"><?=$arrProject['title']?></h1>
      </div>
    </div>
  </div>

  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
      <button onclick="week_show()" class="nav-link active" id="pills-week-tab" data-bs-toggle="pill" data-bs-target="#pills-week" type="button" role="tab" aria-controls="pills-wekk" aria-selected="true"><?=$oLang->get('Week')?></button>
    </li>
    <li class="nav-item" role="presentation">
      <button onclick="month_show()" class="nav-link" id="pills-month-tab" data-bs-toggle="pill" data-bs-target="#pills-month" type="button" role="tab" aria-controls="pills-month" aria-selected="true"><?=$oLang->get('Month')?></button>
    </li>
    <li class="nav-item" role="presentation">
      <button onclick="year_show()" class="nav-link" id="pills-yaer-tab" data-bs-toggle="pill" data-bs-target="#pills-yaer" type="button" role="tab" aria-controls="pills-yaer" aria-selected="false"><?=$oLang->get('Year')?></button>
    </li>
  </ul>

  <div class="tab-content" id="pills-tabContent">
    <!-- Week -->
    <div class="tab-pane fade show active" id="pills-week" role="tabpanel" aria-labelledby="pills-week-tab">
      <!-- Фильтр -->
      <form class="content_filter week_filter pb-4 __no_ajax" action="">
        <div class="input-group mb-2">
          <span class="input-group-text">
            <i class="far fa-calendar-alt"></i>
          </span>

          <select name="week" class="form-select">
            <option value="" selected>Current week</option>
            <option value="1">Prev week</option>
          </select>

          <button class="btn btn-dark" type="submit">
            <!-- <span class="icon">
              <i class="fas fa-plus"></i>
            </span> -->
            <?=$oLang->get('Filter')?>
          </button>
        </div>
      </form>

      <div class="moneyforhour_block" id="moneyforhour_week">
        <div class="_info">
          <div class="_money">
            <div class="_icon">
              m
            </div>
            <div class="_value">
            </div>
          </div>
          <div class="_time">
            <div class="_icon">
              t
            </div>
            <div class="_value">
            </div>
          </div>
        </div>

        <div class="_result">
          <div class="_icon">
            <i class="fas fa-stopwatch"></i>
          </div>
          <div class="_value">

          </div>
          <div class="_title">
            Money for hour
          </div>
        </div>
      </div>

      <h2><?=$oLang->get('Moneys')?></h2>
      <div id="res_weeks_money" class="block_chart">
        <div class="block_loading">
          <div class="_icon">
            <i class="fas fa-chart-area"></i>
          </div>
        </div>
      </div>

      <h2><?=$oLang->get('Times')?></h2>
      <div id="res_weeks_time" class="block_chart">
        <div class="block_loading">
          <div class="_icon">
            <i class="fas fa-chart-area"></i>
          </div>
        </div>
      </div>

      <script>
        $(document).find('.week_filter').on ('submit', function(){
          var iWeek = $(this).find('[name="week"]').val()

          bWeekShow = false
          week_show( iWeek )

          return false
        })
        function week_show( iWeek ) {
          var bWeekShow = false
          if ( ! bWeekShow ) {
            $.when(
              content_download( {
                'action': 'projects_analytics',
                'form': 'analytics_week',
                'project_id': <?=$arrProject['id']?>,
                'week': iWeek,
              }, 'text', false )
            ).then( function( resultData ){
              if ( ! resultData ) return false
              var oData = $.parseJSON( resultData )

              if ( oData.success ) {
                if ( oData.success.chart_time ) $(document).find('#res_weeks_time').html( oData.success.chart_time )
                if ( oData.success.chart_money ) $(document).find('#res_weeks_money').html( oData.success.chart_money )

                if ( oData.success.money_sum ) $(document).find('#moneyforhour_week ._money ._value').html( oData.success.money_sum )
                if ( oData.success.time_sum ) $(document).find('#moneyforhour_week ._time ._value').html( oData.success.time_sum )
                if ( oData.success.moneyforhour ) {
                  $(document).find('#moneyforhour_week ._result ._value').html( oData.success.moneyforhour )
                  $(document).find('#moneyforhour_week ._result').addClass('_active_')
                }
                else {
                  $(document).find('#moneyforhour_week ._result').removeClass('_active_')
                }

                bWeekShow = true
              }
            })
          }
        }
        week_show()
      </script>
    </div>

    <!-- Month -->
    <div class="tab-pane fade show" id="pills-month" role="tabpanel" aria-labelledby="pills-month-tab">
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
            <?=$oLang->get('Filter')?>
          </button>
        </div>
      </form>

      <div class="moneyforhour_block" id="moneyforhour_month">
        <div class="_info">
          <div class="_money">
            <div class="_icon">
              m
            </div>
            <div class="_value">
            </div>
          </div>
          <div class="_time">
            <div class="_icon">
              t
            </div>
            <div class="_value">
            </div>
          </div>
        </div>

        <div class="_result">
          <div class="_icon">
            <i class="fas fa-stopwatch"></i>
          </div>
          <div class="_value">
          </div>
          <div class="_title">
            Money for hour
          </div>
        </div>
      </div>

      <h2><?=$oLang->get('Money')?></h2>
      <div id="res_month_money" class="block_chart">
        <div class="block_loading">
          <div class="_icon">
            <i class="fas fa-chart-area"></i>
          </div>
        </div>
      </div>

      <h2><?=$oLang->get('Time')?></h2>
      <div id="res_month_time" class="block_chart">
        <div class="block_loading">
          <div class="_icon">
            <i class="fas fa-chart-area"></i>
          </div>
        </div>
      </div>

      <script>
        $(document).find('.month_filter').on ('submit', function(){
          var
          iYear = $(this).find('[name="year"]').val(),
          iMonth = $(this).find('[name="month"]').val()

          bMonthShow = false
          month_show( iYear, iMonth )

          return false
        })
        function month_show( iYear, iMonth ) {
          var bMonthShow = false
          if ( ! bMonthShow ) {
            $.when(
              content_download( {
                'action': 'projects_analytics',
                'form': 'analytics_month',
                'project_id': <?=$arrProject['id']?>,
                'year': iYear,
                'month': iMonth,
              }, 'text', false )
            ).then( function( resultData ){
              if ( ! resultData ) return false
              var oData = $.parseJSON( resultData )

              if ( oData.success ) {
                if ( oData.success.chart_time ) $(document).find('#res_month_time').html( oData.success.chart_time )
                if ( oData.success.chart_money ) $(document).find('#res_month_money').html( oData.success.chart_money )

                if ( oData.success.money_sum ) $(document).find('#moneyforhour_month ._money ._value').html( oData.success.money_sum )
                if ( oData.success.time_sum ) $(document).find('#moneyforhour_month ._time ._value').html( oData.success.time_sum )
                if ( oData.success.moneyforhour ) {
                  $(document).find('#moneyforhour_month ._result ._value').html( oData.success.moneyforhour )
                  $(document).find('#moneyforhour_month ._result').addClass('_active_')
                }
                else {
                  $(document).find('#moneyforhour_month ._result').removeClass('_active_')
                }

                bMonthShow = true
              }
            })
          }
        }
      </script>
    </div>

    <!-- Year -->
    <div class="tab-pane fade show" id="pills-yaer" role="tabpanel" aria-labelledby="pills-yaer-tab">
      <!-- Фильтр -->
      <form class="content_filter year_filter pb-4 __no_ajax" action="">
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

          <button class="btn btn-dark" type="submit">
            <!-- <span class="icon">
              <i class="fas fa-plus"></i>
            </span> -->
            <?=$oLang->get('Filter')?>
          </button>
        </div>
      </form>

      <div class="moneyforhour_block" id="moneyforhour_year">
        <div class="_info">
          <div class="_money">
            <div class="_icon">
              m
            </div>
            <div class="_value">
            </div>
          </div>
          <div class="_time">
            <div class="_icon">
              t
            </div>
            <div class="_value">
            </div>
          </div>
        </div>

        <div class="_result">
          <div class="_icon">
            <i class="fas fa-stopwatch"></i>
          </div>
          <div class="_value">
          </div>
          <div class="_title">
            Money for hour
          </div>
        </div>
      </div>

      <h2><?=$oLang->get('Money')?></h2>
      <div id="res_year_money" class="block_chart">
        <div class="block_loading">
          <div class="_icon">
            <i class="fas fa-chart-area"></i>
          </div>
        </div>
      </div>

      <h2><?=$oLang->get('Times')?></h2>
      <div id="res_year_time" class="block_chart">
        <div class="block_loading">
          <div class="_icon">
            <i class="fas fa-chart-area"></i>
          </div>
        </div>
      </div>

      <script>
        $(document).find('.year_filter').on ('submit', function(){
          var iYear = $(this).find('[name="year"]').val()

          bYearShow = false
          year_show( iYear )

          return false
        })
        function year_show( iYear ) {
          var bYearShow = false
          if ( ! bYearShow ) {
            $.when(
              content_download( {
                'action': 'projects_analytics',
                'form': 'analytics_year',
                'project_id': <?=$arrProject['id']?>,
                'year': iYear,
              }, 'text', false )
            ).then( function( resultData ){
              if ( ! resultData ) return false
              var oData = $.parseJSON( resultData )

              if ( oData.success ) {
                if ( oData.success.chart_time ) $(document).find('#res_year_time').html( oData.success.chart_time )
                if ( oData.success.chart_money ) $(document).find('#res_year_money').html( oData.success.chart_money )

                if ( oData.success.money_sum ) $(document).find('#moneyforhour_year ._money ._value').html( oData.success.money_sum )
                if ( oData.success.time_sum ) $(document).find('#moneyforhour_year ._time ._value').html( oData.success.time_sum )
                if ( oData.success.moneyforhour ) {
                  $(document).find('#moneyforhour_year ._result ._value').html( oData.success.moneyforhour )
                  $(document).find('#moneyforhour_year ._result').addClass('_active_')
                }
                else {
                  $(document).find('#moneyforhour_year ._result').removeClass('_active_')
                }

                bYearShow = true
              }
            })
          }
        }
      </script>
    </div>
  </div>
</section>
