<?php $this->pageTitle=Yii::app()->name; ?> 
		
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Inicio</a></li>
	<li class="active"><?php echo CHtml::link('Grupo  '.$match->tournamentGroup->name,array('torneos/gestion/partidos/id/'.$match->id)); ?></li>
	<li class="active">Agendar partido</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Agendar fechas para los partido<br><small>Podra agendar un máximo de 10 fechas. Si coincide con alguna fecha del rival, el partido se dará como agendado.</small><br><small>Partido <strong><?php echo $match->tournamentMatchDetail[0]->player->name.'</strong> vs <strong>'.$match->tournamentMatchDetail[1]->player->name ?></strong></small></h1>

<!-- Tabla de Torneos -->
<div class="row">
    <!-- begin col-6 -->
    <div class="col-md-6 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-7">
            <div class="panel-heading">
                
                <h4 class="panel-title">Tus fechas agendadas</h4>
            </div>
            <div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Id</th>
								<th>Fecha</th>
								<th>Estado</th>
								<th>Opciones</th>
							</tr>
						</thead>
						<tbody>
						<?php $criteria = $tournamentMatchSchedule->search()->getCriteria() ?>
        				<?php $data = TournamentMatchSchedule::model()->findAll($criteria); ?>
        				<?php foreach ($data as $key => $value): ?>
							<tr>
								<td><?php echo $value->id ?></td>
								<td><strong><?php echo $value->date_schedule ?></strong></td>
								<td><?php echo $value->getTestLabel() ?></td>
								<td>
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
    <!-- end col-6 -->
    <div class="col-md-6 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-7">
            <div class="panel-heading">
                
                <h4 class="panel-title">Agendar Fecha</h4>
            </div>
            <div class="panel-body">
				<?php $form=$this->beginWidget('CActiveForm', array(
				    'id'=>'score-form',
                    'action'=>Yii::app()->createUrl("torneos/gestion/registroAgendarPartido"),
				    'enableClientValidation'=>false,
				    'clientOptions'=>array(
				        'validateOnSubmit'=>false,
				    ),
				    'htmlOptions'=>array('class'=>'form-horizontal'),
				)); ?>

                <!--<form class="form-horizontal">-->
                    <div class="form-group">
                        <label class="col-md-3 control-label">Día</label>
                        <div class="col-md-9">
                            <?php echo $form->dropDownList($matchScheduleForm,'day_Schedule',$matchScheduleForm->getScheduleListDay(),
                        		array(
			    				'empty'=>'--- Seleccione día ---',
			    				'class'=>'form-control',
			    				'options' => array(''=>array('selected'=>true))
					    		)
                        	);  ?>
                            <?php echo $form->error($matchScheduleForm,'day_Schedule'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Hora</label>
                        <div class="col-md-9">
                            <?php echo $form->dropDownList($matchScheduleForm,'hour_Schedule',$matchScheduleForm->getScheduleListHour(),
                        		array(
			    				'empty'=>'--- Seleccione hora ---',
			    				'class'=>'form-control',
			    				'options' => array(''=>array('selected'=>true))
					    		)
                        	);  ?>
                            <?php echo $form->error($matchScheduleForm,'hour_Schedule'); ?>
                            <input type="hidden" name="MatchScheduleForm[tournament_match_id]" value="<?php echo $match->id ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-sm btn-success">Registrar</button>
                        </div>
                    </div>
                <!--</form>-->
                <?php $this->endWidget(); ?>   
			</div>
		</div>
        <!-- end panel -->
    </div>
    <!-- end col-12 -->
    <!-- begin col-6 -->
    <div class="col-md-6 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-7">
            <div class="panel-heading">
                
                <h4 class="panel-title">Rival fechas agendadas</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $criteria = $tournamentMatchScheduleVs->search()->getCriteria() ?>
                        <?php $data = TournamentMatchSchedule::model()->findAll($criteria); ?>
                        <?php foreach ($data as $key => $value): ?>
                            <tr>
                                <td><?php echo $value->id ?></td>
                                <td><strong><?php echo $value->date_schedule ?></strong></td>
                                <td><?php echo $value->getTestLabel() ?></td>
                            </tr>
                         <?php endforeach ?>    
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
        <!-- end panel -->
    </div>
    <!-- end col-6 -->
</div>
<!-- Fin Tabla de Torneos -->
