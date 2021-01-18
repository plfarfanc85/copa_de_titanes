<?php $this->pageTitle=Yii::app()->name; ?> 
		
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Inicio</a></li>
	<li class="active">Jugador</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Jugador <small>Crear</small></h1>

<!-- Tabla de Torneos -->
<div class="row">
    <!-- begin col-12 -->
    <div class="col-md-12 ui-sortable">

    	<div class="panel panel-inverse" data-sortable-id="form-stuff-1">
	        <div class="panel-heading">
	            <div class="panel-heading-btn">
	                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
	                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
	                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
	                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
	            </div>
	            <h4 class="panel-title">Formulario</h4>
	        </div>
	        <div class="panel-body">


		    	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
				  'id'=>'player-form',
				  'action'=>Yii::app()->createUrl("pantheon/player/update"),
				  'type'=>'horizontal',
				  'htmlOptions'=>array('enctype'=>'multipart/form-data'),
				  'method'=>'post',
				)); ?>

				<div class="form-group">
		            <?php echo $form->label($player,'name',array('class'=>'col-md-3 control-label'));  ?>
		            <div class="col-md-8">
		            <?php echo $form->textField($player,'name',array('class'=>'form-control'));  ?>
		            <?php echo $form->error($player,'name'); ?>
		            </div>
		        </div> 
		        <div class="form-group">
		            <?php echo $form->label($player,'surname',array('class'=>'col-md-3 control-label'));  ?>
		            <div class="col-md-8">
		            <?php echo $form->textField($player,'surname',array('class'=>'form-control'));  ?>
		            <?php echo $form->error($player,'surname'); ?>
		            </div>
		        </div> 
		        <div class="form-group">
		            <?php echo $form->label($player,'username',array('class'=>'col-md-3 control-label'));  ?>
		            <div class="col-md-8">
		            <?php echo $form->textField($player,'username',array('class'=>'form-control'));  ?>
		            <?php echo $form->error($player,'username'); ?>
		            </div>
		        </div> 
		        <div class="form-group">
		            <?php echo $form->label($player,'dni',array('class'=>'col-md-3 control-label'));  ?>
		            <div class="col-md-8">
		            <?php echo $form->textField($player,'dni',array('class'=>'form-control'));  ?>
		            <?php echo $form->error($player,'dni'); ?>
		            </div>
		        </div> 
		        <div class="form-group">
		            <?php echo $form->label($player,'mobile',array('class'=>'col-md-3 control-label'));  ?>
		            <div class="col-md-8">
		            <?php echo $form->textField($player,'mobile',array('class'=>'form-control'));  ?>
		            <?php echo $form->error($player,'mobile'); ?>
		            </div>
		        </div> 
		        <div class="form-group">
		            <?php echo $form->label($player,'city_id',array('class'=>'col-md-3 control-label'));  ?>
		            <div class="col-md-8">
		            <?php echo $form->dropDownList($player,'city_id',City::model()->getList(),array('class'=>'col-md-3 control-label'));  ?>
		            <?php echo $form->error($player,'city_id'); ?>
		            </div>
		        </div> 
		        <div class="form-group">
		            <?php echo $form->label($player,'email',array('class'=>'col-md-3 control-label'));  ?>
		            <div class="col-md-8">
		            <?php echo $form->textField($player,'email',array('class'=>'form-control'));  ?>
		            <?php echo $form->error($player,'email'); ?>
		            </div>
		        </div>

		        <input type="hidden" name="id" value="<?php echo $player->id ?>">
		        
		        <div class="form-group">
		        	<label class="col-md-3 control-label"></label>
                    <div class="col-md-9">
                        <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                    </div>
                </div>

				<?php $this->endWidget(); ?>

			</div>
		</div>		
    </div>
</div>
