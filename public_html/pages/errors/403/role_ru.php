<main style="display: flex;justify-content: center;align-items: center;flex-direction: column;">
  <h1>Error 403</h1>
  <p>
    Нет прав доступа к странице <strong><?=$_SERVER['REQUEST_URI']?></strong> <br/>
    Ваш уровень доступа <?=$_SESSION['user']['role_val']?>
    </a>
  </p>
</main>
