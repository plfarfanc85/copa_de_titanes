<?php $this->pageTitle=Yii::app()->name; ?> 
		
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Inicio</a></li>
	<li class="active">Mis Inscripciones</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Mis Inscripciones <small>Lista</small></h1>


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
								<th>Torneo</th>
								<th>Consola</th>
								<th>Pago</th>
								<th>Estado</th>
							</tr>
						</thead>
						<tbody>
						<?php $criteria = $model->search()->getCriteria() ?>
        				<?php $data = TournamentPlayer::model()->findAll($criteria); ?>
        				<?php foreach ($data as $key => $value): ?>
							<tr>
								<td><?php echo $value->id ?></td>
								<td style="color:orange"><strong><?php echo $value->tournament->name ?></strong></td>
								<td><?php echo @$value->console->name ?></td>
								<td><?php echo ($value->path != '')?'Registrado':'No Registrado' ?></td>
								<td><?php echo $value->getStateLabel() ?></td>
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

<?php /*
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
  'id'=>'console-form',
  'action'=>Yii::app()->createUrl("torneos/gestion/registerConsole"),
  'type'=>'horizontal',

  'method'=>'post',
)); ?>
<!-- #modal-dialog -->
<div class="modal fade" id="modal-dialog-2">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Seleccionar Consola</h4>
				<p>El tipo de consola con que vas a jugar el Torneo</p>
			</div>
			<div class="modal-body">
				<?php echo $form->dropDownList($inscripcionForm,'console_id',$inscripcionForm->getTypeConsoleList(),
            		array(
    				'empty'=>'--- Seleccione Consola ---',
    				'class'=>'form-control',
    				'options' => array(''=>array('selected'=>true))
		    		)
            	);  ?>
                <?php echo $form->error($inscripcionForm,'console_id'); ?>

				<input name="inscripcion_id" id="id_incripcion2" value="" type="hidden">
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

<?php */ ?>

