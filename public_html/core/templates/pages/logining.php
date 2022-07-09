<?/*
<?include 'core/templates/pages/logining.php';?>
*/?>
<div class="block_logining">
  <div class="btn-group">
    <a class="btn btn-primary <?if($_SERVER['REQUEST_URI']=='/authorizations/') echo 'disabled';?>" href="/authorizations/">
      <div class="_icon">
        <i class="fas fa-user-check"></i>
      </div>
      <div class="_text">
        <?=$oLang->get('SignIn')?>
      </div>
    </a>
    <a class="btn btn-primary <?if($_SERVER['REQUEST_URI']=='/authorizations/registration/') echo 'disabled';?>" href="/authorizations/registration/">
      <div class="_icon">
        <i class="fas fa-user-plus"></i>
      </div>
      <div class="_text">
        <?=$oLang->get('SignUp')?>
      </div>
    </a>
  </div>
</div>
