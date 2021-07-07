<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>FTTM</title>
	<meta name="format-detection" content="telephone=no">
	<meta name="description" content="">
	<!-- <link href="../img/favicon.ico" rel="shortcut icon" type="image/x-icon" /> -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- color theme -->
	<meta name="theme-color" content="#000000">
	<meta name="msapplication-navbutton-color" content="#000000">
	<meta name="apple-mobile-web-app-status-bar-style" content="#000000">
	<!-- color theme x-->

	<!-- jQeury -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<!-- jQeury x-->

	<!-- Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
	<!-- Bootstrap x-->

	<!-- font-awesome -->
	<script defer src="https://pro.fontawesome.com/releases/v5.10.0/js/all.js" integrity="sha384-G/ZR3ntz68JZrH4pfPJyRbjW+c0+ojii5f+GYiYwldYU69A+Ejat6yIfLSxljXxD" crossorigin="anonymous"></script>
	<!-- font-awesome  x-->

	<!-- fancybox_galery -->
	<!-- <script src="js/fancybox-master/jquery.fancybox.min.js" charset="utf-8"></script> -->
	<!-- <link rel="stylesheet" href="js/fancybox-master/jquery.fancybox.min.css"> -->
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.25/jquery.fancybox.min.css" /> -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.25/jquery.fancybox.min.js"></script> -->
	<!-- fancybox_galery x-->

	<!-- slick_slide -->
	<!-- <link rel="stylesheet" type="text/css" href="lib/slick-1.8.0/slick/slick.css"/> -->
	<!-- <link rel="stylesheet" type="text/css" href="lib/slick-1.8.0/slick/slick-theme.css"/> -->
	<!-- <script type="text/javascript" src="lib/slick-1.8.0/slick/slick.min.js"></script> -->
	<!-- slick_slide x-->

	<!-- main -->
	<link rel="stylesheet" href="css/main.css">
	<script src="/template/js/main.min.js"></script>
	<!-- main x-->
</head>
<body>

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
            <a class="nav-link <?if($_SERVER['REQUEST_URI']=='/current/') echo 'active';?>" aria-current="page" href="/">Home</a>
          </li>
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
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
</header>
