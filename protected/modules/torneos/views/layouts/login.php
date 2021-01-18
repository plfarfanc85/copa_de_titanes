<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
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

	<meta charset="utf-8" />
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/ionicons/css/ionicons.min.css" rel="stylesheet" />
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/animate.min.css" rel="stylesheet" />
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/style.min.css" rel="stylesheet" />
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/style-responsive.min.css" rel="stylesheet" />
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/theme/default.css" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/pace/pace.min.js"></script>
	<!-- ================== END BASE JS ================== -->


	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

	<?php echo $content; ?>

	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="assets/crossbrowserjs/html5shiv.js"></script>
		<script src="assets/crossbrowserjs/respond.min.js"></script>
		<script src="assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/login-v2.demo.min.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/apps.min.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->

	<script>
		$(document).ready(function() {
			App.init();
			LoginV2.init();
		});
	</script>	

</div><!-- page -->

</body>
</html>
