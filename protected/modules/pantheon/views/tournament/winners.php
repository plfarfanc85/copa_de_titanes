<?php
    $cs=Yii::app()->clientScript; 
    $cs->registerScript("setWinnerId","

        $(document).on('click','.lla',function(){
          $('#id_position').val($(this).attr('facid'));
        });

      ");
    ?>

<?php $this->pageTitle=Yii::app()->name; ?> 
        
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
    <li><a href="javascript:;">Home</a></li>
    <li class="active"><?php echo CHtml::link('Torneos',array('tournament/')); ?></li>
    <li class="active">Tournament <?php echo $tournament->name ?></li>
    <li class="active">Ganadores</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Ganadores<small> Gestionar los ganadores del torneo.</small></h1>

<!-- begin row -->
<div class="row">
    <!-- begin col-6 -->
    <div class="col-md-6 ui-sortable">
        <div class="panel panel-inverse" data-sortable-id="ui-widget-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Ingreso</h4>
            </div>
            <div class="panel-body">
                <?php $form=$this->beginWidget('CActiveForm', array(
				    'id'=>'winner-form',
				    'enableClientValidation'=>false,
				    'clientOptions'=>array(
				        'validateOnSubmit'=>false,
				    ),
				    'htmlOptions'=>array('class'=>'form-horizontal'),
				)); ?>

                <!--<form class="form-horizontal">-->
                    <div class="form-group">
                        <label class="col-md-3 control-label">Posición</label>
                        <div class="col-md-9">
                            <!--<input type="text" class="form-control" placeholder="Default input">-->
                            <?php echo $form->textField($winnersForm,'position',array('class'=>'form-control','placeholder'=>'1 o 2 o 3')); ?>
                            <?php echo $form->error($winnersForm,'position'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Jugador</label>
                        <div class="col-md-9">
                            <?php echo $form->textField($winnersForm,'percent',array('class'=>'form-control','placeholder'=>'10')); ?>
                            <?php echo $form->error($winnersForm,'percent'); ?>
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
    </div>
    <!-- end col-6 -->    
    <!-- begin col-6 -->
    <div class="col-md-6 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="ui-widget-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Ganadores</h4>
            </div>
            <div class="panel-body">
            	<table class="table">
            		<thead>
            			<th>Id</th>
	            		<th>Posicion</th>
                        <th>Ganador</th>
                        <th>Porcentaje</th>
	            		<th>Opciones</th>
            		</thead>
            		<tbody>
            			<?php foreach ($model as $key => $value): ?>
						<tr>
							<td><?php echo $value->id ?></td>
							<td align="center"><strong><?php echo $value->position ?></strong></td>
                            <td><?php echo @$value->player->name.' '.@$value->player->surname ?></td>
							<td><?php echo $value->percent ?></td>
                            
                            <?php if($value->player_id == null): ?>
                            <td><a href="#modal-dialog" facid="<?php echo $value->id ?>" class="btn btn-success btn-sm lla" data-toggle="modal"><i class="fa fa-edit"></i> Ganador</a></td>     
                            <?php else: ?>
                            <td></td>    
                            <?php endif; ?>
						</tr>
						<?php endforeach; ?>            				
            		</tbody>
            	</table>
            </div>
        </div>
        <!-- end panel -->
    </div>
    <!-- begin col-6 -->    
</div>
<!-- end row -->




<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
  'id'=>'player-form',
  'action'=>Yii::app()->createUrl("pantheon/tournament/assignWinner"),
  'type'=>'horizontal',

  'method'=>'post',
)); ?>
<!-- #modal-dialog -->
<div class="modal fade" id="modal-dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Registrar ganador</h4>
            </div>
            <div class="modal-body">
                <?php echo $form->dropDownList($winnersUserForm,'player_id',$winnersUserForm->getList(),
                    array(
                    'empty'=>'--- Seleccione Jugador ---',
                    'class'=>'form-control',
                    'options' => array(''=>array('selected'=>true))
                    )
                );  ?>
                <?php echo $form->error($winnersUserForm,'player_id'); ?>

                <input name="position_id" id="id_position" value="" type="hidden">
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

