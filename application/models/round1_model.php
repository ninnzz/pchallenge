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
	public function get_answered_questions($params){
		$this->db->order_by("q_number", "asc"); 
		$res = $this->db->get_where('answered_round1', $params)->result_object();
		return $res;
	}

}