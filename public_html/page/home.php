<main class="container pt-4 pb-4">
   <div class="row mb-4">
     <div class="col-12">
       <h1>Freelance Time TrywaR Manager</h1>
       <a href="https://github.com/TrywaR/fttm"><i class="fab fa-github"></i> <small>v 1.0.0 Alfa</small></a>
     </div>
   </div>

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
           <button class="btn btn-primary" type="button" name="button">
             ADD</button>
         </div>
       </div>
     </div>
     <div class="col">
       <div class="card">
         <div class="card-body">
           <h5 class="card-title"> <i class="fas fa-sitemap"></i> Projects <strong><?=count($arrProjects)?></strong></h5>
           <button class="btn btn-primary" type="button" name="button">
             ADD</button>
         </div>
       </div>
     </div>
   </div>
</main>
