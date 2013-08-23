<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Team extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('round1_model');
		$this->load->model('team_model');
		$this->user_model->auth();
	}

	public function add(){

		date_default_timezone_set('EST');
		$date = new DateTime();
		$d = $date->format('Ymd');
		$teams = $this->team_model->getAllTeams();
		$total_team = count($teams);

		if(isset($_POST['req'])){
			if($_POST['team_name'] != "" && $_POST['members'] != "" && $_POST['contact'] !="" && $_POST['team_no'] !=""){
				if($this->team_model->isValidTeamName($_POST['team_name'])){
					$params['team_id'] = md5($_POST['team_name']);
					$params['team_name'] = $_POST['team_name'];
					$params['team_members'] = $_POST['members'];
					$params['contact'] = $_POST['contact'];
					$params['team_no'] = $_POST['team_no'];
					$params['date_created'] = $d; 

					$res = $this->team_model->addTeam($params);
					$teams = $this->team_model->getAllTeams();
					$total_team = count($teams);
					if($res){
						$params2 = array('team_id'=>$params['team_id'],'q_number'=>-1);
						$this->round1_model->setAnswered($params2);
						$data = (object)array('status'=>'ok','message'=>'Team Added :: '.$params['team_name'].'.');
						$this->load->view('add_team',array('response'=>$data,'total'=>$total_team));
					} else{
						$data = (object)array('status'=>'error','message'=>'Something went wrong in the DB, try again.');
						$this->load->view('add_team',array('response'=>$data,'total'=>$total_team));
					}
				} else{
					$data = (object)array('status'=>'error','message'=>'Team name already taken.');
					$this->load->view('add_team',array('response'=>$data,'total'=>$total_team));					
				}

			} else{
				$data = (object)array('status'=>'error','message'=>'Missing Teamname/members/contact');
				$this->load->view('add_team',array('response'=>$data,'total'=>$total_team));
			}

		} else {
			$this->load->view('add_team',array('total'=>$total_team));
		}
	}
	public function get_team_correct(){
		if(isset($_POST['team_id'])){
			$answered = $this->round1_model->getAnsweredQuestions(array('team_id'=>$_POST['team_id']));
			$response['status'] = "ok";
			$response['message'] = "Answered Items";
			$response['data'] = $answered;
			echo json_encode($response);
		} else {
			$response['message'] = "Missing parameters";
			$response['status'] = "error";
			echo json_encode($response);
		}
	}
}