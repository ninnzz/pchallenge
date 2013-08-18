<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Application model
* 
* @package      pchallenge
* @category     Model
* @author       Nino Eclarin | neclarin@stratpoint.com
* @copyright    Copyright (c) 2013, Young Software Engineers' Society.
* @version      Version 1.0
* 
*/

class App_model extends CI_Model {

	public function __construct(){
		parent::__construct();

	}
	public function reset_app(){
		$data = array('app_state'=>'pre','current_question_round2'=>0,'r2_state'=>'init','round1_question_count'=>0,'badge_count'=>0,'round1_timer'=>45);
		/*
			**************COMMENT FOR DEV*******************
			add something that will automatically save a copy of the previous db and dump it in a file
			remember to save all including the app_state talbe
		 */
		$this->db->query("delete from answered_round1");
		$this->db->query("delete from questions_round1");
		return $this->db->update('app_config', $data);
	}
	public function get_app_config(){
		$res = $this->db->get('app_config')->result_object();
		return $res;
	}
	public function set_app_config($params){
		return $this->db->update('app_config', $params);		
	}
	public function gen_round1($r1_count){
		$data = array();
		for($i=1;$i<=$r1_count;$i++){
			array_push($data, array('q_number'=>$i,'q_type'=>'e','q_multiplier'=>1,'points'=>0));
		}
		$this->db->empty_table('questions_round1'); 
		$this->db->empty_table('questions_badge');
		$res = $this->db->insert_batch('questions_round1', $data);
		return $res; 
	}
	public function get_qcount_r1(){
		$res = $this->db->get('questions_round1')->num_rows();
		return $res;	
	}
	public function get_question_r1($q){
		$query = $this->db->get_where('questions_round1', array('q_number' => $q))->result_object();
		return $query;
	}

}