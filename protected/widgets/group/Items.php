<?php 
class Items extends CWidget  
{
    public $tournamentGroupPositionId;
    public $tournamentGroupPosition;
    public $gameTypeId;
    public $items;
    
    public function init()
    {  
       $this->tournamentGroupPosition = TournamentGroupPosition::model()->findByPk($this->tournamentGroupPositionId); 
       $this->gameTypeId = $this->tournamentGroupPosition->tournamentGroup->phase->session->tournament->tournament_type_id;
       #$this->vista = $this->tournament->phase->session->tournament->game->gametype->id;
    }

   
    public function run()  
    {
        $items = $this->getItemsList();

        $params = array(
            'items'=>$items,
    	);
        
        $this->render('list',$params);
    }
    
    // Consulta lista de items, llama a otras funciones para obtener los diferentes items
    public function getItemsList()
    {
        $items = array();
        if($this->gameTypeId == 1 or $this->gameTypeId == 2) //Soccer
        {
            // GF GC DG PJ PG PE PP
            #echo $value->id;die;
            $model = TournamentGroupPositionSoccer::model()->find('tournament_group_position_id = ?',array($this->tournamentGroupPositionId));
            $items[]=$model->gf;
            $items[]=$model->gc;
            $items[]=$model->dg;
            $items[]=$model->pj;
            $items[]=$model->pg;
            $items[]=$model->pe;
            $items[]=$model->pp;
            #echo '<pre>'.print_r($items,true).'</pre>';
            
        }

        return $items;    
    }
/*
    public function getGoalsInFavor()
    {
        $sql = '
            SELECT sum(tmd.point) points
            FROM tournament_match_detail tmd
            INNER JOIN tournament_match tm ON tm.id=tmd.tournament_match_id 
            WHERE tm.tournament_group_id = '.$this->tournamentGroupId.' and tmd.player_id = '.$this->player_id
        ;

        $model = Yii::app()->db->createCommand($sql)->queryAll();

        return $model->points;
    }

    public function getGoalsAgainst()
    {
        $sql = '
            SELECT sum(tmd.point) points
            FROM tournament_match_detail tmd
            INNER JOIN tournament_match tm ON tm.id=tmd.tournament_match_id 
            WHERE tm.tournament_group_id = '.$this->tournamentGroupId.' and tmd.player_id != '.$this->player_id.' and tmd.tournament_match_id IN (SELECT tmd.tournament_match_id
            FROM tournament_match_detail tmd
            INNER JOIN tournament_match tm ON tm.id=tmd.tournament_match_id 
            WHERE tm.tournament_group_id = '.$this->tournamentGroupId.' and tmd.player_id = '.$this->player_id.')
        ';

        $model = Yii::app()->db->createCommand($sql)->queryAll();

        return $model->points;
    }

    public function getPlayedGames()
    {
        $sql = '
            SELECT SUM(tmd.id)games
            FROM tournament_match_detail tmd 
            INNER JOIN tournament_match tm ON tm.id=tmd.tournament_match_id 
            WHERE tm.tournament_group_id = '.$this->tournamentGroupId.'  and tmd.player_id = '.$this->player_id.' and tm.state = 3
        ';

        $model = Yii::app()->db->createCommand($sql)->queryAll();

        return $model->games;
    }
*/
}