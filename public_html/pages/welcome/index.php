<section class="welcome_container main_content">
  <div class="_section _title">
    <div class="_block">
      <div class="_content">
        <?include 'core/templates/elems/logo.php'?>
        <p>This is a simulator that can digitize your life, helping you manage your time and finances more efficiently.</p>
        <p>Leave your exact mark in the history of mankind and look at your life from the side</p>
      </div>
    </div>
    <div class="_bg">
      <!-- <video autoplay muted loop id="myVideo">
        <source src="/template/videos/Background_08.mov" type="video/mp4">
      </video> -->
    </div>
  </div>

   <div class="_section _times">
     <div class="_block">
         <div class="_icon">
           <i class="fas fa-clock"></i>
         </div>
         <div class="_content">
           <h2 class="_block_title"><?=$oLang->get('Times')?></h2>
          <p>
            Time is an irreplaceable resource that is always in short supply. But with this service you can easily manage it. You'll be surprised at how much more time you'll have and how much more productive your activities will become, whether it's work, rest or sleep.
          </p>
          <p>
            By tracking your time, you'll find it easier to optimize it, down to the minute, which will undoubtedly have an impact on your quality of life.
          </p>
          <p>
            The following functions are available:
          </p>
           <ul>
             <li>Division of time spent into categories</li>
              <li>Plotting time expenditure graphs for different time periods</li>
              <li>Tracking your time spent on tasks, by comparing planned time with actual time spent, to see exactly how much time you're planning to spend on tasks and you'll improve your time management skills.</li>
           </ul>
         </div>
       </div>
   </div>

   <div class="_section _moneys">
     <div class="_block">
       <div class="_icon">
         <i class="fas fa-wallet"></i>
       </div>

         <div class="_content">
           <h2 class="_block_title"><?=$oLang->get('Moneys')?></h2>
            <p>This service will help you effectively manage your finances through complete analysis.</p>
            <p>Detailed tracking of all financial flows and dividing them into an unlimited number of categories, such as: cash, credit cards, bank accounts, cashback and more. This analysis will not only help you better control your incoming money but also help you plan your future purchases.</p>
            <p>The following functions are available:</p>
            <ul>
              <li>Splitting your finances into categories.</li>
              <li>onstruction of graphs of expenditures of finances by different periods of time</li>
              <li>pending and replenishments for individual projects</li>
              <li>racking monthly payments and subscriptions</li>
              <li>racking transfers between your cards</li>
              <li>racking fees and delinquencies on credit cards, charges on debit cards</li>
            </ul>
         </div>
       </div>
   </div>

   <div class="_section _moneysforhour">
     <div class="_block">
       <div class="_icon">
         <i class="fa-solid fa-clipboard-check"></i>
       </div>
         <div class="_content">
           <h2 class="_block_title">Time is money</h2>
            <p>A unique tool of our service is a combination of time and money analysis, which allows you to calculate the value of your time in money. </p>
            <p>For example: How much your working hour costs, both in general and on individual projects. This will allow you to adjust the cost of your services, taking into account the financial and time costs of your work. </p>
            <p>Such data helps to assess the picture of the work done in an unbiased manner, that can serve as a justification for increasing the cost of your services in the labor market.</p>
         </div>
       </div>
   </div>

   <div class="_section _info">
     <div class="_block">
       <div class="_icon">
         <i class="fa-solid fa-circle-info"></i>
       </div>
         <div class="_content">
           <h2 class="_block_title">Info</h2>
            <p>Do you have any questions? <a href="/info/">Details</a></p>
         </div>
       </div>
   </div>

   <?php if ( ! isset($_SESSION['user'])): ?>
     <div class="_section _start">
       <div class="_block">
           <div class="_content">
             <h2 class="_block_title">Start</h2>
             <p>
               Try it, quick registration without using email and phone number
             </p>
             <?include 'core/templates/pages/logining.php';?>
           </div>
         </div>
     </div>
   <?php endif; ?>
</section>
