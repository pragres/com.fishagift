<?php 
	$lang = framework::session_get('language');
	include_once framework::resolve("packages/base/i18n/$lang/header.php");
?>
<!DOCTYPE html>
<html lang="<?php echo $i18n['language']; ?>">
	<head>
		<title><?php echo isset ($title) ? $title : $i18n['title']; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="description" content="<?php echo $i18n['description']; ?>"/>
		<meta name="author" content="Pragres Corporation"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="icon" type="image/png" href="<?php echo framework::resolve('static/graphs/icon.png'); ?>"/>

		<link rel="stylesheet" href="<?php echo framework::resolve('static/css/normalize.css'); ?>"/>
		<link rel="stylesheet" href="<?php echo framework::resolve('static/css/bootstrap.min.css'); ?>"/>
		<link rel="stylesheet" href="<?php echo framework::resolve('static/css/general.css'); ?>"/>
		<link rel="stylesheet" href="<?php echo framework::resolve('static/css/responsive.css'); ?>"/>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo framework::resolve('static/libs/ht5ifv/ht5ifv.css'); ?>"/>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="<?php echo framework::resolve('static/js/bootstrap.min.js'); ?>"></script>
		<script src="<?php echo framework::resolve('static/js/respond.min.js'); ?>"></script>
		<script src="<?php echo framework::resolve('static/js/shoppingcart.js'); ?>"></script>
		<script src="<?php echo framework::resolve('static/js/general.js'); ?>"></script>
		<script src="<?php echo framework::resolve('static/libs/date.format/date.format.js'); ?>"></script>
		<script src="<?php echo framework::resolve('static/js/draggable.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo framework::resolve('static/libs/ht5ifv/jquery.ht5ifv.min.js'); ?>" charset="UTF-8"></script>
		<!--[if lt IE 9]><script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	</head>
	<body data-spy="scroll" data-target="#menu">

	<!-- google analytics -->
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-47019615-1', 'fishagift.com');
		ga('send', 'pageview');
	</script>

	<!--facebook sdk-->
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=548757281837358";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	</script>