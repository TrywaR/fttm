<div class="main_jumbotron">
  <div class="_block_title">
    <h1 class="sub_title _value">
      <?=$oLang->get('Dashboard')?>
    </h1>
  </div>
</div>

<div class="main_content">
  <div class="block_dashboard">
    <div class="_prev _days">
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

    <div class="_prev _moneysandtimes">
      moneysandtimes
    </div>

    <div class="_prev _subscriptions">
      subscriptions
    </div>

    <div class="_prev _cards">
      cards
    </div>
  </div>
</div>
