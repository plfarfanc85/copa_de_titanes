<?php
class CreditsController extends Controller
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
                'actions'=>array('index','approve','cancel'),
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

    public function actionIndex()
    {
        $this->layout = "main";

        $model = new Credit;
        $creditForm = new CreditsForm;
        
        $this->render('index',array(
            'model'=>$model,
            'creditForm'=>$creditForm,
        ));   
    }

    /*
    Aprueba solicitu de compra de creditos
    */
    public function actionApprove()
    {
        if(isset($_POST['CreditsForm']) and isset($_POST['credit_id']))
        {
            $creditForm = new CreditsForm;
            $creditForm->cantidad = $_POST['CreditsForm']['cantidad'];
            $creditForm->credit_id = $_POST['credit_id'];

            if($creditForm->validate())
            {
                $credit = Credit::model()->findByPk($creditForm->credit_id);

                if($credit)
                {
                    $credit->amount = $creditForm->cantidad;
                    $credit->state = 1;

                    if($credit->save())
                    {
                        Yii::app()->historical->set($credit,"Aprobar Creditos","Se aprobó la solicitud de compra de creditos id ".$credit->id.' - por '.$credit->amount);
                        Yii::app()->user->setFlash('success','Se asignaron los creditos correctamente.');    
                    }
                }
                else
                    Yii::app()->user->setFlash('danger','No existe el registro de creditos.');
            }
        }
        else
            Yii::app()->user->setFlash('danger','No se enviarón los datos correctamente.');

        $this->redirect(array('index'));
    }

    /*

    */
    public function actionCancel()
    {
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            $model = Credit::model()->findByPk($id);

            if($model)
            {
                $model->state = 0; //Anulado

                if($model->save())
                    Yii::app()->user->setFlash('success','Se anuló la solicitud.');        
                else
                    Yii::app()->user->setFlash('danger','No existe la solicitud.');        
            }
            else
                Yii::app()->user->setFlash('danger','No existe la solicitud.');
        }
        else
            Yii::app()->user->setFlash('danger','No se envió el id de la solicitud.');

        $this->redirect(array('index'));
    }
}


