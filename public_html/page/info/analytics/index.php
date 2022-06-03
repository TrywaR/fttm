<main class="container animate__animated animate__fadeIn">
  <?
   // Stat info
   $sQuery  = "SELECT * FROM `projects`";
   $arrProjects = $db->query_all($sQuery);
   $sQuery  = "SELECT * FROM `users`";
   $arrUsers = $db->query_all($sQuery);
   ?>

   <div class="row">
     <div class="col">
       <div class="card">
         <div class="card-body">
           <h5 class="card-title"> <i class="fas fa-users"></i> Users <strong><?=count($arrUsers)?></strong></h5>
           <?php if (empty($_SESSION['user'])): ?>
             <a href="/registration/" class="btn btn-primary">ADD</a>
           <?php endif; ?>
           <!-- <button class="btn btn-primary" type="button" name="button">
             ADD</button> -->
         </div>
       </div>
     </div>
     <div class="col">
       <div class="card">
         <div class="card-body">
           <h5 class="card-title"> <i class="fas fa-sitemap"></i> Projects <strong><?=count($arrProjects)?></strong></h5>
         </div>
       </div>
     </div>
   </div>
</main>
