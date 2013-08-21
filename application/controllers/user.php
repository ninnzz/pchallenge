<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('app_model');
		$this->load->model('round1_model');
		$this->load->model('event_model');
		$this->load->model('badge_model');
		$this->load->model('team_model');
		$this->user_model->auth();
	}

	public function index(){

		$user = $this->session->userdata['user'];
		$this->load->view('admin',array('user'=>$user));
	}

	public function add_user(){
		date_default_timezone_set('EST');
		$date = new DateTime();
		$d = $date->format('Ymd');

		$users = $this->user_model->getUserList();

		if(isset($_POST['req'])){
			if($_POST['uname'] != "" && $_POST['password'] != "" && $_POST['role'] !=""){
				if($this->user_model->isValidUserName($_POST['uname'])){
					$params['uname'] = $_POST['uname'];
					$params['password'] = md5($_POST['password']);
					$params['scope'] = $_POST['role'];			

					$res = $this->user_model->addUser($params);
					if($res){
						$data = (object)array('status'=>'ok','message'=>'User Added :: '.$params['uname'].'.');
						$this->load->view('add_user',array('response'=>$data,'user_list'=>$users));
					} else{
						$data = (object)array('status'=>'error','message'=>'Something went wrong in the DB, try again.');
						$this->load->view('add_user',array('response'=>$data,'user_list'=>$users));
					}
				} else{
					$data = (object)array('status'=>'error','message'=>'Username already taken.');
					$this->load->view('add_user',array('response'=>$data,'user_list'=>$users));	
				}
			} else{
				$data = (object)array('status'=>'error','message'=>'Missing Username/Password/Role parameter.');
				$this->load->view('add_user',array('response'=>$data,'user_list'=>$users));	
			}
		} else{
			$this->load->view('add_user',array('user_list'=>$users));
		}
	}
}