<?php $this->pageTitle=Yii::app()->name; ?> 
		
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Home</a></li>
	<li class="active"><?php echo CHtml::link('Tournament '.$model->name,array('tournament/')); ?></li>
	<li class="active"><?php echo CHtml::link('Summary',array('tournament/summary/id/'.$model->id)); ?></li>
	<li class="active">Payment</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Pagos de inscripción<small>Resumen y Gestión</small></h1>

<!-- Tabla de Torneos -->
<div class="row">
    <!-- begin col-6 -->
    <div class="col-md-6 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-7">
            <div class="panel-heading">
                
                <h4 class="panel-title">Por la página</h4>
            </div>
            <div class="panel-body">
            	<div class="note note-info">
					<h4>Por favor tenga en cuenta los siguiente para gestionar los pagos.</h4>
					<p>
					    Si el pago no aparece en la cuenta Bancaria o el comprobante parece no valido, se denega el pago. El usuario podra validar y volver a enviar el comprobante.
	                </p>
				</div>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Id</th>
								<th>Jugador</th>
								<th>Pago</th>
								<th>Opciones</th>
							</tr>
						</thead>
						<tbody>
						<?php $criteria = $tournamentPlayer->search()->getCriteria() ?>
        				<?php $data = TournamentPlayer::model()->findAll($criteria); ?>
        				<?php foreach ($data as $key => $value): ?>
							<tr>
								<td><?php echo $value->player_id ?></td>
								<td><strong><?php echo $value->player->name ?></strong></td>
								<td>
									<?php /*<img src="<?php echo Yii::app()->baseUrl.$value->path ?>" alt="" class="media-object"> */ ?>
									<?php echo CHtml::link('<img src="'.Yii::app()->baseUrl.$value->path.'" style="max-height:40px">',array($value->path),array('target'=>'_blank')); ?>
								</td>		
								<td>
									<?php echo CHtml::link('Confirmar Pago',array('tournament/approvedPayment/id/'.$value->id),array('class'=>'btn btn-success btn-sm m-r-5')); ?>
									<?php echo CHtml::link('Denegar Pago',array('tournament/denyPayment/id/'.$value->id),array('class'=>'btn btn-danger btn-sm m-r-5')); ?>		
								</td>
							</tr>
						 <?php endforeach ?>	
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
        <!-- end panel -->
    </div>
    <!-- end col-6 -->
    <div class="col-md-6 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-7">
            <div class="panel-heading">
                
                <h4 class="panel-title">Por Correo o WhatsApp</h4>
            </div>
            <div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Id</th>
								<th>Jugador</th>
								<th>Opciones</th>
							</tr>
						</thead>
						<tbody>
						<?php $tournamentPlayer->state = 0; ?>	
						<?php $criteria = $tournamentPlayer->search()->getCriteria() ?>
        				<?php $data = TournamentPlayer::model()->findAll($criteria); ?>
        				<?php foreach ($data as $key => $value): ?>
							<tr>
								<td><?php echo $value->player_id ?></td>
								<td><strong><?php echo $value->player->name.' - '.$value->player->mobile ?></strong></td>
								<td>
									<?php echo CHtml::link('Confirmar Pago',array('tournament/approvedPayment/id/'.$value->id),array('class'=>'btn btn-success btn-sm m-r-5')); ?>
								</td>
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
