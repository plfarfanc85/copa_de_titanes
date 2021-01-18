<!-- banner start -->
<!-- ================ -->
<div class="banner">
	<div class="fixed-image section light-translucent-bg" style="background-image:url('<?php echo Yii::app()->theme->baseUrl; ?>/assets/images/Torneo-Halo-banner.jpg');">
		<div class="container">
		<div class="space-top"></div>
		<h1>Torneo de Halo</h1>
		<div class="separator-2"></div>
		<p class="lead">Perteneces a la raza extraterrestre Covenant o eres United Nations Space Command,<br class="hidden-xs hidden-sm"> decide la existencia de la humanidad
en el primer torneo de Halo organizado por Cups of Gods.</p>
		</div>
	</div>
</div>
<!-- banner end -->

<!-- page-intro start-->
<!-- ================ -->
<div class="page-intro">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ol class="breadcrumb">
					<li><i class="fa fa-home pr-10"></i><a href="index.html">Home</a></li>
					<li class="active">Torneo de Halo</li>
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
			<div class="main col-md-12">

				<!-- page-title start -->
				<!-- ================ -->
				<h1 class="page-title text-center">Torneo de Halo</h1>
				<div class="separator"></div>
				<!-- page-title end -->

				<!-- begin mensaje de registro -->
		        <?php if(!empty($mensaje)): ?>
		            <div class="alert alert-<?php echo $mensaje[0]; ?> fade in m-b-15">
		                <?php echo $mensaje[1]; ?>
		                <span class="close" data-dismiss="alert">×</span>
		            </div>
		        <?php endif; ?>    
                <!-- fin mensaje de registro -->
				
				<div class="row">
					<div class="col-md-6">
						<div class="contact-form">
							<form role="form" method="post" action="<?php echo $this->createUrl('/site/torneoHalo'); ?>">
								
								<div class="form-group has-feedback">
									<label for="email">Email*</label>
									<input type="email" class="form-control" id="email" name="email" placeholder="">
									<input type="hidden" name="game" value="3">
									<i class="fa fa-envelope form-control-feedback"></i>
								</div>
								
								<div class="g-recaptcha" data-sitekey="your_site_key"></div>
								<input type="submit" value="Pre Inscríbete" class="submit-button btn btn-default">
							</form>
						</div>
						<div class="tab-pane active" id="pill-1">
							<h3>Pre Inscríbete</h3>
							<div >
								<div >
									<p>Pre inscríbete en nuestro <strong>Torneo de Halo</strong> para mantenerte al tanto de las fechas y lugar donde se llevara a cabo. Ademas se el primero de enterarte de muchas sorpresas más.</p>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="space hidden-lg hidden-md"></div>
						<img class="animated fadeInUpSmall" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/images/services-Halo.png" alt="Torneo PES17">
					</div>
				</div>

			</div>
			<!-- main end -->

		</div>
	</div>
</section>
<!-- main-container end -->



<!-- section start *** class="section gray-bg clearfix"  **** -->









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

