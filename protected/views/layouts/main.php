<!DOCTYPE html>
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if gt IE 9]> <html lang="en" class="ie"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
	<head>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-116234487-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-116234487-1');
		</script>


		<meta name="viewport" content="width=device-width; initial-scale=1.0" charset="utf-8">
		<title><?php echo $this->pageTitle; ?></title>
		<meta name="description" content="Los mejores TORNEOS DE FIFA de Colombia | Copa de Titanes">
		<meta name="author" content="Pedro Farfan">

		<!-- Mobile Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Favicon -->
		<link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/favicon.ico">

		<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/animate.min.css" rel="stylesheet" />
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/style.min.css" rel="stylesheet" />
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/style-responsive.min.css" rel="stylesheet" />
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/pace/pace.min.js"></script>
	<!-- ================== END BASE JS ================== -->

	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/theme/black.css" rel="stylesheet" id="theme"/>

	<script src='https://www.google.com/recaptcha/api.js'></script>
	<!--
	<style>
		@media all and (min-width: 576px) {
		    div.home-content {
		        top:25%;
		    }
		}
	</style>
	-->

	</head>

	<body data-spy="scroll" data-target="#header-navbar" data-offset="51">
    <!-- begin #page-container -->
    <div id="page-container" class="fade">

		<!-- header-->
		<!-- ================ -->
		<?php echo $this->renderPartial('/layouts/header_top'); ?>
		<!-- header end -->

		<?php echo $content; ?>

		<!-- footer start (Add "light" class to #footer in order to enable light footer) -->
		<!-- ================ -->
		<?php echo $this->renderPartial('/layouts/footer'); ?>
		<!-- footer end -->

		</div>
		<!-- page-wrapper end -->

		<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/crossbrowserjs/html5shiv.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/crossbrowserjs/respond.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/scrollMonitor/scrollMonitor.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/apps.min.js"></script>
	<!-- ================== END BASE JS ================== -->
	
	<script>    
	    $(document).ready(function() {
	        App.init();
	    });
	</script>

	</body>
</html>
