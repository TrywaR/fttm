<main class="container pt-4 pb-4">
  <div class="row mb-4 block_user animate__animated animate__fadeIn">
     <div class="col-12">
       <h1>
         <!-- <i class="fas fa-user-circle"></i> <br/> -->
         Freelance Time <?=$_SESSION['user']['login']?> Manager
       </h1>
     </div>

     <div class="card">
       <div class="card-header">
         <?=$_SESSION['user']['login']?>
       </div>

       <ul class="list-group mt-1 mb-1">
         <li class="list-group-item">
           <small>
             <span class="icon">
               <i class="fas fa-globe-africa"></i>
             </span>
             Lang:
           </small>
           <?=$_SESSION['user']['lang']?>
         </li>
         <li class="list-group-item">
           <small>
             <span class="icon">
               <i class="fas fa-tint"></i>
             </span>
             Theme:
           </small>
           <?
           switch ((int)$_SESSION['user']['theme']) {
             case 0:
               ?>Auto<?
               break;
             case 1:
               ?>Dark<?
               break;
             case 2:
               ?>Light<?
               break;
             case 3:
               ?>No<?
               break;
           }
           ?>
         </li>
         <li class="list-group-item">
           <small>
             <span class="icon">
               <i class="fas fa-envelope"></i>
             </span>
             Email:
           </small>
           <?=$_SESSION['user']['email']?>
         </li>
         <li class="list-group-item">
           <small>
             <span class="icon">
               <i class="fas fa-mobile"></i>
             </span>
             Phone:
           </small>
           <?=$_SESSION['user']['phone']?>
         </li>
         <li class="list-group-item">
           <small>
             <span class="icon">
               <i class="fas fa-calendar-check"></i>
             </span>
             Registration:
           </small>
           <?=$_SESSION['user']['date_registration']?>
         </li>
       </ul>

       <div class="btn-group btn-group-toggle" data-toggle="buttons">
         <a class="btn btn-dark" href="/users/edit/">
           <i class="fas fa-user-edit"></i>
           Edit
         </a>
         <a class="btn btn-dark" href="#" id="user_logout">
           <i class="fas fa-user-secret"></i>
           Exit
         </a>
         <a class="btn btn-dark" href="#">
           <i class="fas fa-user-alt-slash"></i>
           Delete
         </a>
       </div>
     </div>
   </div>
</main>
