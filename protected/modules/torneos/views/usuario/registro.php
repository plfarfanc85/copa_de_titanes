
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade">
        
	    <!-- begin register -->
        <div class="register register-with-news-feed">
            <!-- begin news-feed -->
            <div class="news-feed">
                <div class="news-image">
                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/login-bg/bg-fifa5.jpg" alt="" />
                </div>
                <div class="news-caption">
                    <div><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/logo-3.png" style="display: inline-block;"><h4 class="caption-title">Copa de Titanes</h4></div>
                    <p>
                        Te damos la bienvenida a la plataforma de Copa de Titanes, aquí pordrás dar seguimiento a los torneos en vivo, ver datos estadísticos de tu historial de torneos y mucho más.
                    </p>
                </div>
            </div>
            <!-- end news-feed -->
            <!-- begin right-content -->
            <div class="right-content">
                <!-- begin mensaje de registro -->
                <?php if(!empty($mensaje)): ?>
                    <div class="alert alert-<?php echo $mensaje[0]; ?> fade in m-b-15">
                        <?php echo $mensaje[1]; ?>
                        <span class="close" data-dismiss="alert">×</span>
                    </div>
                <?php endif; ?>    
                <!-- fin mensaje de registro -->
                <!-- begin register-header -->
                <h1 class="register-header">
                    Registro
                    <small>Crea tu usuario en la plataforma de Copa de Titanes.</small>
                </h1>
                <!-- end register-header -->
                <!-- begin register-content -->
                <div class="register-content">
                    <form action="registro" method="POST" class="margin-bottom-0">
                        <label class="control-label">Nombre <span class="text-danger">*</span></label>
                        <div class="row row-space-10">
                            <div class="col-md-6 m-b-15">
                                <input type="text" name="Player[name]" class="form-control" placeholder="Nombre" required />
                            </div>
                            <div class="col-md-6 m-b-15">
                                <input type="text" name="Player[surname]" class="form-control" placeholder="Apellido" required />
                            </div>
                        </div>
                        <label class="control-label">Usuario <span class="text-danger">*</span></label>
                        <div class="row m-b-15">
                            <div class="col-md-12">
                                <input type="text" name="Player[username]" class="form-control" placeholder="Nombre de usuario" required />
                            </div>
                        </div>
                        <label class="control-label">Documento <span class="text-danger">*</span></label>
                        <div class="row m-b-15">
                            <div class="col-md-12">
                                <input type="text" name="Player[dni]" class="form-control" placeholder="Número de documento" data-parsley-type="digits" required />
                            </div>
                        </div>
                        <label class="control-label">Celular <span class="text-danger">*</span></label>
                        <div class="row m-b-15">
                            <div class="col-md-12">
                                <input type="text" name="Player[mobile]" class="form-control" placeholder="Número de celular" data-parsley-type="digits" required />
                            </div>
                        </div>
                        <label class="control-label">Ciudad <span class="text-danger">*</span><small>donde vives</small></label>
                        <div class="row m-b-15">
                            <div class="col-md-12">
                                <select class="form-control" name="Player[city_id]">
                                <?php foreach (City::model()->getList() as $key => $value): ?>
                                  <option value="<?php echo $key ?>"><?php echo $value ?></option>  
                                <?php endforeach; ?>    
                                </select>
                            </div>
                        </div>
                        <label class="control-label">Email <span class="text-danger">*</span></label>
                        <div class="row m-b-15">
                            <div class="col-md-12">
                                <input type="email" name="Player[email]" class="form-control" placeholder="Email" required />
                            </div>
                        </div>
                        
                        <label class="control-label">Re-ingresa el Email <span class="text-danger">*</span></label>
                        <div class="row m-b-15">
                            <div class="col-md-12">
                                <input type="text" name="Player[reemail]" class="form-control" placeholder="Re-enter email address" required />
                            </div>
                        </div>
                        <label class="control-label">Contraseña <span class="text-danger">*</span></label>
                        <div class="row m-b-15">
                            <div class="col-md-12">
                                <input type="password" name="Player[password]" class="form-control" placeholder="Contraseña" required />
                            </div>
                        </div>
                        <div class="checkbox m-b-30">
                            <label>
                                <input type="checkbox" name="Player[conditions]" required /> Haciendo clic en Registrar, estas de acuerdo con <a href="#">Teminos y condiciones</a> y consta de que has leido nuestras <a href="#">Politicas de datos</a>, incluyendo nuestro <a href="#">uso de Cookies</a>.
                            </label>
                        </div>
                        <div class="register-buttons">
                            <button type="submit" class="btn btn-primary btn-block btn-lg">Registrar</button>
                        </div>
                        <!--
                        <div class="m-t-20 m-b-40 p-b-40 text-inverse">
                            Ya eres miembro? Clic <a href="login_v3.html">aquí</a> para ir al login.
                        </div>
                        -->
                        <hr />
                        <p class="text-center">
                            &copy; Copa de Titanes All Right Reserved 2018
                        </p>
                    </form>
                </div>
                <!-- end register-content -->
            </div>
            <!-- end right-content -->
        </div>
        <!-- end register -->
        
	</div>
	<!-- end page container -->
	