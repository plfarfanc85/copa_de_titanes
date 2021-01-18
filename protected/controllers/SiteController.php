<?php

class SiteController extends Controller
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

	public function init()
	{
	      Yii::app()->theme = 'frontend';

	 	  parent::init();
	}

	public function accessRules()
    {
        return array(

            array('deny',  // deny all users
            	'actions'=>array('contacto'),  // deny all users
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
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		#$cache=new CFileCache();
        #$cache->flush();
        $this->layout="main";
		$this->pageTitle = "Los mejores TORNEOS DE FIFA en Colombia | Copa de Titanes";
		#$meta = "Demuestra tu talento en diferentes torneos de videojuegos , FIFA 17, PES 17, HALO. Gana espectaculares premios y conviértete en el dios de los Gamers.";
		Yii::app()->clientScript->registerMetaTag('Demuestra tu talento en nuestros torneos de FIFA 18. Gana espectaculares premios y conviértete en el Titan de los Gamers.', 'description');

		$contactForm = new ContactForm;
		if(isset($_POST['ContactForm']) and (isset($_POST['g-recaptcha-response']) and !empty($_POST['g-recaptcha-response'])))
		{
			$contactForm->verifyCode = $_POST['g-recaptcha-response'];
			// Call the function post_captcha
    		$res = $this->postCaptcha($contactForm->verifyCode);

			#echo $_POST['ContactForm']['name'];die;
			$contactForm->name = $_POST['ContactForm']['name'];
			$contactForm->email = $_POST['ContactForm']['email'];
			$contactForm->body = $_POST['ContactForm']['body'];
			$contactForm->subject = 'Contacto Home';
			#if($contactForm->validate() and $arr['success'])
			if($contactForm->validate())
			{
				if ($res['success']) 
				{
					$asunto = 'Contacto - Home';
					$body = 'De: '.$contactForm->name.' - Email: '.$contactForm->email.' \r\n '.$contactForm->body;
					$email = Yii::app()->gemail;
		            $email->add('pedrofarfan85@hotmail.com','Pedro Farfan');
		            $email->addBCC('plfarfanc@gmail.com','Admin');
		            #$errores = $email->send($body,$asunto);
		            #echo $errores;die;
				}
			}
		}

		$this->historicoVisitante(1);

		$this->render('home',array(
			'contactForm'=>$contactForm,
			));
	}

	private function postCaptcha($user_response) 
	{
		$secret = '';//localhost
        $fields_string = '';
        $fields = array(
            'secret' => $secret,
            'response' => $user_response
        );
        foreach($fields as $key=>$value)
        $fields_string .= $key . '=' . $value . '&';
        $fields_string = rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }


	public function actionTorneoFifa()
	{
		$this->layout="main";
		$this->pageTitle = "Gran TORNEO de FIFA 18. Espectaculares Premios - Copa de Titanes";
		#$meta = "Demuestra que eres un Dios del FIFA 17 en nuestro torneo y gana el respeto de los demás gamers además de una jugosa bolsa de premios. INSCRIBETE!";
		Yii::app()->clientScript->registerMetaTag('Demuestra que eres un Dios del FIFA 18 en nuestro torneo y gana el respeto de los demás gamers además de una jugosa bolsa de premios. INSCRIBETE!', 'description');
		
		$this->historicoVisitante(2);

		$this->render('torneo-fifa17');
	}

	public function actionTorneoPes()
	{
		$this->layout="main";
		$this->pageTitle = "Espectatular Torneo de PES 18. Inscríbete! - Cups Of Gods ";
		#$meta = "Demuestra que eres un Dios de PES 17 en nuestro torneo y gana una jugosa bolsa de premios. INSCRIBETE!";
		Yii::app()->clientScript->registerMetaTag('Demuestra que eres un Dios de PES 18 en nuestro torneo y gana una jugosa bolsa de premios. INSCRIBETE!', 'description');
		$mensaje = $this->preinscripcion();

		$this->historicoVisitante(3);

		$this->render('torneo-pes17',array(
			'mensaje'=>$mensaje
			));
	}

	public function actionNosotros()
	{
		$this->layout="main";
		$this->pageTitle = "Conoce COG y participa en nuestros Torneos de Videjuegos.";
		Yii::app()->clientScript->registerMetaTag('COG quiere brindarte un espacio donde podrás demostrar tu talento para los video juegos, en excelentes Torneos de FIFA 18, PES 18, Call Of Duty y muchos más.', 'description');
		$this->render('nosotros');
	}

	public function historicoVisitante($page)
	{
		date_default_timezone_set("America/Bogota");
		$model = new HistoricoVisitante;
		$model->date = date("Y-m-d");
		$model->hour = date("G:i:s");
		$model->page = $page;
		$model->state = 1;
		$model->save();
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

}