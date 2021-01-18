<?php
$cs=Yii::app()->clientScript; 
$cs->registerScript("setGroupId","

    $(document).on('click','.lla',function(){
      $('#id_match').val($(this).attr('facid'));
    });

  ");
?>

<?php $this->pageTitle=Yii::app()->name; ?> 
		
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Home</a></li>
	<li class="active">Tournament <?php echo $model->phase->session->tournament->name ?></li>
	<li class="active"><?php echo $model->phase->session->name ?></li>
	<li class="active"><?php echo CHtml::link($model->phase->name,array('tournament/groups/id/'.$model->phase->id)); ?></li>
	<!--<li class="active"><?php echo $model->name ?></li>-->
	<li class="active">Partidos</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Eliminatorias <?php echo $model->name; ?> <small>Resumen y Gestión</small></h1>

<!-- Partidos del grupo -->
<div class="row">
	<?php foreach ($matchs as $key => $value): ?>
	<div class="col-md-6 ui-sortable">
		<div class="panel panel-warning" data-sortable-id="ui-widget-16">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                	<?php if($value->state != 3): ?>
                		<?php if($value->tconsole_id or $model->phase->session->tournament->tournament_class_id == 2): ?>
		                    <div class="btn-group pull-right">
		                        <button type="button" class="btn btn-success btn-xs">Acciones</button>
		                        <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown">
		                            <span class="caret"></span>
		                        </button>
		                        <ul class="dropdown-menu" role="menu">
		                            <?php echo $value->getActions() ?>
		                        </ul>
		                    </div>
		                <?php else: ?>
		                	<a href="#modal-dialog" facid="<?php echo $value->id ?>" class="btn btn-xs btn-warning lla" data-toggle="modal">Consola</a>		
		                <?php endif; ?>    
                    <?php endif; ?>
                </div>
                <h4 class="panel-title"><?php echo $value->name ?> - <?php echo substr($value->date,-8,5) ?> - <?php echo $value->getStateLabel() ?> - <?php echo $value->getConsoleNameLabel() ?></h4>
            </div>
            <div class="panel-body bg-orange text-white">
            <?php if($value->state == 2): //si el partido esta en juego, formulario de registro de marcador ?> 
                <?php $this->renderPartial("_form_score_play_off",array('value'=>$value,'form_arr'=>$form_arr,'score'=>$score)); ?>
           	<?php else: ?>
            	<h6 class="text-center">	
                <?php foreach ($value->tournamentMatchDetail as $key2 => $value2): ?>
                	<?php if($key2==0): ?>
                		<?php echo $value2->player->getNames() ?> <span class="badge badge-info badge-square"><?php echo $value2->point ?></span><br><strong>vs</strong><br>
                	<?php else: ?>
                		<?php echo $value2->player->getNames() ?><span class="badge badge-info badge-square"><?php echo $value2->point ?></span>
                	<?php endif; ?>	
                <?php endforeach; ?>
                </h6>
            <?php endif; ?>	
            </div>
        </div>
	</div>
	<?php endforeach; ?> 
</div>
<!-- Fin Partidos del grupo -->



<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
  'id'=>'console-form',
  'action'=>Yii::app()->createUrl("pantheon/tournament/assignConsoleM"),
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

				<input name="match_id" id="id_match" value="" type="hidden">
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


