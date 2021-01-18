<?php $this->pageTitle=Yii::app()->name; ?> 
		
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Inicio</a></li>
	<li class="active"><?php echo CHtml::link('Torneo '.$session->tournament->name,array('/torneos/gestion/sesion/id/'.$session->tournament_id)); ?></li>
	<li class="active"><?php echo $session->name ?></li>
	<li class="active">Fases</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header"><?php echo $session->tournament->name ?>  <small>Torneo #<?php echo $session->tournament->id ?>, <?php echo $session->tournament->tournamentType->name.' de '.$session->tournament->game->name ?></small></h1>

<div class="row">
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-gradient-blue">
			<div class="stats-icon"><i class="fa fa-trophy"></i></div>
			<div class="stats-info">
				<h4>BOLSA DE PREMIOS</h4>
				<p>350.000 $</p>	
			</div>
			<div class="stats-link">
				<!--<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>-->
			</div>
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-gradient-aqua">
			<div class="stats-icon"><i class="ion-ios-people"></i></div>
			<div class="stats-info">
				<h4>JUGADORES</h4>
				<p>32</p>	
			</div>
			<div class="stats-link">
				<!--<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>-->
			</div>
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-gradient-purple">
			<div class="stats-icon"><i class="ion-ios-game-controller-b"></i></div>
			<div class="stats-info">
				<h4>CONSOLAS</h4>
				<p>Ps4</p>	
			</div>
			<div class="stats-link">
				<!--<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>-->
			</div>
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-gradient-orange">
			<div class="stats-icon"><i class="ion-ios-clock"></i></div>
			<div class="stats-info">
				<h4>FECHA DE INICIO</h4>
				<p>23 Sept</p>	
			</div>
			<div class="stats-link">
				<!--<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>-->
			</div>
		</div>
	</div>
	<!-- end col-3 -->
</div>


<!-- Tabla de Torneos -->
<div class="row">
    <!-- begin col-6 -->
    <div class="col-md-6 ui-sortable">

    	<div class="panel panel-default panel-with-tabs" data-sortable-id="ui-widget-9">
            <div class="panel-heading">
                <ul id="myTab" class="nav nav-tabs pull-right">
                    <li class="active"><a href="#home" data-toggle="tab" aria-expanded="true"><i class="fa fa-sitemap"></i> <span class="hidden-xs">Estructura</span></a></li>
                    <li class=""><a href="#profile" data-toggle="tab" aria-expanded="false"><i class="fa fa-trophy"></i> <span class="hidden-xs">Premios</span></a></li>
                </ul>
                <h4 class="panel-title">Detalle</h4>
            </div>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="home">
                    <p><?php echo $session->tournament->description ?></p>
                </div>
                <div class="tab-pane fade" id="profile">
                    <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
                </div>
                <div class="tab-pane fade" id="dropdown1">
                    <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p>
                </div>
                <div class="tab-pane fade" id="dropdown2">
                    <p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan, sartorial keffiyeh echo park vegan.</p>
                </div>
            </div>
        </div>

        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-7">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                	<!--
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                	-->
                </div>
                <h4 class="panel-title">Desarrollo</h4>
            </div>
            <div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Id</th>
								<th>Nombre</th>
								<th>Consola</th>
								<th>Orden</th>
								<th>Estado</th>
								<th>Opciones</th>
							</tr>
						</thead>
						<tbody>
						<?php $criteria = $model->search()->getCriteria() ?>
        				<?php $data = TournamentPhase::model()->findAll($criteria); ?>
        				<?php foreach ($data as $key => $value): ?>
							<?php if(in_array($value->id, $myPhases_array)): ?>
							<tr class="success">
							<?php else: ?>
							<tr>
							<?php endif; ?>
								<td><?php echo $value->id ?></td>
								<td><?php echo $value->name ?></td>
								<td><?php echo $value->console->name ?></td>
								<td><?php echo $value->number ?></td>
								<td><?php echo $value->getStateLabel() ?></td>
								<td><a href="<?php echo Yii::app()->createUrl("torneos/gestion/grupos",array("id"=>$value->id)) ?>" class="btn btn-success btn-xs" role="button"><i class="fa fa-mail-forward"></i> Ingresar</a></td>
							</tr>
						 <?php endforeach ?>	
						</tbody>
					</table>
				</div>
			</div>
		</div>
        <!-- end panel -->

        <?php if($session->tournament->winner_id != null and $session->tournament->winner_id != 0 ): ?>
		<!-- begin panel -->
		<div class="panel panel-success" data-sortable-id="table-basic-7">
		    <div class="panel-heading">
		        <h4 class="panel-title">Campeón</h4>
		    </div>
		    <div class="panel-body">
		    	<div align="center"><h3>¡Felicitaciones!</h3></div>
		    	<br>
		    	<div align="center">
		    	<ul class="media-list">
		    		<li class="media media-sm">
		    			<div class="media media-sm">
		    				<a class="media" href="javascript:;">
		    					<?php if($session->tournament->winner->path): ?>
					            <img src="<?php echo Yii::app()->theme->baseUrl.$session->tournament->winner->path; ?>" alt="" class="media-object rounded-corner">
					        	<?php else: ?>
					        	<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/user-15.jpg" alt="" class="media-object rounded-corner">
					        	<?php endif; ?>
							</a>
							<div class="media-body">
								<h4 class="media-heading"><?php echo $session->tournament->winner->name.' '.$session->tournament->winner->surname ?></h4>
								<p><?php echo $session->tournament->winner->username  ?></p>
							</div>	
		    			</div>
		    		</li>
		    	</ul>
		    	</div>		
		    </div>
		</div>
		<?php endif; ?>        
    </div>
    <!-- end col-6 -->

    <!-- begin col-6 Red Social -->
    <div class="col-md-6 ui-sortable">
    	<style type="text/css">
    		.registered-users-list>li {
    			width: 20%;
			}
    	</style>
    	<div class="panel panel-inverse" data-sortable-id="index-4">
            <div class="panel-heading">
                <h4 class="panel-title">Jugadores <span class="pull-right label label-primary">24</span></h4>
            </div>
            <ul class="registered-users-list clearfix">
                <li>
                    <a href="javascript:;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/user-5.jpg" alt=""></a>
                    <h4 class="username text-ellipsis">
                        Savory Posh
                        <small>Algerian</small>
                    </h4>
                </li>
                <li>
                    <a href="javascript:;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/user-3.jpg" alt=""></a>
                    <h4 class="username text-ellipsis">
                        Ancient Caviar
                        <small>Korean</small>
                    </h4>
                </li>
                <li>
                    <a href="javascript:;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/user-1.jpg" alt=""></a>
                    <h4 class="username text-ellipsis">
                        Marble Lungs
                        <small>Indian</small>
                    </h4>
                </li>
                <li>
                    <a href="javascript:;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/user-8.jpg" alt=""></a>
                    <h4 class="username text-ellipsis">
                        Blank Bloke
                        <small>Japanese</small>
                    </h4>
                </li>
                <li>
                    <a href="javascript:;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/user-2.jpg" alt=""></a>
                    <h4 class="username text-ellipsis">
                        Hip Sculling
                        <small>Cuban</small>
                    </h4>
                </li>
            </ul>
            <div class="panel-footer text-center">
                <a href="javascript:;" class="text-inverse">Vert todos</a>
            </div>
        </div>

    	<div class="panel panel-inverse" data-sortable-id="index-5">
			<div class="panel-heading">
				<div class="panel-heading-btn">
					<!--
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					-->
				</div>
				<h4 class="panel-title">Mensajes</h4>
			</div>
			<div class="panel-body">
				<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 300px;"><div class="height-sm" data-scrollbar="true" data-init="true" style="overflow: hidden; width: auto; height: 300px;">
					<ul class="media-list media-list-with-divider media-messaging">
						<li class="media media-sm">
							<a href="javascript:;" class="pull-left">
								<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/user-5.jpg" alt="" class="media-object rounded-corner">
							</a>
							<div class="media-body">
								<h5 class="media-heading">John Doe</h5>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi id nunc non eros fermentum vestibulum ut id felis. Nunc molestie libero eget urna aliquet, vitae laoreet felis ultricies. Fusce sit amet massa malesuada, tincidunt augue vitae, gravida felis.</p>
							</div>
						</li>
						<li class="media media-sm">
							<a href="javascript:;" class="pull-left">
								<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/user-6.jpg" alt="" class="media-object rounded-corner">
							</a>
							<div class="media-body">
								<h5 class="media-heading">Terry Ng</h5>
								<p>Sed in ante vel ipsum tristique euismod posuere eget nulla. Quisque ante sem, scelerisque iaculis interdum quis, eleifend id mi. Fusce congue leo nec mauris malesuada, id scelerisque sapien ultricies.</p>
							</div>
						</li>
						<li class="media media-sm">
							<a href="javascript:;" class="pull-left">
								<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/user-8.jpg" alt="" class="media-object rounded-corner">
							</a>
							<div class="media-body">
								<h5 class="media-heading">Fiona Log</h5>
								<p>Pellentesque dictum in tortor ac blandit. Nulla rutrum eu leo vulputate ornare. Nulla a semper mi, ac lacinia sapien. Sed volutpat ornare eros, vel semper sem sagittis in. Quisque risus ipsum, iaculis quis cursus eu, tristique sed nulla.</p>
							</div>
						</li>
						<li class="media media-sm">
							<a href="javascript:;" class="pull-left">
								<img src="assets/img/user-7.jpg" alt="" class="media-object rounded-corner">
							</a>
							<div class="media-body">
								<h5 class="media-heading">John Doe</h5>
								<p>Morbi molestie lorem quis accumsan elementum. Morbi condimentum nisl iaculis, laoreet risus sed, porta neque. Proin mi leo, dapibus at ligula a, aliquam consectetur metus.</p>
							</div>
						</li>
					</ul>
				</div><div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; height: 236.842px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
			</div>
			<div class="panel-footer">
				<form>
					<div class="input-group">
						<input type="text" class="form-control bg-silver" placeholder="Enter message">
						<span class="input-group-btn">
							<button class="btn btn-primary" type="button"><i class="fa fa-pencil"></i></button>
						</span>
					</div>
				</form>
            </div>
		</div>

    </div>	
    <!-- end col-6 Red Social -->
    
    
</div>
<!-- Fin Tabla de Torneos -->