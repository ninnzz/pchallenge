<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('event_model');
		//$this->user_model->auth(); //add this function if you want to make it private
	}

	public function index(){
		$res = $this->event_model->getAll();
		$response['status'] = "ok";
		$response['message'] = "Events list";
		$response['data'] = $res;
		echo json_encode($response);
	}
	public function latest(){
		$res = $this->event_model->getLatest();
		$response['status'] = "ok";
		$response['message'] = "Events list";
		$response['data'] = $res;
		echo json_encode($response);	
	}
}