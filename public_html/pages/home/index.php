<div class="block_home">
  <div class="block_jumbotron">
    <div class="_block_title">
      <h1 class="sub_title _value">
        <?include 'core/templates/pages/logo.php'?>
      </h1>
    </div>
  </div>

  <div class="_section block_bg_blianer">
     <h2 class="sub_title"><?=$oLang->get('ToDay')?></h2>

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

     <div class="_bg_blianer">
       <span></span>
       <span></span>
       <span></span>
     </div>
   </div>

  <div class="_section block_bg_blianer">
    <h2 class="sub_title"><?=$oLang->get('Analytics')?></h2>

    <!-- Фильтр -->
    <form class="content_filter month_filter pb-4 __no_ajax" action="">
      <div class="input-group mb-2">
        <span class="input-group-text">
          <i class="far fa-calendar-alt"></i>
        </span>

        <select name="year" class="form-select">
          <option value="" selected><?=$oLang->get('CurrentYear')?></option>
          <?for ($i=date('Y'); $i > date('Y') - 3; $i--) {?>
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

    <div class="block_analitycs">
      <div class="_prev">
        <div class="_title">
          <?=$oLang->get('Times')?>
        </div>
        <div class="_subs">
          <div class="_sub">
            <div class="_title">
              <?=$oLang->get('Work')?>
            </div>
            <div class="_value" id="block_analitycs_work">
            </div>
          </div>
          <div class="_sub">
            <div class="_title">
              <?=$oLang->get('Sleep')?>
            </div>
            <div class="_value" id="block_analitycs_sleep">
            </div>
          </div>
        </div>
      </div>

      <div class="_prev">
        <div class="_title">
          <?=$oLang->get('Moneys')?>
        </div>
        <div class="_subs">
          <div class="_sub">
            <div class="_title">
              <?=$oLang->get('Costs')?>
            </div>
            <div class="_value" id="block_analitycs_costs">
            </div>
          </div>
          <div class="_sub">
            <div class="_title">
              <?=$oLang->get('Wages')?>
            </div>
            <div class="_value" id="block_analitycs_wages">
            </div>
          </div>
          <div class="_sub">
            <div class="_title">
              <?=$oLang->get('WagesWork')?>
            </div>
            <div class="_value" id="block_analitycs_wages_work">
            </div>
          </div>
          <div class="_sub _res">
            <div class="_title">
              <?=$oLang->get('MoneyPerHour')?>
            </div>
            <div class="_value" id="block_analitycs_moneyforhour">
            </div>
          </div>
        </div>
      </div>

      <div class="_prev">
        <div class="_title">
          <?=$oLang->get('Subscriptions')?>
        </div>

        <div class="_subs" id="block_analitycs_subscriptions">
        </div>
      </div>
    </div>

    <div class="block_analitycs">
      <div class="_prev">
        <div class="_title">
          <?=$oLang->get('Balance')?>
        </div>
        <div class="_subs" id="block_analitycs_cards">
          <div class="_sub _res">
            <div class="_title">
              <?=$oLang->get('Balance')?>
            </div>
            <strong class="_value" id="block_analitycs_balance">
            </strong>
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
        home_show( iYear, iMonth )

        return false
      })
      function home_show( iYear, iMonth ){
        // Получаем данные
        $.when(
          content_download( {
            'action': 'analytics',
            'form': 'analytics',
            'year': iYear,
            'month': iMonth,
          }, 'text', false )
        ).then( function( resultData ){
          if ( ! resultData ) return false
          var oData = $.parseJSON( resultData )

          if ( oData.success ) {
            if ( oData.success.work ) $(document).find('#block_analitycs_work').html( oData.success.work )
            if ( oData.success.sleep ) $(document).find('#block_analitycs_sleep').html( oData.success.sleep )
            if ( oData.success.wages ) $(document).find('#block_analitycs_wages').html( oData.success.wages )
            if ( oData.success.wages_work ) $(document).find('#block_analitycs_wages_work').html( oData.success.wages_work )
            if ( oData.success.costs ) $(document).find('#block_analitycs_costs').html( oData.success.costs )
            $(document).find('#block_analitycs_moneyforhour').html( oData.success.moneyforhour )

            if ( oData.success.cards.length ) {
              var sCardsHtml = ''
              $.each( oData.success.cards, function( iIndex, oElem ){
                sCardsHtml += '<div class="_sub">'
                  sCardsHtml += '<div class="_title">'
                    sCardsHtml += oElem.title
                  sCardsHtml += '</div>'
                  sCardsHtml += '<div class="_value">'
                    sCardsHtml += oElem.balance
                  sCardsHtml += '</div>'
                sCardsHtml += '</div>'
              })
              sCardsHtml += '<div class="_sub _res">'
                sCardsHtml += '<div class="_title">'
                  sCardsHtml += '<?=$oLang->get('Balance')?>'
                sCardsHtml += '</div>'
                sCardsHtml += '<div class="_value">'
                  sCardsHtml += oData.success.balance
                sCardsHtml += '</div>'
              sCardsHtml += '</div>'
              $(document).find('#block_analitycs_cards').html( sCardsHtml )
            }

            if ( oData.success.subscriptions.length ) {
              var sSubscriptionsHtml = ''
              $.each( oData.success.subscriptions, function( iIndex, oElem ){
                sSubscriptionsHtml += '<div class="_sub">'
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
              })

              if ( oData.success.subscriptions_sum ) {
                sSubscriptionsHtml += '<div class="_sub _res">'
                  sSubscriptionsHtml += '<div class="_title">'
                    sSubscriptionsHtml += '<?=$oLang->get('Sum')?>'
                  sSubscriptionsHtml += '</div>'
                  sSubscriptionsHtml += '<strong class="_value">'
                    sSubscriptionsHtml += oData.success.subscriptions_sum
                  sSubscriptionsHtml += '</strong>'
                sSubscriptionsHtml += '</div>'
              }

              $(document).find('#block_analitycs_subscriptions').html( sSubscriptionsHtml )
            }
          }
        })
      }
      home_show()
    </script>

    <div class="_bg_blianer">
    <span></span>
    <span></span>
    <span></span>
  </div>
  </div>
</div>
