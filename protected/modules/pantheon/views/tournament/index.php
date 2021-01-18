<?php $this->pageTitle=Yii::app()->name; ?> 
		
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Home</a></li>
	<li class="active">Tournament</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Torneos <small>Resumen y Gestión</small></h1>



<!-- Tabla de Torneos -->
<div class="row">
    <!-- begin col-12 -->
    <div class="col-md-12 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-7">
            <div class="panel-heading">
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-success btn-xs">Acciones</button>
                    <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><?php echo CHtml::link("Crear",Yii::app()->createUrl("pantheon/tournament/create")); ?></li>
                    </ul>
                </div>
                <h4 class="panel-title">Lista</h4>
            </div>
            <div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Id</th>
								<th>Nombre</th>
								<th>Juego</th>
								<th>Tipo</th>
								<th>Grupos</th>
								<th>Jugadores <small>xGrupo</small></th>
								<th>Inscritos</th>
								<th>Consola</th>
								<th>Clase</th>
								<th>Fecha Inicio</th>
								<th>Estado</th>
								<th>Test</th>
								<th>Opciones</th>
							</tr>
						</thead>
						<tbody>
						<?php $criteria = $model->search()->getCriteria() ?>
        				<?php $data = Tournament::model()->findAll($criteria); ?>
        				<?php foreach ($data as $key => $value): ?>
							<?php if(in_array($value->id, $userTournament_array)): ?>
							<tr class="success">
							<?php else: ?>
							<tr>
							<?php endif; ?>
								<td><?php echo $value->id ?></td>
								<td><?php echo $value->name ?></td>
								<td><?php echo $value->game->name ?></td>
								<td><?php echo $value->tournamentType->name ?></td>
								<td align="center"><?php echo $value->tournamentDetail->amount ?></td>
								<td align="center"><?php echo $value->tournamentDetail->players ?></td>
								<td><span class="badge badge-info"><?php echo count($value->tournamentPlayers)." / ".$value->tournamentDetail->amount*$value->tournamentDetail->players; ?></span></td>
								<td><span class="badge badge-warning"><?php echo Console::model()->getById($value->consoles) ?></td>
								<td><span class="badge badge-warning"><?php echo $value->tournamentClass->name ?></td>
								<td><?php echo $value->start_date ?></td>
								<td><?php echo $value->getStateLabel() ?></td>
								<td><?php echo $value->getTestLabel() ?></td>
								<td>
									<?php if($value->session): ?>
									<a href="<?php echo Yii::app()->createUrl("pantheon/tournament/session",array("id"=>$value->id)) ?>" class="btn btn-success btn-xs" role="button"><i class="fa fa-edit"></i> Gestionar</a>
									<?php endif; ?>
									<a href="<?php echo Yii::app()->createUrl("pantheon/tournament/summary",array("id"=>$value->id)) ?>" class="btn btn-warning btn-xs" role="button"><i class="fa fa-tachometer"></i> Resumen</a>
								</td>
							</tr>
						 <?php endforeach ?>	
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
        <!-- end panel -->
    </div>
    <!-- end col-12 -->
</div>
<!-- Fin Tabla de Torneos -->