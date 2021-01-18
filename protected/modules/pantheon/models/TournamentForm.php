<?php

/**
 * TournamentForm class.
 * TournamentForm is the data structure for keeping
 * tournament form data. It is used by the 'create' action of 'TournamentController'.
 */
class TournamentForm extends CFormModel
{
	public $name;
	public $game_id;
	public $tournament_type_id;
	public $tournament_class_id;
	public $start_date;
	public $amount; //Cuantas veces el tipo (N grupos o ligas)
	public $players; //Jugadores x grupo o liga
	public $classified; // Clasificados x grupo o liga
	public $description;
	public $city_id;
	public $test;
	public $consoles;
	public $sessions; 
	public $group_roundtrip; //Partido de ida y vuela en fase de grupos
	public $playoff_roundtrip; //Partido de ida y vuelta en PlayOff

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('name,game_id,tournament_type_id,tournament_class_id,start_date,amount,players,classified,consoles,description,city_id,test', 'required',"message"=>"Este campo es obligatorio"),
			array('','safe'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			
		);
	}

}