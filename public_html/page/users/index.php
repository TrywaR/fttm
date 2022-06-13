<?$oLang = new lang()?>
<main class="container pt-4 pb-4">
  <div class="row mb-4 block_user animate__animated animate__fadeIn">
     <div class="col-12">
       <h1>
         <!-- <i class="fas fa-user-circle"></i> <br/> -->
         Freelance Time <?=$_SESSION['user']['login']?> Manager
       </h1>
     </div>

     <div class="col-12 col-xl-7 mt-4">
       <div class="card">
         <div class="card-header">
           <?=$_SESSION['user']['login']?>
         </div>

         <div class="card-body">
           <small class="mt-3">
             <?=$oLang->get('Other')?>
           </small>
           <ul class="list-group mt-1 mb-1">
             <li class="list-group-item">
               <?
               switch ((int)$_SESSION['user']['role']) {
                 case 0:
                    ?>
                    <span class="icon">
                      <i class="fas fa-user-circle"></i>
                    </span>
                    User
                    <?
                   break;
                 case 1:
                    ?>
                    <span class="icon">
                      <i class="fas fa-check"></i>
                    </span>
                    Valid user
                    <?
                   break;
                 case 666:
                    ?>
                    <span class="icon">
                      <i class="fas fa-crown"></i>
                    </span>
                    Admin
                    <?
                   break;
               }
               ?>
             </li>
             <li class="list-group-item">
               <small><?=$oLang->get('ReferalLink')?>:</small>
               <input type="text" readonly class="form-control-plaintext" value="<?=config::$site_url?>/?referal=<?=$_SESSION['user']['id']?>">
             </li>
           </ul>

           <small class="mt-3">
             <?=$oLang->get('Config')?>
           </small>
           <ul class="list-group mt-1 mb-1">
             <li class="list-group-item">
               <small>
                 <span class="icon">
                   <i class="fas fa-globe-africa"></i>
                 </span>
                 <?=$oLang->get('Lang')?>:
               </small>
               <?=$_SESSION['user']['lang']?>
             </li>
             <li class="list-group-item">
               <small>
                 <span class="icon">
                   <i class="fas fa-tint"></i>
                 </span>
                 <?=$oLang->get('Theme')?>:
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
               }
               ?>
             </li>
           </ul>

           <small class="mt-3">
             <?=$oLang->get('Info')?>
           </small>
           <ul class="list-group mt-1 mb-1">
             <li class="list-group-item">
               <small>
                 <span class="icon">
                   <i class="fas fa-envelope"></i>
                 </span>
                 <?=$oLang->get('Email')?>:
               </small>
               <?=$_SESSION['user']['email']?>
             </li>
             <li class="list-group-item">
               <small>
                 <span class="icon">
                   <i class="fas fa-mobile"></i>
                 </span>
                 <?=$oLang->get('Phone')?>:
               </small>
               <?=$_SESSION['user']['phone']?>
             </li>
             <li class="list-group-item">
               <small>
                 <span class="icon">
                   <i class="fas fa-calendar-check"></i>
                 </span>
                 <?=$oLang->get('DateRegistration')?>:
               </small>
               <?=$_SESSION['user']['date_registration']?>
             </li>
           </ul>
         </div>
       </div>
     </div>

     <div class="col-12 col-xl-5 mt-4">
       <div class="btn-group-vertical">
         <!-- <a class="btn btn-dark" href="/users/edit/"> -->
         <a data-action="users" data-animate_class="animate__flipInY" data-form="form" href="javascript:;" class="btn btn-dark content_loader_show" title="<?=$oLang->get('Edit')?>">
           <div class="_icon">
             <i class="fas fa-user-edit"></i>
           </div>
           <div class="_text">
             <?=$oLang->get('Edit')?>
           </div>
         </a>

         <a data-action="users" data-animate_class="animate__flipInY" data-form="form_new_password" href="javascript:;" class="btn btn-dark content_loader_show" title="<?=$oLang->get('ChangePassword')?>">
           <div class="_icon">
             <i class="fa-solid fa-key"></i>
           </div>
           <div class="_text">
             <?=$oLang->get('ChangePassword')?>
           </div>
         </a>

         <a class="btn btn-dark" href="#" id="user_logout">
           <div class="_icon">
             <i class="fas fa-user-secret"></i>
           </div>
           <div class="_text">
             <?=$oLang->get('Exit')?>
           </div>
         </a>

         <a class="btn btn-dark" href="#">
           <div class="_icon">
             <i class="fas fa-user-alt-slash"></i>
           </div>
           <div class="_text">
             <?=$oLang->get('Delete')?>
           </div>
         </a>
       </div>
     </div>
   </div>
</main>
