
<div id="sidebar" class="sidebar">
	<!-- begin sidebar scrollbar -->
	<div data-scrollbar="true" data-height="100%">
		<!-- begin sidebar user -->
		<ul class="nav">
			<li class="nav-profile">
				<div class="image">
					<a href="javascript:;"><img src="<?php echo Yii::app()->baseUrl.Yii::app()->user->getState('imagen') ?>" alt="" /></a>
				</div>
				<div class="info">
					<?php echo Yii::app()->user->getState('nombre'); ?>
					<small><?php echo Yii::app()->user->getState('username'); ?></small>
					<br>
					<div align="center"><small>Creditos</small> <strong><?php echo Credit::model()->getTotal(); ?> $</strong></div>
				</div>
			</li>
		</ul>
		<!-- end sidebar user -->
		<!-- begin sidebar nav -->
		<ul class="nav">
			<li class="nav-header">Menú</li>
			<li>
				<?php echo CHtml::link('<i class="ion-ios-pulse-strong"></i><span>Desempeño</span>',array('/torneos/reporte/desempeno')); ?>
			</li>
			<li>
				<?php echo CHtml::link('<i class="fa fa-trophy bg-gradient-purple"></i><span>Torneos</span>',array('/torneos/gestion/')); ?>
			</li>
			<li>
				<?php echo CHtml::link('<i class="fa fa-exchange bg-gradient-blue"></i><span>Creditos</span>',array('/torneos/creditos/')); ?>
			</li>
			<li>
				<?php echo CHtml::link('<i class="ion-ios-calendar-outline bg-pink"></i><span>Calendario</span>',array('/torneos/gestion/calendario')); ?>
			</li>
			<li>
				<?php echo CHtml::link('<i class="ion-ios-mic bg-gradient-orange"></i><span>Noticias</span>',array('/torneos/gestion/noticias')); ?>
			</li>
			
	        <!-- begin sidebar minify button -->
			<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="ion-ios-arrow-left"></i> <span>Collapse</span></a></li>
	        <!-- end sidebar minify button -->
		</ul>
		<!-- end sidebar nav -->
	</div>
	<!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>

