	

	<!-- page-intro start-->
	<!-- ================ -->
	<div class="page-intro">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<ol class="breadcrumb">
						<li><i class="fa fa-home pr-10"></i><a href="index.html">Home</a></li>
						<li class="active">Escribenos</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<!-- page-intro end -->

	<!-- main-container start -->
	<!-- ================ -->
	<section class="main-container">

		<div class="container">
			<div class="row">

				<!-- main start -->
				<!-- ================ -->
				<div class="main col-md-8">

					<!-- page-title start -->
					<!-- ================ -->
					<h1 class="page-title">Escribenos</h1>
					<!-- page-title end -->
					<p>Si tienes alguna duda o sugerencia sobre nuestros torneos, déjanos saberla y nos pondremos en contacto contigo.</p>
					<div class="alert alert-success hidden" id="MessageSent">
						Hemos recibido tu mensaje, en instantes nos comunicaresmos contigo.
					</div>
					<div class="alert alert-danger hidden" id="MessageNotSent">
						Oops! Algo salio mal, por favor verifica que no eres un robot e intenta de nuevo.
					</div>
					<div class="contact-form">
						<form id="contact-form-with-recaptcha" role="form">
							<div class="form-group has-feedback">
								<label for="name">Nombre*</label>
								<input type="text" class="form-control" id="name" name="name" placeholder="">
								<i class="fa fa-user form-control-feedback"></i>
							</div>
							<div class="form-group has-feedback">
								<label for="email">Email*</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="">
								<i class="fa fa-envelope form-control-feedback"></i>
							</div>
							
							<div class="form-group has-feedback">
								<label for="message">Pregúntanos*</label>
								<textarea class="form-control" rows="6" id="message" name="message" placeholder=""></textarea>
								<i class="fa fa-pencil form-control-feedback"></i>
							</div>
							<div class="g-recaptcha" data-sitekey="your_site_key"></div>
							<input type="submit" value="Envíar" class="submit-button btn btn-default">
						</form>
					</div>
				</div>
				<!-- main end -->

				<!-- sidebar start -->
				<aside class="col-md-4">
					<div class="sidebar">
						<div class="side vertical-divider-left">
							<h3 class="title">Cups Of Gods.</h3>
							<ul class="list">
								<li><strong></strong></li>
								<!--<li><i class="fa fa-home pr-10"></i>795 Folsom Ave, Suite 600<br><span class="pl-20">San Francisco, CA 94107</span></li>-->
								<!--<li><i class="fa fa-phone pr-10"></i><abbr title="Phone"></abbr> 301 3498007</li>-->
								<li><i class="fa fa-mobile pr-10 pl-5"></i><abbr title="Phone"></abbr> 301 3498007</li>
								<li><i class="fa fa-envelope pr-10"></i><a href="mailto:info@idea.com">info@cupsofgods.com</a></li>
							</ul>
							<ul class="social-links colored circle large">
								<li class="facebook"><a target="_blank" href="http://www.facebook.com/CupsOfGods"><i class="fa fa-facebook"></i></a></li>
								<!--<li class="twitter"><a target="_blank" href="http://www.twitter.com"><i class="fa fa-twitter"></i></a></li>-->
								<li class="instagram"><a target="_blank" href="http://www.instagram.com/cupsofgods"><i class="fa fa-instagram"></i></a></li>
								<!--<li class="googleplus"><a target="_blank" href="http://plus.google.com"><i class="fa fa-google-plus"></i></a></li>-->
							</ul>
						</div>
					</div>
				</aside>
				<!-- sidebar end -->

			</div>
		</div>
	</section>
	<!-- main-container end -->

	
	<!-- section start -->
	<!-- ================ -->
	<div class="section gray-bg text-muted footer-top clearfix">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="owl-carousel clients">
						<div class="client">
							<a href="#"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/images/FIFA18-edicion-ronaldo.png" alt="FIFA 18 edición Ronaldo"></a>
						</div>
						<div class="client">
							<a href="#"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/images/camisa-oficial-FIFA18.png" alt="Camisa Oficial FIFA 18"></a>
						</div>
						<div class="client">
							<a href="#"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/images/balon.png" alt="Balon de Futbol"></a>
						</div>
						<div class="client">
							<a href="#"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/images/dinero.png" alt="Premio torneo fifa17"></a>
						</div>
						<div class="client">
							<a href="#"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/images/trofeo.png" alt="trofeo fifa17"></a>
						</div>								
					</div>
				</div>
				<div class="col-md-6">
					
						<p class="margin-clear">Inscribete en nuestro torneos y podras ganar una bolsa de premios valorada por más de 3 millones de pesos.</p>	
						<!-- <footer><cite title="Source Title">Steve Jobs </cite></footer>-->
					
				</div>
			</div>
		</div>
	</div>
	<!-- section end -->



