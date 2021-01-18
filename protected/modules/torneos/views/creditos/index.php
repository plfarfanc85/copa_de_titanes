<?php $this->pageTitle=Yii::app()->name; ?> 
		
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Inicio</a></li>
	<li class="active">Creditos</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Creditos<small> Resumen y Gestión</small></h1>

<!-- Tabla de Torneos -->
<div class="row">
    <!-- begin col-7 -->
    <div class="col-md-7 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-7">
            <div class="panel-heading">
                
                <h4 class="panel-title">Historial de Creditos</h4>
            </div>
            <div class="panel-body">
            	<div class="note note-info">
					<h4>Por favor tenga en cuenta los siguiente.</h4>
					<p>
					    Esta lista muestra el historial de ingresos y egresos de los creditos, cada uno esta sujeto a algun error y estará dispuesto a validación. Si tiene alguna duda, por favor contactarnos.
	                </p>
				</div>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Id</th>
								<th>Cantidad $</th>
								<th>Comentario</th>
								<th>Fecha</th>
								<th>Opciones</th>
							</tr>
						</thead>
						<tbody>
						<?php $criteria = $creditos->search()->getCriteria() ?>
        				<?php $data = Credit::model()->findAll($criteria); ?>
        				<?php foreach ($data as $key => $value): ?>
							<tr>
								<td><?php echo $value->id ?></td>
								<td><strong><?php echo number_format($value->amount,0,',','.') ?></strong></td>
								<td><?php echo $value->comments ?></td>		
								<td><?php echo $value->getDateFormat() ?></td>		
								<td></td>
							</tr>
						 <?php endforeach ?>	
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
        <!-- end panel -->
    </div>
    <!-- end col-5 -->
    <div class="col-md-5 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-7">
            <div class="panel-heading">
                <h4 class="panel-title">Comprar creditos</h4>
            </div>
            <div class="panel-body">
				<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
				  'id'=>'console-form',
				  'action'=>Yii::app()->createUrl("torneos/creditos/registroCompra"),
				  'type'=>'horizontal',
				  'htmlOptions'=>array('enctype'=>'multipart/form-data'),
				  'method'=>'post',
				)); ?>

				<label>Adjunte una imagen del comprobante de pago (Foto de la consignación). <br><small>Su incripción quedará en estado EN PROCESO DE VALIDACIÓN, y estaremos confirmando su pago en lapso de 24 horas.</small></label>
				<?php echo $form->fileField($CompraCreditosForm,'path');  ?>
                <?php echo $form->error($CompraCreditosForm,'path'); ?>
                <br>
                <button type="submit" class="btn btn-sm btn-success">Registrar pago</button>

				<?php $this->endWidget(); ?>
			</div>
		</div>
        <!-- end panel -->
    </div>
    <!-- end col-12 -->
</div>
<!-- Fin Tabla de Torneos -->
