<main class="container pt-4 pb-4">
   <div class="row mb-4">
     <div class="col-12  animate__animated animate__fadeIn">
       <div class="jumbotron jumbotron-fluid">
         <div class="container">
           <h1 class="display-4 text-center">FT [<?=$_SESSION['user']['login']{0}?>] M</h1>

           <div class="row mt-4">
             <div class="col-12 col-md-4">
               <h2 class="text-center"><i class="fas fa-sitemap"></i></h2>
               <p class="lead">
                 <span class="icon">
                   <i class="far fa-folder"></i>
                 </span>
                 <a href="/clients/">Clients</a>
                 <span class="text_seporator">,</span> <a href="/projects/">Projects</a>
                 <!--, <a href="/tasks/">задачи</a>. -->
               </p>
             </div>

             <div class="col-12 col-md-4">
               <h2 class="text-center"><i class="fas fa-clock"></i></h2>
               <p class="lead">
                 <span class="icon">
                   <i class="far fa-edit"></i>
                 </span>
                 <a href="/times">
                   Update
                 </a>
               </p>

               <p class="lead">
                 <span class="icon">
                   <i class="far fa-folder"></i>
                 </span>
                 <a href="/times/data/categories/">Times spend categories</a>
                 <!--, <a href="/tasks/">задачи</a>. -->
               </p>

               <p class="lead">
                 <span class="icon">
                   <i class="far fa-chart-bar"></i>
                 </span>
                 <a href="/times/analytics/costs/">Time spent</a>
                 <!-- , <a href="/times/analytics/wages/">Приходы времени по категориям</a> -->
               </p>
             </div>

             <div class="col-12 col-md-4">
               <h2 class="text-center"><i class="fas fa-wallet"></i></h2>
               <p class="lead">
                 <span class="icon">
                   <i class="far fa-edit"></i>
                 </span>
                 <a href="/moneys">
                   Update
                 </a>
               </p>

               <p class="lead">
                 <span class="icon">
                   <i class="far fa-folder"></i>
                 </span>
                 <a href="/moneys/data/cards/">Cards</a>
                 <span class="text_seporator">,</span> <a href="/moneys/data/categories/">Moneys spend categories</a>
                 <span class="text_seporator">,</span> <a href="/moneys/data/subscriptions/">Subscriptions</a>
               </p>

               <p class="lead">
                 <span class="icon">
                   <i class="far fa-chart-bar"></i>
                 </span>
                 <a href="/moneys/analytics/">Analytics</a>
                 <span class="text_seporator">:</span>
                 <a href="/moneys/analytics/costs/">Costs</a>
                 <span class="text_seporator">,</span> <a href="/moneys/analytics/wages/">Wages</a>
                 <!-- , <a href="/times/analytics/wages/">Приходы времени по категориям</a> -->
               </p>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>
</main>
