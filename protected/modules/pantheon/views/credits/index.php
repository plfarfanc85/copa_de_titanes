<?php
    $cs=Yii::app()->clientScript; 
    $cs->registerScript("setInscripcionId","

        $(document).on('click','.apr',function(){
          $('#id_credit').val($(this).attr('facid'));
        });

      ");
?>


<?php $this->pageTitle=Yii::app()->name; ?> 
		
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Inicio</a></li>
	<li class="active">Creditos</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Creditos <small> Trazabilidad y gestión de los creditos de los jugadores</small></h1>


<!-- begin row -->
<div class="row">
    <!-- begin col-12 -->
    <div class="col-md-12">
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <!--<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>-->
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Trazabilidad</h4>
            </div>
            <div class="panel-body">
                <table id="data-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Jugador</th>
                            <th>Documento</th>
                            <th>Creditos</th>
                            <th>Comentario</th>
                            <th>Fecha</th>
                            <th>Comprobante</th>
                            <th>Administrador</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php $criteria = $model->search()->getCriteria() ?>
                    	<?php #$criteria->addCondition('state IN (0,1)'); ?>
        				<?php $data = Credit::model()->findAll($criteria); ?>
        				<?php foreach ($data as $key => $value): ?>
                        <tr class="odd gradeX">
                            <td><?php echo $value->player->getNamesWU() ?></td>
                            <td><?php echo $value->player->dni ?></td>
                            <td><?php echo number_format($value->amount,0,',','.') ?></td>
                            <td><?php echo $value->comments ?></td>
                            <td><?php echo $value->date_import ?></td>
                            <td><?php echo ($value->path)?CHtml::link('<img src="'.Yii::app()->baseUrl.$value->path.'" style="max-height:40px">',array($value->path),array('target'=>'_blank')):''; ?></td>
                            <td><?php echo @$value->rrhh->name ?></td>
                            <td><?php echo $value->getStateLabel() ?></td>
                            <td><?php echo $value->getOpciones(); ?></td>
                        </tr>
                    	<?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- end panel -->
    </div>
    <!-- end col-12 -->
</div>
<!-- end row -->




<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
  'id'=>'credit-form',
  'action'=>Yii::app()->createUrl("pantheon/credits/approve"),
  'type'=>'horizontal',
  'htmlOptions'=>array('enctype'=>'multipart/form-data','class'=>'form-horizontal'),
  'method'=>'post',
)); ?>
<!-- #modal-dialog -->
<div class="modal fade" id="myModalAprobar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Aprobar compra</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="alert alert-warning fade in" align="center">
                        Ingrese la cantidad de creditos a asignar de acuerdo al comprobante de pago. El máximo de compra es <?php echo number_format(Yii::app()->params['maxcreditsbuy'],2,',','.') ?> $
                    </div>
                    <label class="col-md-3 control-label">Cantidad</label>
                    <div class="col-md-9">
                        <?php echo $form->textField($creditForm,'cantidad',array('class'=>'form-control','placeholder'=>'10000'));  ?>
                    </div>                    
                     <?php echo $form->error($creditForm,'cantidad'); ?>
                    <input name="credit_id" id="id_credit" value="" type="hidden">
                </div>
            </div>
            <div class="modal-footer">
                <!--<a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>-->
                <button type="submit" class="btn btn-sm btn-success">Aceptar</button>
                <button class="btn btn-sm btn-white" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

