<header class="header fixed clearfix">
	<div class="container">
		<div class="row">
			<div class="col-md-3">

				<!-- header-left start -->
				<!-- ================ -->
				<div class="header-left clearfix">

					<!-- logo -->
					<div class="logo">
						<?php echo CHtml::link('<img id="logo" src="'.Yii::app()->theme->baseUrl.'/assets/images/logo_red.png" alt="Cups Of Gods">',array('/site/index')); ?>
						<!--<a href="site/index"><img id="logo" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/images/logo_red.png" alt="Cups Of Gods"></a>-->
					</div>

			<!-- name-and-slogan -->
					<div class="site-slogan">
					</div>

				</div>
				<!-- header-left end -->

			</div>
			<div class="col-md-9">

				<!-- header-right start -->
				<!-- ================ -->
				<div class="header-right clearfix">

					<!-- main-navigation start -->
					<!-- ================ -->
					<div class="main-navigation animated">

						<!-- navbar start -->
						<!-- ================ -->
						<nav class="navbar navbar-default" role="navigation">
							<div class="container-fluid">

								<!-- Toggle get grouped for better mobile display -->
								<div class="navbar-header">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-click="sidebar-toggled" data-target="#navbar-collapse-1">
										<span class="sr-only">Toggle navigation</span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</button>
								</div>

								<!-- Collect the nav links, forms, and other content for toggling -->
								<div class="collapse navbar-collapse" id="navbar-collapse-1">
									<ul class="nav navbar-nav navbar-right">
										<li class="active">
											<?php echo CHtml::link('Home',array('/site/index')); ?>
										</li>
										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">Torneos</a>
											<ul class="dropdown-menu">
												<li><?php echo CHtml::link('FIFA 18',array('/site/torneoFifa')); ?></li>
												<li><?php echo CHtml::link('PES 18',array('/site/torneoPes')); ?></li>
												<li><?php echo CHtml::link('HALO',array('/site/torneoHalo')); ?></li>
												<li><?php echo CHtml::link('CALL OF DUTY',array('/site/torneoCallOfDuty')); ?></li>
												<li><?php echo CHtml::link('MARIO KART',array('/site/torneoMarioKart')); ?></li>
												<li><?php echo CHtml::link('GOLDENEYE',array('/site/torneoGoldenEye')); ?></li>
											</ul>
										</li>													
										<!-- mega-menu start -->
										<!-- mega-menu start -->
										<li>
											<?php echo CHtml::link('Nosotros',array('/site/nosotros')); ?>
										</li>
										<!-- mega-menu end -->
										<li>
											<?php echo CHtml::link('Escribenos',array('/site/escribenos')); ?>
										</li>


									</ul>
								</div>

							</div>
						</nav>
						<!-- navbar end -->

					</div>
					<!-- main-navigation end -->

				</div>
				<!-- header-right end -->

			</div>
		</div>
	</div>
</header>