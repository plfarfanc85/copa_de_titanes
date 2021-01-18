<!DOCTYPE html>
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if gt IE 9]> <html lang="en" class="ie"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title><?php echo $this->pageTitle; ?></title>
	<meta name="description" content="iDea a Bootstrap-based, Responsive HTML5 Template">
	<meta name="author" content="htmlcoder.me">
	
	<!-- Mobile Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Favicon -->
		<link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/images/faviconL.ico">

		<!-- Web Fonts -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700,300&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=PT+Serif' rel='stylesheet' type='text/css'>

		<!-- Bootstrap core CSS -->
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/bootstrap/css/bootstrap.css" rel="stylesheet">

		<!-- Font Awesome CSS -->
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet">

		<!-- Fontello CSS -->
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/fonts/fontello/css/fontello.css" rel="stylesheet">

		<!-- Plugins -->
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/animations.css" rel="stylesheet">
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery.countdown/jquery.countdown.css" rel="stylesheet">

		<!-- iDea core CSS file -->
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/style.css" rel="stylesheet">

		<!-- Color Scheme (In order to change the color scheme, replace the red.css with the color scheme that you prefer)-->
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/skins/red.css" rel="stylesheet">

		<!-- Custom css -->
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/custom.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- Facebook Pixel Code -->
		<script>
		  !function(f,b,e,v,n,t,s)
		  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
		  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
		  n.queue=[];t=b.createElement(e);t.async=!0;
		  t.src=v;s=b.getElementsByTagName(e)[0];
		  s.parentNode.insertBefore(t,s)}(window, document,'script',
		  'https://connect.facebook.net/en_US/fbevents.js');
		  fbq('init', '723172154557535');
		  fbq('track', 'PageView');
		</script>
		<noscript><img height="1" width="1" style="display:none"
		  src="https://www.facebook.com/tr?id=723172154557535&ev=PageView&noscript=1"
		/></noscript>
		<!-- End Facebook Pixel Code -->
	
</head>

<body class="no-trans">

	<?php echo $content; ?>


	<!-- JavaScript files placed at the end of the document so the pages load faster
		================================================== -->
		<!-- Jquery and Bootstap core js files -->
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery.js"></script>
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/bootstrap/js/bootstrap.min.js"></script>

		<!-- Modernizr javascript -->
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/modernizr.js"></script>

		<!-- Appear javascript -->
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery.appear.js"></script>

		<!-- Count Down javascript -->
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery.countdown/jquery.plugin.js"></script>
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery.countdown/jquery.countdown.js"></script>
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/coming.soon.config.js"></script>

		<!-- SmoothScroll javascript -->
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery.browser.js"></script>
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/SmoothScroll.js"></script>

		<!-- Initialization of Plugins -->
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/template.js"></script>

		<!-- Custom Scripts -->
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/custom.js"></script>

		<script>
		  fbq('track', 'CompleteRegistration');
		</script>

</body>
</html>
	