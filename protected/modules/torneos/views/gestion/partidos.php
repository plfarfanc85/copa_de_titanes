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
		<div class="panel panel-<?php echo ($key%2==0)?'info':'success' ?>" data-sortable-id="ui-widget-16">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <?php echo $value->getSchudelOptions() ?><?php echo $value->getCheckInOption() ?><?php echo $value->getScoreOption() ?>
                </div>
                <h4 class="panel-title"><?php echo $value->name ?> - <?php echo $value->getDateLabel() ?> - <?php echo $value->getStateLabel() ?></h4>
            </div>
            <div class="panel-body bg-<?php echo ($key%2==0)?'aqua':'green' ?> text-white">
            	<ul class="media-list media-list-with-divider">
                    <li class="media media-sm">
                        <?php foreach ($value->tournamentMatchDetail as $key2 => $value2): ?>   
                            <?php if($key2==0): ?>  
                                <a class="media-left" href="javascript:;">
                                    <?php if($value2->player->path): ?>
                                    <img src="<?php echo $value2->player->path; ?>" alt="" class="media-object rounded-corner" style="height: 64px;">
                                    <?php else: ?>
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/user-15.jpg" alt="" class="media-object rounded-corner">
                                    <?php endif; ?>
                                    <small style="color:gray!important"> <?php echo $value2->player->username ?></small> 
                                </a>
                                <div class="media-body">
                                    <h6 class="text-center">
                                        <em><?php echo $value2->player->getNamesWU() ?></em>  
                                        <span class="badge badge-warning"><?php echo $value2->point ?></span><br><strong>vs</strong><br>
                             <?php else: ?>    
                                        <em><?php echo $value2->player->getNamesWU() ?></em>  
                                        <span class="badge badge-warning"><?php echo $value2->point ?></span> 
                                    </h6>
                                </div>
                                <a class="media-right" href="javascript:;">
                                    <?php if($value2->player->path): ?>
                                    <img src="<?php echo $value2->player->path; ?>" alt="" class="media-object rounded-corner" style="height: 64px;">
                                    <?php else: ?>
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/user-15.jpg" alt="" class="media-object rounded-corner">
                                    <?php endif; ?>
                                    <small style="color:gray!important"> <?php echo $value2->player->username ?></small> 
                                </a>
                            <?php endif; ?> 
                        <?php endforeach; ?> 
                    </li>
                </ul>
            </div>
        </div>
	</div>
	<?php endforeach; ?> 
</div>
<!-- Fin Partidos del grupo -->
