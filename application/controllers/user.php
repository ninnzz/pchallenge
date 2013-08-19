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


		
	/*****************ROUND 2**********************/
	public function edit_round2(){
		$app_conf = $this->app_model->getAppConfig();
		$q_count = $app_conf[0]->round2_question_count;
		if($q_count == 0){
			$data = (object)array('status'=>'error','message'=>'Question Count is set to 0. Generate a new question set.');
			$this->load->view('edit_round2',array('response'=>$data,'q_count'=>$q_count));
		} else {
			$data = (object)array('status'=>'ok');
			$this->load->view('edit_round2',array('response'=>$data,'q_count'=>$q_count));
		}
	}
	public function get_round2_question(){
		if(isset($_POST['q_number'])){
			$app_conf = $this->app_model->getAppConfig();
			$q_count = $app_conf[0]->round2_question_count;
			$question = $this->app_model->getQuestionR2($_POST['q_number']);
			
			if(count($question) == 0){
				$data = (object)array('status'=>'ok','message'=>'No data for question'.$_POST['q_number'].' yet. Please update question data.!');
			}
				$data = (object)array('status'=>'ok','message'=>'Question set to question number:'.$_POST['q_number']);
			$this->load->view('edit_round2',array('response'=>$data,'q_count'=>$q_count,'question'=>$question,'q_num'=>$_POST['q_number']));
			
		} else{
			echo "Invalid Access..!!";
		}	
	}
	public function update_round2_question(){
		$app_conf = $this->app_model->getAppConfig();
		$q_count = $app_conf[0]->round2_question_count;
		$question = $this->app_model->getQuestionR2($_POST['q_number']);
		if(isset($_POST['multiplier']) && isset($_POST['points']) && $_POST['multiplier'] != '' && $_POST['points'] != ''){
			$params = array('multiplier' => $_POST['multiplier'],'points'=>$_POST['points'],'badge_timer'=>$_POST['badge_timer'],'q_type'=>$_POST['q_type'],'prev_timer'=>$_POST['prev_timer'],'bet_timer'=>$_POST['bet_timer'],'q_timer'=>$_POST['q_timer'],'body'=>$_POST['body'],'answer'=>$_POST['answer']);
			if(count($question) == 0){
				$params['q_number'] = $_POST['q_number'];
				$res = $this->app_model->insertRound2Question($params);
			} else{
				$res = $this->app_model->updateRound2Question($params,$_POST['q_number']);
			}
			if($res){
				$question = $this->app_model->getQuestionR2($_POST['q_number']);
				$data = (object)array('status'=>'ok','message'=>'Updated Question For Round2');
				$this->load->view('edit_round2',array('response'=>$data,'q_count'=>$q_count,'question'=>$question,'q_num'=>$_POST['q_number']));
			}else{
				$data = (object)array('status'=>'error','message'=>'Failed to update');
				$this->load->view('edit_round2',array('response'=>$data,'q_count'=>$q_count,'question'=>$question));	
			}
		} else {
			$data = (object)array('status'=>'error','message'=>'Missing some parameters');
			$this->load->view('edit_round2',array('response'=>$data,'q_count'=>$q_count,'question'=>$question));
		}
	}
	/************ENCODER AND BET MODULES FOR ROUND2***************************/
	public function encoder_round2(){
		$app_conf = $this->app_model->getAppConfig();
		$q_count = $app_conf[0]->round2_question_count;
		$team = $this->team_model->getAllTeams();
		if($q_count > 0){
			$this->load->view('encoder_round2',array('teams'=>$team,'q_count'=>$q_count-1));

		} else {
			$data = (object)array('status'=>'error','message'=>'Round2 Question not initialized');
			$this->load->view('encoder_round2',array('response'=>$data,'teams'=>$team));	
		}
	}
	public function get_team_answers_round2(){
		$app_conf = $this->app_model->getAppConfig();
		$q_count = $app_conf[0]->round2_question_count;
		$team = $this->team_model->getAllTeams();
		if(isset($_POST['q_number']) && $_POST['q_number'] != ""){


		} else{
			$response['status'] = "error";
			$response['message'] = "Missing parameters";
			echo json_encode($response);
		}
	}

}