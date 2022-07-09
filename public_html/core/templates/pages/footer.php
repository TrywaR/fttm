</main>

<!-- footer -->
<footer>
  <div class="block_footer">
    <div id="footer_actions" class="_actions animate__animated"></div>

    <div class="_bottom" id="block_nav_mobile_logo_content">
      <?include 'core/templates/elems/soc_block.php'?>

      <div class="_params">
        <div class="_item _theme">
          <div class="block_swich" id="theme_switch">
            <div class="_vals">
              <div class="_val <?=$_SESSION['theme'] == 1 ? '_select_' : ''?>" data-val="1">
                <i class="fa-solid fa-moon"></i>
              </div>
              <div class="_val  <?=$_SESSION['theme'] == 2 ? '_select_' : ''?>" data-val="2">
                <i class="fa-solid fa-sun"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="_item _lang">
          <div class="block_swich" id="lang_switch">
            <select class="select _vals" name="lang">
              <option <?=$_SESSION['lang'] == 'en' ? 'selected="selected"' : ''?> value="en">en</option>
              <option <?=$_SESSION['lang'] == 'ru' ? 'selected="selected"' : ''?> value="ru">ru</option>
            </select>
          </div>
        </div>
      </div>

      <div class="_copy">
        2021 - <?=date('Y')?> <a href="https://trywar.ru/" target="_blank">TrywaR [dev]</a> ©
      </div>
    </div>
  </div>
</footer>

<!-- Forms -->
<div id="fttm_modal" class="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Toasts -->
<!-- <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-header">
    <img src="..." class="rounded me-2" alt="...">
    <strong class="me-auto">Bootstrap</strong>
    <small>11 mins ago</small>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>

  <div class="toast-body">
    Hello, world! This is a toast message.
  </div>
</div> -->

</body>
</html>
