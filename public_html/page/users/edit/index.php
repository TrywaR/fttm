<main class="container">
  <div class="form_block mt-4 col-12 col-md-5 animate__animated animate__flipInX">
    <form id="form_user_edit" class="form_user_edit">
      <div class="card">
        <div class="card-header">
            User edit
        </div>
        <div class="card-body">
          <input type="hidden" name="app" value="app">
          <input type="hidden" name="action" value="users">
          <input type="hidden" name="form" value="edit">
          <input type="hidden" name="id" value="<?=$_SESSION['user']['id']?>">

          <div class="mb-4">
            <label class="form-label" for="form_login">
              <small>
                <i class="fas fa-user-alt"></i>
              </small>
              Login
            </label>
            <input type="text" class="form-control" id="form_login" name="login" value="<?=$_SESSION['user']['login']?>" required="required">
          </div>

          <div class="mb-4">
            <label class="form-label" for="form_phone">
              <small>
                <i class="fas fa-mobile"></i>
              </small>
              Phone
            </label>
            <input type="text" class="form-control" id="form_phone" name="phone" value="<?=$_SESSION['user']['phone']?>">
          </div>

          <div class="mb-4">
            <label class="form-label" for="form_email">
              <small>
                <i class="fas fa-envelope"></i>
              </small>
              Email
            </label>
            <input type="email" class="form-control" id="form_email" name="email" value="<?=$_SESSION['user']['email']?>">
          </div>

          <div class="mb-4">
            <label class="form-label" for="form_date">
              <small>
                <i class="fas fa-calendar-check"></i>
              </small>
              Date registration
            </label>
            <input type="datetime" disabled="disabled" class="form-control" id="form_date" name="date_registration" value="<?=$_SESSION['user']['date_registration']?>">
          </div>

          <div class="mb-4">
            <a class="d-flex justify-content-end" data-bs-toggle="collapse" href="#collapsePassword" role="button" aria-expanded="false" aria-controls="collapsePassword">
              Change password
            </a>

            <div id="collapsePassword" class="collapse">
              <div class="mb-4">
                <label class="form-label" for="form_new_password">
                  <small>
                    <i class="fas fa-key"></i>
                  </small>
                  New password
                </label>
                <input type="password" class="form-control" id="form_new_password" name="new_password" value="">
              </div>

              <div class="mb-4">
                <label class="form-label" for="form_edit_password">
                  <small>
                    <i class="fas fa-key"></i>
                  </small>
                  Password
                </label>
                <input type="password" class="form-control" id="form_edit_password" name="edit_password" value="">
              </div>

              <div class="mb-4">
                <label class="form-label" for="form_edit_password_confirm">
                  <small>
                    <i class="fas fa-key"></i>
                  </small>
                  Password confirmation
                </label>
                <input type="password" class="form-control" id="form_edit_password_confirm" name="edit_password_confirm" value="">
              </div>
            </div>
          </div>

          <div class="_fttm_alerts"></div>

          <div class="block_buttons">
            <button class="btn btn-primary mt-2 mb-4" type="submit">
              <i class="fas fa-save"></i>
              Save
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</main>
