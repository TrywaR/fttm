<section class="row">
  <div class="mt-4 col-12 col-md-7 m-auto">
    <div class="form_block">
      <form id="form_password_recovery" class="form_password_recovery">
      <h2 class="_form_title sub_title">
        Password recovery
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
        <button class="btn btn-primary mt-2 mb-2" type="submit"><i class="fas fa-paper-plane"></i> Send new password on email</button>
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
  </div>
</section>
