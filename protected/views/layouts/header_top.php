<!-- begin #header -->
<div id="header" class="header navbar navbar-default navbar-fixed-top">
    <!-- begin container -->
    <div class="container">
        <!-- begin navbar-header -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="index.html" class="navbar-brand">
                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/logo-2.jpg" style="display: inline-block;">
                <span class="brand-text">
                    <span class="text-theme"><strong>Copa de Titanes</strong></span>
                </span>
            </a>
        </div>
        <!-- end navbar-header -->
        <!-- begin navbar-collapse -->
        <div class="collapse navbar-collapse" id="header-navbar">
            <ul class="nav navbar-nav navbar-right">
            	<li><a href="#home" data-click="scroll-to-target">INICIO</a></li>
                <li><a href="#about" data-click="scroll-to-target">NOSOTROS</a></li>
                <li><a href="#service" data-click="scroll-to-target">ELIGENOS</a></li>
                <li><a href="#work" data-click="scroll-to-target">PLATAFORMA</a></li>
                <li><a href="#pricing" data-click="scroll-to-target">TORNEOS</a></li>
                <li><a href="#contact" data-click="scroll-to-target">CONTACTANOS</a></li>
                <li>
                    <?php echo CHtml::link('<i class="fa fa-lg fa-user"></i> Login',array('/torneos/usuario/login')); ?>
                </li>
            </ul>
        </div>
        <!-- end navbar-collapse -->
    </div>
    <!-- end container -->
</div>
<!-- end #header -->