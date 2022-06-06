<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>FTTM</title>
	<meta name="format-detection" content="telephone=no">
	<meta name="description" content="Free Time TrywaR Manager">
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
	<!-- <script defer src="https://pro.fontawesome.com/releases/v5.10.0/js/all.js" integrity="sha384-G/ZR3ntz68JZrH4pfPJyRbjW+c0+ojii5f+GYiYwldYU69A+Ejat6yIfLSxljXxD" crossorigin="anonymous"></script> -->
	<script defer src="/lib/fontawesome-free-6.1.1-web/js/all.min.js"></script>
	<!-- font-awesome  x-->

	<!-- jGrowl -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.8/jquery.jgrowl.min.css" integrity="sha512-bHAmDko6dIkQXQGO56+bsFtl7FJEuzQ0qKsB+cpdzmOV0D7ONYYwfV8ub+7yevWSCZgP10lIy7aTW8eKv5IgTw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.8/jquery.jgrowl.min.js" integrity="sha512-h77yzL/LvCeAE601Z5RzkoG7dJdiv4KsNkZ9Urf1gokYxOqtt2RVKb8sNQEKqllZbced82QB7+qiDAmRwxVWLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<!-- jGrowl x-->

	<!-- fancybox_galery -->
	<!-- <script src="/js/fancybox-master/jquery.fancybox.min.js" charset="utf-8"></script> -->
	<!-- <link rel="stylesheet" href="/js/fancybox-master/jquery.fancybox.min.css"> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.25/jquery.fancybox.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.25/jquery.fancybox.min.css" />
	<!-- fancybox_galery x -->

	<!-- chart.js -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.0/dist/chart.min.js"></script>
	<!-- chart.js x -->

	<!-- slick_slide -->
	<!-- <link rel="stylesheet" type="text/css" href="lib/slick-1.8.0/slick/slick.css"/> -->
	<!-- <link rel="stylesheet" type="text/css" href="lib/slick-1.8.0/slick/slick-theme.css"/> -->
	<!-- <script type="text/javascript" src="lib/slick-1.8.0/slick/slick.min.js"></script> -->
	<!-- slick_slide x-->

	<!-- main -->
	<!-- <link rel="stylesheet" href="/template/css/main.min.css?v=5.2.4"> -->
	<?
	if ( isset($_SESSION['user']) ) {
		$iTheme = $_SESSION['user']['theme'] ? (int)$_SESSION['user']['theme'] : 1;
		switch ( $iTheme ) {
			case 0:
				?><link rel="stylesheet" href="/template/themes/Dark/theme.min.css?v=5.2.4"><?
				break;
			case 1:
				?><link rel="stylesheet" href="/template/themes/Dark/theme.min.css?v=5.2.4"><?
				break;
			case 2:
				?><link rel="stylesheet" href="/template/themes/Light/theme.min.css?v=5.2.4"><?
				break;
			case 3:
				break;
		}
	}
	else {
		?><link rel="stylesheet" href="/template/themes/Dark/theme.min.css?v=5.2.4"><?
	}
	?>

	<script src="/template/js/authorizations/authorizations.js?v=5.2.4"></script>
	<script src="/template/js/content_loader/content_loader.js?v=5.2.4"></script>
	<script src="/template/js/content_manager/content_manager.js?v=5.2.4"></script>
	<script src="/template/js/content_filter/content_filter.js?v=5.2.4"></script>
	<script src="/template/js/progress_bar/progress_bar.js?v=5.2.4"></script>
	<script src="/template/js/alerts/alerts.js?v=5.2.4"></script>
	<script src="/template/js/content/content.js?v=5.2.4"></script>

	<script src="/template/js/main/nav.js?v=5.2.4"></script>

	<script src="/template/js/session/session.js?v=5.2.4"></script>
	<script src="/template/js/index.js?v=5.2.4"></script>
	<!-- main x-->
</head>

<body class="animate__animated animate__fadeIn">
