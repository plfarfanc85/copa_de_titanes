<?php $this->pageTitle=Yii::app()->name; ?> 
		
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Home</a></li>
	<li class="active"><?php echo CHtml::link('Tournament '.$session->tournament->name,array('tournament/session/id/'.$session->tournament_id)); ?></li>
	<li class="active"><?php echo $session->name ?></li>
	<li class="active">Fases</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Fases <small>Resumen y Gestión</small></h1>



<!-- Tabla de Torneos -->
<div class="row">
    <!-- begin col-12 -->
    <div class="col-md-12 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-7">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
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
								<th>Consola</th>
								<th>Orden</th>
								<th>Estado</th>
								<th>Opciones</th>
							</tr>
						</thead>
						<tbody>
						<?php $criteria = $model->search()->getCriteria() ?>
        				<?php $data = TournamentPhase::model()->findAll($criteria); ?>
        				<?php foreach ($data as $key => $value): ?>
							<?php if(in_array($value->id, $userPhase_array)): ?>
							<tr class="success">
							<?php else: ?>
							<tr>
							<?php endif; ?>
								<td><?php echo $value->id ?></td>
								<td><?php echo $value->name ?></td>
								<td><?php echo $value->console->name ?></td>
								<td><?php echo $value->number ?></td>
								<td><?php echo $value->getStateLabel() ?></td>
								<td><a href="<?php echo Yii::app()->createUrl("pantheon/tournament/groups",array("id"=>$value->id)) ?>" class="btn btn-success btn-xs" role="button"><i class="fa fa-edit"></i> Gestionar</a></td>
							</tr>
						 <?php endforeach ?>	
						</tbody>
					</table>
				</div>
				<?php if($nextPhase): ?>
				<div align="center">
					<p>
						<a href="<?php echo Yii::app()->createUrl("/pantheon/tournament/nextPhase",array("id"=>$session->id)); ?>" class="btn btn-default btn-block"><i class="fa fa-check pull-right"></i> Siguiente Fase</a>
					</p>
				</div>
				<?php endif; ?>
			</div>
		</div>
        <!-- end panel -->
    </div>
    <!-- end col-12 -->
</div>
<!-- Fin Tabla de Torneos -->