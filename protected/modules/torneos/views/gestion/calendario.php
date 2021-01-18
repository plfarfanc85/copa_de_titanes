<?php
    $cs=Yii::app()->clientScript; 
    $cs->registerScript("setInscripcionId","

       $(document).ready(function() {
		    // página cargada, inicializamos el calendario...
		    $('#calendar').fullCalendar({
		        events : [
			        {
			            title  : 'Torneo Hiperión P1',
			            start  : '2018-04-16 20:00:00'
			        },
		    	],
		    	eventColor: '#4CD964'
		    });

		    App.init();
			Calendar.init();
		});

      ");
    ?>

<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Inicio</a></li>
	<li class="active">Calendario</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Calendario <small>Calendario de todos los torneos</small></h1>
<!-- end page-header -->
<!-- begin panel -->
<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Calendario</h4>
    </div>
    <div class="panel-body p-0">
        <div class="vertical-box">
            <div class="vertical-box-column p-15 bg-silver width-200">
                <div id="external-events" class="fc-event-list">
                    <h5 class="m-t-0 m-b-10">Ciudades</h5>
                    <div class="fc-event" data-color="#00acac"><div class="fc-event-icon"><i class="fa fa-circle-o fa-fw text-success"></i></div> Bogotá</div>
                </div>
            </div>
            <div id="calendar" class="vertical-box-column p-15 calendar"></div>
        </div>
    </div>
</div>
<!-- end panel -->
