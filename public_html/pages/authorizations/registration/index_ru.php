<section class="row">
  <div class="mt-4 col-12 col-md-7 m-auto">
    <div class="form_block">
      <form id="form_registration" class="form_registration __form_event_default">
      <h2 class="_form_title sub_title">
        Регистрация
      </h2>
      <input type="hidden" name="app" value="app">
      <input type="hidden" name="action" value="authorizations">
      <input type="hidden" name="form" value="registration">

      <div class="mb-2">
        <label class="form-label" for="form_login">
          Логин
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

      <div class="block_buttons justify-content-end">
        <button class="btn btn-primary mt-2 mb-2" type="submit">
          <div class="_icon">
            <i class="fas fa-user-plus"></i>
          </div>
          <div class="_text">
            Создать аккаунт
          </div>
        </button>
      </div>

      <div class="mt-4 block_sub_text">
        <p>
          <a class="content_upload" href="/authorizations/">
            Уже есть аккаунт, войти
          </a>
        </p>
        <p>
          <a class="content_upload" href="/authorizations/password_recovery/">
            Восстановить пароль
          </a>
        </p>
      </div>
    </form>
    </div>
  </div>
</section>
