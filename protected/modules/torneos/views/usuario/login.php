<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<div class="login-cover">
	    <div class="login-cover-image"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/login-bg/bg-fifa5.jpg" data-id="login-cover-image" alt="" /></div>
	    <div class="login-cover-bg"></div>
	</div>

	<!-- begin #page-container -->
	<div id="page-container" class="fade">
	    <!-- begin login -->
        <div class="login login-v2" data-pageload-addclass="animated fadeIn">
            <!-- begin brand -->
            <div class="login-header">
                <div class="brand">
                    <div><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/logo-3.png" style="display: inline-block;"> Copa de Titanes
                    <small>Hacemos que disfrutes más tu pasión.</small></div>
                </div>
                <div class="icon">
                    <i class="ion-ios-locked"></i>
                </div>
            </div>
            <!-- end brand -->
            <div class="login-content">
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'login-form',
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                    ),
                    'htmlOptions'=>array('class'=>'margin-bottom-0'),
                )); ?>
                <!--<form action="index.html" method="POST" class="margin-bottom-0">-->
                    <div class="form-group m-b-20">
                        <?php echo $form->textField($model,'username',array('class'=>'form-control input-lg','placeholder'=>'Usuario o Documento')); ?>
                        <?php echo $form->error($model,'username'); ?>
                        <!--<input type="text" class="form-control input-lg" placeholder="Username" required />-->
                    </div>
                    <div class="form-group m-b-20">
                        <?php echo $form->passwordField($model,'password',array('class'=>'form-control input-lg','placeholder'=>'Password')); ?>
                        <?php echo $form->error($model,'password'); ?>
                        <!--<input type="password" class="form-control input-lg" placeholder="Password" required />-->
                    </div>
                    <?php /*
                    <div class="checkbox m-b-20">
                        <label>
                            <?php echo $form->checkBox($model,'rememberMe'); ?>
                            <?php echo $form->label($model,'rememberMe'); ?>
                            <?php echo $form->error($model,'rememberMe'); ?>
                            <!--<input type="checkbox" /> Remember Me-->
                        </label>
                    </div>
                    */ ?>
                    <div class="login-buttons">
                        <button type="submit" class="btn btn-primary btn-block btn-lg">Entrar</button>
                    </div>
                    <div class="m-t-20">
                        No eres usuario todavía? Has click <?php echo CHtml::link('aquí',array('/torneos/usuario/registro')); ?> para registrate.
                    </div>
                <?php $this->endWidget(); ?>  
                <br>
                <?php if(isset($_GET['register'])): ?>
                    <?php if($_GET['register'] == 1): ?>
                    <div class="alert alert-success fade in m-b-15">
                        <strong>Muy bien!</strong>
                        Usuario registrado correctamente.
                        <span class="close" data-dismiss="alert">×</span>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>  
            </div>
        </div>
        <!-- end login -->
        
        <ul class="login-bg-list clearfix">
            <li><a href="#" data-click="change-bg"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/login-bg/bg-fifa.jpg" alt="" /></a></li>
            <!--<li><a href="#" data-click="change-bg"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/login-bg/bg-1.jpg" alt="" /></a></li>
            <li><a href="#" data-click="change-bg"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/login-bg/bg-2.jpg" alt="" /></a></li>
            <li><a href="#" data-click="change-bg"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/login-bg/bg-3.jpg" alt="" /></a></li>
            <li><a href="#" data-click="change-bg"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/login-bg/bg-4.jpg" alt="" /></a></li>
            <li><a href="#" data-click="change-bg"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/login-bg/bg-5.jpg" alt="" /></a></li>
            <li><a href="#" data-click="change-bg"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/login-bg/bg-6.jpg" alt="" /></a></li>-->
        </ul>
        
	</div>
	<!-- end page container -->
	