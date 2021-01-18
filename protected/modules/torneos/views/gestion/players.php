<?php $this->pageTitle=Yii::app()->name; ?> 
		
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="<?php echo Yii::app()->createUrl('torneos/gestion/index') ?>">Inicio</a></li>
	<li><a href="<?php echo Yii::app()->createUrl('torneos/gestion/view/',array('id'=>$tournament->id)) ?>"><?php echo $tournament->name ?></a></li>
	<li class="active">Players</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Torneo <?php echo $tournament->name ?>  <small>Jugadores</small></h1>

<div class="row">
	<div class="col-md-6 ui-sortable">    
		<div class="panel panel-inverse" data-sortable-id="table-basic-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                </div>
            </div>
            <div class="panel-body">
            	<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>#</th>
								<th>Nombre</th>
								<th>Username</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($players as $key=>$value): ?>
							<tr>
								<td><?php echo $key ?></td>
								<td><?php echo $value->player->getNamesWU() ?></td>
								<td><?php echo $value->player->username ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
                </div>
            </div>
        </div>
	</div>
</div>
