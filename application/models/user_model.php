<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* User model
* 
* @package      pchallenge
* @category     Model
* @author       Nino Eclarin | neclarin@stratpoint.com
* @copyright    Copyright (c) 2013, Young Software Engineers' Society.
* @version      Version 1.0
* 
*/

class User_model extends CI_Model {

	public function __construct(){
		parent::__construct();

	}
	public function login($uname,$pword){
		$count = 0;
		$status = FALSE;
		$message = '';
		$query = $this->db->get_where('admin', array('uname' => $uname,'password'=>md5($pword)))->result_object();
		if(count($query) > 0){
			$count = count($query);
			$status = TRUE;
		}
		return (object) array('status'=>$status,'result_count'=>$count,'message'=>$message,'data'=>$query);
	}
	public function auth(){
		$logged_in = $this->session->userdata('isUserLoggedIn');	
		if(!$logged_in){
			$this->session->sess_destroy();
			redirect('/');
		}
	}
	public function is_valid_teamname($tname){
		$query = $this->db->get_where('teams', array('team_name' => $tname))->result_object();
		if(count($query) > 0){
			return FALSE;
		}
		return TRUE;
	}
	public function is_valid_username($uname){
		$query = $this->db->get_where('admin', array('uname' => $uname))->result_object();
		if(count($query) > 0){
			return FALSE;
		}
		return TRUE;
	}
	public function add_team($params){
		$res = $this->db->insert('teams', (object)$params); 
		return $res;
	}
	public function add_user($params){
		$res = $this->db->insert('admin', (object)$params); 
		return $res;
	}
	public function get_user_list(){
		$res = $this->db->get('admin')->result_object();
		return $res;
	}
	public function get_all_teams(){
		$this->db->order_by("team_no", "asc");
		$query = $this->db->get('teams')->result_object();
		return $query;
	}
	public function get_single_team($team_id){
		$res = $this->db->get_where('teams', array('team_id' => $team_id))->result_object();
		return $res;	
	}
}