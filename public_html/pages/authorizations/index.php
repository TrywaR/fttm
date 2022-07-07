<section class="row">
  <div class="mt-4 col-12 col-md-7 m-auto">
    <div class="form_block">
      <?php if (isset($_SESSION['user'])) : ?>
        <form class="form_authorization_logout __no_ajax" id="form_authorization_logout" method="post">
          <h2 class="_form_title sub_title">Profile</h2>
          <input type="hidden" name="app" value="app">
          <input type="hidden" name="action" value="authorizations">
          <input type="hidden" name="form" value="logout">
          <div class="mb-2">
            <label class="form-label" for="form_login">
              Login
            </label>
            <input type="text" id="form_login" class="form-control" name="login" value="<?=$_SESSION['user']['login']?>" required="required" disabled>
          </div>

          <div class="_fttm_alerts"></div>

          <div class="block_buttons justify-content-end">
            <button class="btn btn-primary mt-2 mb-2" type="submit">Exit</button>
          </div>
        </form>
      <?php else : ?>
        <form class="form_authorization_login __no_ajax" id="form_authorization_login" method="post">
          <h2 class="_form_title sub_title">Authorization</h2>
          <input type="hidden" name="app" value="app">
          <input type="hidden" name="action" value="authorizations">
          <input type="hidden" name="form" value="login">

          <div class="mb-2">
            <label class="form-label" for="form_login">
              Login
            </label>
            <input type="text" id="form_login" class="form-control" name="login" value="" required="required">
          </div>

          <div class="mb-2">
            <label class="form-label" for="form_password">
              Password
            </label>
            <input type="password" id="form_password" class="form-control" name="password" value="" required="required">
          </div>

          <div class="_fttm_alerts"></div>

          <div class="block_buttons justify-content-end">
            <button class="btn btn-primary mt-2 mb-2" type="submit">
              <div class="_icon">
                <i class="fas fa-user-check"></i>
              </div>
              <div class="_text">
                Sign in
              </div>
            </button>
          </div>

          <div class="mt-4 block_sub_text">
            <p>
              <a class="content_upload" href="/authorizations/registration/">
                If you don't have an account yet, click here to register.
              </a>
            </p>
            <p>
              <a class="content_upload" href="/authorizations/password_recovery/">
                If you have forgotten your password, click here.
              </a>
            </p>
          </div>
        </form>
      <?php endif; ?>
    </div>
  </div>
</section>
