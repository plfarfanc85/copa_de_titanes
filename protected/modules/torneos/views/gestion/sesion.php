<?php $this->pageTitle=Yii::app()->name; ?> 
		
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Inicio</a></li>
	<li class="active"><?php echo CHtml::link('Torneo '.$tournament->name,array('/torneos/gestion/')); ?></li>
	<li class="active">Sesiones</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Sesiones <small>Resumen</small></h1>

<div class="note note-info">
	<h4>Información</h4>
	<p>
	    La fila que aparesca en color verde, es la sesión donde estas asignado. Con esto tambien sabrás hasta que parte del torneo llegaste.
    </p>
</div>

<!-- Tabla de Torneos -->
<div class="row">
    <!-- begin col-12 -->
    <div class="col-md-12 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-7">
            <div class="panel-heading">
                <h4 class="panel-title">Lista</h4>
            </div>
            <div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Id</th>
								<th>Name</th>
								<th>Estado</th>
							</tr>
						</thead>
						<tbody>
						<?php $criteria = $model->search()->getCriteria() ?>
        				<?php $data = TournamentSession::model()->findAll($criteria); ?>
        				<?php foreach ($data as $key => $value): ?>
        					<?php if(in_array($value->id, $mySessions_array)): ?>
							<tr class="success">
							<?php else: ?>
							<tr>
							<?php endif; ?>
								<td><?php echo $value->id ?></td>
								<td><?php echo $value->name ?></td>
								<td><?php echo $value->getStateLabel() ?></td>
								<td><a href="<?php echo Yii::app()->createUrl("torneos/gestion/fase",array("id"=>$value->id)) ?>" class="btn btn-success btn-xs" role="button"><i class="fa fa-mail-forward"></i> Ingresar</a></td>
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
    <?php if($tournament->winner_id != null and $tournament->winner_id != 0 ): ?>
    <!-- begin col-12 -->
    <div class="col-md-12 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-success" data-sortable-id="table-basic-7">
            <div class="panel-heading">
                <h4 class="panel-title">Campeón</h4>
            </div>
            <div class="panel-body">
            	<div align="center"><h3>¡Felicitaciones!</h3></div>
            	<br>
            	<div align="center">
            	<ul class="media-list">
            		<li class="media media-sm">
            			<div class="media media-sm">
            				<a class="media" href="javascript:;">
            					<?php if($tournament->winner->path): ?>
					            <img src="<?php echo Yii::app()->theme->baseUrl.$tournament->winner->path; ?>" alt="" class="media-object rounded-corner">
					        	<?php else: ?>
					        	<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/user-15.jpg" alt="" class="media-object rounded-corner">
					        	<?php endif; ?>
							</a>
							<div class="media-body">
								<h4 class="media-heading"><?php echo $tournament->winner->name.' '.$tournament->winner->surname ?></h4>
								<p><?php echo $tournament->winner->username  ?></p>
							</div>	
            			</div>
            		</li>
            	</ul>
            	</div>		
            </div>
        </div>
    </div>
    <?php endif; ?>        
</div>
<!-- Fin Tabla de Torneos -->