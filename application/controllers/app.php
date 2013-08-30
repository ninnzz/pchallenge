<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('app_model');
        $this->load->model('team_model');
		$this->user_model->auth();
	}

	public function config(){
		$app_config = $this->app_model->getAppConfig();
		$this->load->view('app_config',array('app_config'=>$app_config));
	}

	public function remove_events(){
		$res = $this->app_model->removeEvents();
		if($res){
			$this->session->set_flashdata('data',(object)array('status'=>'ok','message'=>'All events has been removed'));
			redirect('../app/config');
		}else{
			$this->session->set_flashdata('data',(object)array('status'=>'error','message'=>'Failed to remove events.'));
			redirect('../app/config');
		}
	}

	public function reset(){
		$reset = $this->app_model->resetApp();
		if($reset){
			$app_config = $this->app_model->getAppConfig();
			$data = (object)array('status'=>'ok','message'=>'Application has been reset! All config are set to default.');
			$this->load->view('app_config',array('response'=>$data,'app_config'=>$app_config));
		} else {
			$app_config = $this->app_model->getAppConfig();
			$data = (object)array('status'=>'error','message'=>'Failed to reset database');
			$this->load->view('app_config',array('response'=>$data,'app_config'=>$app_config));
		}
	}

	public function reset_round1(){
		$res1 = $this->app_model->resetRound1();
        $res2 = $this->team_model->initializeScores();
		if($res1 && $res2){
			$this->session->set_flashdata('data',(object)array('status'=>'ok','message'=>'Round 1 has been reset.'));
			redirect('../app/config');
		}else{
			$this->session->set_flashdata('data',(object)array('status'=>'error','message'=>'Failed to reset Round 1.'));
			redirect('../app/config');
		}
	}

	public function reset_round2(){
		$res = $this->app_model->resetRound2();
		if($res){
			$this->session->set_flashdata('data',(object)array('status'=>'ok','message'=>'Round 2 has been reset.'));
			redirect('../app/config');
		}else{
			$this->session->set_flashdata('data',(object)array('status'=>'error','message'=>'Failed to reset Round 2.'));
			redirect('../app/config');
		}
	}

	public function update_config(){
		$params['app_state'] = $_POST['app_state'];
		$params['badge_count'] = $_POST['badge_count'];
		$params['round1_question_count'] = $_POST['round1_question_count'];
		$params['round2_question_count'] = $_POST['round2_question_count'];
		$params['round1_timer'] = $_POST['round1_timer'];
		$res = $this->app_model->setAppConfig($params);
		if($res){
			$this->session->set_flashdata('data',(object)array('status'=>'ok','message'=>'Config updated'));
			redirect('../app/config');
		} else {
			$this->session->set_flashdata('data',(object)array('status'=>'error','message'=>'Failed to update application config'));
			redirect('../app/config');
		}
	}

}