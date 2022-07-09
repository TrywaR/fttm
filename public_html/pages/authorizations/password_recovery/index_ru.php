<section class="row">
  <div class="mt-4 col-12 col-md-7 m-auto">
    <div class="form_block">
      <form id="form_password_recovery" class="form_password_recovery __form_event_default">
      <h2 class="_form_title sub_title">
        Восстановление пароля
      </h2>
      <input type="hidden" name="app" value="app">
      <input type="hidden" name="action" value="authorizations">
      <input type="hidden" name="form" value="password_recovery">

      <div class="mb-2">
        <label class="form-label" for="form_email">
          Email
        </label>
        <input type="email" class="form-control" id="form_email" name="email" value="" required="required">
      </div>

      <div class="_fttm_alerts"></div>

      <div class="block_buttons justify-content-end">
        <button class="btn btn-primary mt-2 mb-2" type="submit">
          <div class="_icon">
            <i class="fas fa-paper-plane"></i>
          </div>
          <div class="_text">
            Отправить новый пароль на почту
          </div>
        </button>
      </div>

      <div class="mt-4 block_sub_text">
        <p>
          <a class="content_upload" href="/authorizations/">
            Повторить вход
          </a>
        </p>
      </div>
    </form>
    </div>
  </div>
</section>
