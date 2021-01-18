<?php
class ReporteController extends Controller
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
                'actions'=>array('desempeno','listaTodos','listaGanados','listaPerdidos','listaEmpatados'),
                'users'=>array('@'),
            ),  

            array('deny',  // deny all users
                'users'=>array('*'),
            ),          

 			array('deny',  // deny all users
                'users'=>array('?'),
            ),

        );
    }

  
    /*
    Dashboard - datos estadisticos
    */
    public function actionDesempeno()
    {
        $this->layout = "main";

        $total = TournamentGroup::model()->getTotalByPlayer(0);
        $ganados = TournamentGroup::model()->getTotalByPlayer(1);
        $perdidos = TournamentGroup::model()->getTotalByPlayer(2);
        $empatados = TournamentGroup::model()->getTotalByPlayer(3);
        $golesf = TournamentGroup::model()->getTotalByPlayer(4);//Goles a favor
        $golesc = TournamentGroup::model()->getTotalByPlayer(5);//Goles a favor

        //Grafico goles, maximo eje Y (goles)
        if($golesc >= $golesf)
            $graficoGolesMax = $golesc;
        else
            $graficoGolesMax = $golesf;

        $graficoGolesMax = $graficoGolesMax*2;

        $porcentajesG = ($total!=0)?(($ganados*100)/$total):0;
        $porcentajesE = ($total!=0)?(($empatados*100)/$total):0;
        $porcentajesP = ($total!=0)?(($perdidos*100)/$total):0;
        #echo $porcentajesG;die;
        $porcentajes = array($porcentajesG,$porcentajesP,$porcentajesE);

        // display the login form
        $this->render('desempeno',array(
            'total'=>$total,
            'ganados'=>$ganados,
            'perdidos'=>$perdidos,
            'empatados'=>$empatados,
            'porcentajes'=>$porcentajes,
            'golesf'=>$golesf,
            'golesc'=>$golesc,
            'graficoGolesMax'=>$graficoGolesMax,
            ));
    }

    /*
    Lista de todos los partidos jugados
    */    
    public function actionListaTodos()
    {
        $this->layout = "main";

        $jugador = Yii::app()->user->id;
        $matchs_ids = array();

        //Consultar partidos
        
        $model = TournamentMatchDetail::model()->findAll('player_id = ?',array($jugador));
        foreach ($model as $key => $value) {
            $matchs_ids[] = $value->tournament_match_id;
        }

        $criteria = new CDbCriteria;
        $criteria->addInCondition('id',$matchs_ids);
        $matchs = TournamentMatch::model()->findAll($criteria);

        $this->render('partidos_todos',array(
            'matchs'=>$matchs,
            ));
    }

    /*
    Lista de todos los partidos ganados
    */    
    public function actionListaGanados()
    {
        $this->layout = "main";

        $jugador = Yii::app()->user->id;
        $matchs_ids = array();
        $matchs_win_ids = array();
        $matchs_results = array();

        //Consultar partidos
        
        $model = TournamentMatchDetail::model()->findAll('player_id = ?',array($jugador));
        foreach ($model as $key => $value) {
            $matchs_ids[] = $value->tournament_match_id;
        }

        //Filtrar los partidos ganados
        foreach ($matchs_ids as $key => $value) {
            $match = TournamentMatchDetail::model()->findAll('tournament_match_id = ?',array($value));
            foreach ($match as $key2 => $value2) {
                if($value2->player_id == $jugador)
                    $matchs_results[0] = $value2->point;
                else
                    $matchs_results[1] = $value2->point;
            }

            if($matchs_results[0] > $matchs_results[1]) //Partidos ganados
                $matchs_win_ids[] = $value;

        }

        #echo '<pre>'.print_r($matchs_win_ids,true).'</pre>';die;

        $criteria = new CDbCriteria;
        $criteria->addInCondition('id',$matchs_win_ids);
        $matchs = TournamentMatch::model()->findAll($criteria);

        $this->render('partidos_ganados',array(
            'matchs'=>$matchs,
            ));
    }

    /*
    Lista de todos los partidos perdidos
    */    
    public function actionListaPerdidos()
    {
        $this->layout = "main";

        $jugador = Yii::app()->user->id;
        $matchs_ids = array();
        $matchs_win_ids = array();
        $matchs_results = array();

        //Consultar partidos
        
        $model = TournamentMatchDetail::model()->findAll('player_id = ?',array($jugador));
        foreach ($model as $key => $value) {
            $matchs_ids[] = $value->tournament_match_id;
        }

        //Filtrar los partidos ganados
        foreach ($matchs_ids as $key => $value) {
            $match = TournamentMatchDetail::model()->findAll('tournament_match_id = ?',array($value));
            foreach ($match as $key2 => $value2) {
                if($value2->player_id == $jugador)
                    $matchs_results[0] = $value2->point;
                else
                    $matchs_results[1] = $value2->point;
            }

            if($matchs_results[0] < $matchs_results[1]) //Partidos ganados
                $matchs_win_ids[] = $value;

        }

        #echo '<pre>'.print_r($matchs_win_ids,true).'</pre>';die;

        $criteria = new CDbCriteria;
        $criteria->addInCondition('id',$matchs_win_ids);
        $matchs = TournamentMatch::model()->findAll($criteria);

        $this->render('partidos_perdidos',array(
            'matchs'=>$matchs,
            ));
    }

    /*
    Lista de todos los partidos empatados
    */    
    public function actionListaEmpatados()
    {
        $this->layout = "main";

        $jugador = Yii::app()->user->id;
        $matchs_ids = array();
        $matchs_win_ids = array();
        $matchs_results = array();

        //Consultar partidos
        
        $model = TournamentMatchDetail::model()->findAll('player_id = ?',array($jugador));
        foreach ($model as $key => $value) {
            $matchs_ids[] = $value->tournament_match_id;
        }

        //Filtrar los partidos ganados
        foreach ($matchs_ids as $key => $value) {
            $match = TournamentMatchDetail::model()->findAll('tournament_match_id = ?',array($value));
            foreach ($match as $key2 => $value2) {
                if($value2->player_id == $jugador)
                    $matchs_results[0] = $value2->point;
                else
                    $matchs_results[1] = $value2->point;
            }

            if($matchs_results[0] == $matchs_results[1]) //Partidos ganados
                $matchs_win_ids[] = $value;

        }

        #echo '<pre>'.print_r($matchs_win_ids,true).'</pre>';die;

        $criteria = new CDbCriteria;
        $criteria->addInCondition('id',$matchs_win_ids);
        $matchs = TournamentMatch::model()->findAll($criteria);

        $this->render('partidos_empatados',array(
            'matchs'=>$matchs,
            ));
    }

}