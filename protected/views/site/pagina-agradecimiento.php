<!-- background image -->
<div class="fullscreen-bg"></div>

<!-- page wrapper start -->
<!-- ================ -->
<div class="page-wrapper">

	<!-- main-container start -->
	<!-- ================ -->
	<section class="main-container light-translucent-bg">
		
		<div class="container">
			<div class="row">

				<!-- main start -->
				<!-- ================ -->
				<div class="main col-md-8 col-md-offset-2">

					<!-- logo -->
					<div class="logo">
						<a href="index.html"><img id="logo" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/images/logo_red.png" alt="Cups Of Gods"></a>
					</div>

					<!-- name-and-slogan -->
					<div class="site-slogan" style="font-size: 12px">
						Es fácil presumir, pero difícil demostrar. <br> Únete a los verdaderos dioses de los video juegos.
					</div>

					<h1 class="title text-center">Gracias por <?php echo $mensaje; ?> <br>en nuestro Torneo de <?php echo $game->name ?></h1>
					<br>
					<p class="text-center">Te invitamos que nos sigas en nuestras redes sociales para mantenerte al tanto de todos nuestros torneos, tips en video juegos y datos curiosos.</p>

				</div>
				<!-- main end -->
			</div>
			<div class="row">
					<h4 class="page-title">Además, quizás puede interesarte algun de nuestros otros torneos:</h4>
						<div class="col-md-12">
							<ul class="list-icons">
								<?php foreach ($games as $key => $value): ?>
								<li class="object-non-visible" data-animation-effect="fadeInUpSmall" data-effect-delay="100"><i class="icon-check"></i><a href="torneo-pes17.html"> <?php echo $value->name ?> </a></li>
								<?php endforeach; ?>
							</ul>
							<div class="space hidden-md hidden-lg"></div>
						</div>
			</div>			



		</div>

	</section>
	<!-- main-container end -->



	
	<!-- section start -->
	<div class="section">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="space"></div>
					<ul class="social-links colored large text-center margin-top-clear circle">
						<li class="facebook"><a target="_blank" href="https://www.facebook.com/CupsOfGods/"><i class="fa fa-facebook"></i></a></li>
						<li class="twitter"><a target="_blank" href="https://www.instagram.com/cupsofgods/"><i class="fa fa-instagram"></i></a></li>
					</ul>
				</div>
				<br>
				<div class="col-md-12 text-center">
					<br>
					<p>Copyright © 2017 <b>Cups Of Gods. </b> Todos los derechos reservados </p>
				</div>

			</div>
		</div>
	</div>
	<!-- section end -->


</div>
<!-- page-wrapper end -->

