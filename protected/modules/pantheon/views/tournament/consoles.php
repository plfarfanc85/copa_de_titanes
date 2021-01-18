<?php $this->pageTitle=Yii::app()->name; ?> 
        
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
    <li><a href="javascript:;">Home</a></li>
    <li class="active"><?php echo CHtml::link('Torneos',array('tournament/')); ?></li>
    <li class="active">Tournament <?php echo $tournament->name ?></li>
    <li class="active">Console</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Consolas<small>Consolas de video juegos del Torneo.</small></h1>

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
				    'id'=>'score-form',
				    'enableClientValidation'=>false,
				    'clientOptions'=>array(
				        'validateOnSubmit'=>false,
				    ),
				    'htmlOptions'=>array('class'=>'form-horizontal'),
				)); ?>

                <!--<form class="form-horizontal">-->
                    <div class="form-group">
                        <label class="col-md-3 control-label">Nombre</label>
                        <div class="col-md-9">
                            <!--<input type="text" class="form-control" placeholder="Default input">-->
                            <?php echo $form->textField($consoleForm,'name',array('class'=>'form-control','placeholder'=>'Nombre')); ?>
                            <?php echo $form->error($consoleForm,'name'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Jugador</label>
                        <div class="col-md-9">
                            <?php echo $form->dropDownList($consoleForm,'console_id',$consoleForm->getTypeConsoleList(),
                        		array(
			    				'empty'=>'--- Seleccione Tipo Consola ---',
			    				'class'=>'form-control',
			    				'options' => array(''=>array('selected'=>true))
					    		)
                        	);  ?>
                            <?php echo $form->error($consoleForm,'console_id'); ?>
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
                <h4 class="panel-title">Registrados</h4>
            </div>
            <div class="panel-body">
            	<table class="table">
            		<thead>
            			<th>Id</th>
	            		<th>Consola</th>
	            		<th>Tipo</th>
            		</thead>
            		<tbody>
            			<?php foreach ($model as $key => $value): ?>
						<tr>
							<td><?php echo $value->id ?></td>
							<td><?php echo $value->name ?></td>
							<td><?php echo $value->consoleType->name ?></td>
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