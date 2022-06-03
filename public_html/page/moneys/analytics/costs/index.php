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
      <script>
        var bWeekShow = false
        function week_show() {
          if ( ! bWeekShow ) {
            // Получаем данные
            $.when(
              content_download( {
                'action': 'moneys',
                'form': 'analytics_week',
                'chart_type_sum': 'bar',
                'money_type': '1',
              }, 'text', false )
            ).then( function( resultData ){
              if ( ! resultData ) return false
              var oData = $.parseJSON( resultData )

              if ( oData.success ) {
                if ( oData.success.chart ) $(document).find('#res_weeks').html( oData.success.chart )
                if ( oData.success.chart_sum ) $(document).find('#res_weeks_sum').html( oData.success.chart_sum )
              }
            })
          }
        }
        week_show()
      </script>

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
    </div>

    <!-- Month -->
    <div class="tab-pane fade show" id="pills-month" role="tabpanel" aria-labelledby="pills-month-tab">
      <script>
        var bMonthShow = false;
        function month_show() {
          if ( ! bMonthShow ) {
            // Получаем данные
            $.when(
              content_download( {
                'action': 'moneys',
                'form': 'analytics_month',
                'chart_type_sum': 'bar',
                'money_type': '1',
              }, 'text', false )
            ).then( function( resultData ){
              if ( ! resultData ) return false
              var oData = $.parseJSON( resultData )

              if ( oData.success ) {
                if ( oData.success.chart ) $(document).find('#res_month').html( oData.success.chart )
                if ( oData.success.chart_sum ) $(document).find('#res_month_sum').html( oData.success.chart_sum )
              }
            })
          }
        }
      </script>

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
    </div>

    <!-- Year -->
    <div class="tab-pane fade show" id="pills-yaer" role="tabpanel" aria-labelledby="pills-yaer-tab">
      <script>
        var bYearShow = false;
        function year_show() {
          if ( ! bYearShow ) {
            // Получаем данные
            $.when(
              content_download( {
                'action': 'moneys',
                'form': 'analytics_year',
                'chart_type_sum': 'bar',
                'money_type': '1',
              }, 'text', false )
            ).then( function( resultData ){
              if ( ! resultData ) return false
              var oData = $.parseJSON( resultData )

              // Отправляем данные а получаем график
              if ( oData.success ) {
                if ( oData.success.chart ) $(document).find('#res_year').html( oData.success.chart )
                if ( oData.success.chart_sum ) $(document).find('#res_year_sum').html( oData.success.chart_sum )
              }
            })
          }
        }
      </script>

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
    </div>
  </div>
</main>
