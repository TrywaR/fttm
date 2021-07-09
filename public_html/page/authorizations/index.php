<main class="container">
  <div class="form_block">
    <div class="block_manager_authorization">
      <form class="form_manager_authorization" id="form_manager_authorization" action="index.html" method="post">
        <h2 class="_form_title">Авторизация</h2>
        <input type="hidden" name="form" value="form_manager_authorization">
        <input type="hidden" name="table" value="authorizations">
        <input type="hidden" name="manager" value="manager">

        <div class="block_input">
          <label>
            <p class="label">E-mail</p>
            <input type="email" class="input" name="email" value="" required="required">
          </label>
        </div>

        <div class="block_input">
          <label>
            <p class="label">Пароль</p>
            <input type="password" class="input" name="password" value="" required="required">
          </label>
        </div>

        <div class="form_status" id="form_status"></div>

        <div class="block_buttons">
          <button class="btn btn-primary mt-2 mb-2" type="submit">Войти</button>
        </div>

        <div class="block_sub_text">
          <p>
            <a class="content_upload" href="/registration/">
              Если у вас ещё нет аккаунта, <br/> нажмите сюда для регистрации.
            </a>
          </p>
          <p>
            <a class="content_upload" href="/password_recovery/">
              Если вы забыли пароль, <br/> нажмите сюда.
            </a>
          </p>
        </div>
      </form>
    </div>
  </div>
</main>
