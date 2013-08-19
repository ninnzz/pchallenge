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

	public function isValidUserName($uname){
		$query = $this->db->get_where('admin', array('uname' => $uname))->result_object();
		if(count($query) > 0){
			return FALSE;
		}
		return TRUE;
	}

	public function addUser($params){
		$res = $this->db->insert('admin', (object)$params); 
		return $res;
	}
	public function getUserList(){
		$res = $this->db->get('admin')->result_object();
		return $res;
	}
	
}