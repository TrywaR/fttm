<div class="block_home">
  <div class="block_jumbotron">
    <div class="_block_title">
      <h1 class="sub_title _value">
        <?$dDateReally = new \DateTime();
        echo $oLang->get($dDateReally->format('F'))?>
      </h1>
    </div>
  </div>

  <div class="_section">
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
              if ( oData.moneys_sum )
                sResultHtml += '<div class="_line_moneys"><div class="_val">' + oData.moneys_sum + '</div></div>'
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
                        sResultHtml += '<a href="javascript:;" class="btn btn-dark content_loader_show" data-action="times" data-animate_class="animate__flipInY" data-elem=".time" data-form="form" data-full="true" data-category_id="' + iCategoryId + '" date-date="' + iDay + '.' + iMonth + '.' + iYear + '" data-filter="true" data-success_click="#liveliner_reload_day">'
                          sResultHtml += '<span class="_icon"><i class="fa-solid fa-clock"></i></span>'
                        sResultHtml += '</a>'
                        sResultHtml += '<a href="javascript:;" class="btn btn-dark content_loader_show" data-action="moneys" data-animate_class="animate__flipInY" data-elem=".time" data-form="form" data-full="true" data-category_id="' + iCategoryId + '" date-date="' + iDay + '.' + iMonth + '.' + iYear + '" data-filter="true" data-success_click="#liveliner_reload_day">'
                          sResultHtml += '<span class="_icon"><i class="fa-solid fa-wallet"></i></span>'
                        sResultHtml += '</a>'
                        // sResultHtml += '<div class="btn _button">' + '<i class="fa-solid fa-clock"></i>' + '</div>'
                      //     sResultHtml += '<div class="btn _button">' + '<i class="fa-solid fa-wallet"></i>' + '</div>'
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
</div>
