<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Badge_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->model('round1_model');
	}

	public function setOwner($team_id,$badge_type,$timestamp){
		$this->db->where('id',$badge_type);
		$this->db->update('badge',array('owner'=>$team_id,'timestamp'=>$timestamp));
	}

	public function setQuestionsToBadges($badge_id,$questions_selected,$questions){
		foreach($questions_selected as $question_selected){
			$data = array(
				'badge_type' => $badge_id
			);
			$this->db->where('q_number',$question_selected);
			$this->db->update('questions_badge', $data);
		}
	}

	public function getBadges(){
		$res = $this->db->get("badge");
		return $res->result();
	}

	public function getBadgeType($question_number){
		$this->db->select('badge_type');
		$res = $this->db->get_where('questions_badge',array('q_number'=>$question_number));
		$badge_type = NULL;
		foreach($res->result() as $result){
			$badge_type[] = $result->badge_type;
		}
		return $badge_type;
	}

	public function getBadgeName($badge_type){
		$this->db->select('name');
		$res = $this->db->get_where('badge',array('id'=>$badge_type));
		return $res->row();
	}

	public function getCount($badge_id){
		$this->db->select('q_number');
		$res = $this->db->get_where('questions_badge',array('badge_type'=>$badge_id));
		return $res->num_rows();
	}

	public function getQuestionsWithBadge($badge_id){
		$this->db->select('q_number');
		$res = $this->db->get_where('questions_badge',array('badge_type'=>$badge_id));
		return $res->result();
	}

	public function getQuestionsByBadge($badge_type){
		$this->db->select('q_number');
		$this->db->order_by('q_number','asc');
		$res = $this->db->get_where('questions_badge',array('badge_type'=>$badge_type));
		return $res->result();
	}

	public function hasCompletedBadgeFragments($team, $badge_type){
		$fragment_count = $this->round1_model->countAnsweredQuestionsWithBadgeType(array('team_id'=>$team[0]->team_id,'badge_type'=>$badge_type));
		$this->db->select('count');
		$res = $this->db->get_where('badge',array('id'=>$badge_type));
		foreach($res->result() as $result){
			$badge_total_fragments = $result->count;
		}
		if($fragment_count == $badge_total_fragments)
			return true;
		else
			return false;
	}

	public function hasOwner($badge_type){
		$this->db->select('owner');
		$res = $this->db->get_where('badge',array('id'=>$badge_type));
		foreach($res->result() as $result){
			$owner = $result->owner;
		}
		if($owner != NULL) return true;
		else return false;
	}

}