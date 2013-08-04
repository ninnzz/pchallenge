<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Round1 extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('app_model');
		$this->load->model('round1_model');
		//$this->user_model->auth(); //add this function if you want to make it private
	}

	public function state(){
		$res = $this->app_model->get_app_config();
		$response['status'] = "ok";
		$response['message'] = "App config";
		$response['round1_state'] = $res[0]->app_state;
		echo json_encode($response);
	}
	public function timer(){
		$res = $this->app_model->get_app_config();
		$response['status'] = "ok";
		$response['message'] = "Round1 timer";
		$response['round1_state'] = $res[0]->round1_timer;
		echo json_encode($response);	
	}
	public function team_score(){
		$res = $this->round1_model->get_scores();
		$response['status'] = "ok";
		$response['message'] = "Score List";
		$response['round1_state'] = $res;
		echo json_encode($response);	
	}
}