<main style="display: flex;justify-content: center;align-items: center;flex-direction: column;">
  <h1>Error 403</h1>
  <p>
    Not access to page <strong><?=$_SERVER['REQUEST_URI']?></strong> <br/>
    You access level <?=$_SESSION['user']['role_val']?>
    </a>
  </p>
</main>
