<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Round2 extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('app_model');
		$this->load->model('round2_model');
		//$this->user_model->auth(); //add this function if you want to make it private
	}

	public function questionhandler(){
		$this->load->view('questionhandler');
	}

	public function view(){
		$this->load->view('round2_view');
	}
	
	function setState(){
		$state = $this->input->post('message');
		$arr['state']=$state;
		$res = $this->round2_model->setState($state);
		echo json_encode($arr);
	}

	function getState(){
		$res = $this->round2_model->getState();
		$arr['state']=$res;
		echo json_encode($arr);
	}

	function setNextQuestion(){
		$res = $this->round2_model->setNextQuestion();
		echo json_encode($res);
	}

	function setPreviousQuestion(){
		$res = $this->round2_model->setPreviousQuestion();
		echo json_encode($res);
	}



	
}