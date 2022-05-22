<main class="container">
  <div class="form_block mt-4 col-12 col-md-5">
    <form id="form_registration" class="form_registration">
      <h2 class="_form_title">
        Registration
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
          Password
        </label>
        <input type="password" class="form-control" id="form_password" name="password" value="" required="required">
      </div>

      <div class="mb-2">
        <label class="form-label" for="form_password_confirm">
          Password confirmation
        </label>
        <input type="password" class="form-control" id="form_password_confirm" name="password_confirm" value="" required="required">
      </div>

      <div class="_fttm_alerts"></div>

      <div class="block_buttons">
        <button class="btn btn-primary mt-2 mb-2" type="submit"><i class="fas fa-user-plus"></i> Register</button>
      </div>

      <div class="mt-4 block_sub_text">
        <p>
          <a class="content_upload" href="/authorizations/">
            Already have an account, login
          </a>
        </p>
        <p>
          <a class="content_upload" href="/password_recovery/">
            If you have forgotten your password, click here.
          </a>
        </p>
      </div>
    </form>
  </div>
</main>
