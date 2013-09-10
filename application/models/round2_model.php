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

	public function getScores(){
        $res = $this->db->query(
            "select sum(
                case when (b.is_correct)
                  then (b.bet*c.multiplier)+c.points
                  else (-1*b.bet)
                  end)
            as points,b.team_id,a.team_name
            from teams a, answered_round2 b, questions_round2 c
            where b.q_number = c.q_number and b.team_id = a.team_id
            group by b.team_id
            order by points desc")->result_object();
		return $res;		
	}

	public function getBaseScores(){
		$res = $this->db->query(
			"select sum(
				case when (b.is_fast_round)
				  then (c.points*2)
				  else c.points
				  end)
            as points,b.team_id, a.team_name
            from teams a, answered_round1 b, questions_round1 c
            where b.q_number = c.q_number and b.team_id = a.team_id
            group by b.team_id
            order by points desc")->result_object();
		return $res;
	}

	public function setState($state){
		$res = $this->db->query("update app_config set r2_state='{$state}' where r2_state IS NOT NULL ");
		return $res;
	}

	public function getState(){
		$res = $this->db->query("select * from app_config");
		return $res->row()->r2_state;
	}

	public function getCurrentQuestionRound2(){
		$res = $this->db->query("select * from app_config");
		return $res->row()->current_question_round2;
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

	public function isCorrect(){
		$res = $this->db->query("select * from app_config");
		$q_number = $res->row()->current_question_round2;
		$res = $this->db->query("select a.team_id, b.team_name from answered_round2 a, teams b where a.is_correct=1 and a.q_number='{$q_number}' and a.team_id=b.team_id")->result_object();
		return $res;
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

    public function setBadgeInEffect($badge_id,$q_num){
        foreach($this->team_model->getTeamIds() as $result){
            if(!$this->isTeamAlreadyExist('answered_round2',$q_num,$result->team_id)){
                $res = $this->db->insert('answered_round2',array('q_number'=>$q_num,'team_id'=>$result->team_id,'bet'=>0,'is_correct'=>0,'badge_in_effect'=>$badge_id));
            }else{
                $this->db->where('q_number',$q_num);
                $res = $this->db->update('answered_round2',array('badge_in_effect'=>$badge_id));
            }
            if($res) continue;
            else return false;
        }
        return true;
    }

    public function getBadgeInEffect($q_num){
        $this->db->select('badge_in_effect');
        $this->db->from('answered_round2');
        $this->db->where('q_number',$q_num);
        $res = $this->db->get()->row();
        return $res->badge_in_effect;
    }
}
