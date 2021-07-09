<main class="container pt-4 pb-4">
   <div class="row mb-4">
     <div class="col-12">
       <h1>Freelance Time TrywaR Manager</h1>
       <a href="https://github.com/TrywaR/fttm"><i class="fab fa-github"></i> <small>v 1.0.0 Alfa</small></a>
     </div>
     <!-- <div class="col-12 mt-4">
       <a href="/authorizations/" class="btn btn-primary">Войти</a>
       <a href="/registration/" class="btn btn-primary">Зарегистрироваться</a>
     </div> -->
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
           <?php if (empty($_SESSION['session_key'])): ?>
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
