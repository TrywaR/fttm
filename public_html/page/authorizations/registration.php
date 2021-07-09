<main class="container page_registration registration_forms">
  <div class="form_block">
    <div class="block_manager_authorization">
      <form id="form_manager_registration" class="registration_form form_manager_authorization">
        <h2 class="_form_title">
          Регистрация
        </h2>
        <input type="hidden" name="form" value="form_manager_registration">
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

        <div class="block_input">
          <label>
            <p class="label">Подтверждение пароля</p>
            <input type="password" class="input" name="password_confirm" value="" required="required">
          </label>
        </div>

        <div class="form_status"></div>

        <div class="block_buttons">
          <button class="btn btn-primary mt-2 mb-2" disabled="disabled" type="submit">Зарегистрироваться</button>
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
  </div>
</main>
