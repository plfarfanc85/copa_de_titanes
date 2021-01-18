<?php $this->pageTitle=Yii::app()->name; ?> 
        
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
    <li><a href="javascript:;">Home</a></li>
    <li class="active"><?php echo CHtml::link('Torneos',array('tournament/')); ?></li>
    <li class="active">Tournament <?php echo $model->name ?></li>
    <li class="active">Resumen</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Resumen Torneo <?php echo $model->name; ?> <small>Resumen y Gestión</small></h1>

<!-- begin row -->
<div class="row">
    <!-- begin col-6 -->
    <div class="col-md-6 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="ui-widget-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Resumen</h4>
            </div>
            <div class="panel-body">
            	<div class="note note-success">
					<h4>El Torneo debe desarrollarse bajo los siguientes lineamientos!</h4>
					<p>
					    Cada marcador debe ser registrado correctamente. Dar marcha atras a un marcador conlleva mucha dificultad a nivel de sistemas.<br>
					    Los horarios de cada partido se deben respetar. Asi conservamos el factor diferensiador con la competencia.<br>
					    Hacer cumplir las reglas del torneo esctrictamente. 
	                </p>
				</div>
                
                <div class="table-responsive">
					<table class="table">
						<tbody>
							<tr>
								<th>Nombre</th>
								<td><?php echo $model->name ?></td>
							</tr>
							<tr>
								<th>Juego</th>
								<td><?php echo $model->game->name ?></td>
							</tr>
							<tr>
								<th>Tipo</th>
								<td><?php echo $model->tournamentType->name ?></td>
							</tr>
							<tr>
								<th>Cantidad Tipo</th>
								<td><?php echo $model->tournamentDetail->amount ?></td>
							</tr>
							<tr>
								<th>Jugadores x Tipo</th>
								<td><?php echo $model->tournamentDetail->players ?></td>
							</tr>
							<tr>
								<th>Clasificados x Tipo</th>
								<td><?php echo $model->tournamentDetail->classified ?></td>
							</tr>
							<tr>
								<th>Clase</th>
								<td><?php echo $model->tournamentClass->name ?></td>
							</tr>
							<tr>
								<th>Sesiones</th>
								<td><?php echo $model->tournamentDetail->sessions ?></td>
							</tr>
							<tr>
								<th>Ida y vuelta fase de grupos</th>
								<td><?php echo ($model->tournamentDetail->group_roundtrip)?'Si':'No' ?></td>
							</tr>
							<tr>
								<th>Ida y vuelta playoff</th>
								<td><?php echo ($model->tournamentDetail->playoff_roundtrip)?'Si':'No' ?></td>
							</tr>
							<tr>
								<th>Inicio</th>
								<td><?php echo $model->start_date ?></td>
							</tr>
							<tr>
								<th>Ciudad</th>
								<td><?php echo $model->city->name ?></td>
							</tr>
						</tbody>
					</table>
				</div>

            </div>
        </div>
        <!-- end panel -->
    </div>
    <!-- end col-6 -->    
    <!-- begin col-6 -->
    <div class="col-md-6 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="ui-widget-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Gestión</h4>
            </div>
            <div class="panel-body">
                <p><i class="fa fa-child fa-4x pull-left muted"></i><h3><span class="badge badge-success"><?php echo $inscritos ?></span> / <span class="badge badge-warning"><?php echo $totalConfigurado ?></span> Jugadores</h3></p>
                <?php if(!$creado): ?>
	                <?php if(!$ejecutar): ?>	
		                <div class="alert alert-danger fade in m-b-15">
							<strong>Todavía no se puede crear el torneo!</strong>
							No se puede crear las sesiones, fases y grupos del torneo debido a que no estan inscritos la cantidad configurada de jugadores al torneo.
							<span class="close" data-dismiss="alert">×</span>
						</div>
					<?php else: ?>
						<!--<a href="javascript:;" class="btn btn-success btn-block">Crear Sesiones, fases y Grupos</a>-->
						<?php echo CHtml::link('Crear Sesiones, fases y Grupos',array('tournament/buildTournament/id/'.$model->id),array('class'=>'btn btn-success btn-block')); ?>
					<?php endif; ?>
				<?php endif; ?>	
				<?php if(Yii::app()->user->getState("perfil") == "super"): ?>
					<!--<a href="javascript:;" class="btn btn-success btn-block">Crear Sesiones, fases y Grupos</a>-->
					<?php echo CHtml::link('Cancelar Torneo',array('tournament/cancelTournament/id/'.$model->id),array('class'=>'btn btn-danger btn-block','confirm'=>"Seguro desea cancelar el Torneo?")); ?>
					<?php if($model->tournament_class_id == 1): ?>
						<?php echo CHtml::link('Consolas',array('tournament/consoles/id/'.$model->id),array('class'=>'btn btn-info btn-block')); ?>
						<?php echo CHtml::link('Check In',array('tournament/checkin/id/'.$model->id),array('class'=>'btn btn-warning btn-block')); ?>
					<?php endif; ?>
				<?php endif; ?>
					<?php echo CHtml::link('Pagos',array('tournament/payment/id/'.$model->id),array('class'=>'btn btn-primary btn-block')); ?>
					<?php echo CHtml::link('Ganadores',array('tournament/winners/id/'.$model->id),array('class'=>'btn btn-inverse btn-block')); ?>
            </div>
        </div>
        <!-- end panel -->
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="ui-widget-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Inscritos</h4>
            </div>
            <div class="panel-body">
            	<table class="table">
            		<thead>
	            		<th>Nombre</th>
	            		<th>Telefono</th>	
	            		<th>Correo</th>	
	            		<th>Estado</th>	
            		</thead>
            		<tbody>
            			<?php foreach ($model->tournamentPlayers as $key => $value): ?>
						<tr>
							<td><?php echo $value->player->name ?></td>
							<td><?php echo $value->player->mobile ?></td>
							<td><?php echo $value->player->email ?></td>
							<td><?php echo $value->getStateLabel() ?></td>
						</tr>
						<?php endforeach; ?>            				
            		</tbody>
            	</table>
            </div>
        </div>
        <!-- end panel -->
    </div>
    <!-- begin col-6 -->    
</div>
<!-- end row -->