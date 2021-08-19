<div class="fttm_progress progress">
  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
</div>

<header class="container">
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">FTTM</a>
      <?php if (isset($_SESSION['user'])): ?>
        <?=$_SESSION['user']['login']?>
      <?php endif; ?>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link <?if($_SERVER['REQUEST_URI']=='/') echo 'badge bg-success active';?>" aria-current="page" href="/">Home</a>
          </li>
          <?php if (isset($_SESSION['user'])): ?>
  					<li class="nav-item">
              <a class="nav-link <?if($_SERVER['REQUEST_URI']=='/clients/') echo 'badge bg-success active';?>" href="/clients/">Clients</a>
            </li>
  					<li class="nav-item">
              <a class="nav-link <?if($_SERVER['REQUEST_URI']=='/projects/') echo 'badge bg-success active';?>" href="/projects/">Projects</a>
            </li>
  					<li class="nav-item">
              <a class="nav-link <?if($_SERVER['REQUEST_URI']=='/tasks/') echo 'badge bg-success active';?>" href="/tasks/">Tasks</a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link <?if($_SERVER['REQUEST_URI']=='/events/') echo 'badge bg-success active';?>" href="/events/">Events</a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link <?if($_SERVER['REQUEST_URI']=='/times/') echo 'badge bg-success active';?>" href="/times/">Times</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?if($_SERVER['REQUEST_URI']=='/moneys/') echo 'badge bg-success active';?>" href="/moneys/">Moneys</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?if($_SERVER['REQUEST_URI']=='/authorizations/') echo 'badge bg-success active';?>" href="/authorizations/">Logout</a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link <?if($_SERVER['REQUEST_URI']=='/authorizations/') echo 'badge bg-success active';?>" href="/authorizations/">Login</a>
            </li>
          <?php endif; ?>
        </ul>
        <!-- <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form> -->
      </div>
    </div>
  </nav>
</header>
