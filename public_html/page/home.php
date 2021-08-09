<main class="container pt-4 pb-4">
   <div class="row mb-4">
     <div class="col-12  animate__animated animate__bounceIn">
       <h1>Freelance Time TrywaR Manager</h1>
       <a href="https://github.com/TrywaR/fttm"><i class="fab fa-github"></i> <small>v 3.0.0 Moneys</small></a>
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

   <div class="row  animate__animated animate__bounceIn animate__delay-1s">
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

   <div class="row animate__animated animate__shakeX animate__delay-2s">
     <div class="col col-12 mt-4">
       <figure>
         <blockquote cite="https://yandex.ru/lab/yalm/share?id=4aa38ace1b050d268f565046b553df54996280f0ea5b1a6355d4c4a7ed744556">
           <p>frelance time trywar manager, на который я работаю, имеет два экземпляра с двумя различными проектами.</p>
           <p>Когда мы говорим о времени ожидания между ними, мы имеем в виду время, которое требуется для выполнения задачи менеджером, чтобы выполнить задачу.
             Это можно увидеть в журнале (не для всех задач):</p>
             <ul>
               <li>Как вы можете видеть, это связано с тайм-аут-менеджером.</li>
               <li>Я не знаю, что я могу сделать по этому поводу, поскольку время ожидания - это то, когда выполняется задача, а не когда выполняются процессы.</li>
             </ul>
         </blockquote>
        <figcaption>—Балабоба</figcaption>
      </figure>
     </div>
   </div>

   <div class="row mt-4 animate__animated animate__backInUp animate__delay-3s" id="block_version">
     <div class="col col-md-4">
       <div id="list-example" class="list-group">
          <a class="list-group-item list-group-item-action" href="#list-item-1">1.0.0 Alfa</a>
          <a class="list-group-item list-group-item-action" href="#list-item-2">2.0.0 Hello world</a>
          <a class="list-group-item list-group-item-action" href="#list-item-3">3.0.0 Moneys</a>
          <a class="list-group-item list-group-item-action" href="#list-item-3.3">3.0.3 Moneys</a>
        </div>
     </div>
     <div class="col col-md-8">
      <div data-bs-spy="scroll" data-bs-target="#list-example" data-bs-offset="0" class="scrollspy-example" tabindex="0" style="max-height: 20rem; overflow: auto;">
        <h2 id="list-item-1">1.0.0 Alfa</h4>
        <ol>
          <li>Start</li>
        </ol>
        <h2 id="list-item-2">2.0.0 Hello world</h4>
        <ol>
          <li>Hello world - или большой скачок начальной разработки, которую мне лень было описывать</li>
        </ol>
        <h2 id="list-item-3">3.0.0 Moneys</h4>
        <ol>
          <li>Обновление опсвящено денежкам, добавление и удаление поступающих затрат и пополнение финансов.</li>
          <li>Частинно работающий функционал кредитных карт, чтобы выбирать с какой былы затрата или на какую поступления</li>
          <li>Частинно работающий функционал тип затрат, аля категории, чтобы удобнее было смотреть куда улетают денежки и смотреть им вслед.. пуская одинокую мужскую слезу..</li>
        </ol>
        <h2 id="list-item-3.3">3.0.3 Moneys</h4>
        <ol>
          <li>Money big update, and fix</li>
          <li>Security update</li>
        </ol>
      </div>
     </div>
   </div>
</main>
