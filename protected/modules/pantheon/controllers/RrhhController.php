<?php
class RrhhController extends Controller
{
	#public $open = 'gestion';

	/**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules()
    {
        return array(

            array('allow',  // deny all users
            	'actions'=>array('config','create','update'),
                'expression' => array($this,'allowOnlyBoss'),
                #'roles'=>array('super'),
            ),

            array('allow',  
                'actions'=>array('logout'),
                'users'=>array('@'),
            ),  

            array('allow',
                'actions'=>array('login'),  
                'users'=>array('*'),
            ), 

            array('deny',  // deny all users
                'users'=>array('*'),
            ),          

 			array('deny',  // deny all users
                'users'=>array('?'),
            ),

        );
    }

    public function allowOnlyBoss()
    {
    	if(Yii::app()->user->getState("perfil") == "super")
    		return true;
    	else 
    		return false;
    }

	/*
	Configuracion de usuarios rrhh
	*/
	public function actionConfig()
	{
        $this->layout = 'table_scroller';
        $model = new UserRrhh;

        $this->render('config',array(
            'model'=>$model
        ));
	}

    /*
    Configuracion de usuarios rrhh
    */
    public function actionLogin()
    {
        $cache=new CFileCache();
        $cache->flush();
        #exit;

        $this->layout = "login";

        $model=new LoginFormGods;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['LoginFormGods']))
        {
            $model->attributes=$_POST['LoginFormGods'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login())
                $this->redirect('../report/dashboard'); // ultima url que el usuairo realizo
        }
        // display the login form
        $this->render('login',array('model'=>$model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(array('login'));
    }

    public function actionCreate()
    {
        $this->layout = "main";
        $model = new UserRrhh;

        if(isset($_POST['UserRrhh']))
        {
            $model->attributes = $_POST['UserRrhh'];
            $model->password = sha1($_POST['UserRrhh']['dni']);
            $model->state = 1;
            $model->profile = 'coordinator';

            if($model->save())
            {
                Yii::app()->user->setFlash('success','Se creó el usuario.');
                $this->redirect(array('config'));
            }
            else
                Yii::app()->user->setFlash('danger','No se pudo crear el usuario.');
                #Yii::app()->user->setFlash('danger','No se pudo crear el usuario. '.'<pre>'.print_r($model->getErrors(),true).'</pre>');
        }

        $this->render('create',array('rrhh'=>$model));
    }

    public function actionUpdate()
    {   
        $this->layout = "main";

        if(isset($_REQUEST['id']))
            $id = $_REQUEST['id'];

        if(isset($id))
        {
            $model = UserRrhh::model()->findByPk($id);

            if(!$model)
            {
                Yii::app()->user->setFlash('danger','No se encontró el usuario.');
                $this->redirect(array('list'));    
            }
            
            if(isset($_POST['UserRrhh']))
            {
                $tmpPassword = $model->password;
                $model->attributes = $_POST['UserRrhh'];

                if($_POST['UserRrhh']['password'] != '')
                    $model->password = sha1($_POST['UserRrhh']['password']);
                else
                    $model->password = $tmpPassword;

                if($model->save())
                {
                    Yii::app()->user->setFlash('success','Se actualizarón los datos el coordinador.');
                    $this->redirect(array('config'));
                }
                else
                    Yii::app()->user->setFlash('danger','No se pudo actualizar el coordinador.');
            }
        }
        else 
            $this->redirect(array('config'));

        $model->password='';

        $this->render('update',array(
            'rrhh'=>$model
        ));
    }

}