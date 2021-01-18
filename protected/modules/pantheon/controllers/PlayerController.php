<?php
class PlayerController extends Controller
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
            	'actions'=>array('list','create','update'),
                'expression' => array($this,'allowOnlyBoss'),
                #'roles'=>array('super'),
            ),

            array('allow',  // deny all users
                'actions'=>array('changuestate'),
                'expression' => array($this,'allowOnlySuper'),
                #'roles'=>array('super'),
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
    	if((Yii::app()->user->getState("perfil") == "super" or Yii::app()->user->getState("perfil") == "coordinator") and Yii::app()->user->getState("olimpico") == 1)
        {
            return true;
        }    
    	else 
        {
            return false;
        }    
    }

    public function allowOnlySuper()
    {
        if((Yii::app()->user->getState("perfil") == "super") and Yii::app()->user->getState("olimpico") == 1)
            return true;
        else 
            return false;
    }

    /*
    Lista de jugadores
    */
    public function actionList()
    {
        $this->layout = 'table_scroller';
        $model = new Player;

        $this->render('list',array(
            'model'=>$model
        ));
    }

    public function actionCreate()
    {
        $this->layout = "main";
        $model = new Player;

        if(isset($_POST['Player']))
        {
            $model->attributes = $_POST['Player'];
            $model->password = sha1($_POST['Player']['dni']);
            $model->state = 1;
            $model->profile = 'basic';

            if($model->save())
            {
                Yii::app()->user->setFlash('success','Se creó el usuario.');
                $this->redirect(array('list'));
            }
            else
                Yii::app()->user->setFlash('danger','No se pudo crear el usuario.');
                #Yii::app()->user->setFlash('danger','No se pudo crear el usuario. '.'<pre>'.print_r($model->getErrors(),true).'</pre>');
        }

        $this->render('create',array('player'=>$model));
    }

    public function actionUpdate()
    {   
        $this->layout = "main";

        if(isset($_REQUEST['id']))
            $id = $_REQUEST['id'];

        if(isset($id))
        {
            $model = Player::model()->findByPk($id);

            if(!$model)
            {
                Yii::app()->user->setFlash('danger','No se encontró el usuario.');
                $this->redirect(array('list'));    
            }
            
            if(isset($_POST['Player']))
            {
                $model->attributes = $_POST['Player'];

                if($model->save())
                {
                    Yii::app()->user->setFlash('success','Se actualizarón los datos el usuario.');
                    $this->redirect(array('list'));
                }
                else
                    Yii::app()->user->setFlash('danger','No se pudo actualizar el usuario.');
            }
        }
        else 
            $this->redirect(array('list'));

        $this->render('update',array(
            'player'=>$model
        ));
    }
}