<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Round2 extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('app_model');
		$this->load->model('round2_model');
		//$this->user_model->auth(); //add this function if you want to make it private
	}

	public function questionHandler(){
		$this->load->view('questionhandler');
	}

	public function readyNextQuestion(){

	}

	public function flashQuestion(){

	}

	public function powerUpTimer(){

	}

	public function bettingTimer(){

	}

	public function displayQuestion(){

	}

	public function answeringTimer(){

	}

	public function displayTimer(){

	}

	public function displayTeamSummary(){
		
	}

	public function getState(){
		//$state
	}
}