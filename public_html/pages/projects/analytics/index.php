<?
$oProject = new project( $_REQUEST['project_id'] );
$arrProject = $oProject->get();
?>

<div class="main_jumbotron">
  <div class="_block_title">
    <h1 class="sub_title _value">
      <?=$arrProject['title']?>
    </h1>
  </div>
</div>

<div class="main_content">
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
            <option value="" selected><?=$oLang->get('CurrentWeek')?></option>
            <option value="1"><?=$oLang->get('PrevWeek')?></option>
          </select>

          <button class="btn btn-dark" type="submit">
            Go
          </button>
        </div>
      </form>

      <div class="moneyforhour_block" id="moneyforhour_week">
        <div class="_result">
          <div class="_icon">
            <i class="fas fa-stopwatch"></i>
          </div>
          <div class="_value">

          </div>
          <div class="_title">
            <?=$oLang->get('MoneyPerHour')?>
          </div>
        </div>
      </div>

      <h2>
        <?=$oLang->get('Moneys')?>
        <span id="res_weeks_money_res" class="badge bg-primary">0</span>
      </h2>
      <div id="res_weeks_money" class="block_chart">
        <div class="block_loading">
          <div class="_icon">
            <i class="fas fa-chart-area"></i>
          </div>
        </div>
      </div>

      <h2>
        <?=$oLang->get('Times')?>
        <span id="res_weeks_time_res" class="badge bg-primary">0</span>
      </h2>
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

                if ( oData.success.money_sum ) animation_number_to($("#res_weeks_money_res"),0,oData.success.money_sum)
                if ( oData.success.time_sum ) animation_number_to($("#res_weeks_time_res"),0,oData.success.time_sum)

                if ( oData.success.moneyforhour ) {
                  animation_number_to($(document).find('#moneyforhour_week ._result ._value'),0,oData.success.moneyforhour)
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
            <option value="" selected><?=$oLang->get('CurrentYear')?></option>
            <?for ($i=date('Y')-1; $i > date('Y') - 3; $i--) {?>
              <option value="<?=$i?>"><?=$i?></option>
            <?}?>
          </select>

          <select name="month" class="form-select">
            <option value="" selected><?=$oLang->get('CurrentMonth')?></option>
            <?for ($i=1; $i < 13; $i++) {?>
              <option value="<?=$i?>"><?=$oLang->get(date("F", strtotime(date('Y') . "-" . sprintf("%02d", $i))))?></option>
            <?}?>
          </select>

          <button class="btn btn-dark" type="submit">
            Go
          </button>
        </div>
      </form>

      <div class="moneyforhour_block" id="moneyforhour_month">
        <div class="_result">
          <div class="_icon">
            <i class="fas fa-stopwatch"></i>
          </div>
          <div class="_value">
          </div>
          <div class="_title">
            <?=$oLang->get('MoneyPerHour')?>
          </div>
        </div>
      </div>

      <h2>
        <?=$oLang->get('Money')?>
        <span id="res_month_money_res" class="badge bg-primary">0</span>
      </h2>
      <div id="res_month_money" class="block_chart">
        <div class="block_loading">
          <div class="_icon">
            <i class="fas fa-chart-area"></i>
          </div>
        </div>
      </div>

      <h2>
        <?=$oLang->get('Time')?>
        <span id="res_month_time_res" class="badge bg-primary">0</span>
      </h2>
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

                if ( oData.success.money_sum ) animation_number_to($("#res_month_money_res"),0,oData.success.money_sum)
                if ( oData.success.time_sum ) animation_number_to($("#res_month_time_res"),0,oData.success.time_sum)

                if ( oData.success.moneyforhour ) {
                  animation_number_to($(document).find('#moneyforhour_month ._result ._value'),0,oData.success.moneyforhour)
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
            <option value="" selected><?=$oLang->get('CurrentYear')?></option>
            <?for ($i=date('Y')-1; $i > date('Y') - 3; $i--) {?>
              <option value="<?=$i?>"><?=$i?></option>
            <?}?>
          </select>

          <button class="btn btn-dark" type="submit">
            Go
          </button>
        </div>
      </form>

      <div class="moneyforhour_block" id="moneyforhour_year">
        <div class="_result">
          <div class="_icon">
            <i class="fas fa-stopwatch"></i>
          </div>
          <div class="_value">
          </div>
          <div class="_title">
            <?=$oLang->get('MoneyPerHour')?>
          </div>
        </div>
      </div>

      <h2>
        <?=$oLang->get('Money')?>
        <span id="res_year_money_res" class="badge bg-primary">0</span>
      </h2>
      <div id="res_year_money" class="block_chart">
        <div class="block_loading">
          <div class="_icon">
            <i class="fas fa-chart-area"></i>
          </div>
        </div>
      </div>

      <h2>
        <?=$oLang->get('Times')?>
        <span id="res_year_time_res" class="badge bg-primary">0</span>
      </h2>
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

                if ( oData.success.money_sum ) animation_number_to($("#res_year_money_res"),0,oData.success.money_sum)
                if ( oData.success.time_sum ) animation_number_to($("#res_year_time_res"),0,oData.success.time_sum)

                if ( oData.success.moneyforhour ) {
                  animation_number_to($(document).find('#moneyforhour_year ._result ._value'),0,oData.success.moneyforhour)
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
</div>
