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

	public function setScore($params){
		$this->db->where('team_id',$params['team_id']);
		$res = $this->db->update('teams',array('points'=>$params['score']));
		return $res;
	}
}