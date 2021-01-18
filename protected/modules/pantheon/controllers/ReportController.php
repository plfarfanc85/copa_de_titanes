<?php
class ReportController extends Controller
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
            	'actions'=>array('dashboard','preinscripcion'),
                'expression' => array($this,'allowOnlyBoss'),
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
    	if(Yii::app()->user->getState("perfil") == "super" or Yii::app()->user->getState("perfil") == "coordinator")
        {
            return true;
        }    
    	else 
        {
            return false;
        }    
    }

	/*
	Configuracion de usuarios rrhh
	*/
	public function actionConfig()
	{
		$this->render("config");
	}

    /*
    Dashboard - datos estadisticos
    */
    public function actionDashboard()
    {
        $this->layout = "main";
        // display the login form
        
        $tournamentTotal = Tournament::model()->getTotal();
        $playerTotal = Player::model()->getTotal();
        $playerTotalLinea = Player::model()->getTotalEnLinea();
        $visitanteTotal = HistoricoVisitante::model()->getTotal(0);
        $homeTotal = HistoricoVisitante::model()->getTotal(1);
        $fifaTotal = HistoricoVisitante::model()->getTotal(2);
        $pesTotal = HistoricoVisitante::model()->getTotal(3);

        $this->render('dashboard',array(
            'tournamentTotal'=>$tournamentTotal,
            'playerTotal'=>$playerTotal,
            'visitanteTotal'=>$visitanteTotal,
            'homeTotal'=>$homeTotal,
            'fifaTotal'=>$fifaTotal,
            'pesTotal'=>$pesTotal,
            'playerTotalLinea'=>$playerTotalLinea,
        ));
    }

    /*
    Preinscripcions - lista de usuarios preinscritos
    */
    /*
    public function actionPreinscripcion()
    {
        $this->layout = "main";
        $fifa = EmailsCampaing::model()->findAll("game_id = 1 and state = 1");
        $pes = EmailsCampaing::model()->findAll("game_id = 2 and state = 1");
        $halo = EmailsCampaing::model()->findAll("game_id = 3 and state = 1");
        $callofduty = EmailsCampaing::model()->findAll("game_id = 4 and state = 1");
        $mariokart = EmailsCampaing::model()->findAll("game_id = 5 and state = 1");
        $goldeneye = EmailsCampaing::model()->findAll("game_id = 6 and state = 1");

        if (isset($_GET['Excel']) && $_GET['Excel']==1){
            $model = new EmailsCampaing;
            Yii::app()->request->sendFile("preinscripcionlista.xls",
                $this->renderPartial('preinscripcion_lista',array(
                    'fifa'=>$fifa,
                    'pes'=>$pes,
                    'halo'=>$halo,
                    'callofduty'=>$callofduty,
                    'mariokart'=>$mariokart,
                    'goldeneye'=>$goldeneye,
                    'model'=>$model,
                    'xls'=>1),true)
            );
            Yii::app()->end();
        }

        $this->render('preinscripcion_lista',array(
            'fifa'=>$fifa,
            'pes'=>$pes,
            'halo'=>$halo,
            'callofduty'=>$callofduty,
            'mariokart'=>$mariokart,
            'goldeneye'=>$goldeneye,
            ));
    }
    */

  
}