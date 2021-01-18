<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Home</a></li>
	<li class="active"><?php echo CHtml::link('Desempeño',array('/torneos/reporte/desempeno')); ?></li>
	<li class="active">Partidos empatados</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Partidos Empatados <small>Lista de partidos</small></h1>

<!-- Lista de Partidos de un Jugador -->
<div class="row">
	<?php foreach ($matchs as $key => $value): ?>
	<div class="col-md-6 ui-sortable">
		<div class="panel panel-warning" data-sortable-id="ui-widget-16">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                	
                </div>
                <h4 class="panel-title"><?php echo $value->tournamentGroup->phase->session->tournament->name.' - '.$value->name ?> - <?php echo $value->date ?> </h4>
            </div>
            <div class="panel-body bg-orange text-white">
            	<h6 class="text-center">	
                <?php foreach ($value->tournamentMatchDetail as $key2 => $value2): ?>
                	<?php if($key2==0): ?>
                		<?php echo $value2->player->getNames() ?> <span class="badge badge-info badge-square"><?php echo $value2->point ?></span>&nbsp;<strong>vs</strong>&nbsp;
                	<?php else: ?>
                		<span class="badge badge-info badge-square"><?php echo $value2->point ?></span> <?php echo $value2->player->name.' '.$value2->player->surname ?>
                	<?php endif; ?>	
                <?php endforeach; ?>
                </h6>
            </div>
        </div>
	</div>
	<?php endforeach; ?> 
</div>
<!-- Fin Lista de Partidos de un Jugador -->
