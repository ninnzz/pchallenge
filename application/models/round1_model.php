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

class Round1_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function setAnswered($params){
		$res = $this->db->insert('answered_round1', (object)$params); 
		return $res;
	}

	public function deleteAnswered($params){
		$res = $this->db->delete('answered_round1', $params);
		return $res;
	}

	public function getAnsweredQuestions($params){
		$this->db->order_by("q_number", "asc"); 
		$res = $this->db->get_where('answered_round1', $params)->result_object();
		return $res;
	}

	public function countAnsweredQuestionsWithBadgetype($params){
		$this->db->select('questions_badge.q_number');
		$this->db->distinct();
		$this->db->from('answered_round1');
		$this->db->join('questions_badge','answered_round1.q_number=questions_badge.q_number'); 
		$this->db->where($params);
		$res = $this->db->count_all_results();
		return $res;
	}

    public function getScores(){
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
	public function getNumberOfQuestions(){
		return $this->db->count_all("questions_round1");
	}

	public function isExistingAtBadge($q,$b){
		$res = $this->db->get_where('questions_badge',array('q_number' => $q,'badge_type' => $b))->num_rows();
		if($res > 0) return true;
		else return false;
	}
	
	public function setScore($params){
		$this->db->where('team_id',$params['team_id']);
		$res = $this->db->update('teams',array('points'=>$params['score']));
		return $res;
	}

	public function updateRound1Question($params,$q){
		$res = $this->db->update('questions_round1', $params, array('q_number' => $q)); 
		return $res;
	}

	public function updateQuestionBadge($params){
		foreach($params['badge_types'] as $badge_type){	
			if($this->isExistingAtBadge($params['q_number'],$badge_type)){
				$this->db->where(array('q_number'=>$params['q_number'],'badge_type'=>$badge_type));
				$this->db->delete('questions_badge');
			}
			$this->db->insert('questions_badge',array('q_number'=>$params['q_number'],'badge_type'=>$badge_type));
		}
	}
	
	public function updateQuestionDifficulty($params){
		$this->db->where('q_number',$params['q_number']);
		$res = $this->db->update('questions_round1',array('q_diff'=>$params['difficulty'],'points'=>$params['points']));
		return $res;
	}

	public function updateQuestionType($params){
		$this->db->where('q_number',$params['q_number']);
		$res = $this->db->update('questions_round1',array('q_type'=>$params['type'],'points'=>$params['points']));
		return $res;
	}
}