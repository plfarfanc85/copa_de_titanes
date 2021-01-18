<?php

class CreditosController extends Controller
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
                'actions'=>array('index','registroCompra'),
                'users'=>array('@'),
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

	/*
	Historial de los creditos de un usuario y compra de creditos
	*/		
	public function actionIndex()
	{
		$this->layout = "main";

		$creditos = new Credit;
		$creditos->player_id = Yii::app()->user->id;

		$CompraCreditosForm = new CompraCreditosForm;

		$this->render("index",array(
			'creditos'=>$creditos,
			'CompraCreditosForm'=>$CompraCreditosForm,
		));
	}

	/*
	Registrar comprobante de pago de creditos
	*/
	public function actionRegistroCompra()
    {
        global $HTTP_RAW_POST_DATA;
        
        $file = 0;
        $result = array();

        #echo  $_FILES['file']['tmp_name'];die;
        #echo var_dump($HTTP_RAW_POST_DATA); die;
        #echo var_dump(file_get_contents('php://input'));

        if(isset($_POST['CompraCreditosForm']['path']))
        {
            if ($_POST['CompraCreditosForm']['path']=!'') 
            { // Solo Para insertar
                $modelo = new CompraCreditosForm;
                #echo var_dump($_FILES['file']);die;
                #echo var_dump($_POST['logo']['path']);die;
                $ruta = '/images/creditos/'; // Almacena los archivos en la carpeta creditos.
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
                $modelo = New Credit;
                $modelo->path = $ruta.$img_name;
                $modelo->player_id = Yii::app()->user->id;
                $modelo->comments = 'Compra de creditos';
                $modelo->date_import = date('Y-m-d h:i:s');
                $modelo->state = 2;
                if($modelo->save()){
                    $result['status'] = 'OK';
                    $result['message'] = 'Se registró el pago.';
                }else
                    {
                        $result['status'] = 'ERR';
                        $result['message'] = 'No se pudo registrar el pago.';    
                    }
            }

            #$result = json_encode("success");
            #echo $result;

            if($result['status'] == 'ERR')
                Yii::app()->user->setFlash('danger','Datos de formulario incorrectos.'.$result['message']);
            else if($result['status'] == 'OK')
                Yii::app()->user->setFlash('success','Se registró su pago correctamente.');


        }
        else
            Yii::app()->user->setFlash('danger','Datos de formulario incorrectos.');

        $this->redirect(array('index'));
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