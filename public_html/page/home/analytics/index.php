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
              iTimesDayTimeSum = 24,
              iTimesDayTimeSumPercent = 100,
              iTimesDayTimeCategoriesSum = 0

            sResultHtml += '<div class="_liveliner_day">'
              sResultHtml += '<div class="_day">'
                sResultHtml += '<div class="_number">'
                  sResultHtml += oData.day
                sResultHtml += '</div>'
                sResultHtml += '<button class="_button btn" id="liveliner_prev_day" data-day="' + oData.day + '" data-month="' + oData.month + '" data-year="' + oData.year + '">'
                  sResultHtml += '<?=$oLang->get('PrevDay')?>'
                  sResultHtml += '<i class="fa-solid fa-arrow-right-long"></i>'
                sResultHtml += '</button>'
              sResultHtml += '</div>'
              sResultHtml += '<div class="_vals">'

                $.each(oData.categories, function( iCategoryId, oCategory ){
                  var
                    iCategoryMoneysSum = oCategory.moneys && parseInt(oCategory.moneys.sum) ? oCategory.moneys.sum : 0,
                    dateCategoryTimesSum = oCategory.times && parseInt(oCategory.times.sum) ? oCategory.times.sum : 0

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

                    iCategoryWidthPercent = iCategoryMoneysSum / oCategory.moneys_sum * 100

                    iTimesDayTimeSum = iTimesDayTimeSum - iCategoryTimesSum
                    iTimesDayTimeCategoriesSum = iTimesDayTimeCategoriesSum + iCategoryTimesSum

                    sResultHtml += '<div class="_category" style="height:' + iCategoryHeightPercent + '%">'
                      sResultHtml += '<div class="_content">'
                        sResultHtml += '<div class="_title">' + oCategory.title + '</div> '
                        sResultHtml += '<div class="_moneys">' + iCategoryMoneysSum + '</div>'
                        sResultHtml += '<div class="_times">' + dateCategoryTimesSum + '</div>'
                        // sResultHtml += '<div class="_background_moneys" style="width:' + iCategoryWidthPercent + '%; background:' + oCategory.color + ';"></div>'
                        sResultHtml += '<div class="_background_times" style="background: ' + oCategory.color + '"></div>'
                      sResultHtml += '</div>'
                    sResultHtml += '</div>'
                  }
                })

                sResultHtml += '<div class="_category" style="min-height:' + ( iTimesDayTimeSum / 24 * 100 ) + '%">'
                  sResultHtml += '<div class="_content">'
                    sResultHtml += '<div class="_title">No</div> '
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

        liveliner_day( 'get_day', iDay, iMonth, iYear )

        $(document).on ('click', '#liveliner_prev_day', function(){
          liveliner_day( 'prev_day', $(this).data().day, $(this).data().month, $(this).data().year )
        })
      })
     </script>
   </div>
</div>
