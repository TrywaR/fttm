<?
$oCategory = new category( $_REQUEST['category_id'] );
?>
<div class="main_jumbotron">
  <div class="_block_title">
    <small class="_sub"><?=$oLang->get('Category')?></small>
    <h1 class="sub_title _value">
      <?=$oLang->get($oCategory->title)?>
    </h1>
  </div>
</div>

<div class="main_content">
  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
      <button onclick="month_show()" class="nav-link active" id="pills-month-tab" data-bs-toggle="pill" data-bs-target="#pills-month" type="button" role="tab" aria-controls="pills-month" aria-selected="true">
        <?=$oLang->get('Month')?>
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button <?=$oLock->get_attr('CategoryAnalyticYear', 'onclick="year_show()" id="pills-yaer-tab" data-bs-toggle="pill" data-bs-target="#pills-yaer" type="button" role="tab" aria-controls="pills-yaer" aria-selected="false"')?> class="nav-link elem_lock">
        <?=$oLang->get('Year')?>
        <?=$oLock->get('CategoryAnalyticYear')?>
      </button>
    </li>
  </ul>

  <div class="tab-content" id="pills-tabContent">
    <!-- Month -->
    <div class="tab-pane fade show active" id="pills-month" role="tabpanel" aria-labelledby="pills-month-tab">
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

      <div class="block_category">
        <div class="_analytics">
          <div class="_linear">
            <div class="_line">
              <div class=""></div>
              <div class="_1"></div>
              <div class="_2"></div>
              <div class="_3"></div>
            </div>
            <div class="_vals">
              <div class=""></div>
              <div class="_1"><?=$oLang->get('CategoryAnalyticsLineType1')?></div>
              <div class="_2"><?=$oLang->get('CategoryAnalyticsLineType2')?></div>
              <div class="_3"><?=$oLang->get('CategoryAnalyticsLineType3')?></div>
            </div>
          </div>

          <div class="_params">
            <div class="_param">
              <div class="_name">
                <?=$oLang->get('Money')?>
              </div>
              <div class="_val" id="res_month_money_res">0</div>
            </div>

            <div class="_param">
              <div class="_name">
                <?=$oLang->get('Time')?>
              </div>
              <div class="_val" id="res_month_time_res">0</div>
            </div>
          </div>
        </div>

        <div class="_calendars">
          <div id="res_month" class="block_calendar">
            <div class="block_loading">
              <div class="_icon">
                <i class="fas fa-chart-area"></i>
              </div>
            </div>
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
                'action': 'categories_analytics',
                'form': 'analytics_month',
                'category_id': <?=$oCategory->id?>,
                'year': iYear,
                'month': iMonth,
              }, 'text', false )
            ).then( function( resultData ){
              if ( ! resultData ) return false
              var oData = $.parseJSON( resultData )

              if ( oData.success ) {
                if ( oData.success.calendar ) $(document).find("#res_month").html(oData.success.calendar)
                if ( oData.success.moneys ) animation_number_to($("#res_month_money_res"),0,oData.success.moneys)
                if ( oData.success.times ) animation_number_to($("#res_month_time_res"),0,oData.success.times)
                bMonthShow = true
              }
            })
          }
        }
        month_show()
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

      <div class="block_category">
        <div class="_analytics">
          <div class="_linear">
            <div class="_line">
              <div class=""></div>
              <div class="_1"></div>
              <div class="_2"></div>
              <div class="_3"></div>
            </div>
            <div class="_vals">
              <div class=""></div>
              <div class="_1"><?=$oLang->get('CategoryAnalyticsLineType1')?></div>
              <div class="_2"><?=$oLang->get('CategoryAnalyticsLineType2')?></div>
              <div class="_3"><?=$oLang->get('CategoryAnalyticsLineType3')?></div>
            </div>
          </div>

          <div class="_params">
            <div class="_param">
              <div class="_name">
                <?=$oLang->get('Money')?>
              </div>
              <div class="_val" id="res_year_money_res">0</div>
            </div>

            <div class="_param">
              <div class="_name">
                <?=$oLang->get('Time')?>
              </div>
              <div class="_val" id="res_year_time_res">0</div>
            </div>
          </div>
        </div>

        <div class="_calendars">
          <div id="res_year" class="block_calendar">
            <div class="block_loading">
              <div class="_icon">
                <i class="fas fa-chart-area"></i>
              </div>
            </div>
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
                'action': 'categories_analytics',
                'form': 'analytics_year',
                'category_id': <?=$oCategory->id?>,
                'year': iYear,
              }, 'text', false )
            ).then( function( resultData ){
              if ( ! resultData ) return false
              var oData = $.parseJSON( resultData )

              if ( oData.success ) {
                if ( oData.success.calendar ) $(document).find("#res_year").html(oData.success.calendar)
                if ( oData.success.moneys ) animation_number_to($("#res_year_money_res"),0,oData.success.moneys)
                if ( oData.success.times ) animation_number_to($("#res_year_time_res"),0,oData.success.times)
                bYearShow = true
              }
            })
          }
        }
      </script>
    </div>
  </div>
</div>
