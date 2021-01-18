<?php // registrar datos del partido en el modelo de formulario - solo va a ver 1 formulario por grupo, osea no se puede jugar mas de un partido la mismo tiempo ?>
<?php foreach ($value->tournamentMatchDetail as $key2 => $value2): ?>
        <?php $form_arr[] = array('names'=>$value2->player->getNames(),'player_id'=>$value2->player->id); ?>
<?php endforeach; ?>
<?php $score->registerAttributes($form_arr,$value->id,2); // jugadores,id del partido y tipo de partido (grupo) ?>
<?php #echo '<pre>'.print_r($form_arr,true).'</pre>';die; ?>


<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'score-form',
    'enableClientValidation'=>false,
    'clientOptions'=>array(
        'validateOnSubmit'=>false,
    ),
    'htmlOptions'=>array('class'=>'form-inline'),
)); ?>
<!--<form action="index.html" method="POST" class="margin-bottom-0">-->
    <div class="form-group m-r-8">
        <label class="col-md-8 control-label"><?php echo $form_arr[0]['names']; ?></label>
        <?php echo $form->hiddenField($score,'player_id_1'); ?>
        <?php echo $form->textField($score,'score1',array('class'=>'form-control','size'=>'5')); ?>
        <?php echo $form->error($score,'score1'); ?>
        <!--<input type="text" class="form-control input-lg" placeholder="Username" required />-->
    </div>
    <div class="form-group m-r-8">
        <label class="col-md-8 control-label"><?php echo $form_arr[1]['names']; ?></label>
        <?php echo $form->hiddenField($score,'player_id_2'); ?>
        <?php echo $form->textField($score,'score2',array('class'=>'form-control','size'=>'5')); ?>
        <?php echo $form->error($score,'score2'); ?>
        
        <?php echo $form->hiddenField($score,'match_id'); ?>
        <?php echo $form->hiddenField($score,'type'); ?>
        <!--<input type="text" class="form-control input-lg" placeholder="Username" required />-->
    </div>
    <button type="submit" class="btn btn-xs btn-primary m-r-10" onClick="return confirm('Estas seguro de registrar el marcador? Recuerda que en los partidos de Playoff siempre debe registrar un marcador ganador, nunca debes registrar un empate.');"><i class="fa fa-2x fa-check"></i></button>
<?php $this->endWidget(); ?>   