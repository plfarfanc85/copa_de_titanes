<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
	<head>
		<meta charset="utf-8" />
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
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

		<!-- BLUE -->
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/theme/blue.css" rel="stylesheet" />

	</head>

	<body>
		<!-- begin #page-loader -->
		<div id="page-loader" class="fade in"><span class="spinner"></span></div>
		<!-- end #page-loader -->
		
		<!-- begin #page-container -->
		<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		
		
			<!-- begin #header -->
			<?php echo $this->renderPartial('/layouts/header'); ?>
			<!-- end #header -->

			<!-- begin #sidebar -->
			<?php echo $this->renderPartial('/layouts/sidebar'); ?>
			<!-- end #sidebar -->
			
			<!-- begin #content -->
			<div id="content" class="content">
			<?php $flashMessages=Yii::app()->user->getFlashes(); ?>
			<?php if($flashMessages!==null): ?>
					<?php foreach($flashMessages as $key => $message): ?>
						<div class="alert alert-<?php echo $key; ?> fade in m-b-15">
							<strong><?php echo $key; ?>!</strong>	
							<?php echo $message; ?><a class="close" data-dismiss="alert">×</a>
						</div>
					<?php endforeach; ?>
			<?php endif; ?>

			<?php echo $content; ?>
			</div>
			<!-- end #content -->

			<!-- begin scroll to top btn -->
			<a href="javascript:;" class="btn btn-icon btn-circle btn-primary btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
			<!-- end scroll to top btn -->

		</div>
		<!-- end page container -->	

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
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/apps.min.js"></script>
		<!-- ================== END PAGE LEVEL JS ================== -->
		
		<script>
			$(document).ready(function() {
				App.init();
			});
		</script>
	</body>
</html>