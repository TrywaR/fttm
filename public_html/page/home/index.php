<main class="container home_container pt-4 pb-4">
  <div class="_section row">
    <div class="col-12">
      <h1 class="_title">FT <span class="_seporator">[</span><?=$_SESSION['user']['login']{0}?><span class="_seporator">]</span> M</h1>
    </div>
  </div>

  <div class="_section block_bg_blianer row animate__animated animate__fadeIn animate__delay-1s">
    <div class="col-12">
       <h2 class="sub_title">Today</h2>

       <div class="clock_revers">
         <div class="_date">
           <span class="_n">
             <?$dDateReally = new \DateTime();
             echo $dDateReally->format('F j');?>
           </span>
           <span class="_s">
             <?=$dDateReally->format('l')?>
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

    <div class="_bg_blianer">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>

  <div class="_section row animate__animated animate__fadeIn animate__delay-2s">
    <div class="col-12">
      <h2 class="sub_title">Datas</h2>
    </div>

    <div class="col-12 col-md-4">
      <div class="_block">
        <div class="_icon">
          <i class="fas fa-sitemap"></i>
        </div>
        <div class="_content">
          <span class="icon">
            <i class="far fa-folder"></i>
          </span>
          <a href="/clients/">Clients</a>
          <span class="text_seporator">,</span> <a href="/projects/">Projects</a>
          , <a href="/tasks/"><?=$olang->get('Tasks')?></a>.
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="_block">
        <div class="_icon">
          <i class="fas fa-clock"></i>
        </div>
        <div class="_content">
          <span class="icon">
            <i class="far fa-edit"></i>
          </span>
          <a href="/times">
            Update
          </a>
        </div>

        <div class="_content">
          <span class="icon">
            <i class="far fa-folder"></i>
          </span>
          <a href="/times/data/categories/">Times spend categories</a>
          <!--, <a href="/tasks/">задачи</a>. -->
        </div>

        <div class="_content">
          <span class="icon">
            <i class="far fa-chart-bar"></i>
          </span>
          <a href="/times/analytics/costs/">Time spent</a>
          <!-- , <a href="/times/analytics/wages/">Приходы времени по категориям</a> -->
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="_block">
        <div class="_icon">
          <i class="fas fa-wallet"></i>
        </div>
        <div class="_content">
          <span class="icon">
            <i class="far fa-edit"></i>
          </span>
          <a href="/moneys">
            Update
          </a>
        </div>

        <div class="_content">
          <span class="icon">
            <i class="far fa-folder"></i>
          </span>
          <a href="/moneys/data/cards/">Cards</a>
          <span class="text_seporator">,</span> <a href="/moneys/data/categories/">Moneys spend categories</a>
          <span class="text_seporator">,</span> <a href="/moneys/data/subscriptions/">Subscriptions</a>
        </div>

        <div class="_content">
          <span class="icon">
            <i class="far fa-chart-bar"></i>
          </span>
          <a href="/moneys/analytics/">Analytics</a>
          <span class="text_seporator">:</span>
          <a href="/moneys/analytics/costs/">Costs</a>
          <span class="text_seporator">,</span> <a href="/moneys/analytics/wages/">Wages</a>
          <!-- , <a href="/times/analytics/wages/">Приходы времени по категориям</a> -->
        </div>
      </div>
    </div>
  </div>
</main>
