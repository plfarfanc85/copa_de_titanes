<?php $this->pageTitle=Yii::app()->name; ?> 
		
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Inicio</a></li>
	<li class="active">Torneos</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Torneos <small>Lista</small></h1>

<!-- Tabla de Torneos -->
<div class="row">
    <!-- begin col-12 -->
    <div class="col-md-12 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-7">
            <div class="panel-heading">
                
                <h4 class="panel-title">Lista</h4>
            </div>
            <div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Id</th>
								<th>Nombre</th>
								<th>Juego</th>
								<th>Grupos</th>
								<th>Jugadores <small>xGrupo</small></th>
								<th>Inscritos</th>
								<th>Consola</th>
								<th>Clase</th>
								<th>Inscripción</th>
								<th>Fecha Inicio</th>
								<th>Estado</th>
							</tr>
						</thead>
						<tbody>
						<?php $criteria = $model->search()->getCriteria() ?>
        				<?php $data = Tournament::model()->findAll($criteria); ?>
        				<?php foreach ($data as $key => $value): ?>
							<tr onclick="document.location = '<?php echo Yii::app()->createUrl('torneos/gestion/view',array('id'=>$value->id)) ?>';">
								<td><?php echo $value->id ?></td>
								<td style="color:orange"><strong><?php echo $value->name ?></strong></td>
								<td><?php echo $value->game->name ?></td>
								<td align="center"><?php echo $value->tournamentDetail->amount ?></td>
								<td align="center"><?php echo $value->tournamentDetail->players ?></td>
								
								<td><p><span class="badge badge-info"><?php echo count($value->tournamentPlayersNotPayCanceled)." / ".$value->tournamentDetail->amount*$value->tournamentDetail->players; ?></span></p></td>
								<?php /*
								<td><p><span class="badge badge-warning"><?php echo Console::model()->getById(1) ?> - <?php echo TournamentPlayer::model()->getPlayerByConsole($value->id,1)." / ".($value->tournamentDetail->amount*$value->tournamentDetail->players)/2; ?></span></p>
								<p><span class="badge badge-warning"><?php echo Console::model()->getById(2) ?> - <?php echo TournamentPlayer::model()->getPlayerByConsole($value->id,2)." / ".($value->tournamentDetail->amount*$value->tournamentDetail->players)/2; ?></span></p>
								</td>
								*/ ?>
								<td><span class="badge badge-warning"><?php echo Console::model()->getById($value->consoles) ?></td>
								<td><span class="badge badge-warning"><?php echo $value->tournamentClass->name ?></td>
								<td><?php echo number_format($value->inscription,'0',',','.').' $'; ?></td>
								
								<td><?php echo $value->start_date ?></td>
								<td><?php echo $value->getStateLabel() ?></td>
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