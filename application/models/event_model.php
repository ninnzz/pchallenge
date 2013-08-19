<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Event model
* 
* @package      pchallenge
* @category     Model
* @author       Nino Eclarin | neclarin@stratpoint.com
* @copyright    Copyright (c) 2013, Young Software Engineers' Society.
* @version      Version 1.0
* 
*/

class Event_model extends CI_Model {

	public function __construct(){
		parent::__construct();

	}
	public function addEvent($params){
		$res = $this->db->insert('events', (object)$params); 
		return $res;
	}
	public function getAll(){
		$this->db->order_by("date_time", "desc");
		$res = $this->db->get('events')->result_object();
		return $res;
	}
	public function getLatest(){
		$this->db->where("date_time = (select max(date_time) from events)");
		$res = $this->db->get('events')->result_object();
		return $res;	
	}

}