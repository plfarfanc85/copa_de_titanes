<style type="text/css">
    .content.has-bg .content-bg:before {
        position: static;
    }
    @media only screen and (max-width: 600px) {
        #logoCT {
            margin-top: 35%!important;
        }
    }
</style>
<!-- begin #home -->
<div id="home" class="content has-bg home">
    <!-- begin content-bg -->
    <div class="content-bg">
        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/banner_principal_2.jpg" alt="Home"/>
    </div>
    <!-- end content-bg -->
    <!-- begin container -->
    <div class="container home-content logog" style="top:21%">
        <img id="logoCT" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/logo_grande.png" width="55%" alt="Home" />
        <br>
        <?php echo CHtml::link('Regístrate',array('/torneos/usuario/registro'),array('class'=>'btn btn-outline')); ?>
    </div>
    <!-- end container -->
</div>
<!-- end #home -->




<!-- begin #pricing -->
<div id="pricing" class="content" data-scrollview="true">
    <!-- begin container -->
    <div class="container">
        <h2 class="content-title">TORNEOS</h2>
        <p class="content-desc">
            Participa en nuestros torneos Online y Presenciales. <br>
            <strong>Crea tu usuario y podrás hacer seguimiento en vivo de los torneos, ver datos estadísticos de tu desempeño y mucho más.</strong>
        </p>
        <!-- begin pricing-table -->
        
        <ul class="pricing-table col-4">
                    <li data-animation="true" data-animation-type="fadeInUp" class="fadeInUp contentAnimated finishAnimated">
                        
                    </li>
                    <li data-animation="true" data-animation-type="fadeInUp" class="fadeInUp contentAnimated finishAnimated">
                        <div class="pricing-container">
                            <h3>Hiperión X1 de Fifa 18 <br>Online Xbox One</h3>
                            <div class="price">
                                <div class="price-figure">
                                    <span class="price-number">$20.000</span>
                                    <span class="price-tenure">Inscripción</span>
                                </div>
                            </div>
                            <ul class="features">
                                <li>
                                    <p>Segundo torneo online de Fifa 18. Fase de grupo y finales de PlayOff.</p>
                                </li>
                                <li>Desde el sabado 28 de Julio</li>
                                <li>Todo el país</li>
                                <li>32 Cupos</li>
                                <li>$ 470.000 en premios</li>
                                <li>$ 330.000 al Campeón</li>
                                <li>$ 140.000 al Segundo</li>
                            </ul>
                            <div class="footer">
                            <?php echo CHtml::link('Inscríbite',array('/torneos/usuario/login'),array('class'=>'btn btn-primary btn-block')); ?>
                            </div>
                        </div>
                    </li>
                    <li class="highlight" data-animation="true" data-animation-type="fadeInUp">
                        <div class="pricing-container">
                            <h3>Hiperión P1 de Fifa 18 <br>Online Ps4</h3>
                            <div class="price">
                                <div class="price-figure">
                                    <span class="price-number">$20.000</span>
                                    <span class="price-tenure">Inscripción</span>
                                </div>
                            </div>
                            <ul class="features">
                                <li>
                                    <p>Segundo torneo online de Fifa 18. Fase de grupo y finales de PlayOff.</p>
                                </li>
                                <li>Desde el sabado 28 de Julio</li>
                                <li>Todo el país</li>
                                <li>32 Cupos</li>
                                <li>$ 470.000 en premios</li>
                                <li>$ 330.000 al Campeón</li>
                                <li>$ 140.000 al Segundo</li>
                            </ul>
                            <div class="footer">
                            <?php echo CHtml::link('Inscríbite',array('/torneos/usuario/login'),array('class'=>'btn btn-primary btn-block')); ?>
                            </div>
                        </div>
                    </li>
                    <li data-animation="true" data-animation-type="fadeInUp" class="fadeInUp contentAnimated finishAnimated">
                        
                    </li>
                </ul>

    </div>
    <!-- end container -->
</div>
<!-- end #pricing -->




<!-- begin #milestone -->
<div id="milestone" class="content bg-black-darker has-bg" data-scrollview="true">
    <!-- begin content-bg -->
    <div class="content-bg">
        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/banner-03-2.jpg" alt="Milestone" />
    </div>
    <!-- end content-bg -->
    <!-- begin container -->
    <div class="container">
        <!-- begin row -->
        <div class="row">
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-3 milestone-col">
                <div class="milestone">
                    <div class="number" data-animation="true" data-animation-type="number" data-final-number="<?php echo Tournament::model()->getTotal(); ?>"><?php echo Tournament::model()->getTotal(); ?></div>
                    <div class="title" style="color:white">Torneos</div>
                </div>
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-3 milestone-col">
                <div class="milestone">
                    <div class="number" data-animation="true" data-animation-type="number" data-final-number="<?php echo number_format(Player::model()->getTotal(),0,',','.'); ?>"><?php echo Player::model()->getTotal(); ?></div>
                    <div class="title" style="color:white">Usuarios</div>
                </div>
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-3 milestone-col">
                <div class="milestone">
                    <div class="number" data-animation="true" data-animation-type="number" data-final-number="15">15</div>
                    <div class="title" style="color:white">Ciudades</div>
                </div>
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-3 milestone-col">
                <div class="milestone">
                    <div class="number" data-animation="true" data-animation-type="number" data-final-number="4">4</div>
                    <div class="title" style="color:white">Millones en Premios</div>
                </div>
            </div>
            <!-- end col-3 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end #milestone -->

<!-- beign #service -->
<div id="service" class="content" data-scrollview="true">
    <!-- begin container -->
    <div class="container">
        <h2 class="content-title">¿Por qué elegirnos?</h2>
        <p class="content-desc">
            Nos preocupamos en darte la mejor experiencia en torneos de FIFA 18. Para poder hacer esto nos hemos basado en los siguientes pilares.
        </p>
        <!-- begin row -->
        <div class="row">
            <!-- begin col-4 -->
            <div class="col-md-4 col-sm-4">
                <div class="service">
                    <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i class="fa fa-laptop"></i></div>
                    <div class="info">
                        <h4 class="title">Tecnología</h4>
                        <p class="desc">Desarrollamos una plataforma de torneos donde podrás ver el histórico de los torneos en que has participado, datos estadísticos, seguir torneos en vivo y mucho más.</p>
                    </div>
                </div>
            </div>
            <!-- end col-4 -->
            <!-- begin col-4 -->
            <div class="col-md-4 col-sm-4">
                <div class="service">
                    <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i class="fa fa-shield"></i></div>
                    <div class="info">
                        <h4 class="title">Seguridad</h4>
                        <p class="desc">Tomamos las medidas preventivas y reactivas para proteger la información.</p>
                    </div>
                </div>
            </div>
            <!-- end col-4 -->
            <!-- begin col-4 -->
            <div class="col-md-4 col-sm-4">
                <div class="service">
                    <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i class="fa fa-file"></i></div>
                    <div class="info">
                        <h4 class="title">Transparencia</h4>
                        <p class="desc">Brindamos transparencia en el manejo de la información antes, durante y después de los torneos.</p>
                    </div>
                </div>
            </div>
            <!-- end col-4 -->
        </div>
        <!-- end row -->
        <!-- begin row -->
        <div class="row">
            <!-- begin col-4 -->
            <div class="col-md-4 col-sm-4">
                <div class="service">
                    <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i class="fa fa-sitemap"></i></div>
                    <div class="info">
                        <h4 class="title">Orden</h4>
                        <p class="desc">La plataforma de los coordinadores permitirá mejorar el proceso de desarrollo de los torneos, disminuir tiempos y así permitir que participen más  jugadores.</p>
                    </div>
                </div>
            </div>
            <!-- end col-4 -->
            <!-- begin col-4 -->
            <div class="col-md-4 col-sm-4">
                <div class="service">
                    <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i class="fa fa-trophy"></i></div>
                    <div class="info">
                        <h4 class="title">Premios</h4>
                        <p class="desc">Más premios, más emoción. Al aumentar en número de participantes, podemos incrementar la cantidad de premios para los ganadores de los torneos y los mejores jugadores del año.</p>
                    </div>
                </div>
            </div>
            <!-- end col-4 -->
            <!-- begin col-4 -->
            <div class="col-md-4 col-sm-4">
                <div class="service">
                    <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i class="fa fa-group"></i></div>
                    <div class="info">
                        <h4 class="title">Desempeño</h4>
                        <p class="desc">No queremos que los ganadores siempre sean los mismo, para esto te vamos a ayudar a mejorar tu desempeño mediante el modulo PROGRESAR.</p>
                    </div>
                </div>
            </div>
            <!-- end col-4 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end #about -->

<!-- beign #action-box -->
<div id="action-box" class="content has-bg" data-scrollview="true">
    <!-- begin content-bg -->
    <div class="content-bg">
        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/banner-03-2.jpg" alt="Action" />
    </div>
    <!-- end content-bg -->
    <!-- begin container -->
    <div class="container" data-animation="true" data-animation-type="fadeInRight">
        <!-- begin row -->
        <div class="row action-box">
            <!-- begin col-9 -->
            <div class="col-md-9 col-sm-9">
                <div class="icon-large text-theme">
                    <i class="fa fa-binoculars" style="color:white"></i>
                </div> 
                <h3>¡DALE UN VISTAZO A NUESTRA PLATAFORMA DE TORNEOS!</h3>
                <p style="color:white">
                   Queremos ir adaptando la plataforma a sus gustos, y por eso esperamos de su constante Feedback para seguir mejorando.
                </p>
            </div>
            <!-- end col-9 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-3">
                <!--<a href="#" class="btn btn-white btn-block">Registrate</a>-->
                <?php echo CHtml::link('Registrate',array('/torneos/usuario/registro'),array('class'=>'btn btn-white btn-block')); ?>
            </div>
            <!-- end col-3 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end #action-box -->

<!-- begin #work -->
<div id="work" class="content" data-scrollview="true">
    <!-- begin container -->
    <div class="container" data-animation="true" data-animation-type="fadeInDown">
        <h2 class="content-title">Nuestro Trabajo</h2>
        <p class="content-desc">
            Hemos desarrollado una plataforma donde podrás ver tu desempeño en todo tu historial de participación, visualizarás en vivo el desarrollo de cada torneo, sabrás en donde estas ubicado y en que fases participaste, y mucho más. Debes registrarte para poder ingresar.
        </p>
        <?php $this->renderPartial('nuestro_trabajo_modal'); ?>
    </div>
    <!-- end container -->
</div>
<!-- end #work -->

<!-- begin #client -->
<div id="client" class="content has-bg bg-green" data-scrollview="true">
    <!-- begin content-bg -->
    <div class="content-bg">
        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/banner-04-3.jpg" alt="Client" />
    </div>
    <!-- end content-bg -->
    <!-- begin container -->
    <div class="container" data-animation="true" data-animation-type="fadeInUp">
        <h2 class="content-title">Nuestros Titanes</h2>
        <!-- begin carousel -->
        <div class="carousel testimonials slide" data-ride="carousel" id="testimonials">
            <!-- begin carousel-inner -->
            <div class="carousel-inner text-center">
                <!-- begin item -->
                <div class="item active">
                    <blockquote>
                        <i class="fa fa-quote-left"></i>
                        Conviértete en un Titán de Copas, demuestra tu talento, tu concentración y estrategia. La Gloria se toca con la confirmación de estas tres características. ¡Mejora cada día, entrena, desafía tu mente y llegaras a ser un Titán!
                        <i class="fa fa-quote-right"></i>
                    </blockquote>
                    <div class="name"> — <span class="text-theme">Copa de Titanes</span></div>
                </div>
                <!-- end item -->
                <!-- begin item -->
                <div class="item">
                    <blockquote>
                        <i class="fa fa-quote-left"></i>
                        Premiamos a los mejores Titanes, a los mejores del Ranking del año. También premiamos a la fidelidad, participa en muchos torneos y tendrás más posibilidad de ganar.
                        <i class="fa fa-quote-right"></i>
                    </blockquote>
                    <div class="name"> — <span class="text-theme">Copa de Titanes</span></div>
                </div>
                <!-- end item -->
                <!-- begin item -->
                <div class="item">
                    <blockquote>
                        <i class="fa fa-quote-left"></i>
                        Un Titán enfrente sus temores, maneja sus emociones y lleva su desempeño a su más alto nivel cuando más lo necesita. <br>Domina tu mente, no todo es talento.
                        <i class="fa fa-quote-right"></i>
                    </blockquote>
                    <div class="name"> — <span class="text-theme">Copa de Titanes</span></div>
                </div>
                <!-- end item -->
            </div>
            <!-- end carousel-inner -->
            <!-- begin carousel-indicators -->
            <ol class="carousel-indicators">
                <li data-target="#testimonials" data-slide-to="0" class="active"></li>
                <li data-target="#testimonials" data-slide-to="1" class=""></li>
                <li data-target="#testimonials" data-slide-to="2" class=""></li>
            </ol>
            <!-- end carousel-indicators -->
        </div>
        <!-- end carousel -->
    </div>
    <!-- end containter -->
</div>
<!-- end #client -->

<!-- begin #about -->
<div id="about" class="content" data-scrollview="true">
    <!-- begin container -->
    <div class="container" data-animation="true" data-animation-type="fadeInDown">
        <h2 class="content-title">Nosotros</h2>
        <p class="content-desc">
            Somos profesionales apasionados al fútbol, y queremos crear los torneos presenciales y online de Fifa 18 más grandes del País.
        </p>
        <!-- begin row -->
        <div class="row">
            <!-- begin col-4 -->
            <div class="col-md-4 col-sm-6">
                <!-- begin about -->
                <div class="about">
                    <h3>Nuestro Objetivo</h3>
                    <p>
                        A los apasionados de los videos juegos, desde pequeños nos gustaba jugar a toda hora en las consolas que en ese momento existían. Siempre jugamos con amigos y familiares, pero ahora todos deseamos competir más, convertirnos en los mejores y ganar un gran torneo. Por esto quisimos crear los torneos de FIFA 18 más grandes de Colombia, empezaremos desde 192 personas en un solo torneo en Bogotá y queremos llegar más de 1000 personas en un torneo a nivel Nacional. Para poder hacer esto creamos un plataforma de Torneos, donde podrán ver en todo momento su desempeño, historial de torneos donde han jugado y seguir torneos en vivo.

                    </p>
                </div>
                <!-- end about -->
            </div>
            <!-- end col-4 -->
            <!-- begin col-4 -->
            <div class="col-md-4 col-sm-6">
                <h3>Nuestra Filosofía</h3>
                <!-- begin about-author -->
                <div class="about-author">
                    <div class="quote bg-silver">
                        <i class="fa fa-quote-left"></i>
                        <h3>Entregar la mejor experiencia mediante dedicación, pasión <br /><span>y servicio.</span></h3>
                        <i class="fa fa-quote-right"></i>
                    </div>
                    <div class="author">
                        <div class="image">
                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/adminPF.jpg" alt="Sean Ngu" />
                        </div>
                        <div class="info">
                            Copa de Titanes
                            <small>Desarrollador y creador</small>
                        </div>
                    </div>
                </div>
                <!-- end about-author -->
            </div>
            <!-- end col-4 -->
            <!-- begin col-4 -->
            <div class="col-md-4 col-sm-12">
                <h3>Nuestras Caracteristicas</h3>
                <!-- begin skills -->
                <div class="skills">
                    <div class="skills-name">Tecnología</div>
                    <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 100%">
                            <span class="progress-number">100%</span>
                        </div>
                    </div>
                    <div class="skills-name">Seguridad</div>
                    <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 100%">
                            <span class="progress-number">100%</span>
                        </div>
                    </div>
                    <div class="skills-name">Transparencia</div>
                    <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 100%">
                            <span class="progress-number">100%</span>
                        </div>
                    </div>
                </div>
                <!-- end skills -->
            </div>
            <!-- end col-4 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end #about -->



<!-- begin #contact -->
<div id="contact" class="content bg-silver-lighter" data-scrollview="true">

    <!-- begin #content -->
    <div id="content" class="content">
    
    <!-- begin container -->
    <div class="container">
        <h2 class="content-title">Contactanos</h2>
        <p class="content-desc">
            Si tienes alguna duda sobre el torneo o funcionamiento de la plataforma, no dudes en escribirnos. Responderemos a tu solicitud lo más pronto posible. También podrás utilizar este medio si tienes una idea de mejora que quisieras ver en nuestra plataforma.
        </p>
        <!-- begin row -->
        <div class="row">
            <!-- begin col-6 -->
            <div class="col-md-6" data-animation="true" data-animation-type="fadeInLeft">
                <h3>Escribenos tu mensaje.</h3>
                <p>
                    Ingresa tu nombre, email, y mensaje. Por favor escríbenos tu duda puntualmente. Puedes también contactarnos al número a continuación.
                </p>
                <p>
                    <strong>Info</strong><br />
                    <br />
                    Celular: (350) 642-8340<br />
                </p>
                <p>
                    <!--<span class="phone">+11 (0) 123 456 78</span><br />-->
                    <a href="mailto:hello@emailaddress.com">info@copadetitanes.com</a>
                </p>
            </div>
            <!-- end col-6 -->
            <!-- begin col-6 -->
            <div class="col-md-6 form-col" data-animation="true" data-animation-type="fadeInRight">
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'contact-form',
                    'enableClientValidation'=>false,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>false,
                    ),
                    'htmlOptions'=>array('class'=>'form-horizontal'),
                )); ?>
                <!--<form class="form-horizontal" action="<?php #echo Yii::app()->createUrl('site/contacto') ?>" method="post">-->
                    <div class="form-group">
                        <label class="control-label col-md-3">Nombre <span class="text-theme">*</span></label>
                        <div class="col-md-9">
                            <!--<input type="text" name="ContactForm[name]" class="form-control" />-->
                            <?php echo $form->textField($contactForm,'name',array('class'=>'form-control')); ?>
                            <?php echo $form->error($contactForm,'name'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Email <span class="text-theme">*</span></label>
                        <div class="col-md-9">
                            <!--<input type="text" name="ContactForm[email]" class="form-control" />-->
                            <?php echo $form->textField($contactForm,'email',array('class'=>'form-control')); ?>
                            <?php echo $form->error($contactForm,'email'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Mensaje <span class="text-theme">*</span></label>
                        <div class="col-md-9">
                            <!--<textarea name="ContactForm[body]" class="form-control" rows="10"></textarea>-->
                            <?php echo $form->textArea($contactForm,'body',array('class'=>'form-control','rows'=>"10")); ?>
                            <?php echo $form->error($contactForm,'body'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Captcha <span class="text-theme">*</span></label>
                        <div class="col-md-9">
                            <?php /* 
                            <?php $this->widget("CCaptcha"); ?>
                            <?php echo $form->textField($contactForm,'verifyCode'); ?>
                            <div class="hint">
                                Por favor, introduzca el texto que ve en la imagen.
                            </div>
                            <?php echo $form->error($contactForm,'verifyCode'); ?>
                            */ ?>
                            <div class="g-recaptcha" data-sitekey="6LeroEUUAAAAAPFi2ln6_pYTrUbP-buZWLlwMSMF"></div>
                            <!--<div class="g-recaptcha" data-sitekey="6LfYoEUUAAAAAAM7imdTy3IGcmBvc2Qs08glcvfk"></div>--><!--Local-->
                        </div>    
                    </div>    

                    <div class="form-group">
                        <label class="control-label col-md-3"></label>
                        <div class="col-md-9 text-left">
                            <button type="submit" class="btn btn-theme btn-block">Envíar Mensaje</button>
                        </div>
                    </div>
                <!--</form>-->
                <?php $this->endWidget(); ?>  
            </div>
            <!-- end col-6 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end #contact -->
