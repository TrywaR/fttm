<main class="container pt-4 pb-4">
   <div class="row mb-4">
     <div class="col-12  animate__animated animate__bounceIn">
       <h1>Freelance Time TrywaR Manager</h1>
       <a href="https://github.com/TrywaR/fttm"><i class="fab fa-github"></i></a>
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

   <div class="row  animate__animated animate__bounceIn">
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

   <div class="row animate__animated animate__shakeX">
     <div class="col col-12 mt-4">
       <figure>
         <blockquote cite="https://yandex.ru/lab/yalm/share?id=4aa38ace1b050d268f565046b553df54996280f0ea5b1a6355d4c4a7ed744556">
           Хеллоу %USER_NAME%, ты наткнулся на очередное приложение для тайм менеджмента.
           Чем оно полезно?
           <ul>
             <li>
               Отслеживание всех денежек, включая наличные, чтобы выстраивать графики и по ним ясно понимать, когда ты начал спиваться..
             </li>
             <li>
               Отслеживание времени, куда ты на самом деле тратишь своё драгоценное время, чтобы его было больше, а самое главное понять и отследить сколько времени у тебя уходит на сон в разных обстоятельствах, чтобы просыпаться без будильника.
             </li>
             <li>
               Абсолютное бесплатная хрень, но за донаты спасибо было бы.
             </li>
             <li>
               Помощь в разгрузке с кредитками, чтобы понять сколько у тебя уходит на оплату процентов по разным кредиткам, какая дороже, где лучше кэшбек и тд.
             </li>
             <li>
               Совмещая графики потраченного времени и заработанных денег можно отслеживать какой проект отнимает много времени а денег за час работы с ним выходит слишком мало.
             </li>
           </ul>
           <p>
             В общем полезно не только фрилансерам, но и рядовым пользователям.
           </p>
         </blockquote>
        <figcaption>—TrywaR</figcaption>
      </figure>
     </div>
   </div>

   <div class="row mt-4 animate__animated animate__backInUp" id="block_version">
     <div class="col col-md-4">
       <div id="list-example" class="list-group">
          <a class="list-group-item list-group-item-action active" href="#list-item-5_1_1">5.1.1 All users fix</a>
          <a class="list-group-item list-group-item-action" href="#list-item-5_1_0">5.1.0 Beta form for time</a>
          <a class="list-group-item list-group-item-action" href="#list-item-5_0_9">5.0.9 Edits content manager</a>
          <a class="list-group-item list-group-item-action" href="#list-item-5_0_8">5.0.8 Edits form</a>
          <a class="list-group-item list-group-item-action" href="#list-item-5_0_7">5.0.7 Edits forms mega</a>
          <a class="list-group-item list-group-item-action" href="#list-item-5_0_6">5.0.6 Edits forms</a>
          <a class="list-group-item list-group-item-action" href="#list-item-5_0_5">5.0.5 Full update</a>
          <a class="list-group-item list-group-item-action" href="#list-item-5_0_4">5.0.4 Time stat</a>
          <a class="list-group-item list-group-item-action" href="#list-item-5_0_3">5.0.3 TAAF</a>
          <a class="list-group-item list-group-item-action" href="#list-item-5_0_2">5.0.2 TAA</a>
          <a class="list-group-item list-group-item-action" href="#list-item-5_0_1">5.0.1 TileLight</a>
          <a class="list-group-item list-group-item-action" href="#list-item-5">5.0.0 BagaFix</a>
          <a class="list-group-item list-group-item-action" href="#list-item-4">4.0.0 First Relizz</a>
          <a class="list-group-item list-group-item-action" href="#list-item-3-5">3.0.5 Moneys categoryes grath</a>
          <a class="list-group-item list-group-item-action" href="#list-item-3-3">3.0.3 Moneys</a>
          <a class="list-group-item list-group-item-action" href="#list-item-3">3.0.0 Moneys</a>
          <a class="list-group-item list-group-item-action" href="#list-item-2">2.0.0 Hello world</a>
          <a class="list-group-item list-group-item-action" href="#list-item-1">1.0.0 Alfa</a>
        </div>
     </div>
     <div class="col col-md-8">
      <div data-bs-spy="scroll" data-bs-target="#list-example" data-bs-offset="0" class="scrollspy-example" tabindex="0" style="max-height: 20rem; overflow: auto;">
        <div class="pt-2 pb-2">
          <h2 id="list-item-5_1_1">5.1.1 All users fix</h2>
          <ol>
            <li>
              All users fix datas
            </li>
            <li>
              Add subscriptions in moneys
            </li>
          </ol>

          <h2 id="list-item-5_1_0">5.1.0 Beta form for time</h2>
          <ol>
            <li>
              Beta form for time
            </li>
            <li>
              Micro fix
            </li>
          </ol>

          <h2 id="list-item-5_0_9">5.0.9 Edits content manager</h2>
          <ol>
            <li>
              Time content manager worker full
            </li>
            <li>
              Money full info write on card
            </li>
          </ol>

          <h2 id="list-item-5_0_8">5.0.8 Edits form</h2>
          <ol>
            <li>
              Times today edit form fix
            </li>
            <li>
              Edit money categories
            </li>
            <li>
              Money categories add types for not plus result in money analytics
            </li>
          </ol>

          <h2 id="list-item-5_0_7">5.0.7 Edits forms mega</h2>
          <ol>
            <li>
              Clients edits forms
            </li>
            <li>
              Times categoryes edits forms
            </li>
            <li>
              Edition animations fix
            </li>
          </ol>

          <h2 id="list-item-5_0_6">5.0.6 Edits forms</h2>
          <ol>
            <li>
              Times form edit and ajax add
            </li>
            <li>
              Clients form edit and ajax add
            </li>
            <li>
              Card styles update
            </li>
          </ol>

          <h2 id="list-item-5_0_5">5.0.5 Full update</h2>
          <ol>
            <li>English lenguage for default</li>
            <li>Update style all form</li>
            <li>Fix time chart</li>
            <li>Add home page for all datas and carts links</li>
            <li>Adaptive version update</li>
          </ol>
          <h2 id="list-item-5_0_4">5.0.4 Time stat</h2>
          <ol>
            <li>Подробный вывод доходов и расходов в статистике по проекту</li>
            <li>Время за час работы за месяц в статистике по проекту</li>
            <li>Исправлена ошибка в датах в статистике времени за неделю</li>
            <li>Исправлены цвта в графиках по проекту</li>
          </ol>
          <h2 id="list-item-5_0_3">5.0.3 TAAF</h2>
          <ol>
            <li>Статистика за неделю по затратам времени</li>
          </ol>
          <h2 id="list-item-5_0_2">5.0.2 TAA</h2>
          <ol>
            <li>Вывод аналитики по затратам времени</li>
          </ol>
          <h2 id="list-item-5_0_1">5.0.1 TileLight</h2>
          <ol>
            <li>Возможность добавлять время</li>
            <li>Возможность добавлять категории для затрат по времени</li>
          </ol>
          <h2 id="list-item-5">5.0.0 BagaFix</h2>
          <ol>
            <li>Добавлена статистика по проектам, пока только финансы</li>
            <li>Пополненна статистика по пополнениям (Сумма за месяц, статистика за год)</li>
            <li>Добавлены цвета для проетов (Например для вывода графиков в аналитике по доходам)</li>
            <li>Исправлен баг с подгрузкой расходов и доходов на странице moneys</li>
          </ol>
          <h2 id="list-item-4">4.0.0 First Relizz</h2>
          <ol>
            <li>Скрыт весь нерабочий и тестовый функционал</li>
            <li>Более разборчивая структура содержимого</li>
            <li>Исправленны баги аналитик</li>
            <li>Обогащена аналитика, разделение категорий по цветам, разделения на месяцы и годы</li>
          </ol>
          <h2 id="list-item-3-5">3.0.5 Moneys categoryes grath</h2>
          <ol>
            <li>Графики затрат по категориям за месяц и за год</li>
            <li>Ajax переходы по страницам</li>
            <li>Маленькие стиливые фиксы</li>
          </ol>
          <h2 id="list-item-3-3">3.0.3 Moneys</h2>
          <ol>
            <li>Money big update, and fix</li>
            <li>Security update</li>
          </ol>

          <h2 id="list-item-3">3.0.0 Moneys</h2>
          <ol>
            <li>Обновление опсвящено денежкам, добавление и удаление поступающих затрат и пополнение финансов.</li>
            <li>Частинно работающий функционал кредитных карт, чтобы выбирать с какой былы затрата или на какую поступления</li>
            <li>Частинно работающий функционал тип затрат, аля категории, чтобы удобнее было смотреть куда улетают денежки и смотреть им вслед.. пуская одинокую мужскую слезу..</li>
          </ol>

          <h2 id="list-item-2">2.0.0 Hello world</h2>
          <ol>
            <li>Hello world - или большой скачок начальной разработки, которую мне лень было описывать</li>
          </ol>

          <h2 id="list-item-1">1.0.0 Alfa</h2>
          <ol>
            <li>Start</li>
          </ol>
        </div>
      </div>
     </div>
   </div>
</main>
