<section class="welcome_container">
  <div class="_section _title">
    <div class="_block">
      <div class="_content">
        <h1 class="text-center">
          <!-- Freelance Time TrywaR Manager -->
          FTTM
          <!-- HOMM -->
          <!-- Hour Of Money Manager -->
          <!-- money per hour Manager -->
        </h1>
        <p>
          Это симулятор, способный оцифровать тебя, помогающий более эффективно распоряжаться своим временем и финансами
        </p>
        <p>
          Оставь свой точный след в истории человечества и взгляни на свою жизнь со стороны
        </p>
      </div>
    </div>
    <div class="_bg">
      <video autoplay muted loop id="myVideo">
        <source src="/template/videos/Background_08.mov" type="video/mp4">
      </video>
    </div>
  </div>

   <div class="_section _times">
     <div class="_block">
         <!-- <div class="_icon">
           <i class="fas fa-clock"></i>
         </div> -->
         <div class="_content">
           <h2 class="_block_title">Times</h2>
           <p>
             Этот сервис содержит систему для учёта времени,
             она позволит найти время для любого дела, или распоряжаться безценным временем более надёжно
           </p>
           <p>
             Например отслеживая различные временные расходы, ты сможешь определить сколько времени в различных обстоятельствах уходит на сон, и планировать время на него по часам, просыпаясь без будильника
           </p>
           <p>
             Для этого есть возможности:
           </p>
           <ul>
             <li>
               Разделения затраченного времени по категориям
             </li>
             <li>
               Построение графиков затрат времени по различным периодам времени
             </li>
             <li>
               Отслеживание времени на конкретные задачи, с определением планируемого времени и реально затраченного, что позволит отследить на сколько точно ты
               планируешь затраты по времени на задачи, и улучшить этот навык
             </li>
           </ul>
         </div>
       </div>
   </div>

   <div class="_section _moneys">
     <div class="_block">
         <div class="_content">
           <h2 class="_block_title">Moneys</h2>
           <p>
             Учёт финансовых потоков для отслеживания их по категориям, проектам, взаимодействуя с неограниченным количеством носителей:
             наличные, кредитки, счета, кэшбеки и прочее
           </p>
           <p>
             Для этого есть возможности:
           </p>
           <ul>
             <li>
               Разделения финансов по категориям
             </li>
             <li>
               Построение графиков затрат финансов по различным периодам времени
             </li>
             <li>
               Затраты и пополнения по отдельным проектам
             </li>
             <li>
               Отслеживание ежемесячных платежей и подписок
             </li>
             <li>
               Учитывание переводов между своими картами
             </li>
             <li>
               Отслеживание коммиссии и просрочек платежей по кредитным картам, начисления по дебетовым
             </li>
           </ul>
         </div>

         <!-- <div class="_icon">
           <i class="fas fa-wallet"></i>
         </div> -->
       </div>
   </div>

   <div class="_section _moneysforhour">
     <div class="_block">
         <div class="_content">
           <h2 class="_block_title">Moneys for hour</h2>
           <p>
             Соединения собранную информацию по временным и денежным затратам можно увидеть много интересных данных
           </p>
           <p>
             Например: Сколько стоит твой час работы, как в общем так и по отдельным проектам, это позволит урегулировать стоимость своих услуг, учитывая финансововые и временные затраты на работу<br/>
             Такие данные дают поддержку и понятное обоснование для повышения стоимости своих услуг
           </p>
         </div>
       </div>
   </div>

   <?php if ( ! isset($_SESSION['user'])): ?>
     <div class="_section _start">
       <div class="_block">
           <div class="_content">
             <h2 class="_block_title">Start</h2>
             <p>
               Попробуй, быстрая регистрация без использования электронной почты и номера телефона
             </p>
             <div class="block_logining">
               <div class="btn-group">
                 <a class="btn btn-primary <?if($_SERVER['REQUEST_URI']=='/authorizations/') echo 'badge bg-success active';?>" href="/authorizations/">
                   <small class="icon">
                     <i class="fas fa-user-check"></i>
                   </small>
                   Sign in
                 </a>
                 <a class="btn btn-primary <?if($_SERVER['REQUEST_URI']=='/registration/') echo 'badge bg-success active';?>" href="/registration/">
                   <small class="icon">
                     <i class="fas fa-user-plus"></i>
                   </small>
                   Sign up
                 </a>
               </div>
             </div>
           </div>
         </div>
     </div>
   <?php endif; ?>
</section>
