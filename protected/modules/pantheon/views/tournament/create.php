<?php # echo '<pre>'.print_r(TournamentClass::model()->getList(),true).'</pre>';die; ?>
<?php # echo '<pre>'.print_r(TournamentForm::model()->getListYN(),true).'</pre>';die; ?>
<?php
    $cs=Yii::app()->clientScript; 
    $cs->registerScript("setDate","

        $(function () {
            $('#datetimepicker1').datetimepicker();
        });

      ");
    ?>

<?php $this->pageTitle=Yii::app()->name; ?> 
		
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Home</a></li>
	<li class="active"><?php echo CHtml::link("Tournament",array('/pantheon/tournament/')); ?></li>
	<li class="active">Create</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Torneos <small>Crear</small></h1>

<!-- begin row -->
<div class="row">
    <!-- begin col-6 -->
    <div class="col-md-6 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Formulario</h4>
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
                            <?php echo $form->textField($model,'name',array('class'=>'form-control','placeholder'=>'Nombre')); ?>
        					<?php echo $form->error($model,'name'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Juego</label>
                        <div class="col-md-9">
                            <!--<select class="form-control">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>-->
                            <?php echo $form->dropDownList($model,'game_id',Game::model()->getList(),
                        		array(
			    				'empty'=>'--- Seleccione Juego ---',
			    				'class'=>'form-control',
			    				'options' => array(''=>array('selected'=>true))
					    		)
                        	);  ?>
                            <?php echo $form->error($model,'game_id'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Tipo de torneo</label>
                        <div class="col-md-9">
                            <?php echo $form->dropDownList($model,'tournament_type_id',TournamentType::model()->getList(),
                        		array(
			    				'empty'=>'--- Seleccione Tipo de Torneo ---',
			    				'class'=>'form-control',
			    				'options' => array(''=>array('selected'=>true))
					    		)
                        	);  ?>
                            <?php echo $form->error($model,'tournament_type_id'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Cantidad</label>
                        <div class="col-md-9">
                            <!--<input type="text" class="form-control" placeholder="Default input">-->
                            <?php echo $form->textField($model,'amount',array('class'=>'form-control','placeholder'=>'Cantida de grupos del torneo')); ?>
        					<?php echo $form->error($model,'amount'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Jugadores</label>
                        <div class="col-md-9">
                            <!--<input type="text" class="form-control" placeholder="Default input">-->
                            <?php echo $form->textField($model,'players',array('class'=>'form-control','placeholder'=>'Jugadores x grupo')); ?>
        					<?php echo $form->error($model,'players'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Clasificados</label>
                        <div class="col-md-9">
                            <!--<input type="text" class="form-control" placeholder="Default input">-->
                            <?php echo $form->textField($model,'classified',array('class'=>'form-control','placeholder'=>'Clasificados x grupo o liga')); ?>
        					<?php echo $form->error($model,'classified'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Clase</label>
                        <div class="col-md-9">
                            <?php echo $form->dropDownList($model,'tournament_class_id',TournamentClass::model()->getList(),
                                array(
                                'empty'=>'--- Seleccione Clase ---',
                                'class'=>'form-control',
                                'options' => array(''=>array('selected'=>true))
                                )
                            );  ?>
                            <?php echo $form->error($model,'tournament_class_id'); ?>
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label">Sesiones</label>
                        <div class="col-md-9">
                            <!--<input type="text" class="form-control" placeholder="Default input">-->
                            <?php echo $form->textField($model,'sessions',array('class'=>'form-control','placeholder'=>'Nº de Sesiones del torneo')); ?>
                            <?php echo $form->error($model,'sessions'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Ida y vuelta fase de grupos</label>
                        <div class="col-md-9">
                            <?php echo $form->dropDownList($model,'group_roundtrip',array('No','Si'),
                                array(
                                'empty'=>'--- Seleccione ---',
                                'class'=>'form-control',
                                'options' => array(''=>array('selected'=>true))
                                )
                            );  ?>
                            <?php echo $form->error($model,'group_roundtrip'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Ida y vuelta playoff</label>
                        <div class="col-md-9">
                            <?php echo $form->dropDownList($model,'playoff_roundtrip',array('No','Si'),
                                array(
                                'empty'=>'--- Seleccione ---',
                                'class'=>'form-control',
                                'options' => array(''=>array('selected'=>true))
                                )
                            );  ?>
                            <?php echo $form->error($model,'playoff_roundtrip'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Consolas</label>
                        <div class="col-md-9">
                            <!--<input type="text" class="form-control" placeholder="Default input">-->
                            <?php #echo $form->textField($model,'consoles',array('class'=>'form-control','placeholder'=>'1,2')); ?>
                            <?php #echo $form->error($model,'consoles'); ?>

                             <select class="multiple-select2 form-control" multiple="multiple" name="consoles[]">
                                <optgroup label="Consolas">
                                    <?php foreach($consoles as $value):  ?>
                                         <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                                     <?php endforeach; ?>  
                                </optgroup>
                            </select>    
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Descripción</label>
                        <div class="col-md-9">
                            <!--<textarea class="form-control" placeholder="Textarea" rows="5"></textarea>-->
                            <?php echo $form->textArea($model,'description',array('class'=>'form-control','placeholder'=>'Descripción')); ?>
        					<?php echo $form->error($model,'description'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Fecha Inicio</label>
                        <div class="col-md-9">
                            <div class="input-group date" id="datetimepicker1">
                            	<?php echo $form->textField($model,'start_date',array('class'=>'form-control')); ?>
        						<?php echo $form->error($model,'start_date'); ?>
                                <!--<input type="text" class="form-control">-->
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Ciudad</label>
                        <div class="col-md-9">
                            <?php echo $form->dropDownList($model,'city_id',City::model()->getList(),
                        		array(
			    				'empty'=>'--- Seleccione Ciudad ---',
			    				'class'=>'form-control',
			    				'options' => array(''=>array('selected'=>true))
					    		)
                        	);  ?>
                            <?php echo $form->error($model,'city_id'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Test</label>
                        <div class="col-md-9">
                            <!--<input type="text" class="form-control" placeholder="Default input">-->
                            <?php echo $form->checkBox($model,'test',array('class'=>'form-control')); ?>
                            <?php echo $form->error($model,'test'); ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-sm btn-success">Crear</button>
                        </div>
                    </div>
                <!--</form>-->
                <?php $this->endWidget(); ?>   
            </div>
        </div>
        <!-- end panel -->
    </div>
    <!-- end col-6 -->
</div>
<!-- end row -->
