<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
	}

	public function index(){
		$logged_in = $this->session->userdata('isUserLoggedIn');	
		($logged_in)?$this->load->view('admin'):$this->load->view('login');		
	}

	public function auth(){
		$uname = $this->input->post('username');
		$pword = $this->input->post('password');
		if($uname && $pword){
			$res = $this->user_model->login($uname,$pword);
			if($res->status){
				$tmp = (object)array(
					'isUserLoggedIn' => 'user_scope',
					'user' => (object)$res->data[0]
					);
				$this->session->set_userdata($tmp);
				redirect("/user");
			} else{
				$data = (object)array('status'=>'error','message'=>'Username/Password does not match..!');
				$this->load->view('login',array('response'=>$data));	
			}
		} else {
			$data = (object)array('status'=>'error','message'=>'Missing username or password');
			$this->load->view('login',array('response'=>$data));
		}
	}
}