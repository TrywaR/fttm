  <!-- Nav -->
  <header class="col-12 col-xl-3">
    <div class="block_nav_header">
      <div class="block_logo">
        <?php if ( $_SERVER['REQUEST_URI']!='/' ): ?>
          <a class="_value" href="/">
            FTTM
          </a>
        <?php else: ?>
          <span class="_value">
            FTTM
          </span>
        <?php endif; ?>
      </div>

      <?php if (isset($_SESSION['user'])): ?>
        <div class="block_nav_fuller" id="block_nav_fuller">
          <a href="#" class="_btn">
            <span class="_icon">
              <i class="fa-solid fa-ellipsis-vertical"></i>
              <i class="fa-solid fa-list-ul"></i>
            </span>
          </a>
        </div>

        <div class="block_user_prev">
          <a href="/users/" class="home_link user_prev">
            <div class="_img">
              <i class="fa-solid fa-address-book"></i>
            </div>
            <span class="_login">
              <?=$_SESSION['user']['login']?>
            </span>
            <small class="_role">
              <?
              switch ((int)$_SESSION['user']['role']) {
                case 0:
                   ?>
                   <span class="_icon">
                     <i class="fas fa-user-circle"></i>
                   </span>
                   <span class="_value">
                     User
                   </span>
                   <?
                  break;
                case 1:
                   ?>
                   <span class="_icon">
                     <i class="fas fa-check"></i>
                   </span>
                   <span class="_value">
                     Valid user
                   </span>
                   <?
                  break;
                case 666:
                   ?>
                   <span class="_icon">
                     <i class="fas fa-crown"></i>
                   </span>
                   <span class="_value">
                     Admin
                   </span>
                   <?
                  break;
              }
              ?>
            </small>
          </a>
        </div>
      <?php else: ?>
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
      <?php endif; ?>
    </div>

    <div class="block_nav" id="block_nav">
      <ul class="nav _main"></ul>
      <ul class="nav _subs"></ul>
    </div>

    <div class="block_nav_mobile">
      <div class="nav_btn _logo">
        <div class="block_logo">
          <?php if ( $_SERVER['REQUEST_URI']!='/' ): ?>
            <a class="_value" href="/">
              FTTM
            </a>
          <?php else: ?>
            <span class="_value">
              FTTM
            </span>
          <?php endif; ?>
        </div>
      </div>

      <div class="nav_btn _main" id="block_nav_mobile_main">
        <div class="_icon">
          <div class="_old">
            <i class="fa-solid fa-bars"></i>
          </div>
          <div class="_new"></div>
        </div>
        <div class="_name">
          <div class="_old">
            Menu
          </div>
          <div class="_new"></div>
        </div>
      </div>

      <div class="nav_btn _subs" id="block_nav_mobile_subs">
        <div class="_icon">
          <div class="_old">
            <i class="fa-solid fa-ellipsis"></i>
          </div>
          <div class="_new"></div>
        </div>
        <div class="_name">
          <div class="_old">
            Subs
          </div>
          <div class="_new"></div>
        </div>
      </div>

      <div class="nav_btn _user">
        <?php if (isset($_SESSION['user'])): ?>
          <a class="_href" href="/users/">
            <i class="fa-solid fa-address-book"></i>
          </a>
        <?php else: ?>
          <a class="_href" href="/authorizations/">
            <i class="fa-solid fa-address-book"></i>
          </a>
        <?php endif; ?>
      </div>
    </div>

    <button class="block_nav_mobile_body_blocker" id="block_nav_mobile_body_blocker"></button>
  </header>

  <!-- content -->
  <main class="col-12 col-xl-6">
