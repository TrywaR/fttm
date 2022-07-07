<div class="main_jumbotron">
  <div class="_block_title">
    <h1 class="sub_title _value">
      <?=$oLang->get('Home')?>
    </h1>
  </div>
</div>

<div class="main_content">
  <div class="block_home">
    <div class="_section">
      <div class="clock_revers">
        <div class="_date">
          <span class="_n">
            <?$dDateReally = new \DateTime();
            echo $oLang->get($dDateReally->format('F')) . ' ';
            echo $dDateReally->format('j')?>
          </span>
          <span class="_s">
            <?=$oLang->get($dDateReally->format('l'))?>
          </span>
        </div>
        <div class="_timer">
          <span class="_icon"><i class="fas fa-history"></i></span>
          <span class="_val" id="clock_revers"></span>
        </div>
        <div class="_progress progress">
          <div id="clock_revers_bar" class="_bar progress-bar" role="progressbar" aria-valuenow="<?=$iLeftHour?>" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>

      <script>
        function clockRevers( output, bar ) {
            var
              $out = $(output),
              $bar = $(bar),
              counter = new Date(),
              hrs = 23 - counter.getHours(),
              min = 59 - counter.getMinutes(),
              sec = 59 - counter.getSeconds(),
              midnight = '<span class="_h">'+String(hrs).padStart(2,'0')+'</span><i class="_p">:</i><span class="_m">'+String(min).padStart(2,'0')+'</span><i class="_p">:</i><span class="_s">'+String(sec).padStart(2,'0')+'</span>',
              iCurrentTimePercent = (hrs / 24 * 100),
              pctDayElapsed = (counter.getHours() * 3600 + counter.getMinutes() * 60 + counter.getSeconds())/86400
              pctDayElapsed = pctDayElapsed * 100
              pctDayElapsed = 100 - pctDayElapsed

            $out.html(midnight)
            $bar.attr({'style':'width: ' + pctDayElapsed + '%'})

            // recursion
            setTimeout(function(){ clockRevers(output, bar) }, 1000)
        }
        clockRevers('#clock_revers', '#clock_revers_bar')
      </script>
    </div>

    <div class="_section">
      <h2 class="sub_title">
        <?=$oLang->get('Day')?>
      </h2>
      <div class="block_liveliner" id="home_days"></div>
      <script>
      $(function(){
        function liveliner_day ( sForm, iDay, iMonth, iYear ) {
          $.when(
            content_download( {
              'action':'homes',
              'form':sForm,
              'day':iDay,
              'month':iMonth,
              'year':iYear,
            }, 'json', false )
          ).then( function( oData ) {
            var sResultHtml = ''

            var
            iTimesDaySum = 24,
            iTimesDaySumPercent = 100,
            iTimesDayCategoriesSum = 0,
            iMoneysDayCategoriesSum = 0

            sResultHtml += '<div class="_liveliner_day">'
            sResultHtml += '<div class="_line_hours"><div class="_val">' + oData.times_sum + '</div><div class="_seporator">/</div><div class="_def">24</div></div>'
            if ( oData.moneys_sum ) sResultHtml += '<div class="_line_moneys"><div class="_val">' + oData.moneys_sum + '</div></div>'
            sResultHtml += '<div class="_day">'
              sResultHtml += '<div class="_number">'
                sResultHtml += oData.day
              sResultHtml += '</div>'
              sResultHtml += '<button class="_button btn" id="liveliner_reload_day" data-day="' + oData.day + '" data-month="' + oData.month + '" data-year="' + oData.year + '">'
                sResultHtml += '<i class="fa-solid fa-rotate-right"></i>'
              sResultHtml += '</button>'
              sResultHtml += '<button class="_button btn" id="liveliner_prev_day" data-day="' + oData.day + '" data-month="' + oData.month + '" data-year="' + oData.year + '">'
                sResultHtml += '<?=$oLang->get('PrevDay')?>'
                sResultHtml += '<i class="fa-solid fa-arrow-right-long"></i>'
              sResultHtml += '</button>'
            sResultHtml += '</div>'
            sResultHtml += '<div class="_vals">'

              $.each(oData.categories, function( iCategoryId, oCategory ){
                iMoneysDayCategoriesSum = oCategory.moneys && Math.abs(oCategory.moneys.sum) > iMoneysDayCategoriesSum ? parseInt(oCategory.moneys.sum) : iMoneysDayCategoriesSum
              })

              $.each(oData.categories, function( iCategoryId, oCategory ){
                var
                  iCategoryMoneysSum = oCategory.moneys && parseInt(oCategory.moneys.sum) != 0 ? oCategory.moneys.sum : 0,
                  dateCategoryTimesSum = oCategory.times && parseInt(oCategory.times.sum) != 0 ? oCategory.times.sum : 0

                if ( iCategoryMoneysSum || dateCategoryTimesSum  ) {
                  var
                    iCategoryHeightPercent = 0,
                    iCategoryWidthPercent = 0

                  if ( dateCategoryTimesSum ) {
                    arrCategoryTimesSum = dateCategoryTimesSum.split(':')
                    iCategoryTimesSum = arrCategoryTimesSum[0]

                    arrCategoryTimesSum = arrCategoryTimesSum[0] + ':' + arrCategoryTimesSum[1]

                    iCategoryHeightPercent = iCategoryTimesSum / 24 * 100
                  }
                  else {
                    iCategoryTimesSum = 2
                    iCategoryHeightPercent = iCategoryTimesSum / 24 * 100
                  }

                  if ( iMoneysDayCategoriesSum ) iCategoryWidthPercent = Math.abs(iCategoryMoneysSum / iMoneysDayCategoriesSum * 100)
                  else iCategoryWidthPercent = 0

                  iTimesDaySum = iTimesDaySum - iCategoryTimesSum
                  iTimesDayCategoriesSum = iTimesDayCategoriesSum + iCategoryTimesSum

                  sResultHtml += '<div class="_category" style="height:' + iCategoryHeightPercent + '%">'
                    sResultHtml += '<div class="_content">'
                      sResultHtml += '<div class="_title">' + oCategory.title + '</div> '
                      if ( iCategoryMoneysSum != 0 )
                        sResultHtml += '<div class="_moneys">' + Math.round(iCategoryMoneysSum) + '</div>'
                      if ( dateCategoryTimesSum )
                        sResultHtml += '<div class="_times">' + dateCategoryTimesSum + '</div>'
                      sResultHtml += '<div class="_background_moneys" style="width:' + iCategoryWidthPercent + '%; background:' + oCategory.color + ';"></div>'
                      sResultHtml += '<div class="_background_times" style="background: ' + oCategory.color + '"></div>'
                    sResultHtml += '</div>'
                    sResultHtml += '<div class="_buttons">'
                      sResultHtml += '<a href="javascript:;" class="_button content_loader_show" data-action="times" data-animate_class="animate__flipInY" data-elem=".time" data-form="form" data-full="true" data-category_id="' + iCategoryId + '" date-date="' + iDay + '.' + iMonth + '.' + iYear + '" data-filter="true" data-success_click="#liveliner_reload_day">'
                        sResultHtml += '<span class="_icon"><i class="fa-solid fa-clock"></i></span>'
                      sResultHtml += '</a>'
                      sResultHtml += '<a href="javascript:;" class="_button content_loader_show" data-action="moneys" data-animate_class="animate__flipInY" data-elem=".time" data-form="form" data-full="true" data-category_id="' + iCategoryId + '" date-date="' + iDay + '.' + iMonth + '.' + iYear + '" data-filter="true" data-success_click="#liveliner_reload_day">'
                        sResultHtml += '<span class="_icon"><i class="fa-solid fa-wallet"></i></span>'
                      sResultHtml += '</a>'
                    sResultHtml += '</div>'
                  sResultHtml += '</div>'
                }
              })

              sResultHtml += '<div class="_category" style="min-height:' + ( iTimesDaySum / 24 * 100 ) + '%">'
                sResultHtml += '<div class="_content">'
                  sResultHtml += '<div class="_title">No</div> '
                  sResultHtml += '<div class="_background_moneys" style="width: 2%; background: white;"></div>'
                  sResultHtml += '<div class="_background_times" style="background: white"></div>'
                sResultHtml += '</div>'
              sResultHtml += '</div>'

            sResultHtml += '</div>'

            sResultHtml += '<div class="_buttons">'
              sResultHtml += '<a href="javascript:;" class="_button content_loader_show" data-action="times" data-animate_class="animate__flipInY" data-elem=".time" data-form="form" data-full="true" date-date="' + iDay + '.' + iMonth + '.' + iYear + '" data-filter="true" data-success_click="#liveliner_reload_day">'
                sResultHtml += '<span class="_icon"><i class="fa-solid fa-clock"></i></span>'
              sResultHtml += '</a>'
              sResultHtml += '<a href="javascript:;" class="_button content_loader_show" data-action="moneys" data-animate_class="animate__flipInY" data-elem=".time" data-form="form" data-full="true" date-date="' + iDay + '.' + iMonth + '.' + iYear + '" data-filter="true" data-success_click="#liveliner_reload_day">'
                sResultHtml += '<span class="_icon"><i class="fa-solid fa-wallet"></i></span>'
              sResultHtml += '</a>'
            sResultHtml += '</div>'

            sResultHtml += '</div>'

            $(document).find('#home_days').html( sResultHtml )
            })
          }

          var
            dateCurrent = new Date(),
            iDay = dateCurrent.getDate(),
            iMonth = dateCurrent.getMonth(),
            iYear = dateCurrent.getFullYear()

          liveliner_day( 'get_day', iDay, iMonth + 1, iYear )

          $(document).on ('click', '#liveliner_prev_day', function(){
            liveliner_day( 'prev_day', $(this).data().day, $(this).data().month, $(this).data().year )
          })

          $(document).on ('click', '#liveliner_reload_day', function(){
            liveliner_day( 'get_day', $(this).data().day, $(this).data().month, $(this).data().year )
          })
        })
      </script>
    </div>

    <div class="_section">
      <h2 class="sub_title">
        <?=$oLang->get('Subscriptions')?>
        <div class="badge bg-primary" id="home_subscriptions_sum"></div>
      </h2>
      <div class="block_subscriptions_slider block_slider" id="home_subscriptions"></div>
      <script>
      $(function(){
        function subscriptions_month ( iMonth, iYear ) {
          $.when(
            content_download( {
              'action':'subscriptions',
              'form':'month',
              'month':iMonth,
              'year':iYear,
            }, 'json', false )
          ).then( function( oData ) {
            $.each(oData.subscriptions, function( iIndex, oElem ){
              if ( oElem.paid && ! oElem.paid_need ) return true

              sSubscriptionsHtml = ''
              sSubscriptionsHtml += '<div class="subscription _slider_item">'
                sSubscriptionsHtml += '<div class="_title">'
                  sSubscriptionsHtml += oElem.title
                sSubscriptionsHtml += '</div>'
                  if ( oElem.paid || oElem.paid_sum > 0 ) {
                    sSubscriptionsHtml += '<div class="_value _check">'
                      sSubscriptionsHtml += '<strike>' + oElem.price + '</strike>'
                      if ( oElem.paid_need > 0 ) sSubscriptionsHtml += '<strong>' + oElem.paid_need + '</strong>'
                      else sSubscriptionsHtml += '<i class="fas fa-check"></i>'
                    sSubscriptionsHtml += '</div>'
                  }
                  else {
                    sSubscriptionsHtml += '<div class="_value">'
                      sSubscriptionsHtml += oElem.price
                    sSubscriptionsHtml += '</div>'
                  }
              sSubscriptionsHtml += '</div>'
              $(document).find('#home_subscriptions').slick('slickAdd',sSubscriptionsHtml)
            })
            // $(document).find('#home_subscriptions').html( sSubscriptionsHtml )
            animation_number_to($("#home_subscriptions_sum"),0,oData.subscriptions_sum)
          })
        }

        subscriptions_month()

      })
      </script>
    </div>

    <div class="_section">
      <h2 class="sub_title">
        <?=$oLang->get('Tasks')?>
      </h2>
      <div class="block_tasks_slider block_slider" id="home_tasks"></div>

      <script>
        $(function(){
          function tasks_active ( iMonth, iYear ) {
            $.when(
              content_download( {
                'action':'tasks',
                'form':'active',
              }, 'json', false )
            ).then( function( oData ) {
              $.each(oData.tasks, function( iIndex, oElem ){
                sTasksHtml = ''

                sTasksHtml += '<div class="_slider_item">'
                  sTasksHtml += '<div class="task_min">'
                    sTasksHtml += '<div class="_title">'
                      sTasksHtml += '' + oElem.title + ''
                      sTasksHtml += '<small>'
                        sTasksHtml += '#' + oElem.id + ''
                      sTasksHtml += '</small>'
                    sTasksHtml += '</div>'

                    sTasksHtml += '<div class="_sub">'
                      sTasksHtml += '<div class="_status" style="background: ' + oElem.status_color + '">'
                        sTasksHtml += '' + oElem.status_val + ''
                      sTasksHtml += '</div>'

                      sTasksHtml += '<div class="_project">'
                        sTasksHtml += '' + oElem.project.title + ''
                      sTasksHtml += '</div>'
                    sTasksHtml += '</div>'
                  sTasksHtml += '</div>'
                sTasksHtml += '</div>'

                $(document).find('#home_tasks').slick('slickAdd',sTasksHtml)
              })
            })
          }

          tasks_active()
        })
      </script>
    </div>

    <script>
    $(function(){
      $(document).find('.block_slider').slick({
        arrows: false,
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 4,
        variableWidth: true,
        responsive: [
          {
            breakpoint: 1500,
            settings: {
              slidesToShow: 4,
              slidesToScroll: 4,
              infinite: true,
              dots: true
            }
          },
          {
            breakpoint: 1000,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3
            }
          },
          {
            breakpoint: 750,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
          // You can unslick at a given breakpoint now by adding:
          // settings: "unslick"
          // instead of a settings object
        ]
      })
    })
    </script>
  </div>
</div>
