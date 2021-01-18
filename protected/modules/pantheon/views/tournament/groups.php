<?php
    $cs=Yii::app()->clientScript; 
    $cs->registerScript("setGroupId","

        $(document).on('click','.lla',function(){
          $('#id_group').val($(this).attr('facid'));
        });

      ");
    ?>

<?php $this->pageTitle=Yii::app()->name; ?> 
		
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
        <?php if(in_array($value->id, $userGroup_array)): ?>
        <div class="panel panel-success" data-sortable-id="table-basic-7">
        <?php else: ?>
        <div class="panel panel-inverse" data-sortable-id="table-basic-7">
        <?php endif; ?>  
            <div class="panel-heading">
                <div class="panel-heading-btn">
                	<?php if($value->rrhh->id == Yii::app()->user->id or Yii::app()->user->getState('perfil')=='super'): ?>
                		<?php if($value->tconsole_id or $phase->session->tournament->tournament_class_id == 2): //Si ya tiene consola asignada (presencial) o si es torneo online ?> 
                			<a href="<?php echo Yii::app()->createUrl("pantheon/tournament/match",array("id"=>$value->id)) ?>" class="btn btn-success btn-xs" role="button"><i class="fa fa-edit"></i> Gestionar</a>
                		<?php else: ?>
                			<a href="#modal-dialog" facid="<?php echo $value->id ?>" class="btn btn-xs btn-warning lla" data-toggle="modal">Consola</a>		
                		<?php endif; ?>	
                    <?php endif; ?>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title"><?php echo $value->name ?> - <?php echo $value->getStateLabel() ?> - <?php echo $value->getConsoleNameLabel() ?> - <?php echo $value->getCoordinator() ?></h4> 
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
							<?php if(in_array($value2->id, $userGroup_array)): ?>
							<tr class="success">
							<?php else: ?>
							<tr>
							<?php endif; ?> 
								<?php $registro = TournamentPlayer::model()->validateRegister($value2->player_id) ?>
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


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
  'id'=>'console-form',
  'action'=>Yii::app()->createUrl("pantheon/tournament/assignConsoleG"),
  'type'=>'horizontal',

  'method'=>'post',
)); ?>
<!-- #modal-dialog -->
<div class="modal fade" id="modal-dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Asignar Consola</h4>
			</div>
			<div class="modal-body">
				<?php echo $form->dropDownList($consoleForm,'console_id',$consoleForm->getList(),
            		array(
    				'empty'=>'--- Seleccione Consola ---',
    				'class'=>'form-control',
    				'options' => array(''=>array('selected'=>true))
		    		)
            	);  ?>
                <?php echo $form->error($consoleForm,'console_id'); ?>

				<input name="group_id" id="id_group" value="" type="hidden">
			</div>
			<div class="modal-footer">
				<!--<a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>-->
				<button type="submit" class="btn btn-sm btn-success">Registrar</button>
				<button class="btn btn-sm btn-white" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			</div>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>

