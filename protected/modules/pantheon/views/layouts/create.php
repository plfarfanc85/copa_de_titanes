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
		
		<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css" rel="stylesheet" />
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/ionRangeSlider/css/ion.rangeSlider.css" rel="stylesheet" />
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/ionRangeSlider/css/ion.rangeSlider.skinNice.css" rel="stylesheet" />
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet" />
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" />
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/password-indicator/css/password-indicator.css" rel="stylesheet" />
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap-combobox/css/bootstrap-combobox.css" rel="stylesheet" />
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery-tag-it/css/jquery.tagit.css" rel="stylesheet" />
	    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />
	    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
	    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap-eonasdan-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
	    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css" rel="stylesheet" />
	    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.css" rel="stylesheet" />
	    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-fontawesome.css" rel="stylesheet" />
	    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-glyphicons.css" rel="stylesheet" />
		<!-- ================== END PAGE LEVEL STYLE ================== -->
		
		<!-- ================== BEGIN BASE JS ================== -->
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/pace/pace.min.js"></script>
		<!-- ================== END BASE JS ================== -->
		
		<!-- ORANGE -->
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/theme/orange.css" rel="stylesheet" />

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
			<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/crossbrowserjs/html5shiv.js"></script>
			<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/crossbrowserjs/respond.min.js"></script>
			<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/crossbrowserjs/excanvas.min.js"></script>
		<![endif]-->
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
		<!-- ================== END BASE JS ================== -->
		
		<!-- ================== BEGIN PAGE LEVEL JS ================== -->
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/ionRangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/masked-input/masked-input.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/password-indicator/js/password-indicator.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap-combobox/js/bootstrap-combobox.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery-tag-it/js/tag-it.min.js"></script>
	    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap-daterangepicker/moment.js"></script>
	    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
	    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/select2/dist/js/select2.min.js"></script>
	    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap-show-password/bootstrap-show-password.js"></script>
	    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
	    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.js"></script>
	    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/clipboard/clipboard.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/form-plugins.demo.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/apps.min.js"></script>
		<!-- ================== END PAGE LEVEL JS ================== -->
		
		<script>
			$(document).ready(function() {
				App.init();
				FormPlugins.init();

				$('.multiple-select2').select2({
				  placeholder: 'Seleccionar'
				});
			});
		</script>
	</body>
</html>