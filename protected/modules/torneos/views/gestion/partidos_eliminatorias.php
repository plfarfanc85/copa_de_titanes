<?php $this->pageTitle=Yii::app()->name; ?> 
		
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Inicio</a></li>
	<li class="active">Torneo <?php echo $model->phase->session->tournament->name ?></li>
	<li class="active"><?php echo $model->phase->session->name ?></li>
	<li class="active"><?php echo CHtml::link($model->phase->name,array('/torneos/gestion/fase/id/'.$model->phase->session->id)); ?></li>
	<!--<li class="active"><?php echo $model->name ?></li>-->
	<li class="active">Partidos</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Eliminatorias <?php echo $model->name; ?> <small>Resumen</small></h1>

<!-- Partidos del grupo -->
<div class="row">
	<?php foreach ($matchs as $key => $value): ?>
	<div class="col-md-6 ui-sortable">
		<div class="panel panel-warning" data-sortable-id="ui-widget-16">
            <div class="panel-heading">
                <h4 class="panel-title"><?php echo $value->name ?> - <?php echo substr($value->date,-8,5) ?> - <?php echo $value->getStateLabel() ?>  <?php echo ($model->phase->session->tournament->tournament_class_id == 1)?$value->getConsoleNameLabel():'' ?></h4>
            </div>
            <div class="panel-body bg-orange text-white">
            	<ul class="media-list media-list-with-divider">
                    <li class="media media-sm">
                        <?php foreach ($value->tournamentMatchDetail as $key2 => $value2): ?>   
                            <?php if($key2==0): ?>  
                                <a class="media-left" href="javascript:;">
                                    <?php if($value2->player->path): ?>
                                    <img src="<?php echo $value2->player->path; ?>" alt="" class="media-object rounded-corner">
                                    <?php else: ?>
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/user-15.jpg" alt="" class="media-object rounded-corner">
                                    <?php endif; ?>
                                    <small style="color:gray!important"> <?php echo $value2->player->username ?></small> 
                                </a>
                                <div class="media-body"><br>
                                    <h6 class="text-center text-white">
                                        <em><?php echo $value2->player->getNamesWU() ?></em> 
                                        <span class="badge badge-info"><?php echo $value2->point ?></span>&nbsp;<strong>vs</strong>&nbsp;
                             <?php else: ?>    
                                        <span class="badge badge-info"><?php echo $value2->point ?></span> 
                                        <em><?php echo $value2->player->getNamesWU() ?></em>
                                           
                                    </h6>
                                </div>
                                <a class="media-right" href="javascript:;">
                                    <?php if($value2->player->path): ?>
                                    <img src="<?php echo $value2->player->path; ?>" alt="" class="media-object rounded-corner">
                                    <?php else: ?>
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/user-15.jpg" alt="" class="media-object rounded-corner">
                                    <?php endif; ?>
                                    <small style="color:gray!important"> <?php echo $value2->player->username ?></small> 
                                </a>
                            <?php endif; ?> 
                        <?php endforeach; ?> 
                    </li>
                </ul>
            </div>
        </div>
	</div>
	<?php endforeach; ?> 
</div>
<!-- Fin Partidos del grupo -->


