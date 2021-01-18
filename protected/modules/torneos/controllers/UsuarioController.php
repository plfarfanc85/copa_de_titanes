<?php

class UsuarioController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),

		);
	}

	
	public function accessRules()
    {
        return array(

            
            array('allow',  // deny all users
                'actions'=>array('salir','perfil','fotoPerfil'),
                'users'=>array('@'),
            ),  

            array('deny',  // deny all users
            	'actions'=>array('login'),  // deny all users
                'users'=>array('*'),
            ),

            array('allow',
                'users'=>array('*'),
            ),    

            array('deny',  // deny all users
                'users'=>array('?'),
            ),
       

        );
    }

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Register new User
	 */
	public function actionRegistro()
	{
		#$cache=new CFileCache();
        #$cache->flush();
        $this->layout = "register2";
		
		$player = new Player();
		$player->scenario = 'register';    
		$mensaje = array();
		#$mensaje = array('success','<strong>Gracias por registrarte!</strong> Ya puedes ir al login y ingresar a la plataforma de torneos.');

		if(isset($_POST['Player']))
		{
			$player->attributes = $_POST['Player'];
			$player->password = sha1($_POST['Player']['password']);
			$player->reemail = $_POST['Player']['reemail'];
			$player->conditions = $_POST['Player']['conditions'];
			$player->profile = 'basic';
			$player->state = 1;

			#echo $player->conditions;die;
			if($player->save())
			{
				/*
				date_default_timezone_set("America/Bogota");
				$preinscripcion = new EmailsCampaing;
				$preinscripcion->email = $player->email;
				$preinscripcion->game_id = 1;
				$preinscripcion->date = date('Y-m-d h:m:s');
				$preinscripcion->ip = Yii::app()->request->getUserHostAddress();
				$preinscripcion->save();
				*/

				#$mensaje = array('success','<strong>Gracias por registrarte!</strong> Pronto podrás ingresar a nuestra plataforma de torneos. Te enviaremos un correo nitficandote.');
				$this->redirect(array('login','register'=>1));
			}	
			else
			{
				$m = "";
				foreach ($player->getErrors() as $key => $value) {
					foreach ($value as $key => $value2) {
						#echo var_dump($value2);
						$m .= "<br>".$value2;
					}
				}
				#die;
				$mensaje = array('danger','<strong>Error</strong> No se pudo registrar el usuario, intentalo de nuevo.'.$m);			
			}
				
				#echo print_r($player->getErrors());die;
		}	
		
		$this->render("registro",array('player'=>$player,'mensaje'=>$mensaje));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->layout = "login";
		$register = 0;
		
		$model=new LoginForm;

		if(isset($_GET['register']))
			$register = $_GET['register'];

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login())
            {
            	$this->historicoSession('login');
            	$this->redirect(array('reporte/desempeno')); // ultima url que el usuairo realizo
            }	
                
        }
        // display the login form
        $this->render('login',array(
        	'model'=>$model,
        	'register'=>$register,
        	));
	}

	/*
	Guarda un historico de la sesión y actualiza el estado del jugador en linea
	*/
	private function historicoSession($action)
	{
		date_default_timezone_set("America/Bogota");
		$model = new HistoricalSession;
		$model->user_id = Yii::app()->user->id;
		$model->action = $action;
		$model->date = date("Y-m-d");
		$model->hour = date("G:i:s");
		$model->ip = $_SERVER['REMOTE_ADDR'];
		$model->save();

		//Se coloca en linea o no al usuario
		Player::model()->updateEnLinea($action);
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionSalir()
	{
		$this->historicoSession('logout');
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	/*
	Gestion de perfil del usuario
	*/
	public function actionPerfil()
	{
		$this->layout = "profile";

		$perfilForm = new PerfilForm;
		$player = Player::model()->findByPk(Yii::app()->user->id);

		if(isset($_POST['Player']))
		{
			$player->attributes = $_POST['Player'];
			if($player->save())
				Yii::app()->user->setFlash("success","Se actualizò los datos de tu perfil.");
			else
				Yii::app()->user->setFlash("danger","No se pudo actualizar los datos de tu perfil.");
		}

		$this->render("perfil",array(
			'player'=>$player,
			'perfilForm'=>$perfilForm,
			));
	}

	public function actionFotoPerfil()
    {
        global $HTTP_RAW_POST_DATA;
        
        $file = 0;
        $result = array();

        #echo  $_FILES['file']['tmp_name'];die;
        #echo var_dump($HTTP_RAW_POST_DATA); die;
        #echo var_dump(file_get_contents('php://input'));

        if(isset($_POST['PerfilForm']['path']))
        {
            if ($_POST['PerfilForm']['path']=!'') 
            { // Solo Para insertar
                $modelo = new PerfilForm;
                #echo var_dump($_FILES['file']);die;
                #echo var_dump($_POST['logo']['path']);die;
                $ruta = '/images/perfil/'; // Almacena los archivos en la carpeta inscripciones.
                $path = Yii::getPathOfAlias("webroot").$ruta;   
                $img = CUploadedFile::getInstance($modelo,'path');
                #echo $img;die;
                if($img)
                {
                    $img_name = time().$img->name;
                    $img_name = strtolower(str_replace(' ', '-', $img_name));
                        // exit($img_name);
                    if($img->saveAs($path.$img_name))
                    {
                        // Identifica si es un PDF, ZIP o RAR
                        $ext = $this->getExtFileImg($path.$img_name);
                        if($ext)
                            $file = 1;
                        else
                        {
                            $result['status'] = 'ERR';
                            $result['message'] = 'El archivo no es JPG o PNG';
                        }   
                    }else
                        {
                            $result['status'] = 'ERR';
                            $result['message'] = 'No se pudo subir el archivo.';    
                        }
                }else
                {
                    $result['status'] = 'ERR';
                    $result['message'] = 'No reconoce el archivo.';    
                }
            }

            // Almacena el registro en la base de datos
            if($file==1) {
                $modelo = Player::model()->findByPk(Yii::app()->user->id);
                $modelo->path = $ruta.$img_name;
                if($modelo->save()){
                    $result['status'] = 'OK';
                    $result['message'] = 'Se registró la imágen.';
                }else
                    {
                        $result['status'] = 'ERR';
                        $result['message'] = 'No se pudo registrar la imágen.'.print_r($modelo->getErrors(),true);    
                    }
            }

            #$result = json_encode("success");
            #echo $result;

            if($result['status'] == 'ERR')
                Yii::app()->user->setFlash('danger','Datos de formulario incorrectos.'.$result['message']);
            else if($result['status'] == 'OK')
            {
            	Yii::app()->user->setState('imagen',$modelo->path);
            	Yii::app()->user->setFlash('success','Se actualizó la imágen correctamente.');
            }	

        }
        else
            Yii::app()->user->setFlash('danger','Datos de formulario incorrectos.');

        $this->redirect(array('perfil'));
    }

    /*
    Busca si la extensión del archivo es de tipo imagen
    */
    private function getExtFileImg($filepath)
    {
        $formatos = array(
            'image/jpeg',
            'image/png',
        );
        $mime = mime_content_type($filepath);
        return in_array($mime, $formatos)? true:false;
    }

	
}