<?php
    $cs=Yii::app()->clientScript; 
    $cs->registerScript("setGraficos","

    	// Star PIE

        var data = [
			{ label: 'Ganados',  data: ".$porcentajes[0].", color:green},
			{ label: 'Perdidos',  data: ".$porcentajes[1].", color:red},
			{ label: 'Empatados',  data: ".$porcentajes[2].", color:orange},
		];

		var placeholder = $('#donut-chart');

		$.plot(placeholder, data, {
			series: {
				pie: { 
					innerRadius: 0.5,
					show: true,
					label: {
						show: true,
						radius: 1,
					}
				}
			},
		});

		// Finish PIE



		// Star BAR 

		var data = [    
		    [1, ".$golesf."], //Goles a favor
		    [2, ".$golesc."], //Goles en contra
		];

		var dataset = [
		    { label: 'Cantidad', data: data, color: '#247af2' }
		];

		var ticks = [
		    [1, 'Goles a Favor'], [2, 'Goles en Contra']
		];
		 
		var options = {
            series: {
                bars: {
                    show: true
                }
            },
            bars: {
                align: 'center',
                barWidth: 0.3,
                fill:1,
            },
            xaxis: {
                axisLabel: 'Goles',
                min:0,
                max:3,
                tickLength:5,
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                ticks: ticks
            },
            yaxis: {
                axisLabel: 'Cantidad',
                min:0,
                max:".$graficoGolesMax.",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 3,
                
            },
            legend: {
                noColumns: 0,
                labelBoxBorderColor: '#000000',
                position: 'nw'
            },
            grid: {
                hoverable: true,
                borderWidth: 2,
            }
        };

        $.plot($('#bar-chart'), dataset, options);
        $('#bar-chart').UseTooltip();

		// Finish BAR

      ");
    ?>

<?php $this->pageTitle=Yii::app()->name; ?> 
		
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Home</a></li>
	<li class="active">Desempeño</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Desempeño <small>Datos estadisticos de tu historial.</small></h1>
<!-- end page-header -->

<!-- begin row -->
<div class="row">
	<?php /*
	<div class="col-md-12">
		<div class="m-b-10 f-s-10 m-t-5"><b class="text-inverse">En Vivo</b></div>
		<div class="card card-inverse">
			<a href="<?php echo Yii::app()->createUrl('/torneos/gestion/partidos/',array('id'=>62)); ?>"><img class="card-img" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/banner/banner-titanes.png" alt="Card image">
			<div class="card-img-overlay">
				<h4 class="card-title">En Vivo</h4>
				<p class="card-text"><strong>¡Sigue el torneo aquí!</strong></p>
				<p class="card-text"><small></small></p>
			</div>
			</a>
		</div>
	</div>	
	*/ ?>
	<!-- begin col-3 -->
	<p>Torneos</p>
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-gradient-purple">
			<div class="stats-icon"><i class="fa fa-trophy"></i></div>
			<div class="stats-info">
				<h4>Torneos Ganados</h4>
				<p><strong>0</strong><small> /1</small></p>	
			</div>
			
			<div class="stats-link">
				<!--<a href="javascript:;">Ver Lista <i class="fa fa-arrow-circle-o-right"></i></a>-->
			</div>
			
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-gradient-aqua">
			<div class="stats-icon"><i class="fa fa-sort-numeric-asc"></i></div>
			<div class="stats-info">
				<h4>Ranking</h4>
				<p><strong><?php echo '1'; ?></strong></p>	
			</div>
			
			<div class="stats-link">
				<!--<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>-->
				<?php #echo CHtml::link('Ver Lista <i class="fa fa-arrow-circle-o-right"></i>',array('/torneos/reporte/listaGanados')); ?>
			</div>
			
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-gradient-green">
			<div class="stats-icon"><i class="ion-ios-football"></i></div>
			<div class="stats-info">
				<h4>Goles a favor</h4>
				<p><strong><?php echo $golesf ?></strong></p>	
			</div>
			
			<div class="stats-link">
				<!--<a href="javascript:;">Ver Lista <i class="fa fa-arrow-circle-o-right"></i></a>-->
				<?php #echo CHtml::link('Ver Lista <i class="fa fa-arrow-circle-o-right"></i>',array('/torneos/reporte/listaTodos')); ?>
			</div>
			
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-gradient-red">
			<div class="stats-icon"><i class="ion-ios-football"></i></div>
			<div class="stats-info">
				<h4>Goles en contra</h4>
				<p><strong><?php echo $golesc; ?></strong></p>	
			</div>
			
			<div class="stats-link">
				<!--<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>-->
				<?php #echo CHtml::link('Ver Lista <i class="fa fa-arrow-circle-o-right"></i>',array('/torneos/reporte/listaGanados')); ?>
			</div>
			
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col 3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-gradient-blue">
			<div class="stats-icon"><i class="ion-ios-game-controller-b"></i></div>
			<div class="stats-info">
				<h4>Partidos Jugados</h4>
				<p><strong><?php echo $total; ?></strong></p>	
			</div>
			
			<div class="stats-link">
				<!--<a href="javascript:;">Ver Lista <i class="fa fa-arrow-circle-o-right"></i></a>-->
				<?php echo CHtml::link('Ver Lista <i class="fa fa-arrow-circle-o-right"></i>',array('/torneos/reporte/listaTodos')); ?>
			</div>
			
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-gradient-green">
			<div class="stats-icon"><i class="fa fa-child"></i></div>
			<div class="stats-info">
				<h4>Partidos Ganados</h4>
				<p><strong><?php echo $ganados; ?></strong></p>	
			</div>
			
			<div class="stats-link">
				<!--<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>-->
				<?php echo CHtml::link('Ver Lista <i class="fa fa-arrow-circle-o-right"></i>',array('/torneos/reporte/listaGanados')); ?>
			</div>
			
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-gradient-red">
			<div class="stats-icon"><i class="fa fa-frown-o"></i></div>
			<div class="stats-info">
				<h4>Partidos Perdidos</h4>
				<p><strong><?php echo $perdidos ?></strong> </p>	
			</div>
			
			<div class="stats-link">
				<!--<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>-->
				<?php echo CHtml::link('Ver Lista <i class="fa fa-arrow-circle-o-right"></i>',array('/torneos/reporte/listaPerdidos')); ?>
			</div>
			
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-gradient-orange">
			<div class="stats-icon"><i class="fa fa-meh-o"></i></div>
			<div class="stats-info">
				<h4>Partidos Empatados</h4>
				<p><strong><?php echo $empatados ?></strong> </p>	
			</div>
			
			<div class="stats-link">
				<!--<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>-->
				<?php echo CHtml::link('Ver Lista <i class="fa fa-arrow-circle-o-right"></i>',array('/torneos/reporte/listaEmpatados')); ?>
			</div>
			
		</div>
	</div>
	<!-- end col-3 -->
</div>
<!-- end row -->


<div class="row">
	<p>Graficos</p>
	<div class="col-md-6 col-sm-6">
		<div class="panel panel-inverse" data-sortable-id="index-7">
			<div class="panel-heading">
				<div class="panel-heading-btn">
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand" data-original-title="" title="" data-init="true"><i class="fa fa-expand"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload" data-original-title="" title="" data-init="true"><i class="fa fa-repeat"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse" data-original-title="" title="" data-init="true"><i class="fa fa-minus"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
				</div>
				<h4 class="panel-title">Partidos</h4>
			</div>
			<div class="panel-body">
				<div id="donut-chart" class="height-sm" style="padding: 0px; position: relative;">
				</div>
			</div>
		</div>
	</div>	
	<div class="col-md-6 col-sm-6">
		<div class="panel panel-inverse" data-sortable-id="index-7">
			<div class="panel-heading">
				<div class="panel-heading-btn">
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand" data-original-title="" title="" data-init="true"><i class="fa fa-expand"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload" data-original-title="" title="" data-init="true"><i class="fa fa-repeat"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse" data-original-title="" title="" data-init="true"><i class="fa fa-minus"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
				</div>
				<h4 class="panel-title">Goles</h4>
			</div>
			<div class="panel-body">
				<div id="bar-chart" class="height-sm"></div>
			</div>
		</div>
	</div>	
</div>


