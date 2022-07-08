</main>

<!-- footer -->
<footer>
  <div class="block_footer">
    <div id="footer_actions" class="_actions animate__animated"></div>

    <div class="_bottom">
      <!-- <div class="_lang">
        <div class="block_swich">
          <div class="_val">en</div>
          <div class="_val">ru</div>
        </div>
      </div> -->

      <div class="_theme">
        <div class="block_swich" id="theme_switch">
          <div class="_vals">
            <div class="_val <?=$_SESSION['theme'] == 1 ? '_select_' : ''?>" data-val="1">
              <i class="fa-solid fa-moon"></i>
            </div>
            <div class="_val  <?=$_SESSION['theme'] == 2 ? '_select_' : ''?>" data-val="2">
              <i class="fa-solid fa-sun"></i>
            </div>
          </div>
          <input class="_input" type="hidden" name="theme" value="">
        </div>
      </div>

      <div class="_social block_social">
        <a class="_item" href="https://t.me/u0life" target="_blank">
          <i class="fa-brands fa-telegram"></i>
        </a>
        <a class="_item" href="https://www.instagram.com/u0life/" target="_blank">
          <i class="fa-brands fa-instagram"></i>
        </a>
        <a class="_item" href="https://www.tiktok.com/@u0life" target="_blank">
          <i class="fa-brands fa-tiktok"></i>
        </a>
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
