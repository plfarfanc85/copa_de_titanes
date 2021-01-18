<?php $this->pageTitle=Yii::app()->name; ?> 
		
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Inicio</a></li>
	<li class="active"><?php echo CHtml::link('Grupo  '.$match->tournamentGroup->name,array('torneos/gestion/partidos/id/'.$match->id)); ?></li>
	<li class="active">Registrar marcador</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Registrar marcador del partido</h1>


<?php foreach ($match->tournamentMatchDetail as $key2 => $value2): ?>
        <?php $form_arr[] = array('names'=>$value2->player->getNames(),'player_id'=>$value2->player->id); ?>
<?php endforeach; ?>
<?php $score->registerAttributes($form_arr,$match->id,1); // jugadores,id del partido y tipo de partido (grupo) ?>
<?php #echo '<pre>'.print_r($form_arr,true).'</pre>';die; ?>

<!-- Tabla de Torneos -->
<div class="row">
    <!-- begin col-6 -->
    <div class="col-md-6 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-7">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <?php echo CHtml::link("No registrar marcador",Yii::app()->createUrl("torneos/gestion/noRegistrarMarcador",array("id"=>$match->id)), array('class'=>'btn btn-primary btn-xs m-r-5'));  ?>
                </div>
                <h4 class="panel-title">Marcador</h4>
            </div>
            <div class="panel-body">
                <div class="note note-success">
                    <h4>El partido esta en modo Edición!</h4>
                    <p>
                        Este estado te permitirá solo a ti cambiar el marcador. Si deseas que le adversario registre el marcador, seleccione la opción <strong>No registrar marcador</strong>
                    </p>
                </div>
                <div class="note note-info">
                    <h4>Importante!</h4>
                    <p>
                        Registrar el marcador del partido y envía el comprobante del marcador, toma la foto con tu celular de la pantalla donde se pueda ver el marcador y los ids de los usuarios, se revisará la imagen y en un plazo de 24 horas se registrará el marcador.
                    </p>
                </div>
				<?php $form=$this->beginWidget('CActiveForm', array(
				    'id'=>'score-form',
                    'action'=>Yii::app()->createUrl("torneos/gestion/finalizarRegistroMarcador"),
				    'enableClientValidation'=>false,
				    'clientOptions'=>array(
				        'validateOnSubmit'=>false,
				    ),
				    'htmlOptions'=>array('class'=>'form-horizontal','enctype'=>'multipart/form-data'),
				)); ?>



                <div class="form-group">
                    <label for='ScoreForm_score1' class="col-md-5 control-label"><?php echo $form_arr[0]['names']; ?></label>
                    <div class="col-md-7">
                    <?php echo $form->hiddenField($score,'player_id_1'); ?>
                    <?php echo $form->textField($score,'score1',array('class'=>'form-control col-md-2')); ?>
                    <?php echo $form->error($score,'score1'); ?>
                    <!--<input type="text" class="form-control input-lg" placeholder="Username" required />-->
                    </div>
                </div>
                <div class="form-group">
                    <label for='ScoreForm_score2' class="col-md-5 control-label"><?php echo $form_arr[1]['names']; ?></label>
                    <div class="col-md-7">
                    <?php echo $form->hiddenField($score,'player_id_2'); ?>
                    <?php echo $form->textField($score,'score2',array('class'=>'form-control col-md-2')); ?>
                    <?php echo $form->error($score,'score2'); ?>
                    
                    <?php echo $form->hiddenField($score,'match_id'); ?>
                    <?php echo $form->hiddenField($score,'type'); ?>
                    </div>
                    <!--<input type="text" class="form-control input-lg" placeholder="Username" required />-->
                </div>

                <!--<form class="form-horizontal">-->
                <div class="form-group">
                    <label class="col-md-5 control-label">Marcador</label>
                    <div class="col-md-7">
                        <?php echo $form->fileField($matchScoreForm,'path');  ?>
                        <?php echo $form->error($matchScoreForm,'path'); ?>

                        <input name="match_id" id="id_match" value="<?php echo $match->id ?>" type="hidden">
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
</div>
<!-- Fin Tabla de Torneos -->
