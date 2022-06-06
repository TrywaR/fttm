<section class="row">
  <?
   // Stat info
   $sQuery  = "SELECT * FROM `projects`";
   $arrProjects = $db->query_all($sQuery);
   $sQuery  = "SELECT * FROM `users`";
   $arrUsers = $db->query_all($sQuery);
   ?>

   <div class="col col-12 pt-4 pb-1">
     <div class="jumbotron jumbotron-fluid">
       <div class="container">
         <h1 class="display-4 sub_title">Analytics</h1>
       </div>
     </div>
   </div>

   <div class="col">
     <div class="card mb-2">
       <div class="card-body">
         <h5 class="card-title"> <i class="fas fa-users"></i> Users <strong><?=count($arrUsers)?></strong></h5>
         <?php if (empty($_SESSION['user'])): ?>
           <a href="/registration/" class="btn btn-primary">ADD</a>
         <?php endif; ?>
         <!-- <button class="btn btn-primary" type="button" name="button">
           ADD</button> -->
       </div>
     </div>

     <div class="card">
       <div class="card-body">
         <h5 class="card-title"> <i class="fas fa-sitemap"></i> Projects <strong><?=count($arrProjects)?></strong></h5>
       </div>
     </div>
   </div>
</section>
