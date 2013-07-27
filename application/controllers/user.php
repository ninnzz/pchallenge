<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('app_model');
		$this->user_model->auth();
	}

	public function index(){

		$user = $this->session->userdata['user'];
		$this->load->view('admin',array('user'=>$user));
	}
	public function add_team(){

		date_default_timezone_set('EST');
		$date = new DateTime();
		$d = $date->format('Ymd');

		if(isset($_POST['req'])){
			if($_POST['team_name'] != "" && $_POST['members'] != "" && $_POST['contact'] !=""){
				if($this->user_model->is_valid_teamname($_POST['team_name'])){
					$params['team_id'] = md5($_POST['team_name']);
					$params['team_nam]3e'] = $_POST['team_name'];
					$params['team_members'] = $_POST['members'];
					$params['contact'] = $_POST['contact'];
					$params['date_created'] = $d; 

					$res = $this->user_model->add_team($params);
					if($res){
						$data = (object)array('status'=>'ok','message'=>'Team Added :: '.$params['team_name'].'.');
						$this->load->view('add_team',array('response'=>$data));
					} else{
						$data = (object)array('status'=>'error','message'=>'Something went wrong in the DB, try again.');
						$this->load->view('add_team',array('response'=>$data));
					}
				} else{
					$data = (object)array('status'=>'error','message'=>'Team name already taken.');
					$this->load->view('add_team',array('response'=>$data));					
				}

			} else{
				$data = (object)array('status'=>'error','message'=>'Missing Teamname/members/contact');
				$this->load->view('add_team',array('response'=>$data));
			}

		} else {
			$this->load->view('add_team');
		}
	}
	public function add_user(){
		date_default_timezone_set('EST');
		$date = new DateTime();
		$d = $date->format('Ymd');

		$users = $this->user_model->get_user_list();

		if(isset($_POST['req'])){
			if($_POST['uname'] != "" && $_POST['password'] != "" && $_POST['role'] !=""){
				if($this->user_model->is_valid_username($_POST['uname'])){
					$params['uname'] = $_POST['uname'];
					$params['password'] = md5($_POST['password']);
					$params['scope'] = $_POST['role'];			

					$res = $this->user_model->add_user($params);
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
	public function app_config(){
		$app_config = $this->app_model->get_app_config();
		$this->load->view('app_config',array('app_config'=>$app_config));
	}
	public function reset_app(){
		$reset = $this->app_model->reset_app();
		if($reset){
			$app_config = $this->app_model->get_app_config();
			$data = (object)array('status'=>'ok','message'=>'Application has been reset! All config are set to default.');
			$this->load->view('app_config',array('response'=>$data,'app_config'=>$app_config));
		} else {
			$app_config = $this->app_model->get_app_config();
			$data = (object)array('status'=>'error','message'=>'Failed to reset database');
			$this->load->view('app_config',array('response'=>$data,'app_config'=>$app_config));
		}
	}
	public function update_app_config(){
		$params['app_state'] = $_POST['app_state'];
		$params['badge_count'] = $_POST['badge_count'];
		$params['round1_question_count'] = $_POST['round1_question_count'];
		$params['round1_timer'] = $_POST['round1_timer'];
		$res = $this->app_model->set_app_config($params);
		if($res){
			$app_config = $this->app_model->get_app_config();
			$data = (object)array('status'=>'ok','message'=>'Config updated');
			$this->load->view('app_config',array('response'=>$data,'app_config'=>$app_config));
		} else {
			$app_config = $this->app_model->get_app_config();
			$data = (object)array('status'=>'error','message'=>'Failed to update application config');
			$this->load->view('app_config',array('response'=>$data,'app_config'=>$app_config));
		}
	}
	public function edit_round1(){
		$questions = "";
		$this->load->view('edit_round1',array('questions'=>$questions));
	}
}