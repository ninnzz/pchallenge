<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->user_model->auth();
	}

	public function index(){
		$this->session->sess_destroy();
		$data = (object)array('status'=>'error','message'=>'Logged out');
		$this->load->view('login',array('response'=>$data));
	}
}