<main class="container pt-4 pb-4 animate__animated animate__fadeIn block_moneys">
  <div class="row mb-4">
    <div class="col-12">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4 sub_title">Moneys trip costs</h1>
        </div>
      </div>
    </div>
  </div>

  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
      <button onclick="week_show()" class="nav-link active" id="pills-week-tab" data-bs-toggle="pill" data-bs-target="#pills-week" type="button" role="tab" aria-controls="pills-wekk" aria-selected="true">Week</button>
    </li>
    <li class="nav-item" role="presentation">
      <button onclick="month_show()" class="nav-link" id="pills-month-tab" data-bs-toggle="pill" data-bs-target="#pills-month" type="button" role="tab" aria-controls="pills-month" aria-selected="true">Mounth</button>
    </li>
    <li class="nav-item" role="presentation">
      <button onclick="year_show()" class="nav-link" id="pills-yaer-tab" data-bs-toggle="pill" data-bs-target="#pills-yaer" type="button" role="tab" aria-controls="pills-yaer" aria-selected="false">Year</button>
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
            Go
          </button>
        </div>
      </form>

      <h2>Costs for week</h2>
      <div id="res_weeks" class="block_chart">
        <div class="block_loading">
          <div class="_icon">
            <i class="fas fa-chart-area"></i>
          </div>
        </div>
      </div>

      <h2>Sum</h2>
      <div id="res_weeks_sum" class="block_chart">
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

        var bWeekShow = false
        function week_show( iWeek ) {
          if ( ! bWeekShow ) {
            // Получаем данные
            $.when(
              content_download( {
                'action': 'moneys',
                'form': 'analytics_week',
                'chart_type_sum': 'bar',
                'money_type': '1',
                'week': iWeek,
              }, 'text', false )
            ).then( function( resultData ){
              if ( ! resultData ) return false
              var oData = $.parseJSON( resultData )

              if ( oData.success ) {
                if ( oData.success.chart ) $(document).find('#res_weeks').html( oData.success.chart )
                if ( oData.success.chart_sum ) $(document).find('#res_weeks_sum').html( oData.success.chart_sum )

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
            Go
          </button>
        </div>
      </form>

      <h2>Month</h2>
      <div id="res_month" class="block_chart">
        <div class="block_loading">
          <div class="_icon">
            <i class="fas fa-chart-area"></i>
          </div>
        </div>
      </div>

      <h2>Sum</h2>
      <div id="res_month_sum" class="block_chart">
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

        var bMonthShow = false;
        function month_show( iYear, iMonth ) {
          if ( ! bMonthShow ) {
            // Получаем данные
            $.when(
              content_download( {
                'action': 'moneys',
                'form': 'analytics_month',
                'chart_type_sum': 'bar',
                'money_type': '1',
                'year': iYear,
                'month': iMonth,
              }, 'text', false )
            ).then( function( resultData ){
              if ( ! resultData ) return false
              var oData = $.parseJSON( resultData )

              if ( oData.success ) {
                if ( oData.success.chart ) $(document).find('#res_month').html( oData.success.chart )
                if ( oData.success.chart_sum ) $(document).find('#res_month_sum').html( oData.success.chart_sum )

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
            Go
          </button>
        </div>
      </form>

      <h2>Yaer</h2>
      <div id="res_year" class="block_chart">
        <div class="block_loading">
          <div class="_icon">
            <i class="fas fa-chart-area"></i>
          </div>
        </div>
      </div>

      <h2>Sum</h2>
      <div id="res_year_sum" class="block_chart">
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

        var bYearShow = false;
        function year_show( iYear ) {
          if ( ! bYearShow ) {
            // Получаем данные
            $.when(
              content_download( {
                'action': 'moneys',
                'form': 'analytics_year',
                'chart_type_sum': 'bar',
                'money_type': '1',
                'year': iYear,
              }, 'text', false )
            ).then( function( resultData ){
              if ( ! resultData ) return false
              var oData = $.parseJSON( resultData )

              // Отправляем данные а получаем график
              if ( oData.success ) {
                if ( oData.success.chart ) $(document).find('#res_year').html( oData.success.chart )
                if ( oData.success.chart_sum ) $(document).find('#res_year_sum').html( oData.success.chart_sum )
                
                bYearShow = true
              }
            })
          }
        }
      </script>
    </div>
  </div>
</main>
