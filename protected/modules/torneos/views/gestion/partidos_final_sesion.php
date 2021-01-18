<?php $this->pageTitle=Yii::app()->name; ?> 
		
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Inicio</a></li>
	<li class="active">Torneo <?php echo $model->phase->session->tournament->name ?></li>
	<li class="active"><?php echo $model->phase->session->name ?></li>
	<li class="active"><?php echo CHtml::link($model->phase->name,array('/torneos/gestion/grupos/id/'.$model->phase->id)); ?></li>
	<li class="active"><?php echo $model->name ?></li>
	<li class="active">Partidos</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header"><?php echo $model->name; ?> <small>Resumen</small></h1>

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
                <h4 class="panel-title"><?php echo $model->name ?> - <?php echo $model->getStateLabel() ?></h4> 
            </div>
            <div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>#</th>
								<th>Jugador</th>
								<th>Puntos</th>
								<?php echo $this->renderPartial('_items_name', array('model'=>$model)); ?>
							</tr>
						</thead>
						<tbody>
                        <?php
                              $criteria = new CDbCriteria;
                              $criteria->condition = 'tournament_group_id=:id';
                              $criteria->params = array(':id'=>$model->id);
                              $criteria->order = 'position ASC';
                         ?>
        				<?php $data = TournamentGroupPosition::model()->findAll($criteria); ?>
        				<?php foreach ($data as $key2 => $value2): ?>
							<tr>
								<td><?php echo $value2->position?></td>
								<td><?php echo $value2->player->name.' '.$value2->player->surname ?></td>
								<td><?php echo $value2->point ?></td>
								<?php $this->widget('widgets.group.Items',array('tournamentGroupPositionId'=>$value2->id)); ?>
								<?php #echo $this->renderPartial('_items_data', array('value2'=>$value2,'model'=>$model)); ?>
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

<!-- Partidos del grupo -->
<div class="row">
	<?php foreach ($matchs as $key => $value): ?>
	<div class="col-md-6 ui-sortable">
		<div class="panel panel-inverse" data-sortable-id="ui-widget-16">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                </div>
                <h4 class="panel-title"><?php echo $value->name ?> - <?php echo substr($value->date,-8,5) ?> - <?php echo $value->getStateLabel() ?></h4>
            </div>
            <div class="panel-body bg-black text-white">
            	<h6 class="text-center" style="color:white">	
                <?php foreach ($value->tournamentMatchDetail as $key2 => $value2): ?>
                	<?php if($key2==0): ?>
                		<?php echo $value2->player->getNames() ?> <span class="badge badge-warning badge-square"><?php echo $value2->point ?></span>&nbsp;<strong>vs</strong>&nbsp;
                	<?php else: ?>
                		<span class="badge badge-warning badge-square"><?php echo $value2->point ?></span> <?php echo $value2->player->name.' '.$value2->player->surname ?>
                	<?php endif; ?>	
                <?php endforeach; ?>
                </h6>
            </div>
        </div>
	</div>
	<?php endforeach; ?> 
</div>
<!-- Fin Partidos del grupo -->
