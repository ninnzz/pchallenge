<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Team_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function getTeamName($params){
		$this->db->select('team_name');
		$this->db->from('teams');
		$this->db->where($params);
		return $this->db->get()->row()->team_name;
	}

	public function getTeamId($params){
		$this->db->select('team_id');
		$this->db->where('team_name',$params['team_name']);
		$res = $this->db->get('teams')->row();
		return $res->team_id;
	}

	public function addTeam($params){
		$res = $this->db->insert('teams', (object)$params); 
		return $res;
	}

	public function getAllTeams(){
		$this->db->order_by("team_no", "asc");
		$query = $this->db->get('teams')->result_object();
		return $query;
	}

    public function getTotalNumberOfTeams(){
        return $this->db->count_all('teams');
    }

	public function getSingleTeam($team_id){
		$res = $this->db->get_where('teams', array('team_id' => $team_id))->result_object();
		return $res;	
	}

	public function isValidTeamName($tname){
		$query = $this->db->get_where('teams', array('team_name' => $tname))->result_object();
		if(count($query) > 0){
			return FALSE;
		}
		return TRUE;
	}
}