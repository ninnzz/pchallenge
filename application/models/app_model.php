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
	public function resetAPp(){
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

	public function resetRound1(){
		$res1 = $this->db->empty_table('answered_round1');
		$res2 = $this->db->update('badge',array('owner'=>NULL,'timestamp'=>NULL));
		return $res1 && $res2;
	}

	public function getAppConfig(){
		$res = $this->db->get('app_config')->result_object();
		return $res;
	}
	public function setAppConfig($params){
		return $this->db->update('app_config', $params);		
	}
	public function genRound1($r1_count){
		$data = array();

		for($i=1;$i<=$r1_count;$i++){
			array_push($data, array('q_number'=>$i,'q_type'=>'e','q_multiplier'=>1,'points'=>0));
		}
		$this->db->empty_table('questions_round1'); 
		$this->db->empty_table('questions_badge');
		$res = $this->db->insert_batch('questions_round1', $data);
		return $res; 
	}
	public function getQCountR1(){
		$res = $this->db->get('questions_round1')->num_rows();
		return $res;	
	}
	public function getQuestionR1($q){
		$query = $this->db->get_where('questions_round1', array('q_number' => $q))->result_object();
		return $query;
	}
	public function updateRound1Question($params,$q){
		$res = $this->db->update('questions_round1', $params, array('q_number' => $q)); 
		return $res;
	}
	public function getQuestionR2($q){
		$query = $this->db->get_where('questions_round2', array('q_number' => $q))->result_object();
		return $query;
	}
	public function updateRound2Question($params,$q){
		$res = $this->db->update('questions_round2', $params, array('q_number' => $q)); 
		return $res;
	}
	public function insertRound2Question($params){
		$res = $this->db->insert('questions_round2', $params); 
		return $res;
	}	
}