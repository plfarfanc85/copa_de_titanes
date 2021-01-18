<?php
class TournamentController extends Controller
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
            	'actions'=>array('index','session','phase','groups','match','matchStatus','nextPhase','create','summary','buildTournament','nextSession','checkin','consoles','assignConsoleG','assignConsoleM','finalizeTournament','payment','approvedPayment','denyPayment','winners'),
                'expression' => array($this,'allowOnlyBoss'),
                #'roles'=>array('super'),
            ),

            array('allow',  // deny all users
                'actions'=>array('UndoScore'),
                'expression' => array($this,'allowOnlySuper'),
                #'roles'=>array('super'),
            ),

            array('allow',
                'actions'=>array('cronMatchScheduleCoincide'),
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
	Configuracion de usuarios rrhh
	*/
	public function actionConfig()
	{
		$this->render("config");
	}

    /*
    Torneos - Solo se muestran las padres
    */
    public function actionIndex()
    {
        $this->layout = "main";

        $model = new Tournament;
        $userTournament_array = array();
        Yii::app()->user->setState("user_search",null);
        
        if(isset($_POST['search']))
        {
            $search = $_POST['search'];
            $user = Player::model()->find('dni = ?',array($search));
            if($user)
            {
                $userSessions = TournamentGroupPosition::model()->findAll("player_id = ?",array($user->id)); 
                if($userSessions)
                {
                    foreach ($userSessions as $key => $value) {
                        array_push($userTournament_array, $value->tournamentGroup->phase->session->tournament->id); 
                    }
                    Yii::app()->user->setState("user_search",$search);
                    #echo '<pre>'.print_r($userTournament_array,true).'</pre>';die;
                }
                else
                    Yii::app()->user->setFlash('danger','No existe torneos para el usuario.');    
            }
            else 
                Yii::app()->user->setFlash('danger','No existe el usuario en el sistema');
        }    

        $this->render('index',array(
            'model'=>$model,
            'userTournament_array'=>$userTournament_array,
            ));
    }

    /*
    Crear torneos
    */
    public function actionCreate()
    {
        #$cache=new CFileCache();
        #$cache->flush();
        $this->layout = "create";
        $consoles_by_comas = null;
        $model = new TournamentForm;

        $consoles = Console::model()->findAll('state = 1');

        if(isset($_POST['TournamentForm']))
        {
            if(isset($_POST['consoles']))
            $consoles_by_comas = implode(",", $_POST['consoles']);
            
            $model->attributes = $_POST['TournamentForm'];
            $model->consoles = $consoles_by_comas;
            $model->sessions = $_POST['TournamentForm']['sessions'];
            $model->group_roundtrip = $_POST['TournamentForm']['group_roundtrip'];
            $model->playoff_roundtrip = $_POST['TournamentForm']['playoff_roundtrip'];
            #echo $model->tournament_class_id;die;
            $transaction = Yii::app()->db->beginTransaction();

            try
            {
                if($model->validate())
                {
                    //Un torneo se puede realizar si la cantidad de participantes es multiplo de 2
                    if($this->validarMultiploDeDos($model->amount,$model->classified))
                    {
                        $start = date("Y-m-d H:i:s", strtotime($model->start_date)); 

                        $tournamentDetail = new TournamentDetail;
                        $tournamentDetail->amount = $model->amount;
                        $tournamentDetail->players = $model->players;
                        $tournamentDetail->classified = $model->classified;
                        $tournamentDetail->sessions = $model->sessions;
                        $tournamentDetail->group_roundtrip = $model->group_roundtrip;
                        $tournamentDetail->playoff_roundtrip = $model->playoff_roundtrip;

                        if($tournamentDetail->save())
                        {
                            $tournament = new Tournament;
                            $tournament->name = $model->name;
                            $tournament->game_id = $model->game_id;
                            $tournament->tournament_type_id = $model->tournament_type_id;
                            $tournament->start_date = $start;
                            $tournament->description = $model->description;
                            $tournament->city_id = $model->city_id;
                            $tournament->state = 1;
                            $tournament->tournament_detail_id = $tournamentDetail->id;
                            $tournament->test = $model->test;
                            $tournament->consoles = $model->consoles;
                            $tournament->tournament_class_id = $model->tournament_class_id;

                            if($tournament->save())
                            {
                                Yii::app()->historical->set($tournament,"Crear Torneo","Se crear el Torneo id ".$tournament->id.' - '.$tournament->name);
                                Yii::app()->user->setFlash("success","Se creó el Torneo.");
                                $transaction->commit();
                                $this->redirect(array("index"));
                            }
                            else
                            {
                                $transaction->rollback();
                                Yii::app()->user->setFlash("danger","No se pudo crear el Torneo. ");
                            }    
                        }
                    }
                    else
                    {
                        $transaction->rollback();
                        Yii::app()->user->setFlash("danger","No se puede realizar el torneo. Recuerde que el total de clasificados debe ser multiplo de dos.");
                    }     
                    
                }    
                else
                    Yii::app()->user->setFlash("danger","Error en el formulario.");
                    
            }
            catch(Exception $e)
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('danger',$e->getMessage());   
            }

        }  

        $this->render("create",array(
            'model'=>$model,
            'consoles'=>$consoles,
            ));
    }

    private function validarMultiploDeDos($grupos,$clasificados)
    {
        $multiplo = 2;
        $totalClasificados = $grupos*$clasificados;

        while($multiplo <= $totalClasificados)
        {
            if($multiplo*2 <= $totalClasificados)
                $multiplo = $multiplo*2;
            else
                break;
        } 

        if($multiplo % $totalClasificados == 0)
            return true;
        else 
            return false;
    }

    /*
    Fases - divisiones del torneo 
    */
    public function actionSession()
    {
        $this->layout = "main";

        $nextSession = null;
        $finishedTournament = null;
        $userSession_array = array();

        if(isset($_GET['id']))
        {   
            $tournament = Tournament::model()->findByPk($_GET['id']);
            $model = new TournamentSession;
            $model->tournament_id = $_GET['id'];

            if($tournament->state == 1)
            {
                $nextSession = $this->validateFinishedSessions($tournament); //validar si la fase se ha terminado, si hay que pasar a la siguiente fase o simplemnte se cierra la sesion.
                $finishedTournament = $this->validateFinishedTournament($tournament);//Validar si el torneo se ha terminado    
            }    

            $search = Yii::app()->user->getState("user_search");
            #echo $search;die;
            if($search)
            {
                $user = Player::model()->find('dni = ?',array($search));
                if($user)
                {
                    $userSessions = TournamentGroupPosition::model()->findAll("player_id = ?",array($user->id)); 
                    if($userSessions)
                    {
                        foreach ($userSessions as $key => $value) {
                            array_push($userSession_array, $value->tournamentGroup->phase->session->id); 
                        }
                        Yii::app()->user->setState("user_search",$search);
                        #echo '<pre>'.print_r($userTournament_array,true).'</pre>';die;
                    }
                    else
                        Yii::app()->user->setFlash('danger','No existe torneos para el usuario.');    
                }
                else 
                    Yii::app()->user->setFlash('danger','No existe el usuario en el sistema');
            }    

        }
        else 
            $this->redirect(array('index'));

        $this->render('session',array(
            'model'=>$model,
            'tournament'=>$tournament,
            'nextSession'=>$nextSession,
            'finishedTournament'=>$finishedTournament,
            'userSession_array'=>$userSession_array,
            ));
    }

    /*
    Fases - divisiones del torneo 
    */
    public function actionPhase()
    {
        $this->layout = "main";

        $nextPhase = null;
        $userPhase_array = array();

        if($_GET['id'])
        {   
            $session = TournamentSession::model()->findByPk($_GET['id']);
            $model = new TournamentPhase;
            $model->tournament_session_id = $session->id;

            if($model->session->tournament->state == 1)
                $nextPhase = $this->validateFinishedPhases($session); //validar si la fase se ha terminado, si hay que pasar a la siguiente fase o simplemnte se cierra la sesion.    

            $search = Yii::app()->user->getState("user_search");
            #echo $search;die;
            if($search)
            {
                $user = Player::model()->find('dni = ?',array($search));
                if($user)
                {
                    $userSessions = TournamentGroupPosition::model()->findAll("player_id = ?",array($user->id)); 
                    if($userSessions)
                    {
                        foreach ($userSessions as $key => $value) {
                            array_push($userPhase_array, $value->tournamentGroup->phase->id); 
                        }
                        Yii::app()->user->setState("user_search",$search);
                        #echo '<pre>'.print_r($userTournament_array,true).'</pre>';die;
                    }
                    else
                        Yii::app()->user->setFlash('danger','No existe torneos para el usuario.');    
                }
                else 
                    Yii::app()->user->setFlash('danger','No existe el usuario en el sistema');
            }    

        }
        else 
            $this->redirect(array('index'));

        $this->render('phase',array(
            'model'=>$model,
            'session'=>$session,
            'nextPhase'=>$nextPhase,
            'userPhase_array'=>$userPhase_array,
            ));
    }

    /*
    Valida si las fases han terminado y si hay que mostrar el boton de siguiente fase
    */
    private function validateFinishedPhases($session)
    {
        $last = 0;
        $bandera = 1; // Variable bandera donde 1 es para que se visualice el botón de "Siguiente Fase", 0 es para no visualizarlo
        $sessions_array = array();
        $phases = TournamentPhase::model()->findAll('tournament_session_id = ? and state = 3',array($session->id));
        $phasesAll = TournamentPhase::model()->findAll('tournament_session_id = ?',array($session->id));
        $consoles = explode(',', $session->tournament->consoles);

        if(count($phases) == count($phasesAll)) // si todas las fases estan en estado 3
        {
            foreach ($phases as $key => $value) 
                $last = $value->number;

            if($last != 0) // Entra a validación de - si existe phases con estado 3
            {
                //Validar fase de final de sesion - Si estamos en final de sesion, no hay seguiente fase.
                $sessions = TournamentSession::model()->findAll('tournament_id = ?',array($session->tournament_id));
                $sessionLast = $session->tournament->tournamentDetail->sessions+1; //cantidad de sesiones configuradas + 1 - Session final
                foreach ($sessions as $value) 
                    $sessions_array[] = $value->id;

                if( ($last != 4 and count($sessions_array) != $sessionLast and count($consoles) > 1 ) or ($last!=3 and count($consoles) == 1) ) // Precensial: si la ultima fase encontrada no es la 4, se puede seguir a la siguiente, Online: 
                {
                    $lastphase = TournamentPhase::model()->findAll('tournament_session_id = :sid and number = :nid',array(':sid'=>$session->id,':nid'=>$last)); //se buscan las fases con ese orden y se valida que esten todas en estado 3
                    foreach ($lastphase as $key => $value) {
                        if($value->state != 3)
                            $bandera = 0;
                    }    
                }
                else // Aquí entra para actualizar la sesión
                {
                    $bandera = 0;

                    //Si esta en fase 4 o estan en sesion final, y todas las fases estan terminadoas, se da por terminada la Sesión.
                    if($session->state !=2)
                    {
                        $session->state = 2;
                        if($session->save())
                            Yii::app()->user->setFlash("success","Se actualizó la sesión del torneo ".$session->tournament_id);    
                    }    
                }    
                
            } 
            else $bandera = 0;  
        }
        else $bandera = 0;  

        return $bandera;
        
    }

    public function actionNextPhase()
    {
        $nextPhase = null;
        $last = null;
        $structure = null;
        $players = array();
        $playoff = array();
        $bandera = 1;
        $paso = 0;
        $matchs = 1;
        $updateTP = 0;// cantidad de jugadores del torneos actualizados - quitar checkin para el siguiente dia
        $sessionTime = array();//Variables funcional para algoritmo de tiempos
        
        if($_GET['id'])
        {   
            $session = TournamentSession::model()->findByPk($_GET['id']);
            $tournament = Tournament::model()->findByPk($session->tournament_id);
            $sessionAll = TournamentSession::model()->findAll('tournament_id = ?',array($tournament->id));
            $consoles = explode(',', $tournament->consoles);

            foreach ($sessionAll as $key => $value) {
                $sessionTime[$value->id] = $key;
            }
            #echo '<pre>'.print_r($sessionTime,1).'</pre>';die;
            #echo count($tournament->session->phase); die;
            #$count_players_playoff = ($session->tournament->tournamentDetail->amount * $session->tournament->tournamentDetail->classified)/(count($tournament->session)); // Cantidad de jugadores en el torneo clasificados al playoff por sesion
            $nextPhase = $this->validateFinishedPhases($session); //validar si la fase se ha terminado, si hay que pasar a la siguiente fase o simplemnte se cierra la sesion.
            if($nextPhase)
            {
                $phases = TournamentPhase::model()->findAll('tournament_session_id = ? and state = 3',array($session->id));
                if($phases)
                {
                    foreach ($phases as $key => $value) 
                        $last = $value->number; //Obtengo el ultimo orden para saber a que fase seguir
                }

                $fecha = $tournament->start_date;
                $nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
                #echo $nuevafecha;die;
                #echo $session->id;die;
                //Definicion de tiempos de inicio de PlayOff
                if($sessionTime[$session->id] == 0)
                $inicio = date ( 'Y-m-j 09:00:00' , $nuevafecha );
                else if($sessionTime[$session->id] == 1)
                $inicio = date ( 'Y-m-j 11:30:00' , $nuevafecha );
                else if($sessionTime[$session->id] == 2)
                $inicio = date ( 'Y-m-j 14:00:00' , $nuevafecha );
                #echo $inicio;die;
                
                if($last == 1) // si la fase esta en el orden 1 (fase de grupos), nos dirijimos a la fase de eliminatorias
                {
                    // Se procede a crear todos los registros de la siguient fase
                    $sessionsLast = TournamentPhase::model()->findAll('tournament_session_id = ?',array($session->id));
                    $transaction = Yii::app()->db->beginTransaction();
                    try
                    {

                        foreach ($sessionsLast as $key => $value) 
                        {
                            $classified = $session->tournament->tournamentDetail->classified;//Cantidad de jugardores clasificado por grupo
                            $count_players_playoff = count($value->tournamentGroup) * $classified; //Cantidad de grupos de la fase * jugadores clasificados por grupo
                            $players = array();
                            $playoff = array();
                             $ids = array(); //ids de los jugadores clasificados
                            $separado_comas_ids = "";
                            //Las elminatorias son el siguiente días
                            
                            //Separar por coma los numeros de clasficados
                            $classifiedArray = array();
                            for($cl=1;$cl<=$classified;$cl++) 
                                $classifiedArray[] = $cl;
                            $classifiedComma = implode(',', $classifiedArray);

                            $criteria = new CDbCriteria();
                            $criteria->join = "
                                INNER JOIN tournament_group tg ON tg.id = t.tournament_group_id
                                INNER JOIN tournament_phase tf ON tf.id = tg.tournament_phase_id
                                INNER JOIN player p ON p.id = t.player_id
                            ";
                            $criteria->addCondition(" t.position IN (".$classifiedComma.") and tf.id = ".$value->id);
                            $criteria->select = "t.player_id,concat(p.name,p.surname) playerInfo";
                            $criteria->order = "tg.id ASC, t.position ASC";
                            $groupPosition = TournamentGroupPosition::model()->findAll($criteria);

                            if($groupPosition)
                            {
                                foreach ($groupPosition as $key => $value2) //Jugadores clasificados de toda la fase
                                {
                                    $players[] = array($value2->player_id,$value2->playerInfo);
                                    array_push($ids,$value2->player_id);  
                                }

                                //Actualizar jugadores como no checkin para el siguiente día, si es torneo presencial
                                if($tournament->tournament_class_id == 1)
                                {
                                    $separado_comas_ids ="'".implode("','",$ids)."'";
                                    $updateTP = TournamentPlayer::model()->updateAll(array("state"=>"5"),"player_id IN (".$separado_comas_ids.") AND tournament_id = ?",array($tournament->id));

                                    if($updateTP != count($ids)) // si los jugadores actualizados no es igual a los jugadores clasificados - checkin
                                    {
                                        $bandera = 0;
                                        $paso = 0;
                                    }
                                }   

                                #echo '<pre>'.print_r($players,true).'</pre>';die;
                                #echo $count_players_playoff;
                                /*
                                for($i=1; $i<=$count_players_playoff; $i+=4)
                                { 
                                  $playoff[$i] = $i ;  
                                  $playoff[$i+1] = $i+3;
                                  $playoff[$i+2] = $i+1;
                                  $playoff[$i+3] = $i+2;
                                }
                                */
                                $playoff = $this->scheduleMatchsPlayoff($classified,$count_players_playoff,$tournament->tournamentDetail->amount);
                                #echo '<pre>'.print_r($playoff,true).'</pre>';die;
                                #echo '<br>';
                                #echo '<pre>'.print_r($players,true).'</pre>';
                                #echo '<pre>'.print_r($playoff,true).'</pre>';
                                #echo '<pre>'.print_r($sessionsLast,true).'</pre>';
                            
                                $z = 1; //contador para la asignar los jugadores a los partidos
                                $tournamentPhasePlayOff = new TournamentPhase;
                                $tournamentPhasePlayOff->tournament_session_id = $session->id;
                                $tournamentPhasePlayOff->console_id = $value->console_id;
                                $tournamentPhasePlayOff->name = 'Eliminatoria - '.TournamentPhase::model()->getPlayOffById($count_players_playoff).' '.$value->console_id;
                                $tournamentPhasePlayOff->number = 2;
                                $tournamentPhasePlayOff->state = 1;
                                if($tournamentPhasePlayOff->save())
                                {
                                    $countMatchConsole = 0;//Variable funcional para asignacion de tiempos de los partidos - cuenta 1 por cada grupo creado
                                    $inicioG = $inicio;

                                    $tournamentGroupPlayOff = new TournamentGroup;
                                    $tournamentGroupPlayOff->tournament_phase_id =  $tournamentPhasePlayOff->id;
                                    $tournamentGroupPlayOff->tournament_coordinator_id = $value->tournamentGroup[0]->tournament_coordinator_id;//Un coordinador por fase, osea 2 por sesio.
                                    $tournamentGroupPlayOff->name = TournamentPhase::model()->getPlayOffById($count_players_playoff);
                                    $tournamentGroupPlayOff->state = 1;
                                    if($tournamentGroupPlayOff->save())
                                    {
                                        foreach ($playoff as $key => $value) 
                                        {
                                            #echo '<pre>'.print_r($players[$playoff[$key+1]],true).'</pre>';die;
                                            $tournamentGroupPositionPlayOff = new TournamentGroupPosition;
                                            $tournamentGroupPositionPlayOff->tournament_group_id = $tournamentGroupPlayOff->id;
                                            $tournamentGroupPositionPlayOff->player_id = $players[$playoff[$key]-1][0];
                                            $tournamentGroupPositionPlayOff->point = 0;
                                            $tournamentGroupPositionPlayOff->position = 0;
                                            if($tournamentGroupPositionPlayOff->save())
                                            {
                                                $tournamentGroupPositionSoccerPlayOff = new TournamentGroupPositionSoccer;
                                                $tournamentGroupPositionSoccerPlayOff->tournament_group_position_id = $tournamentGroupPositionPlayOff->id;
                                                $tournamentGroupPositionSoccerPlayOff->gf = 0;
                                                $tournamentGroupPositionSoccerPlayOff->gc = 0;
                                                $tournamentGroupPositionSoccerPlayOff->dg = 0;
                                                $tournamentGroupPositionSoccerPlayOff->pj = 0;
                                                $tournamentGroupPositionSoccerPlayOff->pg = 0;
                                                $tournamentGroupPositionSoccerPlayOff->pe = 0;
                                                $tournamentGroupPositionSoccerPlayOff->pp = 0;
                                                $tournamentGroupPositionSoccerPlayOff->state = 1;
                                                if(!$tournamentGroupPositionSoccerPlayOff->save())
                                                {
                                                    $bandera = 0;
                                                    $paso = 1;
                                                }    
                                            }else 
                                            {
                                                $bandera = 0;
                                                $paso = 2;
                                            }
                                        }
                                        #echo count($playoff)/2;die;
                                        for($i=1;$i<=count($playoff)/2;$i++) // ciclo por la mitad de los jugadores del playoff, cada partido tiene 2 juagores.
                                        {
                                            $countMatchConsole++;  //En Playoff es 1 consola por partido
                                            if($tournament->tournament_class_id == 1) //Si es presencia, se calcula fecha
                                            $inicioG = TournamentMatch::model()->calculateDatePLayOff($countMatchConsole,$inicioG); //valida si incio debe cambiar - Despues de haber terminado los grupos en N consolas
                                            $dateM = $inicioG;
                                            #echo $z.' '.'<strong>'.$i.'</strong> ';
                                            #if($z==17)
                                            #    die;
                                            $tournamentMatchPlayOff = new TournamentMatch;
                                            $tournamentMatchPlayOff->name = 'Eliminatoria '.$i;
                                            $tournamentMatchPlayOff->tournament_group_id = $tournamentGroupPlayOff->id;
                                            $tournamentMatchPlayOff->date = $dateM;
                                            $tournamentMatchPlayOff->state= 1;
                                            if(!$tournamentMatchPlayOff->save())
                                            {
                                                $bandera = 0;
                                                $paso = 3;
                                            }
                                            else
                                            {
                                                $tournamentMatchDetailPlayOff1 = new TournamentMatchDetail;
                                                $tournamentMatchDetailPlayOff1->tournament_match_id = $tournamentMatchPlayOff->id;
                                                $tournamentMatchDetailPlayOff1->player_id = $players[$playoff[$z]-1][0];
                                                $tournamentMatchDetailPlayOff1->point = 0;
                                                $tournamentMatchDetailPlayOff1->tournament_match_type_id = 1;
                                                $tournamentMatchDetailPlayOff1->state = 1;

                                                $tournamentMatchDetailPlayOff2 = new TournamentMatchDetail;
                                                $tournamentMatchDetailPlayOff2->tournament_match_id = $tournamentMatchPlayOff->id;
                                                $tournamentMatchDetailPlayOff2->player_id = $players[$playoff[$z+1]-1][0];
                                                $tournamentMatchDetailPlayOff2->point = 0;
                                                $tournamentMatchDetailPlayOff2->tournament_match_type_id = 1;
                                                $tournamentMatchDetailPlayOff2->state = 1;

                                                $z+=2;

                                                if(!$tournamentMatchDetailPlayOff1->save() or !$tournamentMatchDetailPlayOff2->save())
                                                {
                                                    $bandera = 0;
                                                    $paso = 4;
                                                }
                                            } 
                                                
                                        }

                                           
                                    }   
                                    else 
                                    {
                                        $bandera = 0;
                                        $paso = 5;
                                    }
                                } 
                                else    
                                {
                                    $bandera = 0;
                                    $paso = 6;
                                }
                            }    
                        }

                        if(!$bandera)
                        {
                            $transaction->rollback();
                            Yii::app()->user->setFlash("danger","Existen errores en la transacción. Paso: ".$paso);
                        }    
                        else 
                        {
                            $transaction->commit();
                            Yii::app()->user->setFlash("success","Se creó la siguiente Fase.");
                        }    

                        $this->redirect(array("phase","id"=>$_GET['id']));                                        
                    }

                    catch(Exception $e)
                    {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('danger',$e->getMessage());   
                    }
                    
                }
                else if($last==2) //Esta en fase eliminatorias, y puede estar en varias etapas de la fase 2 (Cuartos de final, semi final)
                {
                    // Se procede a crear todos los registros de la siguient fase
                    $criteria = new CDbCriteria();
                    $criteria->condition = "tournament_session_id = ".$session->id." and number = ".$last;
                    $criteria->limit = count($consoles); // dependiendo la cantidad de consolas, es la cantidad de fases por sesion por default
                    $criteria->order = 'id DESC';
                    $sessionsLast = TournamentPhase::model()->findAll($criteria);
                    $transaction = Yii::app()->db->beginTransaction();
                    try{

                        foreach ($sessionsLast as $key => $value) 
                        {
                            #echo $value->id;die;
                            $tournamentGroup = TournamentGroup::model()->find('tournament_phase_id = ?',array($value->id));
                            $count_players_playoff = count($tournamentGroup->tournamentGroupPosition)/2;
                            $players = array();
                            $playoff = array();

                            $criteria = new CDbCriteria();
                            $criteria->join = "
                                INNER JOIN tournament_group tg ON tg.id = t.tournament_group_id
                                INNER JOIN tournament_phase tf ON tf.id = tg.tournament_phase_id
                                INNER JOIN player p ON p.id = t.player_id
                            ";
                            $criteria->addCondition("t.point = 3 and tf.id = ".$value->id);
                            $criteria->select = "t.player_id,concat(p.name,p.surname) playerInfo";
                            #$criteria->order = "tg.id ASC";
                            $groupPosition = TournamentGroupPosition::model()->findAll($criteria);

                            if($groupPosition)
                            {
                                foreach ($groupPosition as $key => $value2) 
                                {
                                    $players[] = array($value2->player_id,$value2->playerInfo);
                                }

                                #echo '<pre>'.print_r($players,true).'</pre>';die;
                                #echo TournamentPhase::model()->getPlayOffById($count_players_playoff);die;
                                $z = 0; //contador para la asignar los jugadores a los partidos
                                $tournamentPhasePlayOff = new TournamentPhase;
                                $tournamentPhasePlayOff->tournament_session_id = $session->id;
                                $tournamentPhasePlayOff->console_id = $value->console_id;
                                $tournamentPhasePlayOff->name = 'Eliminatoria - '.TournamentPhase::model()->getPlayOffById($count_players_playoff).' '.$value->console_id;

                                if(count($players)==2) //Si son 2 jugadores, entonces estan en la final. Si es asi, deben quedar con fase 3 para poder hacer la transiciòn de fase.
                                $tournamentPhasePlayOff->number = 3;
                                else
                                $tournamentPhasePlayOff->number = 2;

                                $tournamentPhasePlayOff->state = 1;
                                if($tournamentPhasePlayOff->save())
                                {
                                    $countMatchConsole = 0;//Variable funcional para asignacion de tiempos de los partidos - cuenta 1 por cada grupo creado
                                    #$inicioG = $inicio;
                                    $dateMatch = new DateTime($inicio);

                                    //Calcular tiempo de inicio 
                                    if($count_players_playoff == 32)
                                    $date = $dateMatch->add(new DateInterval('PT45M'));
                                    else if($count_players_playoff == 16)
                                    $date = $dateMatch->add(new DateInterval('PT30M'));
                                    else if($count_players_playoff == 8)
                                    $date = $dateMatch->add(new DateInterval('PT15M'));
                                    else if($count_players_playoff == 4)
                                    $date = $dateMatch->add(new DateInterval('PT15M'));
                                    else if($count_players_playoff == 2)
                                    $date = $dateMatch->add(new DateInterval('PT15M'));

                                    $inicioG = $date->format('Y-m-d H:i:s');

                                    $tournamentGroupPlayOff = new TournamentGroup;
                                    $tournamentGroupPlayOff->tournament_phase_id =  $tournamentPhasePlayOff->id;
                                    $tournamentGroupPlayOff->tournament_coordinator_id = $value->tournamentGroup[0]->tournament_coordinator_id;//Un coordinador por fase, osea 2 por sesio.
                                    $tournamentGroupPlayOff->name = TournamentPhase::model()->getPlayOffById($count_players_playoff);
                                    $tournamentGroupPlayOff->state = 1;
                                    if($tournamentGroupPlayOff->save())
                                    {
                                        #echo "hola";die;
                                        foreach ($players as $key => $value) 
                                        {
                                            #echo $key;die;
                                            #echo '<pre>'.print_r($players[$playoff[$key+1]],true).'</pre>';die;
                                            $tournamentGroupPositionPlayOff = new TournamentGroupPosition;
                                            $tournamentGroupPositionPlayOff->tournament_group_id = $tournamentGroupPlayOff->id;
                                            $tournamentGroupPositionPlayOff->player_id = $players[$key][0];
                                            $tournamentGroupPositionPlayOff->point = 0;
                                            $tournamentGroupPositionPlayOff->position = 0;
                                            if($tournamentGroupPositionPlayOff->save())
                                            {
                                                $tournamentGroupPositionSoccerPlayOff = new TournamentGroupPositionSoccer;
                                                $tournamentGroupPositionSoccerPlayOff->tournament_group_position_id = $tournamentGroupPositionPlayOff->id;
                                                $tournamentGroupPositionSoccerPlayOff->gf = 0;
                                                $tournamentGroupPositionSoccerPlayOff->gc = 0;
                                                $tournamentGroupPositionSoccerPlayOff->dg = 0;
                                                $tournamentGroupPositionSoccerPlayOff->pj = 0;
                                                $tournamentGroupPositionSoccerPlayOff->pg = 0;
                                                $tournamentGroupPositionSoccerPlayOff->pe = 0;
                                                $tournamentGroupPositionSoccerPlayOff->pp = 0;
                                                $tournamentGroupPositionSoccerPlayOff->state = 1;
                                                if(!$tournamentGroupPositionSoccerPlayOff->save())
                                                {
                                                    $bandera = 0;
                                                    $paso = 1;
                                                }    
                                            }else 
                                            {
                                                $bandera = 0;
                                                $paso = 2;
                                            }
                                        }
                                        #echo count($playoff)/2;die;
                                        for($i=1;$i<=count($players)/2;$i++) // ciclo por la mitad de los jugadores del playoff, cada partido tiene 2 juagores.
                                        {
                                            #echo $z.' '.'<strong>'.$i.'</strong> ';
                                            #if($z==17)
                                            #    die;
                                            $countMatchConsole++;  //En Playoff es 1 consola por partido
                                            if($tournament->tournament_class_id == 1) //Si es presencia, se calcula fecha
                                            $inicioG = TournamentMatch::model()->calculateDatePLayOff($countMatchConsole,$inicioG); //valida si incio debe cambiar - Despues de haber terminado los grupos en N consolas
                                            $dateM = $inicioG;

                                            $tournamentMatchPlayOff = new TournamentMatch;
                                            $tournamentMatchPlayOff->name = 'Eliminatoria '.$i;
                                            $tournamentMatchPlayOff->tournament_group_id = $tournamentGroupPlayOff->id;
                                            $tournamentMatchPlayOff->date = $dateM;
                                            $tournamentMatchPlayOff->state= 1;
                                            if(!$tournamentMatchPlayOff->save())
                                            {
                                                $bandera = 0;
                                                $paso = 3;
                                            }
                                            else
                                            {
                                                #echo $players[$z][0];die;
                                                $tournamentMatchDetailPlayOff1 = new TournamentMatchDetail;
                                                $tournamentMatchDetailPlayOff1->tournament_match_id = $tournamentMatchPlayOff->id;
                                                $tournamentMatchDetailPlayOff1->player_id = $players[$z][0];
                                                $tournamentMatchDetailPlayOff1->point = 0;
                                                $tournamentMatchDetailPlayOff1->tournament_match_type_id = 1;
                                                $tournamentMatchDetailPlayOff1->state = 1;

                                                $tournamentMatchDetailPlayOff2 = new TournamentMatchDetail;
                                                $tournamentMatchDetailPlayOff2->tournament_match_id = $tournamentMatchPlayOff->id;
                                                $tournamentMatchDetailPlayOff2->player_id = $players[$z+1][0];
                                                $tournamentMatchDetailPlayOff2->point = 0;
                                                $tournamentMatchDetailPlayOff2->tournament_match_type_id = 1;
                                                $tournamentMatchDetailPlayOff2->state = 1;

                                                $z+=2;
                                                #echo $z;die;

                                                if(!$tournamentMatchDetailPlayOff1->save() or !$tournamentMatchDetailPlayOff2->save())
                                                {
                                                    $bandera = 0;
                                                    $paso = 4;
                                                }
                                            } 
                                                
                                        }

                                           
                                    }   
                                    else 
                                    {
                                        $bandera = 0;
                                        $paso = 5;
                                    }
                                } 
                                else    
                                {
                                    $bandera = 0;
                                    $paso = 6;
                                }
                            }
                        }

                        if(!$bandera)
                        {
                            $transaction->rollback();
                            Yii::app()->user->setFlash("danger","Existen errores en la transacción. Paso: ".$paso);
                        }    
                        else 
                        {
                            $transaction->commit();
                            Yii::app()->user->setFlash("success","Se creó la siguiente Fase.");
                        }    

                        $this->redirect(array("phase","id"=>$_GET['id']));       
                    }

                    catch(Exception $e)
                    {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('danger',$e->getMessage());   
                    }    
                }
                else if($last==3) //Esta en fase eliminatorias final, donde el jugador de final de una consola se enfrenta al jugador final de otra consola (ose se enfrentan entre diferente fase)
                {
                    $dateMatch = new DateTime($nuevafecha);
                    $dateM = $dateMatch->add(new DateInterval('PT120M'));
                    // Se procede a crear todos los registros de la siguient fase
                    $consolas = "";
                    $coordinador = 0;
                    $players = array();
                    $playoff = array();
                    $criteria = new CDbCriteria();
                    $criteria->condition = "tournament_session_id = ".$session->id." and number = ".$last;
                    $criteria->limit = 2; // las 2 ultimas fases del orden 2
                    $sessionsLast = TournamentPhase::model()->findAll($criteria);
                    $transaction = Yii::app()->db->beginTransaction();
                    try{

                        foreach ($sessionsLast as $key => $value) //Obtengo los 2 jugadores clasficados
                        {
                            $tournamentGroup = TournamentGroup::model()->find('tournament_phase_id = ?',array($value->id));
                            $count_players_playoff = count($tournamentGroup->tournamentGroupPosition);
                            #echo $count_players_playoff;die;

                            $criteria = new CDbCriteria();
                            $criteria->join = "
                                INNER JOIN tournament_group tg ON tg.id = t.tournament_group_id
                                INNER JOIN tournament_phase tf ON tf.id = tg.tournament_phase_id
                                INNER JOIN player p ON p.id = t.player_id
                            ";
                            $criteria->addCondition("t.point = 3 and tf.id = ".$value->id);
                            $criteria->select = "t.player_id,concat(p.name,p.surname) playerInfo, tg.tournament_coordinator_id coordinador";
                            $groupPosition = TournamentGroupPosition::model()->findAll($criteria);
                            
                            if($groupPosition)
                            {
                                foreach ($groupPosition as $key => $value2) 
                                {
                                    $players[] = array($value2->player_id,$value2->playerInfo);
                                    $coordinador = $value2->coordinador;
                                }
                                #echo '<pre>'.print_r($players,true).'</pre>';die;
                            } 
                        }
                        #echo '<pre>'.print_r($players,true).'</pre>';die;
                        $z = 0; //contador para la asignar los jugadores a los partidos    
                        //De las 2 fases se crea una final y un grupo final de 2 jugadores
                        $tournamentPhasePlayOff = new TournamentPhase;
                        $tournamentPhasePlayOff->tournament_session_id = $session->id;
                        $tournamentPhasePlayOff->console_id = 3;//mescla de consolas - final
                        $tournamentPhasePlayOff->name = 'Final sesión - '.TournamentPhase::model()->getPlayOffById($count_players_playoff);
                        $tournamentPhasePlayOff->number = 4;
                        $tournamentPhasePlayOff->state = 1;
                        if($tournamentPhasePlayOff->save())
                        {
                            $tournamentGroupPlayOff = new TournamentGroup;
                            $tournamentGroupPlayOff->tournament_phase_id =  $tournamentPhasePlayOff->id;
                            $tournamentGroupPlayOff->tournament_coordinator_id = $coordinador;//Cualquiera de los coordinadores de las fases de la sesion.
                            $tournamentGroupPlayOff->name = TournamentPhase::model()->getPlayOffById($count_players_playoff);
                            $tournamentGroupPlayOff->state = 1;
                            if($tournamentGroupPlayOff->save())
                            {
                                foreach ($players as $key => $value) 
                                {
                                    #echo $key;die;
                                    #echo '<pre>'.print_r($players[$playoff[$key+1]],true).'</pre>';die;
                                    $tournamentGroupPositionPlayOff = new TournamentGroupPosition;
                                    $tournamentGroupPositionPlayOff->tournament_group_id = $tournamentGroupPlayOff->id;
                                    $tournamentGroupPositionPlayOff->player_id = $players[$key][0];
                                    $tournamentGroupPositionPlayOff->point = 0;
                                    $tournamentGroupPositionPlayOff->position = 0;
                                    if($tournamentGroupPositionPlayOff->save())
                                    {
                                        $tournamentGroupPositionSoccerPlayOff = new TournamentGroupPositionSoccer;
                                        $tournamentGroupPositionSoccerPlayOff->tournament_group_position_id = $tournamentGroupPositionPlayOff->id;
                                        $tournamentGroupPositionSoccerPlayOff->gf = 0;
                                        $tournamentGroupPositionSoccerPlayOff->gc = 0;
                                        $tournamentGroupPositionSoccerPlayOff->dg = 0;
                                        $tournamentGroupPositionSoccerPlayOff->pj = 0;
                                        $tournamentGroupPositionSoccerPlayOff->pg = 0;
                                        $tournamentGroupPositionSoccerPlayOff->pe = 0;
                                        $tournamentGroupPositionSoccerPlayOff->pp = 0;
                                        $tournamentGroupPositionSoccerPlayOff->state = 1;
                                        if(!$tournamentGroupPositionSoccerPlayOff->save())
                                        {
                                            $bandera = 0;
                                            $paso = 1;
                                        }    
                                    }else 
                                    {
                                        $bandera = 0;
                                        $paso = 2;
                                    }
                                } 

                                for($i=1;$i<=count($players)/2;$i++) // ciclo por la mitad de los jugadores del playoff, cada partido tiene 2 juagores.
                                {
                                    for($j=1;$j<=2;$j++)//Partido de ida y vuelta
                                    {
                                        $label = ($j==1)?" Ida":" Vuelta";
                                        $tournamentMatchPlayOff = new TournamentMatch;
                                        $tournamentMatchPlayOff->name = 'Eliminatoria - Final'.$label;
                                        $tournamentMatchPlayOff->tournament_group_id = $tournamentGroupPlayOff->id;
                                        $tournamentMatchPlayOff->date = $dateM;
                                        $tournamentMatchPlayOff->state= 1;
                                        if(!$tournamentMatchPlayOff->save())
                                        {
                                            $bandera = 0;
                                            $paso = 3;
                                        }
                                        else
                                        {
                                            #echo $players[$z][0];die;
                                            $tournamentMatchDetailPlayOff1 = new TournamentMatchDetail;
                                            $tournamentMatchDetailPlayOff1->tournament_match_id = $tournamentMatchPlayOff->id;
                                            $tournamentMatchDetailPlayOff1->player_id = $players[$z][0];
                                            $tournamentMatchDetailPlayOff1->point = 0;
                                            $tournamentMatchDetailPlayOff1->tournament_match_type_id = 1;
                                            $tournamentMatchDetailPlayOff1->state = 1;

                                            $tournamentMatchDetailPlayOff2 = new TournamentMatchDetail;
                                            $tournamentMatchDetailPlayOff2->tournament_match_id = $tournamentMatchPlayOff->id;
                                            $tournamentMatchDetailPlayOff2->player_id = $players[$z+1][0];
                                            $tournamentMatchDetailPlayOff2->point = 0;
                                            $tournamentMatchDetailPlayOff2->tournament_match_type_id = 1;
                                            $tournamentMatchDetailPlayOff2->state = 1;

                                            if(!$tournamentMatchDetailPlayOff1->save() or !$tournamentMatchDetailPlayOff2->save())
                                            {
                                                $bandera = 0;
                                                $paso = 4;
                                            }
                                        } 

                                        $dateMatch = new DateTime($dateM);
                                        $dateM = $dateMatch->add(new DateInterval('PT15M'));  
                                    }

                                    $z+=2;
                                }
                            }   
                            else 
                            {
                                $bandera = 0;
                                $paso = 5;
                            }    
                        }
                        else    
                        {
                            $bandera = 0;
                            $paso = 6;
                        }

                        if(!$bandera)
                        {
                            $transaction->rollback();
                            Yii::app()->user->setFlash("danger","Existen errores en la transacción. Paso: ".$paso);
                        }    
                        else 
                        {
                            $transaction->commit();
                            Yii::app()->user->setFlash("success","Se creó la siguiente Fase.");
                        }    

                        $this->redirect(array("phase","id"=>$_GET['id']));       
                    }

                    catch(Exception $e)
                    {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('danger',$e->getMessage());   
                    }        
                }
                
            }

        }
        else 
            $this->redirect(array('index'));
    }

    /*
    Siempre debe ser un numero par de grupos porque el primero de un grupo se debe enfrentar al segundo del otro y viceversa.
    */
    private function scheduleMatchsPlayoff($classified,$count_players_playoff,$count_groups)
    {
        #echo $count_groups;die;
        $playoff = array();

        //excepcion si la cantida de grupos es 1
        if($count_groups==1)
            $g = 1;
        else
            $g = 2;
        
        for($i=1; $i<=$count_players_playoff; $i+=$classified*$g)
        { 
            $j = ($i+$classified*$g)-1;
            $t = $i;
            $n = $j;

            for($k=$i;$k<=$j;$k++)
            {
                if($k%2!=0)
                {
                    $playoff[$k] = $t ;
                    $t += 1;      
                }    
                else
                {
                    $playoff[$k] = $n;
                    $n -= 1;
                }    
            }
        }

        return $playoff;
    }

    public function actionFinalizeTournament($id)
    {
        $tournament = Tournament::model()->findByPk($id);
        $sessions = TournamentSession::model()->findAll('tournament_id = ? and state = 2',array($tournament->id));
        if($tournament)
        {
            //obtener el jugador ganador
            foreach ($sessions as $key => $value) 
                    $sessions_array[] = $value->id;  

            $session_last = end($sessions_array);
            $session = TournamentSession::model()->findByPk($session_last);
            
            $criteria = new CDbCriteria();
            $criteria->condition = 'tournament_session_id = '.$session->id;
            $criteria->limit = 1; // dependiendo la cantidad de consolas, es la cantidad de fases por sesion por default
            $criteria->order = 'id DESC';
            $phase = TournamentPhase::model()->find($criteria);
            #echo $phase->id;die;
            $group = TournamentGroup::model()->find('tournament_phase_id = ?',array($phase->id));

            if($tournament->tournamentDetail->sessions == 1)
            {
                $criteria2 = new CDbCriteria();
                $criteria2->condition = "tournament_group_id = ".$group->id;
                $criteria2->order = 'point DESC'; 
                $tournamentGroupPositionChampion = TournamentGroupPosition::model()->find($criteria2);
                #echo $tournamentGroupPositionChampion->player_id;die;
            }    
            else // Si hay más de una sesión, se define el torneo en una sesión final con una sola fase    
                $tournamentGroupPositionChampion = TournamentGroupPosition::model()->find("tournament_group_id = ? and position = 1",array($group->id));

            $tournament->winner_id = $tournamentGroupPositionChampion->player_id;
            $tournament->state = 2;
            if($tournament->save())
                Yii::app()->user->setFlash('success','Se Finalizó el Torneo correctamente.');
            else
            {
                Yii::app()->user->setFlash('error','No se pudo finalizar el Torneo.');
                $this->redirect(array('index'));    
            }
        }
        
        $this->redirect(array('index'));
    }

    /*
    Crear la siguiente sesion - Cuando se terminan todas las sesiones, se procede a crear la sesion FINAL
    */
    public function actionNextSession()
    {
        $nextSessions = true;
        //Validar si las sesiones del Torneo estan en estado 3

        if($_GET['id'])
        {
            $tournament = Tournament::model()->findByPk($_GET['id']);
            $nextSessions = $this->validateFinishedSessions($tournament);
            $playersId = array(); //Jugadores Finalistas - Ganadores de cada Sesión
            $dg = array();
            $final = array();

            if($nextSessions)// Se procede a crar la Siguiente Sesión
            {
                $structure = $tournament->structure_id;
                $bandera = 1;

                if($structure == 1) // Amplia 3 sesiones y 2 fases por sesion - elminatorias, final de fase y final de sesion
                {
                    //Se crea la sesion final - 1 fase - 1 grupo de 3 jugadores - Todos contra todos
                    $transaction = Yii::app()->db->beginTransaction();
                    try
                    {
                        $fecha = $tournament->start_date;
                        $nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
                        if($sessionTime[$session->id] == 1)
                        $inicio = date ( 'Y-m-j 16:30:00' , $nuevafecha );
                        $dateM = $inicio;

                        $criteria = new CDbCriteria;
                        $criteria->join = "
                            INNER JOIN tournament_phase tph ON tph.tournament_session_id = t.id
                            INNER JOIN tournament_group tg ON tg.tournament_phase_id = tph.id
                        ";
                        $criteria->select = "tg.id group_id";
                        $criteria->condition = "tph.number = 4 and t.tournament_id = ".$tournament->id;
                        $phases = TournamentSession::model()->findAll($criteria);

                        foreach ($phases as $key => $value) {
                            $group = TournamentGroup::model()->findByPk($value->group_id);
                            //Primero se valida si alguno de los 2 ganó los 2 partidos
                            foreach ($group->tournamentGroupPosition as $key2 => $value2) {
                                if($value2->point == 6)
                                    $playersId[] = $value2->player_id;
                                else // Validar diferencia de goles
                                {
                                    $groupPositionSoccer = TournamentGroupPositionSoccer::model()->find('tournament_group_position_id = ?',array($value2->id));
                                    $dg[] = array($value2->player_id,$groupPositionSoccer->dg);
                                }    
                            }

                            if(!empty($dg))
                            {
                                if($dg[0][1]>$dg[1][1])
                                    $playersId[] = $dg[0][0];
                                else if($dg[0][1]<$dg[1][1])
                                {
                                    $playersId[] = $dg[1][0];
                                }    
                            }

                            #echo '<pre>'.print_r($playersId,true).'</pre>';die;
                            $dg = array();
                        }
                        #echo '<pre>'.print_r($playersId,true).'</pre>';die;

                        $final = array(
                            1 => array(0,1),
                            2 => array(1,2),
                            3 => array(0,2),
                            4 => array(1,0),
                            5 => array(2,1),
                            6 => array(0,1),
                            );//Como se juegan los partidos
                        #echo '<pre>'.print_r($final,true).'</pre>';die;                            

                        //Se procede a crear la Sesión, la Phase, el Grupo.
                        $tournamentSession = new TournamentSession;
                        $tournamentSession->name = 'Gran Final';
                        $tournamentSession->tournament_id = $tournament->id;
                        $tournamentSession->state = 1;

                        if($tournamentSession->save())
                        {
                            #echo $tournamentSession->id;die;
                            $tournamentPhase = new TournamentPhase;
                            $tournamentPhase->tournament_session_id = $tournamentSession->id;
                            $tournamentPhase->console_id = 3;
                            $tournamentPhase->name = 'Gran Final';
                            $tournamentPhase->number = 5;
                            $tournamentPhase->state = 1;

                            if($tournamentPhase->save())
                            {

                                #echo $tournamentPhase->id;die;    
                                $coordinator = UserRrhh::model()->getCoordinatorsTournament();

                                $tournamentGroup = new tournamentGroup;
                                $tournamentGroup->name = "Grupo Final";
                                $tournamentGroup->tournament_phase_id = $tournamentPhase->id;
                                $tournamentGroup->tournament_coordinator_id = $coordinator[0];
                                $tournamentGroup->state = 1;

                                if($tournamentGroup->save())
                                {
                                    #echo $tournamentGroup->id;die;
                                    foreach ($playersId as $key => $value) {
                                        #echo $key;die;
                                        $tournamentGroupPosition = new TournamentGroupPosition;
                                        $tournamentGroupPosition->tournament_group_id = $tournamentGroup->id;
                                        $tournamentGroupPosition->player_id = $value;    
                                        $tournamentGroupPosition->point = 0;    
                                        $tournamentGroupPosition->position = $key+1;

                                        if($tournamentGroupPosition->save())
                                        {
                                            #echo $TournamentGroupPosition->id;die;
                                            $tournamentGroupPositionSoccer = new tournamentGroupPositionSoccer;
                                            $tournamentGroupPositionSoccer->tournament_group_position_id = $tournamentGroupPosition->id;
                                            $tournamentGroupPositionSoccer->gf = 0;
                                            $tournamentGroupPositionSoccer->gc = 0;
                                            $tournamentGroupPositionSoccer->dg = 0;
                                            $tournamentGroupPositionSoccer->pj = 0;
                                            $tournamentGroupPositionSoccer->pg = 0;
                                            $tournamentGroupPositionSoccer->pe = 0;
                                            $tournamentGroupPositionSoccer->pp = 0;
                                            $tournamentGroupPositionSoccer->state = 1;

                                            if(!$tournamentGroupPositionSoccer->save())
                                            {
                                                $bandera = 0;
                                                $paso = 5;
                                            }        
                                        }
                                        else 
                                        {
                                            $bandera = 0;
                                            $paso = 4;
                                        }      
                                    }
                                    #echo count($playersId);die;
                                    $k=1;//variable contadora de los partidos de cada ronda
                                    for($i=1;$i<=count($playersId)*2;$i++) // ciclo del doble de los jugadores clasificados, ida y vuelta.
                                    {
                                        $ida_vuelta = ($i<=count($playersId))?'ida':'vuelta';
                                        $tournamentMatch = new TournamentMatch;
                                        $tournamentMatch->name = 'Final '.$ida_vuelta.' '.$k;
                                        $tournamentMatch->tournament_group_id = $tournamentGroup->id;
                                        $tournamentMatch->date = $dateM;
                                        $tournamentMatch->state= 1;
                                        if($tournamentMatch->save())
                                        {
                                            $tournamentMatchDetail1 = new TournamentMatchDetail;
                                            $tournamentMatchDetail1->tournament_match_id = $tournamentMatch->id;
                                            $tournamentMatchDetail1->player_id = $playersId[$final[$i][0]];
                                            $tournamentMatchDetail1->point = 0;
                                            $tournamentMatchDetail1->tournament_match_type_id = 1;
                                            $tournamentMatchDetail1->state = 1;

                                            $tournamentMatchDetail2 = new TournamentMatchDetail;
                                            $tournamentMatchDetail2->tournament_match_id = $tournamentMatch->id;
                                            $tournamentMatchDetail2->player_id = $playersId[$final[$i][1]];
                                            $tournamentMatchDetail2->point = 0;
                                            $tournamentMatchDetail2->tournament_match_type_id = 1;
                                            $tournamentMatchDetail2->state = 1;

                                            if(!$tournamentMatchDetail1->save() or !$tournamentMatchDetail2->save())
                                            {
                                                $bandera = 0;
                                                $paso = 7;
                                            }

                                            $dateMatch = new DateTime($inicio);
                                            $dateMatch->add(new DateInterval('PT15M'));
                                            $inicio = $dateMatch->format('Y-m-d H:i:s');
                                        }
                                        else 
                                        {
                                            $bandera = 0;
                                            $paso = 6;
                                        }

                                        $k++;

                                        if($k > count($playersId)) // en la segunda ronda, el contador del partido se debe reiniciar
                                            $k=1;

                                        $dateMatch = new DateTime($dateM);
                                        $dateM = $dateMatch->add(new DateInterval('PT15M'));      
                                            
                                    }
                                    
                                }
                                else
                                {
                                    $bandera = 0;
                                    $paso = 3;
                                }       
                            }
                            else
                            {
                                $bandera = 0;
                                $paso = 2;
                            }    
                        }
                        else
                        {
                            $bandera = 0;
                            $paso = 1;
                        }    

                        if(!$bandera)
                        {
                            $transaction->rollback();
                            Yii::app()->user->setFlash("danger","Existen errores en la transacción. Paso: ".$paso);
                        }    
                        else 
                        {
                            $transaction->commit();
                            Yii::app()->user->setFlash("success","Se creó la Sesión Final.");
                        }  

                        $this->redirect(array('tournament/session','id'=>$tournament->id));  

                    }
                    catch(Exception $e)
                    {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('danger',$e->getMessage());   
                    }
                }
            }   
        }
        else 
            $this->redirect(array('index'));    
    }

    private function validateFinishedSessions($tournament)
    {
        $bandera = 1;
        $sessions = TournamentSession::model()->findAll('tournament_id = ? and state = 2',array($tournament->id));
        $sessionsAll = TournamentSession::model()->findAll('tournament_id = ?',array($tournament->id));
        #echo 'validando';die;
        if(count($sessions) == count($sessionsAll))
        {
            if(count($sessionsAll) == 1) // Si solo es 1 sesión, no debe haber siguiente sesión
                $bandera = 0;
        }
        else $bandera = 0;  

        return $bandera;
    }

    private function validateFinishedTournament($tournament)
    {
        $bandera = 0;
        $sessions = TournamentSession::model()->findAll('tournament_id = ? and state = 2',array($tournament->id));
        $sessionsAll = TournamentSession::model()->findAll('tournament_id = ?',array($tournament->id));
        $sessions_array = array();
        $session_last = 0;
        
        if(count($sessions) == count($sessionsAll)+1) // si ya hay 1 sesión más que el total de sesesiones configuradas del torneo, es porque se ha finalizado el torneo
            $bandera = 1;   

        if(count($sessions) == count($sessionsAll) and $tournament->tournamentDetail->sessions == 1) // Si la fase esta en la final y solo hay 1 sesion y solo se juegan en un tipo de consola, no hay fase final entre consolas y no hay final de sesion. Aqui se termina el torneo            
        $bandera = 1;  

        if($tournament->winner_id != null and $tournament->winner_id != 0)
            $bandera = 0;
        
        return $bandera;
    }

    /*
    Grupos - datos de los grupos
    */
    public function actionGroups()
    {
        $this->layout = "main";
        $consoleForm = new TournametConsoleForm;
        $userGroup_array = array();

        if($_GET['id'])// si envia el id del grupo
        {   
            $phase = TournamentPhase::model()->findByPk($_GET['id']);
            $model = TournamentGroup::model()->findAll('tournament_phase_id = ?',array($_GET['id']));

            $this->validateFinishedGroups($phase,$model); //se valida el estado de los grupos para actualizar el estado del fase

            $search = Yii::app()->user->getState("user_search");
            #echo $search;die;
            if($search)
            {
                $user = Player::model()->find('dni = ?',array($search));
                if($user)
                {
                    $userSessions = TournamentGroupPosition::model()->findAll("player_id = ?",array($user->id)); 
                    if($userSessions)
                    {
                        foreach ($userSessions as $key => $value) {
                            array_push($userGroup_array, $value->tournamentGroup->id); 
                        }
                        Yii::app()->user->setState("user_search",$search);
                        #echo '<pre>'.print_r($userTournament_array,true).'</pre>';die;
                    }
                    else
                        Yii::app()->user->setFlash('danger','No existe torneos para el usuario.');    
                }
                else 
                    Yii::app()->user->setFlash('danger','No existe el usuario en el sistema');
            }        

        }
        else 
            $this->redirect(array('index'));

        //validar vista
        $vista = $this->validateViewGroups($phase);

        $this->render($vista,array(
            'model'=>$model,
            'phase'=>$phase,
            'consoleForm'=>$consoleForm,
            'userGroup_array'=>$userGroup_array,
            ));
    }

    private function validateFinishedGroups($phase,$groups)
    {
        if($phase->session->tournament->state == 1) // Si el torneo esta activo, se valida
        {
            $cambioEstado = 1;
            foreach ($groups as $key => $value) 
            {
                #echo $value->state;die;
                if($value->state != 3 and $value->state != 4)
                    $cambioEstado = 0;    
            }

            if($phase->state == 3)// si la fase ya esta terminada
            $cambioEstado = 0;

            #echo $cambioEstado;die;
            if($cambioEstado)
            {
                $phase->state = 3;
                if($phase->save())
                    Yii::app()->user->setFlash("success","Se actualizó el estado de la Fase ".$phase->id);
            }
        }    
            
            
    }

    /*
    Grupos - datos de los grupos
    */
    public function actionMatch()
    {
        $this->layout = "main";
        $form_arr = array();
        $score = new ScoreForm;
        $puntos = array();
        $consoleForm = new TournametConsoleForm;

        //Registrar marcador
        if(isset($_POST['ScoreForm']))
        {
            $this->registerScore($score);
        }

        //Consultar partidos
        if($_GET['id'])
        {
            $model = TournamentGroup::model()->findByPk($_GET['id']);
            $matchs = TournamentMatch::model()->findAll(" tournament_group_id = ? ",array($_GET['id']));
        }    
        else 
            $this->redirect(array('index'));

        //validar vista
        $vista = $this->validateViewMatchs($model);

        $score->unsetAttributes();

        $this->render($vista,array(
            'model'=>$model,
            'matchs'=>$matchs,
            'score'=>$score,
            'form_arr'=>$form_arr,
            'consoleForm'=>$consoleForm,
            ));
    }

    public function actionUndoScore($id)
    {
        $match = TournamentMatch::model()->findByPk($id);

        if($match)
        {
            if($match->tournamentGroup->phase->number == 1) // fase de grupos
            {
                $tournamentMatchDetail = TournamentMatchDetail::model()->findAll('tournament_match_id = ?',array($match->id));
                $scores = array();
                $bandera = 1;//variable bandera para saber si se completa la transacción

                $transaction = Yii::app()->db->beginTransaction();

                try
                {
                    foreach ($tournamentMatchDetail as $key => $value) 
                        $scores[] = array($value->player_id,$value->point);

                    $tournamentGroupDetailPlayer1 = new TournamentGroupDetail;
                    $tournamentGroupDetailPlayer2 = new TournamentGroupDetail;

                    $groupPositionAll = new TournamentGroupPosition;
                    $groupPositionAll->tournament_group_id = $match->tournament_group_id;

                    $match->state = 1;

                    $matchPlayer1 = TournamentMatchDetail::model()->find('tournament_match_id = ? and player_id = ?',array($match->id,$scores[0][0]));
                    $matchPlayer2 = TournamentMatchDetail::model()->find('tournament_match_id = ? and player_id = ?',array($match->id,$scores[1][0]));

                    //colocar marcadores a 0
                    $matchPlayer1->point = 0;
                    $matchPlayer1->state = 1;
                    $matchPlayer2->point = 0;
                    $matchPlayer2->state = 1;

                    $puntos = TournamentGroupPositionSoccer::model()->decidePoint($scores[0][1],$scores[1][1]);
                    
                    $groupPosition1 = TournamentGroupPosition::model()->find('tournament_group_id = :g and player_id = :p',array(':g'=>$match->tournament_group_id,':p'=>$scores[0][0]));
                    $groupPosition2 = TournamentGroupPosition::model()->find('tournament_group_id = :g and player_id = :p',array(':g'=>$match->tournament_group_id,':p'=>$scores[1][0]));

                    $group = TournamentGroup::model()->findByPk($groupPosition1->tournament_group_id);
                    
                    $groupPosition1->point -= $puntos[0];
                    $groupPosition2->point -= $puntos[1];
                    #echo $groupPosition2->point;die;

                    $groupPositionSoccer1 = TournamentGroupPositionSoccer::model()->find('tournament_group_position_id = ?',array($groupPosition1->id));
                    $groupPositionSoccer1->gf -= $scores[0][1];
                    $groupPositionSoccer1->gc -= $scores[1][1];
                    $groupPositionSoccer1->dg -= ($scores[0][1]-$scores[1][1]);
                    $groupPositionSoccer1->pj -= 1;
                    $groupPositionSoccer1->pg -= ($puntos[0]>1)?1:0;
                    $groupPositionSoccer1->pe -= ($puntos[0]==1)?1:0;
                    $groupPositionSoccer1->pp -= ($puntos[0]==0)?1:0;

                    $groupPositionSoccer2 = TournamentGroupPositionSoccer::model()->find('tournament_group_position_id = ?',array($groupPosition2->id));
                    $groupPositionSoccer2->gf -= $scores[1][1];
                    $groupPositionSoccer2->gc -= $scores[0][1];
                    $groupPositionSoccer2->dg -= ($scores[1][1]-$scores[0][1]);
                    $groupPositionSoccer2->pj -= 1;
                    $groupPositionSoccer2->pg -= ($puntos[1]>1)?1:0;
                    $groupPositionSoccer2->pe -= ($puntos[1]==1)?1:0;
                    $groupPositionSoccer2->pp -= ($puntos[1]==0)?1:0;

                    $tournamentGroupDetailPlayer1->player_id = $scores[0][0];
                    $tournamentGroupDetailPlayer1->tournament_group_id = $match->tournament_group_id;
                    $tournamentGroupDetailPlayer1->point = $puntos[0];
                    $tournamentGroupDetailPlayer1->state =1;

                    $tournamentGroupDetailPlayer2->player_id = $scores[0][1];
                    $tournamentGroupDetailPlayer2->tournament_group_id = $match->tournament_group_id;
                    $tournamentGroupDetailPlayer2->point = $puntos[1];
                    $tournamentGroupDetailPlayer2->state =1;

                    if($match->save() and $matchPlayer1->save() and $matchPlayer2->save() and $groupPosition1->save() and $groupPosition2->save() and $groupPositionSoccer1->save() and $groupPositionSoccer2->save() and $tournamentGroupDetailPlayer1->save() and $tournamentGroupDetailPlayer2->save())
                    {
                        $calculated = $groupPositionAll->calculatePosition();

                        if($calculated)
                         {
                            $transaction->commit();
                            Yii::app()->user->setFlash('success','Se hizo reversión al marcador.');   

                            $this->redirect(array("match","id"=>$match->tournament_group_id));
                         }   
                        else
                        {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('danger','No se hizo reversión el marcador.');   
                        }    
                    }
                    else
                    {
                        #print_r($match->getErrors());die; 
                        $transaction->rollback();
                        Yii::app()->user->setFlash('danger','No se pudo registrar el marcador.');   
                    }

                }
                catch(Exception $e)
                {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('danger',$e->getMessage());   
                }     
            }
            else
                Yii::app()->user->setFlash("error","Solo se puede hacer devolución de marcador en fase de grupos."); 
        }
        else
            Yii::app()->user->setFlash("error","No se encontró partido"); 

        $this->redirect(array("index"));       
    }

    private function registerScore($score)
    {
        $transaction = Yii::app()->db->beginTransaction();

        try{
            $score->match_id = $_POST['ScoreForm']['match_id'];
            $score->player_id_1 = $_POST['ScoreForm']['player_id_1'];
            $score->player_id_2 = $_POST['ScoreForm']['player_id_2'];
            $score->score1 = $_POST['ScoreForm']['score1'];
            $score->score2 = $_POST['ScoreForm']['score2'];
            $score->type = $_POST['ScoreForm']['type'];
            
            $unassignConsole = true;
            #echo is_numeric($score->score1).' '.is_numeric($score->score2);die;
            //Validar que el marcador este correcto - que solo sea número.
            if(is_numeric($score->score1) and is_numeric($score->score2))
            {
                if($score->score1 < 0 or $score->score2 < 0)
                {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('danger','Los marcadores tiene valores negativos.');
                    $this->redirect(array('index'));
                } 
            }
            else
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('danger','Los marcadores no son númericos');
                $this->redirect(array('index'));
            } 

            $match = TournamentMatch::model()->findByPk($_POST['ScoreForm']['match_id']);

            if($match->state == 3) // Si ya se registro el marcador
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('danger','Ya se ha registrado marcador para este partido');
                $this->redirect(array('index'));  
            }

            if($score->type == 1) // Cuando es partido de fase de grupos
            {
                $matchPlayer1 = TournamentMatchDetail::model()->find('tournament_match_id = :m and player_id = :p',array(':m'=>$score->match_id,':p'=>$score->player_id_1));
                $matchPlayer2 = TournamentMatchDetail::model()->find('tournament_match_id = :m and player_id = :p',array(':m'=>$score->match_id,':p'=>$score->player_id_2));
                $groupPosition1 = TournamentGroupPosition::model()->find('tournament_group_id = :g and player_id = :p',array(':g'=>$match->tournament_group_id,':p'=>$score->player_id_1));
                $groupPosition2 = TournamentGroupPosition::model()->find('tournament_group_id = :g and player_id = :p',array(':g'=>$match->tournament_group_id,':p'=>$score->player_id_2));

                
                $groupPositionAll = new TournamentGroupPosition;
                $groupPositionAll->tournament_group_id = $match->tournament_group_id;
                
                $groupPositionSoccer1 = TournamentGroupPositionSoccer::model()->find('tournament_group_position_id = ?',array($groupPosition1->id));
                $groupPositionSoccer2 = TournamentGroupPositionSoccer::model()->find('tournament_group_position_id = ?',array($groupPosition2->id));
                $tournamentGroupDetailPlayer1 = new TournamentGroupDetail;
                $tournamentGroupDetailPlayer2 = new TournamentGroupDetail;

                $group = TournamentGroup::model()->findByPk($match->tournament_group_id);

                $match->state = 3; //terminado

                $matchPlayer1->point = $score->score1;
                $matchPlayer1->state = 2;
                $matchPlayer1->tournament_match_type_id = 1;
                $matchPlayer2->point = $score->score2;
                $matchPlayer2->state = 2;
                $matchPlayer2->tournament_match_type_id = 1;
                #echo $score->score1.' '.$score->score2;die;
                $puntos = TournamentGroupPositionSoccer::model()->decidePoint($score->score1,$score->score2);
                #echo '<pre>'.print_r($puntos,true).'</pre>';die;
                #echo $puntos[1];die;
                $groupPosition1->point += $puntos[0];
                $groupPosition2->point += $puntos[1];
                #echo $groupPosition2->point;die;

                $groupPositionSoccer1->gf += $score->score1;
                $groupPositionSoccer1->gc += $score->score2;
                $groupPositionSoccer1->dg += ($score->score1-$score->score2);
                $groupPositionSoccer1->pj += 1;
                $groupPositionSoccer1->pg += ($puntos[0]>1)?1:0;
                $groupPositionSoccer1->pe += ($puntos[0]==1)?1:0;
                $groupPositionSoccer1->pp += ($puntos[0]==0)?1:0;
                
                $groupPositionSoccer2->gf += $score->score2;
                $groupPositionSoccer2->gc += $score->score1;
                $groupPositionSoccer2->dg += ($score->score2-$score->score1);
                $groupPositionSoccer2->pj += 1;
                $groupPositionSoccer2->pg += ($puntos[1]>1)?1:0;
                $groupPositionSoccer2->pe += ($puntos[1]==1)?1:0;
                $groupPositionSoccer2->pp += ($puntos[1]==0)?1:0;

                $tournamentGroupDetailPlayer1->player_id = $score->player_id_1;
                $tournamentGroupDetailPlayer1->tournament_group_id = $match->tournament_group_id;
                $tournamentGroupDetailPlayer1->point = $puntos[0];
                $tournamentGroupDetailPlayer1->state =1;

                $tournamentGroupDetailPlayer2->player_id = $score->player_id_2;
                $tournamentGroupDetailPlayer2->tournament_group_id = $match->tournament_group_id;
                $tournamentGroupDetailPlayer2->point = $puntos[1];
                $tournamentGroupDetailPlayer2->state =1;
                #echo $groupPositionSoccer2->id; die;
                if($match->save() and $matchPlayer1->save() and $matchPlayer2->save() and $groupPosition1->save() and $groupPosition2->save() and $groupPositionSoccer1->save() and $groupPositionSoccer2->save() and $tournamentGroupDetailPlayer1->save() and $tournamentGroupDetailPlayer2->save())
                {
                    #$transaction->commit();
                    #$groupPositionAll = TournamentGroupPosition::model()->findAll($criteria);
                    #echo $groupPosition1->point;die;
                    $group->changueStatus($match->state);

                    if($group->phase->session->tournament->tournament_class_id == 1) // Si es torneo presencial, si se deasigna la consola
                    $unassignConsole = $group->unassignConsole();//Desasignar consola del grupo - fase 1

                    #$total = count($groupPositionAll);
                    $calculated = $groupPositionAll->calculatePosition();
                    #echo $groupPosition2->point;die;
                    #if($group->save())
                    if($group->save() and $calculated and $unassignConsole)
                     {
                        Yii::app()->historical->set($match,"Marcador Partido",'Se registra marcador para el partido id '.$match->id.' del torneo '.$match->tournamentGroup->phase->session->tournament->name.' con los marcadores -  '.$match->tournamentMatchDetail[0]->player->username.' : '.$match->tournamentMatchDetail[0]->point.' '.$match->tournamentMatchDetail[1]->player->username.' : '.$match->tournamentMatchDetail[1]->point);
                        $transaction->commit();
                        Yii::app()->user->setFlash('success','Se registró el marcador.');    
                     }   
                    else
                    {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('danger','No se pudo registrar el marcador.');   
                    }    
                }
                else
                {
                    #print_r($match->getErrors());die; 
                    $transaction->rollback();
                    Yii::app()->user->setFlash('danger','No se pudo registrar el marcador.');   
                }
            }
            else if($score->type == 2) // Cuando es partido de fase de eliminatorias - la logica es que si gana por penaltis es que se anote un gol más al ganador
            {
                $matchPlayer1 = TournamentMatchDetail::model()->find('tournament_match_id = :m and player_id = :p',array(':m'=>$score->match_id,':p'=>$score->player_id_1));
                $matchPlayer2 = TournamentMatchDetail::model()->find('tournament_match_id = :m and player_id = :p',array(':m'=>$score->match_id,':p'=>$score->player_id_2));
                $groupPosition1 = TournamentGroupPosition::model()->find('tournament_group_id = :g and player_id = :p',array(':g'=>$match->tournament_group_id,':p'=>$score->player_id_1));
                $groupPosition2 = TournamentGroupPosition::model()->find('tournament_group_id = :g and player_id = :p',array(':g'=>$match->tournament_group_id,':p'=>$score->player_id_2));

                
                $groupPositionAll = new TournamentGroupPosition;
                $groupPositionAll->tournament_group_id = $match->tournament_group_id;

                $groupPositionSoccer1 = TournamentGroupPositionSoccer::model()->find('tournament_group_position_id = ?',array($groupPosition1->id));
                $groupPositionSoccer2 = TournamentGroupPositionSoccer::model()->find('tournament_group_position_id = ?',array($groupPosition2->id));
                $tournamentGroupDetailPlayer1 = new TournamentGroupDetail;
                $tournamentGroupDetailPlayer2 = new TournamentGroupDetail;

                $group = TournamentGroup::model()->findByPk($match->tournament_group_id);

                $match->state = 3; //terminado

                $matchPlayer1->point = $score->score1;
                $matchPlayer1->state = 1;
                $matchPlayer1->tournament_match_type_id = 1;
                $matchPlayer2->point = $score->score2;
                $matchPlayer2->state = 1;
                $matchPlayer2->tournament_match_type_id = 1;
                #echo $score->score1.' '.$score->score2;die;
                $puntos = TournamentGroupPositionSoccer::model()->decidePoint($score->score1,$score->score2);
                #echo '<pre>'.print_r($puntos,true).'</pre>';die;
                #echo $puntos[1];die;
                $groupPosition1->point += $puntos[0];
                $groupPosition2->point += $puntos[1];
                #echo $groupPosition2->point;die;

                $groupPositionSoccer1->gf += $score->score1;
                $groupPositionSoccer1->gc += $score->score2;
                $groupPositionSoccer1->dg += ($score->score1-$score->score2);
                $groupPositionSoccer1->pj += 1;
                $groupPositionSoccer1->pg += ($puntos[0]>1)?1:0;
                $groupPositionSoccer1->pe += ($puntos[0]==1)?1:0;
                $groupPositionSoccer1->pp += ($puntos[0]==0)?1:0;
                
                $groupPositionSoccer2->gf += $score->score2;
                $groupPositionSoccer2->gc += $score->score1;
                $groupPositionSoccer2->dg += ($score->score2-$score->score1);
                $groupPositionSoccer2->pj += 1;
                $groupPositionSoccer2->pg += ($puntos[1]>1)?1:0;
                $groupPositionSoccer2->pe += ($puntos[1]==1)?1:0;
                $groupPositionSoccer2->pp += ($puntos[1]==0)?1:0;

                $tournamentGroupDetailPlayer1->player_id = $score->player_id_1;
                $tournamentGroupDetailPlayer1->tournament_group_id = $match->tournament_group_id;
                $tournamentGroupDetailPlayer1->point = $puntos[0];
                $tournamentGroupDetailPlayer1->state =1;

                $tournamentGroupDetailPlayer2->player_id = $score->player_id_2;
                $tournamentGroupDetailPlayer2->tournament_group_id = $match->tournament_group_id;
                $tournamentGroupDetailPlayer2->point = $puntos[1];
                $tournamentGroupDetailPlayer2->state =1;
                #echo $groupPositionSoccer2->id; die;
                if($match->save() and $matchPlayer1->save() and $matchPlayer2->save() and $groupPosition1->save() and $groupPosition2->save() and $groupPositionSoccer1->save() and $groupPositionSoccer2->save() and $tournamentGroupDetailPlayer1->save() and $tournamentGroupDetailPlayer2->save())
                {
                    #$transaction->commit();
                    #$groupPositionAll = TournamentGroupPosition::model()->findAll($criteria);
                    #echo $groupPosition1->point;die;
                    $group->changueStatus($match->state);
                    
                    if($group->phase->session->tournament->tournament_class_id == 1) // Si es torneo presencial, si se deasigna la consola
                    $unassignConsole = $match->unassignConsole();


                    #$total = count($groupPositionAll);
                    #echo $groupPosition2->point;die;
                    #if($group->save())
                    if($group->save() and $unassignConsole)
                     {
                        Yii::app()->historical->set($match,"Marcador Partido",'Se registra marcador para el partido id '.$match->id.' del torneo '.$match->tournamentGroup->phase->session->tournament->name.' con los marcadores -  '.$match->tournamentMatchDetail[0]->player->username.' : '.$match->tournamentMatchDetail[0]->point.' '.$match->tournamentMatchDetail[1]->player->username.' : '.$match->tournamentMatchDetail[1]->point);
                        $transaction->commit();
                        Yii::app()->user->setFlash('success','Se registró el marcador.');    
                     }   
                    else
                    {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('danger','No se pudo registrar el marcador.');   
                    }    
                }
                else
                {
                    #print_r($matchPlayer2->getErrors());die; 
                    $transaction->rollback();
                    Yii::app()->user->setFlash('danger','No se pudo registrar el marcador. Error en alguna tabla.');   
                }
            }
            
        }

        catch(Exception $e)
        {
            $transaction->rollback();
            Yii::app()->user->setFlash('danger',$e->getMessage());   
        }
    }

    /*
    Validar vista de los partidos de grupo
    */
    private function validateViewMatchs($model)
    {
        if($model->phase->number == 1)
            return 'match';
        else if($model->phase->number == 2)
            return 'match_play_off';
        else if($model->phase->number == 3 or $model->phase->number == 4)
            return 'match_final_phases';
        else if($model->phase->number == 5)
            return 'match_final_sessions';
    }

    /*
    Validar vista de los grupos de fase
    */
    private function validateViewGroups($model)
    {
        if($model->number == 1) //Etapa de Grupos
            return 'groups';
        else if($model->number == 2) //Etapa eliminatorias
            return 'groups_play_off';
        else if($model->number == 3 or $model->number == 4) //Etapa Final de Fases
            return 'groups_play_off';
        else if($model->number == 5) //Etapa final de Sesiones
            return 'groups';
    } 



    public function actionPrueba()
    {
        if((-1)>(-2))
            echo 1;
        else 
            echo 0;
        die;
    }
    /*
    Cambiar estado - acctiones de cada partido
    */
    public function actionMatchStatus()
    {
        if(isset($_GET['id_match']) and isset($_GET['state'])){
            $model = TournamentMatch::model()->findByPk($_GET['id_match']);
            $model->state = $_GET['state'];
            $model->save();

            //Si todos los partidos estan activos y algun partido cambio a estado en juego, el torneo tambien cambia estado en juego.
            $group = TournamentGroup::model()->findByPk($model->tournament_group_id);
            $group->changueStatus($model->state);
            $group->save();

            $this->redirect(array('match','id'=>$model->tournament_group_id));
        }

    }

    /*
    Resumen del torneo
    */
    public function actionSummary($id)
    {
        $this->layout = "create";
        $model = Tournament::model()->findByPk($id);
        $inscritos = count($model->tournamentPlayersSignedUp);
        $totalConfigurado = $model->tournamentDetail->amount*$model->tournamentDetail->players;
        
        $ejecutar = ($inscritos==$totalConfigurado)?1:0;
        $creado = ($model->tournamentSessions)?1:0;

        $this->render('summary',array(
            'model'=>$model,
            'inscritos'=>$inscritos,
            'totalConfigurado'=>$totalConfigurado,
            'ejecutar'=>$ejecutar,
            'creado'=>$creado,
            ));
    }

    /*
    Construcción del Torneo - Grupos, Sesiones y Fases
    */
    public function actionBuildTournament($id)
    {
        $tournament = Tournament::model()->findByPk($id);
        if($tournament)
        {  
            if(!$tournament->tournamentSessions)
            {
                $players = TournamentPlayer::model()->getDrawTournament($tournament);//Jugadores del torneo ya sorteados de posición
                $z = 0; //Variable funcional para el arreglo de los jugadores, contador por cada sesión - esta variable es continua y no se reincia
                $sessions = $tournament->tournamentDetail->sessions;
                $consols = explode(',', $tournament->consoles);
                #echo count($consols);die;
                #echo $sessions;die;
                $cantGroups = ($tournament->tournamentDetail->amount/count($consols))/$sessions;
                #echo $cantGroups;die;
                
                #echo '<pre>'.print_r($players,true).'</pre>';die;

                if($players != null)
                {
                    #echo '<pre>'.print_r($players,true).'</pre>';die;
                    $inicio = $tournament->start_date;//Constante de inicio del torneo
                    #$playersConsole1 = $players[0];
                    #$playersConsole2 = $players[1];
                    #echo '<pre>'.print_r($playersConsole1,true).'</pre>';
                    #echo '<pre>'.print_r($playersConsole2,true).'</pre>';die;   

                    
                    $transaction = Yii::app()->db->beginTransaction();
                    try
                    {
                        $bandera = 1; //Indicador para saber si se guarda o no todo el torneo  
                        //Se crean las 3 Sesiones
                        for($i=1;$i<=$sessions;$i++)
                        {
                            $sesion = new TournamentSession;
                            $sesion->name = 'Sesión '.$i;
                            $sesion->tournament_id = $tournament->id;
                            $sesion->state = 1;    
                            if($sesion->save())
                            {
                                //Se crean las fases (1 por cada consola en 1 sesión)
                                $con = 1;//variable contadora para el coordinador
                                for($j=1;$j<=count($consols);$j++)
                                {
                                    $phase = new TournamentPhase;
                                    $phase->tournament_session_id = $sesion->id;
                                    $phase->console_id = $j;
                                    $phase->name = 'Fase '.$j;
                                    $phase->number = 1;
                                    $phase->state = 1;
                                    if($phase->save())
                                    {
                                        //Se crean los grupos de cada fase
                                        #echo $cantGroups;die;
                                        $t = 0; //Variable para los jugadores, contador por cada fase
                                        $countGroupsConsole = 0;//Variable funcional para asignacion de tiempos de los partidos - cuenta 1 por cada grupo creado
                                        $inicioG = $inicio;
                                        for($k=1;$k<=$cantGroups;$k++)
                                        {
                                            $coordinators = UserRrhh::model()->getCoordinatorsTournament();
                                            $playersGroup = array();
                                            #echo '<pre>'.print_r($coordinators,true).'</pre>';die;
                                            $tournamentGroup = new TournamentGroup;
                                            $tournamentGroup->name = $tournament->type->name.' '.$tournamentGroup->getLabelName($k);
                                            $tournamentGroup->tournament_phase_id = $phase->id;
                                            $tournamentGroup->tournament_coordinator_id = $coordinators[$con];
                                            $tournamentGroup->state = 1;

                                            if($tournamentGroup->save())
                                            {

                                                $countGroupsConsole++;
                                               
                                                if($tournament->tournament_class_id == 1)//Presencial
                                                    $inicioG = TournamentMatch::model()->calculateDate($countGroupsConsole,$inicioG); //valida si incio debe cambiar - Despues de haber terminado los grupos en N consolas
                                                else
                                                    $inicioG = null;
                                                    
                                                $dateM = $inicioG;
                                                #if($j==1)//Si la fase es 1 (primera), se ingresan jugadores de la consola 1 (ps4)
                                                $playersM = $players[$j-1];
                                                #else if($j==2)//Si la fase es 2 (segunda), se ingresan jugadores de la consola 2 (xbox One)
                                                    #$playersM = $playersConsole2;
                                                #echo '<pre>'.print_r($playersM,true).'</pre>';die;
                                                //se crean los jugadores del grupo.
                                                for($c=0;$c<$tournament->tournamentDetail->players;$c++)
                                                {

                                                    $playersGroup[] = $playersM[$z+$t];
                                                    #echo '<pre>'.print_r($playersGroup,true).'</pre>';die;
                                                    $tournamentGroupPosition = new TournamentGroupPosition;
                                                    $tournamentGroupPosition->tournament_group_id = $tournamentGroup->id;
                                                    $tournamentGroupPosition->player_id = $playersM[$z+$t];
                                                    $tournamentGroupPosition->point = 0;
                                                    $tournamentGroupPosition->position = $c+1;
                                                    #echo $tournamentGroupPosition->position; die;
                                                    #echo 'No ha grabado torunament group position';die;
                                                    if($tournamentGroupPosition->save())
                                                    {
                                                        #echo "hola";die;
                                                        #echo $tournamentGroupPosition->id;die;
                                                        $tournamentGroupPositionSoccer = new TournamentGroupPositionSoccer;
                                                        $tournamentGroupPositionSoccer->tournament_group_position_id = $tournamentGroupPosition->id;
                                                        $tournamentGroupPositionSoccer->gf = 0;
                                                        $tournamentGroupPositionSoccer->gc = 0;
                                                        $tournamentGroupPositionSoccer->dg = 0;
                                                        $tournamentGroupPositionSoccer->pj = 0;
                                                        $tournamentGroupPositionSoccer->pg = 0;
                                                        $tournamentGroupPositionSoccer->pe = 0;
                                                        $tournamentGroupPositionSoccer->pp = 0;
                                                        $tournamentGroupPositionSoccer->state = 1;

                                                        if(!$tournamentGroupPositionSoccer->save())
                                                            $bandera = 0;   

                                                        #echo $tournamentGroupPositionSoccer->id;die;
                                                    }
                                                    else
                                                        $bandera = 0; 
                                                    #echo $bandera;die;
                                                    $t++;  
                                                }  
                                                #echo '<pre>'.print_r($playersGroup,true).'</pre>';die;  
                                                #echo 'pasas tournament group position';die;
                                                //Se crean los partidos del grupo - 6 partidos (3 rondas de 2 partidos)
                                                /*
                                                $matchs = array(
                                                    1 => array(0,1),
                                                    2 => array(2,3),
                                                    3 => array(0,2),
                                                    4 => array(1,3),
                                                    5 => array(0,3),
                                                    6 => array(1,2),
                                                    );//Como se juegan los partidos
                                                */
                                                $playersTotal = count($players[0])/$tournament->tournamentDetail->amount;    
                                                /*
                                                if($k==2)
                                                {
                                                    echo '<pre>'.print_r($playersGroup,true).'</pre>';
                                                    die;    
                                                }
                                                */
                                                
                                                #echo '<pre>'.print_r($players,true).'</pre>';die;
                                                $matchs = $this->scheduleMatchs($playersGroup);    
                                                $pT = (count($playersTotal)%2==0)?($playersTotal-1):(($playersTotal-1)/2); //calcular partidos por ronda
                                                #echo $playersTotal;die;
                                                #echo '<pre>'.print_r($matchs,true).'</pre>';die;
                                                $journeys = ($playersTotal*($playersTotal-1))/2; //Cantidad de partidos a jugar - formula algoritmo de selección
                                                #echo $journeys;die;
                                                $groupsRoundTrip = $tournament->tournamentDetail->group_roundtrip;//partidos ida y vuelta en face de grupos
                                                $groupsRoundTrip = ($groupsRoundTrip)?2:1;
                                                #echo $journeys;die;
                                                for($tt=1;$tt<=$groupsRoundTrip;$tt++)
                                                {
                                                    $p=1;//variable para las rondas
                                                    $groupsRoundTripText = ($tt==1)?'Ida':'Vuelta';
                                                    for($m=1;$m<=$journeys;$m++)
                                                    {
                                                        $tournamentMatch = new TournamentMatch;
                                                        $tournamentMatch->name = 'Ronda '.$p.' - '.$groupsRoundTripText.'Partido '.$m;
                                                        $tournamentMatch->tournament_group_id = $tournamentGroup->id;
                                                        $tournamentMatch->date = $dateM;
                                                        $tournamentMatch->state = 1;

                                                        if($tournamentMatch->save())
                                                        {
                                                            #echo $m-1;die;
                                                            #echo $matchs[$m-1][0];die;
                                                            $tournamentMatchDetail = new TournamentMatchDetail;
                                                            $tournamentMatchDetail->tournament_match_id = $tournamentMatch->id;
                                                            $tournamentMatchDetail->player_id = $matchs[$m-1][0];
                                                            $tournamentMatchDetail->point = 0;
                                                            $tournamentMatchDetail->tournament_match_type_id = 1;
                                                            $tournamentMatchDetail->state = 1;

                                                            $tournamentMatchDetail2 = new TournamentMatchDetail;
                                                            $tournamentMatchDetail2->tournament_match_id = $tournamentMatch->id;
                                                            $tournamentMatchDetail2->player_id = $matchs[$m-1][1];
                                                            $tournamentMatchDetail2->point = 0;
                                                            $tournamentMatchDetail2->tournament_match_type_id = 1;
                                                            $tournamentMatchDetail2->state = 1;

                                                            if(!$tournamentMatchDetail->save() OR !$tournamentMatchDetail2->save())
                                                                $bandera = 0;  
                                                        } 
                                                        else
                                                            $bandera = 0;  
                                                        #echo $pT;die;
                                                        if($m%$pT==0)
                                                            $p++;
                                                        #echo $p;die;
                                                        //Para cada partido se agrega 15 min
                                                        //Validamos tambien si el partido es presencial, para los torneos online los jugadores agendan sus fechas
                                                        if($tournament->tournament_class_id == 1)//Presencial
                                                        {
                                                            $dateMatch = new DateTime($dateM);
                                                            $dateMatch->add(new DateInterval('PT15M'));
                                                            $dateM = $dateMatch->format('Y-m-d H:i:s');
                                                            #echo $inicio;die;    
                                                        }
                                                    }  
                                                }    
                                                    
                                                #echo $m;die;
                                            }
                                            else
                                                $bandera = 0;
                                        }
                                        #echo $k;die;
                                    }    
                                    else
                                        $bandera = 0;    

                                    $con++;
                                }
                                $z = $z + ($tournament->tournamentDetail->players*$cantGroups);    

                                //Por cada sesion, $inicio se suman las horas que demora la sesion - 4 horas
                                $dateInicio = new DateTime($inicio);
                                $dateInicio->add(new DateInterval('PT240M'));
                                $inicio = $dateInicio->format('Y-m-d H:i:s');
                            }    
                            else
                                $bandera = 0;
                        }

                        //Se finaliza el proceso de construcción del torneo
                        if($bandera)
                        {
                            $transaction->commit();
                            Yii::app()->user->setFlash('success','Se construyó el Torneo.');
                        }    
                        else
                        {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('danger','No se construyó el Torneo.');
                        } 

                        $this->redirect(array('index'));   
                    }
                    catch(Exception $e)
                    {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('danger',$e->getMessage());   
                    }                  
                    
                    
                }
                else
                    Yii::app()->user->setFlash('danger','Los jugadores totales configurados no son iguales a los totales inscritos.');
            }    
            else
                Yii::app()->user->setFlash('danger','Ya esta creadó todo el torneo.'); 
        }
        else
            Yii::app()->user->setFlash('danger','No se encuentra el Torneo.');
            
        $this->redirect(array('index')); 
    }

    private function scheduleMatchs($players)
    {
        $matchs = array();
        #echo '<pre>'.print_r($players,true).'</pre>';die;

        foreach($players as $k){
            foreach($players as $j){
                if($k == $j){
                    continue;
                }
                $z = array($k,$j);
                sort($z);
                if(!in_array($z,$matchs)){
                        $matchs[] = $z;
                }
            }
        }

        #echo '<pre>'.print_r($matchs,true).'</pre>';die;
        return $matchs;
    }

    public function actionPruebaSorteo()
    {
        $rand = range(1, 40); 
        shuffle($rand); 
        foreach ($rand as $val) { 
            echo $val . '<br />'; 
        }
        die;
    }

    public function actionPruebaFechaPartido()
    {
        $dateMatch = new DateTime('2017-12-31 09:00:00');
        $dateMatch->add(new DateInterval('PT15M'));
        echo $dateMatch->format('Y-m-d H:i:s');
        die;
    }

    public function actionPruebaTextoPartidos()
    {
        $p=1;
        $playersGroup = array(36,78,56,45);
        $matchs = array(
        1 => array(0,1),
        2 => array(2,3),
        3 => array(0,2),
        4 => array(1,3),
        5 => array(0,3),
        6 => array(1,2),
        );//Como se juegan los partidos

        for($m=1;$m<=6;$m++)
        {
            echo 'Ronda '.$p.'Partido '.$m.'<br>';
            echo $playersGroup[$matchs[$m][0]].' vs '.$playersGroup[$matchs[$m][1]].'<br>';
            if($m%2==0)
                 $p++;
        }  
    }

    /*
    Registro cuando el usuario ya esta en el sitio del torneo. 
    */
    public function actionCheckin($id)
    {
        $this->layout = "main";
        $tournament = Tournament::model()->findByPk($id);
        $checkinForm = new CheckInForm;

        if(isset($_POST['CheckInForm']))
        {
            $checkinForm->attributes = $_POST['CheckInForm'];
            if($checkinForm->validate())
            {
                $tournamentPlayer = TournamentPlayer::model()->find('player_id = ?',array($checkinForm->player_id)); 
                #echo $tournamentPlayer->id;die;
                $tournamentPlayer->state = 3;
                if($tournamentPlayer->save())
                    Yii::app()->user->setFlash('success','Se registró el usuario.');
                else   
                    Yii::app()->user->setFlash('danger','No se pudo registrar el usuario.'.print_r($tournamentPlayer->getErrors(),true).' '.$tournamentPlayer->player_id);
            }    
            
        }

        //Consulta jugadores registrados
        $criteria = new CDbCriteria;
        $criteria->condition = 't.tournament_id = '.$tournament->id.' and t.state = 3';
        $criteria->join = "
                INNER JOIN player p ON p.id = t.player_id
        ";
        $criteria->select = "t.player_id, concat(p.name,p.surname) names, p.username username";
        $criteria->order = "p.name ASC";
        $checkin = TournamentPlayer::model()->findAll($criteria);

        $this->render('checkin',array(
            'checkin'=>$checkin,
            'model'=>$tournament,
            'checkinForm'=>$checkinForm,
            ));
    }

    /*
    Consolas a utilizar en el torneo. Pueden ser 10 de que cada tipo, cada una se asignara a un grupo.
    */
    public function actionConsoles($id)
    {
        $this->layout = "main";
        $tournament = Tournament::model()->findByPk($id);
        $consoleForm = new ConsoleForm;

        if(isset($_POST['ConsoleForm']))
        {
            $consoleForm->attributes = $_POST['ConsoleForm'];
            if($consoleForm->validate())
            {
                $console = new TournamentConsole;
                $console->name = $consoleForm->name;
                $console->console_id = $consoleForm->console_id;
                $console->state = 1;

                if($console->save())
                    Yii::app()->user->setFlash("success","Se creó la Consola.");
                else
                    Yii::app()->user->setFlash("danger","No se pudo crear la Consola.");
            }
        }

        $model = TournamentConsole::model()->findAll();

        $this->render('consoles',array(
            'model'=>$model,
            'consoleForm'=>$consoleForm,
            'tournament'=>$tournament,
            ));
    }

    /*
    Gestion de los ganadores del torneo
    */
    public function actionWinners($id)
    {
        $this->layout = "main";
        $tournament = Tournament::model()->findByPk($id);
        $winnersForm = new WinnersForm;
        
        $winnersUserForm = new WinnersUserForm;
        $winnersUserForm->tournament_id = $tournament->id;

        if(isset($_POST['WinnersForm']))
        {
            $winnersForm->attributes = $_POST['WinnersForm'];
            if($winnersForm->validate())
            {
                $winners = new TournamentWinners;
                $winners->percent = $winnersForm->percent;
                $winners->position = $winnersForm->position;
                $winners->state = 0;
                $winners->tournament_id = $tournament->id;

                if($winners->save())
                    Yii::app()->user->setFlash("success","Se creó el ganador.");
                else
                    Yii::app()->user->setFlash("danger","No se pudo crear el ganador, ya existe la posicion o esta la suma de los porcentajes es mayor al 100%.");
            }
        }

        $model = TournamentWinners::model()->findAll('tournament_id = ?',array($tournament->id));

        $this->render("winners",array(
            'model'=>$model,
            'tournament'=>$tournament,
            'winnersForm'=>$winnersForm,
            'winnersUserForm'=>$winnersUserForm
        ));
    }  

    /*
    Asignar Consola al grupo - fase 1
    */
    public function actionAssignConsoleG()
    {
        if( (isset($_POST['TournametConsoleForm']['console_id']) and $_POST['TournametConsoleForm']['console_id']!='') and (isset($_POST['group_id']) and $_POST['group_id']!=''))
        {
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                $tournamentGroup = TournamentGroup::model()->findByPk($_POST['group_id']);
                $tournamentGroupConsole = TournamentConsole::model()->findByPk($_POST['TournametConsoleForm']['console_id']);
                if($tournamentGroup and $tournamentGroupConsole)
                {
                    $tournamentGroup->tconsole_id = $_POST['TournametConsoleForm']['console_id'];
                    $tournamentGroupConsole->state = 2;

                    if($tournamentGroupConsole->save() and $tournamentGroup->save())
                    {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success','Se asingó la consola al grupo.');
                        $this->redirect(array('groups','id'=>$tournamentGroup->phase->id));
                    }
                }
            }
            catch(Exception $e)
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('danger',$e->getMessage());   
            }
        }   
        else
            Yii::app()->user->setFlash('danger','No se enviaron los datos correctos.');

        $this->redirect(array('index'));
    }

    /*
    Asignar Consola al partido - Eliminatorias y Finales
    */
    public function actionAssignConsoleM()
    {
        if( (isset($_POST['TournametConsoleForm']['console_id']) and $_POST['TournametConsoleForm']['console_id']!='') and (isset($_POST['match_id']) and $_POST['match_id']!=''))
        {
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                $tournamentMatch = TournamentMatch::model()->findByPk($_POST['match_id']);
                $tournamentMatchConsole = TournamentConsole::model()->findByPk($_POST['TournametConsoleForm']['console_id']);
                if($tournamentMatch and $tournamentMatchConsole)
                {
                    $tournamentMatch->tconsole_id = $_POST['TournametConsoleForm']['console_id'];
                    $tournamentMatchConsole->state = 2;

                    if($tournamentMatchConsole->save() and $tournamentMatch->save())
                    {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success','Se asingó la consola al partido.');
                        $this->redirect(array('match','id'=>$tournamentMatch->tournament_group_id));
                    }
                }
            }
            catch(Exception $e)
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('danger',$e->getMessage());   
            }
        }   
        else
            Yii::app()->user->setFlash('danger','No se enviaron los datos correctos.');

        $this->redirect(array('index'));
    }

    public function actionAssignWinner()
    {
        if( isset($_POST['winnersUserForm']['tournament_id']) and isset($_POST['winnersUserForm']['player_id']) and isset($_POST['position_id']) )
        {
            $tournamentId = $_POST['winnersUserForm']['tournament_id'];
            $tournamentPlayerId = $_POST['winnersUserForm']['player_id'];
            $position = $_POST['position_id'];
            $tournamentPLayer = TournamentPlayer::model()->find('tournament_id = ? and player_id ?',array($tournamentId, $tournamentPlayerId));

            if($tournamentPlayer)
            {
                $tournamentWinner = TournamentWinners::model()->find('tournament_id = ? and position = ?',array($tournamentId,$position));
                if($tournamentWinner)
                {
                    if($tournamentWinner->player_id == null)
                    {
                        $tournamentWinner->player_id = $tournamentPlayerId;

                        if($tournamentWinner->save()){
                            Yii::app()->user->setFlash('success','Se registró el ganador.');            
                            $this->redirect(array('winners','id'=>$tournamentId));
                        }
                        else{
                            Yii::app()->user->setFlash('danger','Error al registrar el ganador.');
                        }
                    }
                    else{
                        Yii::app()->user->setFlash('danger','Ya hay registrado un jugador ganador para esta posición.');
                    }
                }
                else{
                    Yii::app()->user->setFlash('danger','No hay registro de ganador para esta posición.');
                }
            }
            else{
                Yii::app()->user->setFlash('danger','El usuario no esta registrado en el torneo.');
            }
        }

        $this->redirect(array('index'));
    }

    public function actionPayment($id)
    {
        $this->layout = "main";
        $model = Tournament::model()->findByPk($id);
        $tournamentPlayer = new TournamentPlayer;
        $tournamentPlayer->tournament_id = $model->id;
        $tournamentPlayer->state = 1; //Pendiente de Validación

        $this->render("payment",array(
            'model'=>$model,
            'tournamentPlayer'=>$tournamentPlayer,
            ));
    }

    /*
    Aprobar el pago y gestionar la inscripcioón - Se valida si el torneo es presencial o online.
    Online -> el jugador queda inscrito y podrá jugarlo con el estado 2, con este estado el jugador podrá jugar sus partidos.
    Presencial -> el jugador queda inscirto con el estado 2, si son de varias consolas, el jugador debera seleccionar una consola y habrá el estado 5 cuando el jugador selecciona la consola, y el estado 3 cuando el jugador esta en el lugar del torneo y hace checking y entra al lugar para jugar, este quedará con el estado 3, solo con el estado 3 el jugador podrá jugar sus partidos
    */
    public function actionApprovedPayment($id)
    {
        $model = TournamentPlayer::model()->findByPk($id);
        $consolas = array();

        if($model)
        {
            $tournament = Tournament::model()->findByPk($model->tournament_id);
            $consolas = explode(',', $tournament->consoles);

            if($tournament->tournamentClass->id == 1)// presencial
            {
                if(count($consolas) == 1) //Si solo es una consola, pues no tiene necesidad de seleccionar consola
                {
                    $model->state = 5;
                    $model->console_id = $consolas[0];
                }
                else if(count($consolas) > 1)
                    $model->state = 2; //Inscrito
            }
            else if($tournament->tournamentClass->id == 2)// online
            {
                $model->state = 2; //Inscrito
            }
            
            if($model->save())
            {
                Yii::app()->user->setFlash("success","Se aprobo el pago, y el usuario ya esta inscrito al torneo.");
                //Envio de correo de notificasion al usuario
            }    
            else
                Yii::app()->user->setFlash("danger","No se pudo aprobar el pago. Error al actualizar el registro.");        
        }
        else
            Yii::app()->user->setFlash("danger","No se pudo aprobar el pago. El id no existe.");

        $this->redirect(array("payment","id"=>$model->tournament_id));
    }

    public function actionDenyPayment($id)
    {
        $model = TournamentPlayer::model()->findByPk($id);

        if($model)
        {
            $model->state = 4; //Inscrito
            if($model->save())
            {
                Yii::app()->user->setFlash("success","Se denego el pago.");
                //Envio de correo de notificacion al usuario
            }
            else
                Yii::app()->user->setFlash("danger","No se pudo aprobar el pago. Error al actualizar el registro.");
        }
        else
            Yii::app()->user->setFlash("danger","No se pudo aprobar el pago. El id no existe.");

        $this->redirect(array("payment","id"=>$model->tournament_id));
    }

    /*
    Cron para agendar los partidos de los torneos segun las fechas que coinciden entre los jugadores
    */
    public function actionCronMatchScheduleCoincide()
    {
        $tournament = Tournament::model()->findAll('state = 1');

        if($tournament)
        {
            $player1_matchs = array();
            $player2_matchs = array();
            $player_match = null;
            $player1 = null;
            $player2 = null;
            $commit = true;

            $transaction = Yii::app()->db->beginTransaction();

            try
            {
                foreach ($tournament as $key => $valueTournament) 
                {
                    if($valueTournament->tournamentSessions) // Si se ha creado la estructura del torneo
                    {
                        // Se hacer foreacch por cada sesion, phases, grupos y partidos
                        foreach ($valueTournament->tournamentSessions as $valueSession) 
                        {
                            echo '<br>Sesion '.$valueSession->id;
                            foreach ($valueSession->phase as $valuePhase) 
                            {
                                echo '<br>Fase '.$valuePhase->id;
                                foreach ($valuePhase->tournamentGroup as $valueGroup) 
                                {
                                    echo '<br>Grupo '.$valueGroup->id;
                                    foreach ($valueGroup->tournamentMatchs as $value) 
                                    {
                                        echo '<br>Partido '.$value->id;
                                        // se valida si el partido ya se habia agendado y si el partido aun no se ha jugado
                                        if($value->date == null and $value->state == 1)
                                        {
                                            echo '<br>No se ha jugado';

                                            //Si no son equipos
                                            #echo '<br>'.$value->tournamentMatchDetail[1]->player_id;die;
                                            $player1 = $value->tournamentMatchDetail[0]->player_id;       
                                            $player2 = $value->tournamentMatchDetail[1]->player_id;

                                            $criteria = new CDbCriteria;
                                            $criteria->condition = "state = 0 and tournament_match_id = ".$value->id;
                                            $criteria->order = 'player_id ASC';
                                            
                                            $tournamentMatchSchedule = TournamentMatchSchedule::model()->findAll($criteria);    
                                            echo '<br>Entro';
                                                                                    
                                            if($tournamentMatchSchedule)
                                            {
                                                foreach ($tournamentMatchSchedule as $key => $valueSchedule) // guardamos las fechas de cada jugador o equipo en sus respectivos arreglos
                                                {
                                                    if($player1 == $valueSchedule->player_id)
                                                        $player1_matchs[] = $valueSchedule->date_schedule;
                                                    else if($player2 == $valueSchedule->player_id)   
                                                        $player2_matchs[] = $valueSchedule->date_schedule;
                                                }
                                                echo 'Casi entra';
                                                if(!empty($player2_matchs) and !empty($player1_matchs))
                                                {
                                                    echo '<br>Hay partidos agendados de los 2';
                                                    foreach ($player1_matchs as $valueDateSchedule1) 
                                                    {
                                                        foreach ($player2_matchs as $valueDateSchedule2) 
                                                        {
                                                           if($valueDateSchedule1 == $valueDateSchedule2) // si hay fecha que coincidan, rompe los 2 foreach
                                                           {
                                                                echo '<br>Si hay partido que coincidan';
                                                                $player_match = $valueDateSchedule1;
                                                                break;
                                                           }
                                                        }

                                                        if($player_match) // si hay fecha que coincidan, rompe los 2 foreach
                                                            break;
                                                    }
                                                    #echo $player_match;die;
                                                    // Se actualiza fecha de coincidencia para el partido
                                                    if($player_match)
                                                    {
                                                        $tournamentMatch = TournamentMatch::model()->findByPk($value->id);
                                                        $tournamentMatch->date = $player_match;

                                                        if($tournamentMatch->save())
                                                        {
                                                            echo '<br>Se guarda fecha de partido';
                                                            Yii::app()->historical->set($tournamentMatch,"Agendar Partido","Se agenda el partido con la fecha ".$tournamentMatch->date." que coincide con los jugadores");
                                                        }  

                                                        $player_match = null;
                                                    }
                                                }

                                                $player1_matchs = array();
                                                $player2_matchs = array();
                                            }  

                                            $player1 = null;
                                            $player2 = null;    
                                        }
                                    }
                                }   
                            }
                        }
                    }
                }
                    

                $transaction->commit();
            }
            catch(Exception $e)
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('danger',$e->getMessage());   
            }    

            
        }
    }
}