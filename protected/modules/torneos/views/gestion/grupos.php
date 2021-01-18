<?php $this->pageTitle=Yii::app()->name; ?> 
		
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Inicio</a></li>
	<li class="active">Torneo <?php echo $phase->session->tournament->name ?></li>
	<li class="active"><?php echo CHtml::link($phase->session->name,array('/torneos/gestion/fase/id/'.$phase->session->id)); ?></li>
	<li class="active"><?php echo $phase->name ?></li>
	<li class="active">Grupos</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Grupos <small>Resumen</small></h1>



<!-- Tabla de Torneos -->
<div class="row">
	<?php foreach ($model as $key => $value): ?>
    <!-- begin col-12 -->
    <div class="col-md-6 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-7">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                	<a href="<?php echo Yii::app()->createUrl("torneos/gestion/partidos",array("id"=>$value->id)) ?>" class="btn btn-success btn-xs" role="button"><i class="fa fa-mail-forward"></i> Ingresar</a>
                </div>
                <h4 class="panel-title"><?php echo $value->name ?> - <?php echo $value->getStateLabel() ?> <?php echo ($phase->session->tournament->tournament_class_id == 1)?' - '.$value->getConsoleNameLabel():'' ?></h4> 
            </div>
            <div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
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
							<?php if($value2->player->id == Yii::app()->user->id): ?>
							<tr class="success">
							<?php else: ?>
							<tr>
							<?php endif; ?>
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
