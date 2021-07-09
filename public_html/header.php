<header class="container">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">FTTM</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link <?if($_SERVER['REQUEST_URI']=='/') echo 'active';?>" aria-current="page" href="/">Home</a>
          </li>
          <?php if (isset($_SESSION['session_key'])): ?>
  					<li class="nav-item">
              <a class="nav-link <?if($_SERVER['REQUEST_URI']=='/clients/') echo 'active';?>" href="/clients/">Clients</a>
            </li>
  					<li class="nav-item">
              <a class="nav-link <?if($_SERVER['REQUEST_URI']=='/projects/') echo 'active';?>" href="/projects/">Projects</a>
            </li>
  					<li class="nav-item">
              <a class="nav-link <?if($_SERVER['REQUEST_URI']=='/tasks/') echo 'active';?>" href="/tasks/">Tasks</a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link <?if($_SERVER['REQUEST_URI']=='/events/') echo 'active';?>" href="/events/">Events</a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link <?if($_SERVER['REQUEST_URI']=='/moneys/') echo 'active';?>" href="/moneys/">Moneys</a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link <?if($_SERVER['REQUEST_URI']=='/authorizations/') echo 'active';?>" href="/authorizations/">Login</a>
            </li>
          <?php endif; ?>
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
</header>
