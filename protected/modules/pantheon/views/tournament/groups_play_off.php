<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Home</a></li>
	<li class="active">Tournament <?php echo $phase->session->tournament->name ?></li>
	<li class="active"><?php echo CHtml::link($phase->session->name,array('tournament/phase/id/'.$phase->session->id)); ?></li>
	<li class="active"><?php echo $phase->name ?></li>
	<li class="active">Grupos</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Grupos <small>Resumen y Gestión</small></h1>



<!-- Tabla de Torneos -->
<div class="row">
	<?php foreach ($model as $key => $value): ?>
    <!-- begin col-12 -->
    <div class="col-md-6 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-7">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                	<?php if($value->rrhh->id == Yii::app()->user->id or Yii::app()->user->getState('perfil')=='super'): ?>
                		<a href="<?php echo Yii::app()->createUrl("pantheon/tournament/match",array("id"=>$value->id)) ?>" class="btn btn-success btn-xs" role="button"><i class="fa fa-edit"></i> Gestionar</a>
                    <?php endif; ?>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title"><?php echo $value->name ?> - <?php echo $value->getStateLabel() ?> </h4> 
            </div>
            <div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Registro</th>
								<th>Id</th>
								<th>Jugador</th>
								<th>Puntos</th>
							</tr>
						</thead>
						<tbody>
						<?php
                              $criteria = new CDbCriteria();
                              $criteria->condition = 'tournament_group_id=:id';
                              $criteria->params = array(':id'=>$value->id);
                              $criteria->order = 'position ASC';
                         ?>
        				<?php $data = TournamentGroupPosition::model()->findAll($criteria); ?>
        				<?php foreach ($data as $key2 => $value2): ?>
							<tr> <?php $registro = TournamentPlayer::model()->validateRegister($value2->player_id) ?>
								<td><span class="badge badge-<?php echo ($registro)?'primary':'danger' ?> badge-square"><?php echo ($registro)?'S':'N' ?></span></td>
								<td><?php echo $value2->player->id; ?></td>	
								<td><?php echo $value2->player->name.' '.$value2->player->surname ?></td>
								<td><?php echo $value2->point ?></td>
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
    <?php endforeach; ?>
</div>
<!-- Fin Tabla de Torneos -->
