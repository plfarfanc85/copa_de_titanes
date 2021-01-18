<?php
    $cs=Yii::app()->clientScript; 
    $cs->registerScript("setInscripcionId","

        $(document).on('click','.lla',function(){
          $('#id_incripcion1').val($(this).attr('facid'));
        });

      ");
    ?>


<?php $this->pageTitle=Yii::app()->name; ?> 
		
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="<?php echo Yii::app()->createUrl('torneos/gestion/index') ?>">Inicio</a></li>
	<li class="active"><?php echo $tournament->name ?></li>
	<li class="active">Fases</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header"><?php echo $tournament->name ?>  <small>Torneo #<?php echo $tournament->id ?>, <?php echo $tournament->tournamentType->name.' de '.$tournament->game->name ?></small></h1> 

<div class="row">
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-gradient-blue">
			<div class="stats-icon"><i class="fa fa-trophy"></i></div>
			<div class="stats-info">
				<h4>BOLSA DE PREMIOS</h4>
				<p><?php echo number_format(($tournament->tournamentDetail->amount*$tournament->tournamentDetail->players)*$tournament->inscription*(1-$tournament->profit/100),'0',',','.'); ?> $</p>	
			</div>
			<div class="stats-link">
				<!--<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>-->
			</div>
		</div>
	</div>
	<!-- end col-3 -->
	
	<?php if($tournamentPlayer): ?>
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-gradient-aqua">
			<div class="stats-icon"><i class="ion-ios-people"></i></div>
			<div class="stats-info">
				<h4>JUGADORES</h4>
				<p><?php echo count($tournament->tournamentPlayersNotPayCanceled)." de ".$tournament->tournamentDetail->amount*$tournament->tournamentDetail->players; ?></p>	
			</div>
			<div class="stats-link">
				<!--<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>-->
			</div>
		</div>
	</div>
	<!-- end col-3 -->
	<?php endif; ?>

	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-gradient-purple">
			<div class="stats-icon"><i class="ion-ios-game-controller-b"></i></div>
			<div class="stats-info">
				<h4>CONSOLAS</h4>
				<p><?php echo Console::model()->getById($tournament->consoles) ?></p>	
			</div>
			<div class="stats-link">
				<!--<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>-->
			</div>
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-gradient-orange">
			<div class="stats-icon"><i class="ion-ios-clock"></i></div>
			<div class="stats-info">
				<h4>FECHA DE INICIO</h4>
				<p><?php echo $tournament->getDateFormated() ?></p>	
			</div>
			<div class="stats-link">
				<!--<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>-->
			</div>
		</div>
	</div>
	<!-- end col-3 -->
</div>


<!-- Tabla de Torneos -->
<div class="row">
    <!-- begin col-6 -->
    <div class="col-md-6 ui-sortable">

    	<div class="panel panel-default panel-with-tabs" data-sortable-id="ui-widget-9">
            <div class="panel-heading">
                <ul id="myTab" class="nav nav-tabs pull-right">
                    <li class="active"><a href="#home" data-toggle="tab" aria-expanded="true"><i class="fa fa-sitemap"></i> <span class="hidden-xs">Estructura</span></a></li>
                    <li class=""><a href="#profile" data-toggle="tab" aria-expanded="false"><i class="fa fa-trophy"></i> <span class="hidden-xs">Premios</span></a></li>
                </ul>
                <h4 class="panel-title">Detalle</h4>
            </div>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="home">
                    <p><?php echo $tournament->description ?></p>
                </div>
                <div class="tab-pane fade" id="profile">
                    <dl class="dl-horizontal">
                    	<?php foreach($tournament->tournamentWinners as $value): ?>
						<dt><?php echo $value->position ?>º puesto = </dt>
						<dd><?php echo number_format(($tournament->tournamentDetail->amount*$tournament->tournamentDetail->players)*$tournament->inscription*(1-$tournament->profit/100)*($value->percent/100),'0',',','.'); ?> $</dd>
						<?php endforeach; ?>
					</dl>
                </div>
            </div>
        </div>

        <?php if($model): ?>
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-7">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                </div>
                <h4 class="panel-title">Desarrollo</h4>
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
							</tr>
						</thead>
						<tbody>
						<?php $criteria = $model->search()->getCriteria() ?>
        				<?php $data = TournamentPhase::model()->findAll($criteria); ?>
        				<?php foreach ($data as $key => $value): ?>
							<?php if(in_array($value->id, $myPhases_array)): ?>
							<tr onclick="document.location = '<?php echo Yii::app()->createUrl("torneos/gestion/grupos",array("id"=>$value->id)) ?>';" class="success">
							<?php else: ?>
							<tr onclick="document.location = '<?php echo Yii::app()->createUrl("torneos/gestion/grupos",array("id"=>$value->id)) ?>';">
							<?php endif; ?>
								<td><?php echo $value->id ?></td>
								<td><?php echo $value->name ?></td>
								<td><?php echo $value->console->name ?></td>
								<td><?php echo $value->number ?></td>
								<td><?php echo $value->getStateLabel() ?></td>
							</tr>
						 <?php endforeach ?>	
						</tbody>
					</table>
				</div>
			</div>
		</div>
        <!-- end panel -->
    	<?php endif; ?>
		

        <?php if($tournament->winner_id != null and $tournament->winner_id != 0 ): ?>
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
								<p><?php echo $session->tournament->winner->username  ?></p>
							</div>	
		    			</div>
		    		</li>
		    	</ul>
		    	</div>		
		    </div>
		</div>
		<?php endif; ?>        
    </div>
    <!-- end col-6 -->

    <!-- begin col-6 Red Social -->
    <div class="col-md-6 ui-sortable">
    	<div class="panel panel-default" data-sortable-id="ui-widget-10">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Opciones</h4>
            </div>
            <div class="panel-body">
                <?php echo TournamentPlayer::model()->getOpciones($tournament->id) ?>
                
            </div>
        </div>

    	<style type="text/css">
    		.registered-users-list>li {
    			width: 20%;
			}
    	</style>
    	<div class="panel panel-inverse" data-sortable-id="index-4">
            <div class="panel-heading">
                <h4 class="panel-title">Jugadores <span class="pull-right label label-primary"><?php echo count($jugadores); ?></span></h4>
            </div>
            <ul class="registered-users-list clearfix">
            	<?php if(count($jugadores)>0): ?>
            	<?php foreach($jugadores as $key => $value): ?>
            	<?php if($key == 5) break; ?>
                <li>
                	<?php if($value->path): ?>
                    <a href="javascript:;"><img src="<?php echo $value->player->path; ?>" alt=""></a>
                    <?php else: ?>
                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/user-15.jpg" alt="">
                    <?php endif; ?>

                    <h4 class="username text-ellipsis">
                        <?php echo $value->player->getNamesWU() ?>
                        <small><?php echo $value->player->username ?></small>
                    </h4>
                </li>
            	<?php endforeach; ?>
            	<?php endif; ?>
            </ul>
            <div class="panel-footer text-center">
                <a href="<?php echo Yii::app()->createUrl('torneos/gestion/players',array('id'=>$tournament->id));  ?>" class="text-inverse">Vert todos</a>
            </div>
        </div>

    	<div class="panel panel-inverse" data-sortable-id="index-5">
			<div class="panel-heading">
				<div class="panel-heading-btn">
					<!--
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					-->
				</div>
				<h4 class="panel-title">Mensajes</h4>
			</div>
			<div class="panel-body">
				<div class="height-sm" data-scrollbar="true">
					<ul class="media-list media-list-with-divider media-messaging">
						<?php if(count($socialNetwork)>0): ?>
						<?php foreach($socialNetwork as $key=>$value): ?>
						<li class="media media-sm">
							<?php if($value->player->path): ?>
		                    <a href="javascript:;" class="pull-left"><img src="<?php echo $value->player->path; ?>" alt="" class="media-object rounded-corner"></a>
		                    <?php else: ?>
		                    <a href="javascript:;" class="pull-left"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/user-15.jpg" alt="" class="media-object rounded-corner"></a>
		                    <?php endif; ?>

							<div class="media-body">
								<h5 class="media-heading"><?php echo $value->player->getNamesWU() ?></h5>
								<p><?php echo $value->comments; ?></p>
							</div>
						</li>
						<?php endforeach; ?>
						<?php endif; ?>
					</ul>
				</div>	
			</div>
			<div class="panel-footer">
				<form method="post" action="<?php echo Yii::app()->createUrl('torneos/gestion/postSN') ?>">
					<div class="input-group">
						<input type="text" name="comentario" class="form-control bg-silver" placeholder="Escribe un mensaje">
						<input type="hidden" name="e" value="t">
						<input type="hidden" name="id" value="<?php echo $tournament->id ?>">
						<span class="input-group-btn">
							<button class="btn btn-primary" type="submit"><i class="fa fa-pencil"></i></button>
						</span>
					</div>
				</form>
            </div>
		</div>

    </div>	
    <!-- end col-6 Red Social -->
    
    
</div>
<!-- Fin Tabla de Torneos -->





<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
  'id'=>'console-form',
  'action'=>Yii::app()->createUrl("torneos/gestion/pagoInscripciones"),
  'type'=>'horizontal',
  'htmlOptions'=>array('enctype'=>'multipart/form-data'),
  'method'=>'post',
)); ?>
<!-- #modal-dialog -->
<div class="modal fade" id="modal-dialog-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Registrar Pago</h4>
			</div>
			<div class="modal-body">
				<label>Adjunte una imagen del comprobante de pago (Foto de la consignación). <br><small>Su incripción quedará en estado EN PROCESO DE VALIDACIÓN, y estaremos confirmando su pago en lapso de 24 horas.</small></label>
				<?php echo $form->fileField($inscripcionForm,'path');  ?>
                <?php echo $form->error($inscripcionForm,'path'); ?>

				<input name="inscripcion_id" id="id_incripcion1" value="" type="hidden">
			</div>
			<div class="modal-footer">
				<!--<a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>-->
				<button type="submit" class="btn btn-sm btn-success">Enviar</button>
				<button class="btn btn-sm btn-white" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			</div>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>


