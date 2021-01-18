<?php
class GestionController extends Controller
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
                'actions'=>array('index','view','calendario','noticias','inscripcion','pagoInscripciones','registerConsole','getCalendarioAgenda','sesion','fase','grupos','partidos','players','postSN','agendarPartido','registroAgendarPartido','realizarCheckin','regitrarMarcador','finalizarRegistroMarcador','noRegistrarMarcador'),
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

    public function notAllowTest()
    {
        $id = $_GET['id'];
        $model = Tournament::model()->findByPk($id);

        if($model)
        {
            if($model->test)
                return false;
            else 
                return true;
        }
        else 
            return false;
    }

    /*
    Torneos - Solo se muestran las padres
    */
    public function actionIndex()
    {
        /*
        Yii::app()->cache->flush();
        // Load all tables of the application in the schema
        Yii::app()->db->schema->getTables();
        // clear the cache of all loaded tables
        Yii::app()->db->schema->refresh();
        */

        $this->layout = "main";

        $user = Player::model()->findByPk(Yii::app()->user->id);

        $model = new Tournament;

        if($user->state == 99)
            $model->test = 1;
        else if($user->state == 1)
            $model->test = 0;

        
        $this->render('index',array(
            'model'=>$model,
            ));
    }

    /*
    Dashboard del torneo - Solo esta programado para mostrar las fases de una sola sesion
    */
    public function actionView()
    {
        $this->layout = "main";

        $inscripcionForm = new InscripcionForm;

        if(isset($_GET['id']))
        {
            $tournament = Tournament::model()->findByPk($_GET['id']);
            $tournamentPlayer = TournamentPlayer::model()->find("player_id = ?",array(Yii::app()->user->id));

            if($tournament)
            {
                if($tournament->test)
                {
                    Yii::app()->user->setFlash('danger','Acceso denegado!');
                    $this->redirect(array("index"));
                }

                $myPhases_array = array();
                $myPhases = TournamentGroupPosition::model()->findAll("player_id = ?",array(Yii::app()->user->id));
                if($myPhases)
                {
                    foreach ($myPhases as $key => $value) 
                    array_push($myPhases_array, $value->tournamentGroup->phase->id); 
                }
                
                if(isset($tournament->session[0]->id))
                {
                    $model = new TournamentPhase;
                    $model->tournament_session_id = $tournament->session[0]->id;        
                }
                else
                    $model = null;

                //Lista de jugadores
                $jugadores = TournamentPlayer::model()->getPlayerRegistered($tournament->id);

                //Red social
                $socialNetwork = SocialNetwork::model()->getPublicaciones('tournament',$tournament->id);
            }    
            else
            {
                Yii::app()->user->setFlash('danger','Torneo no existe');
                $this->redirect(array("index"));
            }
        }
        else
            $this->redirect(array("index"));

        $this->render('view',array(
            'tournament'=>$tournament,
            'myPhases_array'=>$myPhases_array,
            'jugadores'=>$jugadores,
            'socialNetwork'=>$socialNetwork,
            'inscripcionForm'=>$inscripcionForm,
            'tournamentPlayer'=>$tournamentPlayer,
            'model'=>$model
        ));
    } 

    /*
    Realizar un post en la rede social
    */
    public function actionPostSN()
    {
        if( (isset($_POST['e']) && !empty($_POST['e'])) && (isset($_POST['id']) && !empty($_POST['id'])) && (isset($_POST['comentario']) && !empty($_POST['comentario'])) )
        {
            $entity = $_POST['e'];
            $entity = SocialNetwork::model()->definitEntidad($entity);

            $id = $_POST['id'];
            $comments = $_POST['comentario'];

            $javascript = '/<script[^>]*?>.*?<\/script>/si';  //Expresión regular buscará todos los códigos Javascripts
            $comentario = preg_replace($javascript,'xxxxxxxx',$comments);

            $model = new SocialNetwork;
            $model->entity = $entity;
            $model->entity_id = $id;
            $model->comments = htmlentities($comentario);
            $model->published = date('Y-m-d H:i:s');
            $model->player_id = Yii::app()->user->id;
            $model->father = 0;

            if($model->save())
            {
                Yii::app()->user->setFlash("success","Se realizó la publiación");

                $vista = SocialNetwork::model()->definirVista($entity,$id);
                if($id == 0)
                    $this->redirect(array($vista));
                else
                    $this->redirect(array($vista,'id'=>$id));
            }
            else
                Yii::app()->user->setFlash("danger","No se pudo registrar el mensaje.");

        }   

        $this->redirect(array("index"));
    }

    /*
    Lista de jugadores del torneo
    */
    public function actionPlayers($id)
    {
        $this->layout = "main";

        if(isset($id))
        {
            $players = TournamentPlayer::model()->findAll('tournament_id = ?',array($id));
            $tournament = Tournament::model()->findByPk($id);
        }
        else
            $this->redirect(array("index"));

        $this->render("players",array(
            'players'=>$players,
            'tournament'=>$tournament,
        ));
    }

    /*
    Fases - divisiones del torneo 
    */
    public function actionSesion()
    {
        $this->layout = "main";


        if(isset($_GET['id']))
        {   
            $mySessions_array = array();
            $mySessions = TournamentGroupPosition::model()->findAll("player_id = ?",array(Yii::app()->user->id));
            foreach ($mySessions as $key => $value) {
                array_push($mySessions_array, $value->tournamentGroup->phase->session->id); 
            }
            #echo '<pre>'.print_r($mySessions_array,true).'</pre>';die;
            #echo in_array((63), $mySessions_array);die;

            $tournament = Tournament::model()->findByPk($_GET['id']);

            if($tournament->test)
            {
                Yii::app()->user->setFlash('danger','Acceso denegado!');
                $this->redirect(array("index"));
            }

            $model = new TournamentSession;
            $model->tournament_id = $_GET['id'];
        }
        else 
            $this->redirect(array('index'));

        //Si solo hay una sesion, que lo lleve directamente a las fases
        if(count($tournament->session)==1)
            $this->redirect(array('fase','id'=>$tournament->session[0]->id)); 

        $this->render('sesion',array(
            'model'=>$model,
            'tournament'=>$tournament,
            'mySessions_array'=>$mySessions_array,
            ));
    }

    /*
    Fases - divisiones del torneo 
    */
    public function actionFase()
    {
        $this->layout = "main";

        $nextPhase = null;

        if($_GET['id'])
        {   
            $myPhases_array = array();
            $myPhases = TournamentGroupPosition::model()->findAll("player_id = ?",array(Yii::app()->user->id));
            foreach ($myPhases as $key => $value) {
                array_push($myPhases_array, $value->tournamentGroup->phase->id); 
            }

            $session = TournamentSession::model()->findByPk($_GET['id']);

            //Validar si el torneo es de prueba
            if($session->tournament->test)
            {
                Yii::app()->user->setFlash('danger','Acceso denegado!');
                $this->redirect(array("index"));
            } 

            $model = new TournamentPhase;
            $model->tournament_session_id = $session->id;
        }
        else 
            $this->redirect(array('index'));

        $this->render('fase',array(
            'model'=>$model,
            'session'=>$session,
            'myPhases_array'=>$myPhases_array,
            ));
    }

    /*
    Grupos - datos de los grupos
    */
    public function actionGrupos()
    {
         $this->layout = "main";

        if($_GET['id'])// si envia el id del grupo
        {   
            $phase = TournamentPhase::model()->findByPk($_GET['id']);
            $model = TournamentGroup::model()->findAll('tournament_phase_id = ?',array($_GET['id']));

            if($phase->session->tournament->test)
            {
                Yii::app()->user->setFlash('danger','Acceso denegado!');
                $this->redirect(array("index"));
            }

            if($phase->number > 1)
                $this->redirect(array('partidos','id'=>$model[0]->id));
        }
        else 
            $this->redirect(array('index'));

        //validar vista
        $vista = $this->validateViewGroups($phase);

        $this->render($vista,array(
            'model'=>$model,
            'phase'=>$phase,
            ));
    }

    /*
    Validar vista de los grupos de fase
    */
    private function validateViewGroups($model)
    {
        if($model->number == 1) //Etapa de Grupos
            return 'grupos';
        else if($model->number == 2) //Etapa eliminatorias
            return 'grupos_eliminatorias';
        else if($model->number == 3 or $model->number == 4) //Etapa Final de Fases
            return 'grupos_eliminatorias';
        else if($model->number == 5) //Etapa final de Sesiones
            return 'grupos';
    } 

    /*
    Grupos - datos de los grupos
    */
    public function actionPartidos()
    {
        $this->layout = "main";

        //Consultar partidos
        if($_GET['id'])
        {
            $model = TournamentGroup::model()->findByPk($_GET['id']);
            $matchs = TournamentMatch::model()->findAll(" tournament_group_id = ? ",array($_GET['id']));

            if($model && $matchs)
            {
                if($model->phase->session->tournament->test)
                {
                    Yii::app()->user->setFlash('danger','Acceso denegado!');
                    $this->redirect(array("index"));
                }      
            }    
            else 
                $this->redirect(array('index'));
        }    
        else 
            $this->redirect(array('index'));

        //validar vista
        $vista = $this->validateViewMatchs($model);

        $this->render($vista,array(
            'model'=>$model,
            'matchs'=>$matchs,
            ));
    }

    /*
    Agendar fechas de los partidos
    */
    public function actionAgendarPartido()
    {
        $this->layout = "main";

        if(isset($_GET['id']))
        {
            $match = TournamentMatch::model()->findByPk($_GET['id']);

            if($match)
            {
                $is_player = false; //variable bandera, comprobar si el usuario es del partido
                $plaver_vs = null;

                //Validar si es jugador de partido
                foreach($match->tournamentMatchDetail as $key => $value) 
                {
                    if($value->player_id == Yii::app()->user->id)
                        $is_player = true;
                }
                
                if(is_null($match->date))
                {
                    if($is_player) //Validar si el jugador si es del partido
                    {
                        $tournamentMatchSchedule = new TournamentMatchSchedule;
                        $tournamentMatchSchedule->tournament_match_id = $match->id;
                        $tournamentMatchSchedule->player_id = Yii::app()->user->id;

                        $matchScheduleForm = new MatchScheduleForm;
                        $matchScheduleForm->tournament_match_id = $match->id;

                        foreach($match->tournamentMatchDetail as $key => $value) 
                        {
                            if($value->player_id != Yii::app()->user->id)
                                $plaver_vs = $value->player_id;
                        }

                        $tournamentMatchScheduleVs = new TournamentMatchSchedule;
                        $tournamentMatchScheduleVs->tournament_match_id = $match->id;
                        $tournamentMatchScheduleVs->player_id = $plaver_vs;

                    }
                    else
                    {
                        Yii::app()->historical->set($match,"Agendar","Se registra ingreso indebido para agendar el partido id ".$match->id.' -  por el usuario id: '.Yii::app()->user->id); // se debe registrar el intento de agendar de un usuario permitido
                        Yii::app()->user->setFlash('danger','Usted no es jugador del partido.');
                        $this->redirect(array('index'));
                    }    
                }  
                else   
                {
                    Yii::app()->user->setFlash('danger','Ya ha sido agendado.');
                    $this->redirect(array('index'));
                }
                    
            }
            else
            {
                Yii::app()->user->setFlash('danger','No se encontró el partido.');
                $this->redirect(array('index'));
            }
        }
        else
            $this->redirect(array('index'));

        $this->render('agendar_partidos',array(
            'tournamentMatchSchedule'=>$tournamentMatchSchedule,
            'tournamentMatchScheduleVs'=>$tournamentMatchScheduleVs,
            'matchScheduleForm'=>$matchScheduleForm,
            'match'=>$match,
        )); 
    }

    public function actionRealizarCheckin()
    {
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            $matchDetail = TournamentMatchDetail::model()->find('tournament_match_id = ? and player_id = ?',array($id, Yii::app()->user->id));
            $matchDetail2 = TournamentMatchDetail::model()->find('tournament_match_id = ? and player_id != ?',array($id, Yii::app()->user->id)); #segundo jugador
            $match = TournamentMatch::model()->findByPk($id);

            if($matchDetail)
            {
                if($matchDetail->state == 1)
                {
                    $matchDetail->state = 2; //estado check-in

                    if($matchDetail2->state == 2) // si el otro jugador tambien hizo check-in, el partido se actualiza a estado "en juego"
                        $match->state = 2;

                    if($matchDetail->save() && $match->save())
                    {
                        Yii::app()->historical->set($matchDetail,"Check-in Partido","Se realiza Check-in el jugador :".Yii::app()->user->id." para el partido id:".$id);   
                        Yii::app()->user->setFlash('success','Se hizo Check-in');
                        $this->redirect(array('partidos','id'=>$matchDetail->match->tournament_group_id));
                    }    
                }   
                else
                    Yii::app()->user->setFlash('danger','Ya se hizo Check-in o ya se jugó el partido');
            }
            else
                Yii::app()->user->setFlash('danger','No se pudo hacer Check-In');
        }

        $this->redirect(array('index'));            
    }

    public function actionRegitrarMarcador()
    {
        $this->layout = "main";

        if(isset($_GET['id']))
        {
            $match = TournamentMatch::model()->findByPk($_GET['id']);
            $score = new MarcadorForm;

            if($match)
            {
                $is_player = false; //variable bandera, comprobar si el usuario es del partido
                $plaver_vs = null;

                //Validar si es jugador de partido
                foreach($match->tournamentMatchDetail as $key => $value) 
                {
                    if($value->player_id == Yii::app()->user->id)
                        $is_player = true;
                }
                
                if($match->state == 2)
                {
                    if($is_player) //Validar si el jugador si es del partido
                    {
                        //El partido se coloca en modo edición - esto para que el usuario adversario no pueda registrar el marcador al mismo tiempo - SOLO PARA ONLINE
                        $match->state = 5;
                        if($match->save())
                        {
                            $matchScoreForm = new MarcadorForm;
                        }
                        else   
                        {
                            Yii::app()->user->setFlash('danger','No se cambiar el estado del partido ha edición.');

                            $this->redirect(array('index'));
                        }
                        
                    }
                    else
                    {
                        Yii::app()->historical->set($match,"Marcador","Se registra ingreso indebido para registrar marcador a el partido id ".$match->id.' -  por el usuario id: '.Yii::app()->user->id); // se debe registrar el intento de agendar de un usuario permitido
                        Yii::app()->user->setFlash('danger','Usted no es jugador del partido.');
                        $this->redirect(array('index'));
                    }   
                }  
                else   
                {
                    if($match->state == 5)
                        Yii::app()->user->setFlash('danger','El partido esta en edición por tu adversario.');
                    else    
                        Yii::app()->user->setFlash('danger','No se puede registrar el marcador.');

                    $this->redirect(array('index'));
                }

            }
            else
            {
                Yii::app()->user->setFlash('danger','No se encontró el partido.');
                $this->redirect(array('index'));
            }
        }
        else
            $this->redirect(array('index'));

        $this->render('registrar_marcador',array(
            'matchScoreForm'=>$matchScoreForm,
            'match'=>$match,
            'score'=>$score,
        ));          
    }

    public function actionNoRegistrarMarcador()
    {
        if(isset($_GET['id']))
        {
            $match_id = $_GET['id'];
            $match = TournamentMatch::model()->findByPk($match_id);
            $user = false;

            if($match)
            {
                foreach ($match->tournamentMatchDetail as $value) {
                    if($value->player_id == Yii::app()->user->id)
                        $user = true;
                }
                
                if($user)
                {
                    $match->state = 2;

                    if($match->save())
                    {
                        Yii::app()->user->setFlash('success','Se habilitó el partido');
                        $this->redirect(array('partidos','id'=>$match->tournamentGroup->id));
                    }
                    else
                        Yii::app()->user->setFlash('danger','No se pudo cambiar el estado del partido');
                }
                else
                    Yii::app()->user->setFlash('danger','No eres jugador de este partido');
            }
            else
                Yii::app()->user->setFlash('danger','No se encontró el partido');
        }
        Yii::app()->user->setFlash('danger','No se envió el id del partido');

        $this->redirect(array('index'));
    }

    public function actionRegistroAgendarPartido()
    {
        if(isset($_POST['MatchScheduleForm']))
        {
            $matchScheduleForm = new MatchScheduleForm;
            $matchScheduleForm->attributes = $_POST['MatchScheduleForm'];

            //se envian es el id del select, ahora hay que convertirlo a fecha
            $fechas = $matchScheduleForm->getScheduleListDay();
            $horas = $matchScheduleForm->getScheduleListHour();
            $matchScheduleForm->day_Schedule = $fechas[$matchScheduleForm->day_Schedule];
            $matchScheduleForm->hour_Schedule = $horas[$matchScheduleForm->hour_Schedule];
            #echo $matchScheduleForm->day_Schedule;die;

            if($matchScheduleForm->validate())
            {
                $fecha = $matchScheduleForm->day_Schedule;
                $valores = explode('-', $fecha);
                #echo count($valores);die;
                #echo '<pre>'.print_r($valores,true).'</pre>';die;
                #echo checkdate($valores[1],$valores[2],$valores[0])?'true':'false';die;
                #echo $matchScheduleForm->hour_Schedule;die;


                if(count($valores) == 3 && checkdate($valores[1],$valores[2],$valores[0])) // Validar que la fecha que se haya enviado sea correcta
                {
                    $date_match = $matchScheduleForm->day_Schedule.' '.$matchScheduleForm->hour_Schedule;

                    $tournamentMatchSchedulePlayer = TournamentMatchSchedule::model()->findAll('player_id = ? and tournament_match_id = ?',array(Yii::app()->user->id, $matchScheduleForm->tournament_match_id));
                    
                    if(count($tournamentMatchSchedulePlayer) < 10)
                    {
                        $matchSchedule = new TournamentMatchSchedule;
                        $matchSchedule->tournament_match_id = $matchScheduleForm->tournament_match_id;
                        $matchSchedule->date_schedule = $date_match;
                        $matchSchedule->player_id = Yii::app()->user->id;
                        $matchSchedule->state = 0;

                        if($matchSchedule->save())
                        {
                            Yii::app()->historical->set($matchSchedule,"Agendar Partido","El usuario id ".$matchSchedule->player_id." agenda para la fecha ".$matchSchedule->date_schedule);
                            Yii::app()->user->setFlash('success','Se registró la fecha del partido.');
                            $this->redirect(array('partidos','id'=>$matchSchedule->match->tournamentGroup->id));        
                        }
                        else
                            Yii::app()->user->setFlash('danger','No se pudo guardar la fecha.');
                    }       
                    else
                        Yii::app()->user->setFlash('danger','Ya ha registrado todas sus fechas.');    
                }
                else
                    Yii::app()->user->setFlash('danger','Formato de fecha invalido');
                
            }
            else
                Yii::app()->user->setFlash('danger','Errores en los datos del formulario');
        }
        else
            Yii::app()->user->setFlash('danger','No se enivaron los datos correctos');

        $this->redirect(array('index'));
    }

    /*
    Validar vista de los partidos de grupo
    */
    private function validateViewMatchs($model)
    {
        if($model->phase->number == 1)
            return 'partidos';
        else if($model->phase->number == 2)
            return 'partidos_eliminatorias';
        else if($model->phase->number == 3 or $model->phase->number == 4)
            return 'partidos_final_fases';
        else if($model->phase->number == 5)
            return 'partidos_final_sesion';
    }

    public function actionCalendario()
    {
        $this->layout = "calendar";

        $this->render("calendario");
    }

    public function actionNoticias()
    {
        $this->layout = "news";

        $this->render("noticias");
    }    

    /*
    Lista de incripciones de los jugadores
    */
    public function actionInscripciones()
    {
        $this->layout = "main";
        $model = new TournamentPlayer;
        $model->player_id = Yii::app()->user->id;

        $this->render("inscripciones",array(
            'model'=>$model,
            ));
    } 

    /*
    Inscribirse a un torneo - despues viene el proceso de pago
    */
    public function actionInscripcion()
    {
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            $player = Yii::app()->user->id;
            $tournamentPlayer = TournamentPlayer::model()->find('tournament_id = ? and player_id = ?',array($id,$player));
            if(!$tournamentPlayer)
            {
                $newTP = new TournamentPlayer;
                $newTP->tournament_id = $id;
                $newTP->player_id = $player;
                $newTP->state = 0;

                if($newTP->save())
                    Yii::app()->user->setFlash("success","Se ha creado un proceso de Inscripción. Para continuar debes ir al menú -> Mis Inscripcesiones.");
                else
                    Yii::app()->user->setFlash("danger","No se pudo crear el proceso de inscripción.");
            }
            else
                 Yii::app()->user->setFlash("danger","Ya tienes un proceso de inscripción");

            $this->redirect(array("view",'id'=>$id)); 
        }

        $this->redirect(array("index"));
    }

    /*
    Registrar consola del jugador en inscripcion
    */
    public function actionRegisterConsole()
    {
        if(isset($_POST['InscripcionForm']['console_id']) and isset($_POST['inscripcion_id']))
        {
            $tournamentPlayer = TournamentPlayer::model()->findByPk($_POST['inscripcion_id']);
            $tournamentPlayerConsoles = TournamentPlayer::model()->findAll('tournament_id = ? and console_id = ?',array($tournamentPlayer->tournament_id,$_POST['InscripcionForm']['console_id']));
            $tournament = Tournament::model()->findByPk($tournamentPlayer->tournament_id);
            $players = $tournament->tournamentDetail->amount * $tournament->tournamentDetail->players;
            #echo $players/2;die;
            #echo count($tournamentPlayerConsoles);die;
            if($players/2 == count($tournamentPlayerConsoles)) //Validar si todavia hay cupos para la consola seleccionada
            {
                Yii::app()->user->setFlash('danger','No hay cupos disponibles para la consola seleccionada. Al haber pocos cupos, existe la posibilidad que en el proceso de pago y selección de consola, ya otros jugadores hayan seleccionado los últimos cupos de consola disponible. Por favor contactar al correo o número de contacto.');
                $this->redirect(array("inscripciones"));
            }    

            $tournamentPlayer->console_id = $_POST['InscripcionForm']['console_id'];
            $tournamentPlayer->state = 5;
            if($tournamentPlayer->save())
                Yii::app()->user->setFlash('success','Se registró la consola con que vas a jugar. Una semana antes del torneo podrás visualizar la estructura del torneo y en que grupo queaste. Gracias por ser parte de Copa de Titanes!!');    
            else
                Yii::app()->user->setFlash('danger','No se pudo registrar la consola.');    
        }
        else
            Yii::app()->user->setFlash('danger','Datos de formulario incorrectos.');

        $this->redirect(array('inscripciones'));
    }

    
    /*
    Relacionar comprobante de pago a inscripcion a los torneos.
    */
    public function actionPagoInscripciones()
    {
        global $HTTP_RAW_POST_DATA;
        
        $file = 0;
        $result = array();

        #echo  $_FILES['file']['tmp_name'];die;
        #echo var_dump($HTTP_RAW_POST_DATA); die;
        #echo var_dump(file_get_contents('php://input'));

        if(isset($_POST['InscripcionForm']['path']) and isset($_POST['inscripcion_id']))
        {
            if ($_POST['InscripcionForm']['path']=!'' and $_POST['inscripcion_id'] != '') 
            { // Solo Para insertar
                $modelo = new InscripcionForm;
                #echo var_dump($_FILES['file']);die;
                #echo var_dump($_POST['logo']['path']);die;
                $ruta = '/images/inscripciones/'; // Almacena los archivos en la carpeta inscripciones.
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
                $modelo = TournamentPlayer::model()->findByPk($_POST['inscripcion_id']);
                $modelo->path = $ruta.$img_name;
                $modelo->state = 1;
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
                Yii::app()->user->setFlash('success','Se registró su pago correctamente');


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

    public function actionGetCalendarioAgenda()
    {
        $data = array();

        $data[] = array('title'=> 'Torneo Ares','observaciones'=> 'Primer torneo','start'=> '2017-02-20','id'=>1,'entidad_id'=>null,'foto'=>null,'link'=>null,'user'=>null);

        echo json_encode($data);
    }

    /*
    Pagar inscripcion con los creditos del usuario
    */
    public function pagoconCreditos()
    {
        if(isset($_GET['tournament_id']))
        {
            $tournament_id = $_GET['tournament_id'];
            $id = Yii::app()->user->id;
            
            $user = Player::model()->findByPk($id);
            $tournament = Tournament::model()->findByPk($tournament_id);
            $tournamentPlayer = TournamentPlayer::model()->find("tournament_id = ? and player_id = ?",array($tournament_id,$player_id));

            if($tournament)
            {
                $credits = Credit::getTotal();  
                if($credits >= $tournament->inscripcion)
                {
                    $transaction = Yii::app()->db->beginTransaction();

                    try
                    {
                        $creditTrans = new Credit; // Se descuentan los creditos
                        $creditTrans->amount = ($tournament->inscripcion)*(-1);
                        $creditTrans->comments = "Registro Torneo id ".$tournament->id." - ".$tournament->name;
                        $creditTrans->player_id = Yii::app()->user->id;
                        $creditTrans->date_import = date('Y-m-d h:i:s');
                        $creditTrans->path = null;
                        $creditTrans->rrhh_id = null;
                        $creditTrans->state = 1;

                        $tournamentPlayer->state = 2; //Registrado

                        if($creditTrans->save() and $tournamentPlayer->save())
                        {
                            Yii::app()->user->setFlash("success","Estas registrado en el torneo");
                            Yii::app()->historical->set($creditTrans,"Transaccion","Registro al Torneo id ".$tournament->id.' - '.$tournament->name);
                            $this->redirect(array("view","id"=>$tournament_id));
                        }
                        else
                            Yii::app()->user->setFlash("danger","Error al registrar la inscripción");    
                    }
                    catch(Exception $e)
                    {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('danger',$e->getMessage());   
                    }    
                }      
                else
                    Yii::app()->user->setFlash("danger","No se enviaron los datos correctos");
            }    
            else
                Yii::app()->user->setFlash("danger","No existe el torneo");
        }
        else
            Yii::app()->user->setFlash("danger","No se enviaron los datos correctos");

        $this->redirect(array("index"));
    }

    public function actionFinalizarRegistroMarcador()
    {
        global $HTTP_RAW_POST_DATA;
        
        $file = 0;
        $result = array();

        #echo  $_FILES['file']['tmp_name'];die;
        #echo var_dump($HTTP_RAW_POST_DATA); die;
        #echo var_dump(file_get_contents('php://input'));

        if(isset($_POST['MarcadorForm']['path']) and isset($_POST['match_id']))
        {
            if ($_POST['MarcadorForm']['path']=!'') 
            { // Solo Para insertar
                $modelo = new MarcadorForm;
                #echo var_dump($_FILES['file']);die;
                #echo var_dump($_POST['logo']['path']);die;
                $ruta = '/images/marcador/'; // Almacena los archivos en la carpeta inscripciones.
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
                if(isset($_POST['MarcadorForm']))
                {
                    $id = $_POST['match_id'];
                    $modelo = TournamentMatchDetail::model()->find("tournament_match_id = ? and player_id = ?",array($id,Yii::app()->user->id));
                    $modelo->path = $ruta.$img_name;
                    if($modelo->save()){
                        $score = new MarcadorForm;
                        $this->registerScore($score);
                        
                        $result['status'] = 'OK';
                        $result['message'] = 'Se registró la imágen.';    
                    }
                    else
                    {
                        $result['status'] = 'ERR';
                        $result['message'] = 'No se pudo registrar la imágen.'.print_r($modelo->getErrors(),true);    
                    }    
                }    
                else
                {
                    $result['status'] = 'ERR';
                    $result['message'] = 'No se identificó el partido, error en el fomrulario.';    
                }    
            }

            #$result = json_encode("success");
            #echo $result;

            if($result['status'] == 'ERR')
                Yii::app()->user->setFlash('danger','Datos de formulario incorrectos.'.$result['message']);
            else if($result['status'] == 'OK')
                Yii::app()->user->setFlash('success','Se subió la imágen correctamente.');

        }
        else
            Yii::app()->user->setFlash('danger','Datos de formulario incorrectos.');

        $this->redirect(array('index'));
    }

    /*
    Registrar el marcador que envia el usuario - solo para ONLINE
    */
    private function registerScore($score)
    {
        $transaction = Yii::app()->db->beginTransaction();

        try{
            $score->match_id = $_POST['MarcadorForm']['match_id'];
            $score->player_id_1 = $_POST['MarcadorForm']['player_id_1'];
            $score->player_id_2 = $_POST['MarcadorForm']['player_id_2'];
            $score->score1 = $_POST['MarcadorForm']['score1'];
            $score->score2 = $_POST['MarcadorForm']['score2'];
            $score->type = $_POST['MarcadorForm']['type'];
            
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

            $match = TournamentMatch::model()->findByPk($_POST['MarcadorForm']['match_id']);

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
                        $tournament = Tournament::model()->findByPk($group->phase->session->tournament->id);
                        Yii::app()->historical->set($tournament,"Marcador Partido",'Se registra marcador para el partido id '.$match->id.' del torneo '.$match->tournamentGroup->phase->session->tournament->name.' con los marcadores -  '.$match->tournamentMatchDetail[0]->player->username.' : '.$match->tournamentMatchDetail[0]->point.' '.$match->tournamentMatchDetail[1]->player->username.' : '.$match->tournamentMatchDetail[1]->point);
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
            $this->redirect(array('index'));
        }
    }

}