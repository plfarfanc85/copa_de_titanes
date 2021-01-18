<div id="header" class="header navbar navbar-default navbar-fixed-top">
	<!-- begin container-fluid -->
	<div class="container-fluid">
		<!-- begin mobile sidebar expand / collapse button -->
		<div class="navbar-header">
			<!--<a href="index.html" class="navbar-brand"><span class="navbar-logo"><i class="ion-ios-cloud"></i></span> <b>CupsOfGods</b> </a>-->
			<a href="index.html" class="navbar-brand"><span class="navbar-logo">
			<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/logo-3.png" height="30">	
			</span> <b>Copa de Titanes</b> </a>
			<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<!-- end mobile sidebar expand / collapse button -->
		
		<!-- begin header navigation right -->
		<ul class="nav navbar-nav navbar-right">
			<!--
			<li>
				<form class="navbar-form full-width">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Enter keyword" />
						<button type="submit" class="btn btn-search"><i class="ion-ios-search-strong"></i></button>
					</div>
				</form>
			</li>
			-->
			<li class="dropdown">
				<a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle icon">
					<i class="ion-ios-bell"></i>
					<span class="label">1</span>
				</a>
				<ul class="dropdown-menu media-list pull-right animated fadeInDown">
                    <li class="dropdown-header">Notifications (1)</li>
                    <li class="media">
                        <a href="javascript:;">
                            <div class="media-left"><i class="ion-ios-game-controller-b media-object bg-red"></i></div>
                            <div class="media-body">
                                <h6 class="media-heading">Bievenido Usuario</h6>
                                <div class="text-muted f-s-11">Hace 1 minuto</div>
                            </div>
                        </a>
                    </li>
				</ul>
			</li>
			<li class="dropdown navbar-user">
				<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
					<span class="user-image online">
						<img src="<?php echo Yii::app()->baseUrl.Yii::app()->user->getState('imagen') ?>" alt="" /> 
					</span>
					<span class="hidden-xs"><?php echo Yii::app()->user->getState('nombre'); ?></span> <b class="caret"></b>
				</a>
				<ul class="dropdown-menu animated fadeInLeft">
					<li class="arrow"></li>
					<li><?php echo CHtml::link('Perfil',array('/torneos/usuario/perfil')); ?></li>
					<li class="divider"></li>
					<li><?php echo CHtml::link('Salir',array('/torneos/usuario/salir')); ?></li>
				</ul>
			</li>
		</ul>
		<!-- end header navigation right -->
	</div>
	<!-- end container-fluid -->
</div>