<?php $this->pageTitle=Yii::app()->name; ?> 
		
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Home</a></li>
	<li class="active">Dashboard</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Dashboard <small>Datos estadisticos.</small></h1>
<!-- end page-header -->

<!-- begin row -->
<div class="row">
	<!-- begin col-3 -->
	<p>General <small></small></p>
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-gradient-blue">
			<div class="stats-icon"><i class="fa fa-trophy"></i></div>
			<div class="stats-info">
				<h4>Torneos</h4>
				<p><strong><?php echo $tournamentTotal ?></strong></p>	
			</div>
			<!--
			<div class="stats-link">
				<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
			</div>
			-->
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-gradient-aqua">
			<div class="stats-icon"><i class="fa fa-child"></i></div>
			<div class="stats-info">
				<h4>Jugadores</h4>
				<p><strong><?php echo $playerTotal; ?></strong></p>	
			</div>
			<!--
			<div class="stats-link">
				<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
			</div>
			-->
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-gradient-green">
			<div class="stats-icon"><i class="fa fa-child"></i></div>
			<div class="stats-info">
				<h4>En linea</h4>
				<p><strong><?php echo $playerTotalLinea; ?></strong></p>	
			</div>
			<!--
			<div class="stats-link">
				<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
			</div>
			-->
		</div>
	</div>
	<!-- end col-3 -->
	
</div>
<!-- end row -->


<!-- begin row -->
<div class="row">
	<!-- begin col-3 -->
	<p>VISITANTES - <small>Home</small></p>
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-gradient-blue">
			<div class="stats-icon"><i class="ion-ios-world"></i></div>
			<div class="stats-info">
				<h4>Total</h4>
				<p><strong><?php echo $visitanteTotal; ?></strong></p>	
			</div>
			<!--
			<div class="stats-link">
				<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
			</div>
			-->
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-gradient-aqua">
			<div class="stats-icon"><i class="ion-ios-world"></i></div>
			<div class="stats-info">
				<h4>Home</h4>
				<p><strong><?php echo $homeTotal; ?></strong></p>	
			</div>
			<!--
			<div class="stats-link">
				<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
			</div>
			-->
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-gradient-purple">
			<div class="stats-icon"><i class="ion-ios-world"></i></div>
			<div class="stats-info">
				<h4>FIFA 18</h4>
				<p><strong><?php echo $fifaTotal; ?></strong> </p>	
			</div>
			<!--
			<div class="stats-link">
				<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
			</div>
			-->
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-gradient-orange">
			<div class="stats-icon"><i class="ion-ios-world"></i></div>
			<div class="stats-info">
				<h4>PES 18</h4>
				<p><strong><?php echo $pesTotal; ?></strong> </p>	
			</div>
			<!--
			<div class="stats-link">
				<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
			</div>
			-->
		</div>
	</div>
	<!-- end col-3 -->
	
</div>
<!-- end row -->

