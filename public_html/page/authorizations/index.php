<main class="container">
  <div class="form_block mt-4 col-12 col-md-5">
    <?php if (isset($_SESSION['user'])) : ?>
      <form class="form_authorization_logout __no_ajax" id="form_authorization_logout" method="post">
        <h2 class="_form_title">Пользователь</h2>
        <input type="hidden" name="app" value="app">
        <input type="hidden" name="action" value="authorizations">
        <input type="hidden" name="form" value="logout">
        <div class="mb-2">
          <label class="form-label" for="form_login">
            Логин
          </label>
          <input type="text" id="form_login" class="form-control" name="login" value="<?=$_SESSION['user']['login']?>" required="required" disabled>
        </div>

        <div class="_fttm_alerts"></div>

        <div class="block_buttons">
          <button class="btn btn-primary mt-2 mb-2" type="submit">Выйти</button>
        </div>
      </form>
    <?php else : ?>
      <form class="form_authorization_login __no_ajax" id="form_authorization_login" method="post">
        <h2 class="_form_title">Авторизация</h2>
        <input type="hidden" name="app" value="app">
        <input type="hidden" name="action" value="authorizations">
        <input type="hidden" name="form" value="login">

        <div class="mb-2">
          <label class="form-label" for="form_login">
            Логин
          </label>
          <input type="text" id="form_login" class="form-control" name="login" value="" required="required">
        </div>

        <div class="mb-2">
          <label class="form-label" for="form_password">
            Пароль
          </label>
          <input type="password" id="form_password" class="form-control" name="password" value="" required="required">
        </div>

        <div class="_fttm_alerts"></div>

        <div class="block_buttons">
          <button class="btn btn-primary mt-2 mb-2" type="submit">Войти</button>
        </div>

        <div class="mt-4 block_sub_text">
          <p>
            <a class="content_upload" href="/registration/">
              Если у вас ещё нет аккаунта, нажмите сюда для регистрации.
            </a>
          </p>
          <!-- <p>
            <a class="content_upload" href="/password_recovery/">
              Если вы забыли пароль, нажмите сюда.
            </a>
          </p> -->
        </div>
      </form>
    <?php endif; ?>
  </div>
</main>
