<main class="container">
  <div class="form_block mt-4 col-12 col-md-5">
    <form id="form_registration" class="form_registration">
      <h2 class="_form_title">
        Регистрация
      </h2>
      <input type="hidden" name="app" value="app">
      <input type="hidden" name="action" value="authorizations">
      <input type="hidden" name="form" value="registration">

      <div class="mb-2">
        <label class="form-label" for="form_login">
          Login
        </label>
        <input type="text" class="form-control" id="form_login" name="login" value="" required="required">
      </div>

      <div class="mb-2">
        <label class="form-label" for="form_password">
          Пароль
        </label>
        <input type="password" class="form-control" id="form_password" name="password" value="" required="required">
      </div>

      <div class="mb-2">
        <label class="form-label" for="form_password_confirm">
          Подтверждение пароля
        </label>
        <input type="password" class="form-control" id="form_password_confirm" name="password_confirm" value="" required="required">
      </div>

      <div class="_fttm_alerts"></div>

      <div class="block_buttons">
        <button class="btn btn-primary mt-2 mb-2" type="submit">Зарегистрироваться</button>
      </div>

      <div class="block_sub_text">
        <!-- <p>
            <a class="content_upload" href="templates/authorizations/password.htm">
              Если вы забыли пароль, <br> нажмите сюда
            </a>
          </p> -->

        <p>
          <a class="content_upload" href="/authorizations/">
            Уже есть аккаунт, войти
          </a>
        </p>
      </div>
    </form>
  </div>
</main>
