<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Round1 model
* 
* @package      pchallenge
* @category     Model
* @author       Nino Eclarin | neclarin@stratpoint.com
* @copyright    Copyright (c) 2013, Young Software Engineers' Society.
* @version      Version 1.0
* 
*/

class Round2_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->model('team_model');

	}

	public function get_scores(){
		$mult = 2;
		$res = $this->db->query(
			"select sum( 
				case when (b.is_fast_round) then (c.points*{$mult}) else c.points end) 
				as points,b.team_id, a.team_name 
				from teams a, answered_round1 b, questions_round1 c 
				where b.q_number = c.q_number and b.team_id = a.team_id 
				group by b.team_id 
				order by points desc")->result_object();
		return $res;		
	}

	public function get_base_score($team_id){
		$mult = 2;
		$res = $this->db->query(
			'select sum(
				case when (b.is_`fast_round) then (c.points*__mult_) else c.points end)
				as points,b.team_id, a.team_name
				from teams a, answered_round1 b, questions_round1 c
				where b.q_number = c.q_number and b.team_id = a.team_id and b.team_id=\'__team_id_\'
				group by b.team_id
				order by points desc')->row();
		return $res->points;	
	}

	public function setState($state){
		$res = $this->db->query("update app_config set r2_state='{$state}' where r2_state IS NOT NULL ");
		return $res;
	}

	public function getState(){
		$res = $this->db->query("select * from app_config");
		return $res->row()->r2_state;
	}

	public function setNextQuestion(){
		$res = $this->db->query("update app_config set current_question_round2=current_question_round2+1 where r2_state IS NOT NULL ");
		return $res;
	}

	public function setPreviousQuestion(){
		$res = $this->db->query("update app_config set current_question_round2=current_question_round2-1 where r2_state IS NOT NULL and current_question_round2>0");
		return $res;
	}

	public function getQuestionDetails(){
		$res = $this->db->query("select * from app_config");
		$q_number =  $res->row()->current_question_round2;	
		$res = $this->db->query("select * from questions_round2 where q_number='{$q_number}'");
		return $res->row();
	}

	public function isTeamAlreadyExist($table, $question_number, $team_id){
		return $this->db->query("SELECT team_id FROM $table WHERE q_number=$question_number AND team_id='$team_id'")->num_rows;
	}

	public function getTotalQuestions($table){
		return $this->db->query("SELECT * FROM $table")->num_rows;
	}

	public function getBet($question_number, $team_id){
		return $this->db->query("SELECT bet FROM answered_round2 WHERE q_number='$question_number' AND team_id='$team_id'")->row()->bet;
	}

	public function getPoints($question_number){
		return $this->db->query("SELECT points FROM questions_round2 WHERE q_number=$question_number")->row()->points;
    }

	public function insertBet($params){
   		return $this->db->query(
            "INSERT INTO answered_round2 (q_number,team_id,bet)
            VALUES ({$params['q_number']},'{$params['team_id']}',{$params['bet']})");
	}

	public function editBet($params){
		return $this->db->query("UPDATE answered_round2 SET bet={$params['bet']} WHERE q_number={$params['q_number']} AND team_id='{$params['team_id']}'");
	}

	public function insertScore($params){
		return $this->db->query(
            "INSERT INTO answered_round2 (q_number,team_id,is_correct,bet,badge_in_effect)
            VALUES ({$params['q_number']}, '{$params['team_id']}', {$params['is_correct']}, {$params['bet']}, '{$params['badge_in_effect']}'");
	}

	public function updateScore($params){
        return $this->db->query(
            "UPDATE answered_round2
            SET is_correct= {$params['is_correct']},bet={$params['bet']},badge_in_effect='{$params['badge_in_effect']}'
            WHERE q_number={$params['q_number']} AND team_id='{$params['team_id']}'");
	}
}
