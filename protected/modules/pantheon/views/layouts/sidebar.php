
<div id="sidebar" class="sidebar">
	<!-- begin sidebar scrollbar -->
	<div data-scrollbar="true" data-height="100%">
		<!-- begin sidebar user -->
		<ul class="nav">
			<li class="nav-profile">
				<div class="image">
					<a href="javascript:;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/user-13.jpg" alt="" /></a>
				</div>
				<div class="info">
					<?php echo Yii::app()->user->getState('nombre'); ?>
					<small><?php echo Yii::app()->user->getState('perfil'); ?></small>
				</div>
			</li>
		</ul>
		<!-- end sidebar user -->
		<!-- begin sidebar nav -->
		<ul class="nav">
			<li class="nav-header">Menú</li>
			<li>
				<!--
				<a href="dashboard">
					<i class="ion-ios-pulse-strong"></i>
				    <span>Dashboard</span> 
				</a>
				-->
				<?php echo CHtml::link('<i class="ion-ios-pulse-strong"></i><span>Dashboard</span>',array('/pantheon/report/dashboard')); ?>
			</li>
			<li>
				<?php echo (Yii::app()->user->getState('perfil') == 'super')?CHtml::link('<i class="fa fa-exchange bg-gradient-blue"></i><span>Creditos</span>',array('/pantheon/credits/')):''; ?>
			</li>
			<li>
				<?php echo CHtml::link('<i class="ion-ios-briefcase-outline bg-gradient-purple"></i><span>Torneos</span>',array('/pantheon/tournament')); ?>
			</li>
			<li>
				<?php echo CHtml::link('<i class="fa fa-2x fa-group bg-gradient-aqua"></i><span>Jugadores</span>',array('/pantheon/player/list')); ?>
			</li>
			<li>
				<?php echo (Yii::app()->user->getState('perfil') == 'super')?CHtml::link('<i class="fa fa-2x fa-institution bg-gradient-pink"></i><span>Coordinadores</span>',array('/pantheon/rrhh/config')):''; ?>
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

