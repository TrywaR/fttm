<div class="fttm_progress progress">
  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
</div>
<header class="container">
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">
        FTTM
      </a>
      <?php if (isset($_SESSION['user'])): ?>
        <a href="/users/" class="home_link">
          <?=$_SESSION['user']['login']?>
        </a>
      <?php endif; ?>
      <?php if (isset($_SESSION['user'])): ?>
        <a class="navbar-toggler" href="" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <!-- <span class="navbar-toggler-icon"></span> -->
          <i class="fas fa-bars"></i>
        </a>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
          <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link <?if($_SERVER['REQUEST_URI']=='/home/') echo 'badge bg-success active';?>" aria-current="page" href="/home/">Home</a>
            </li>

              <li class="nav-item">
                <a class="nav-link <?if($_SERVER['REQUEST_URI']=='/times/') echo 'badge bg-success active';?>" href="/times/">Times</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?if($_SERVER['REQUEST_URI']=='/moneys/') echo 'badge bg-success active';?>" href="/moneys/">Moneys</a>
              </li>
            <?php else: ?>
              <li class="nav-item">
                <a class="nav-link <?if($_SERVER['REQUEST_URI']=='/authorizations/') echo 'badge bg-success active';?>" href="/authorizations/">Login</a>
              </li>
          </ul>
          <!-- <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form> -->
        </div>
      <?php endif; ?>
    </div>
  </nav>
</header>
