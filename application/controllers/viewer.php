<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Viewer extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('app_model');
		$this->load->model('round1_model');
		//$this->user_model->auth();
	}

	public function _remap($functionName,$args)
	{
		switch($functionName)
		{
			case 1:
				$this->load->view('round1_view');
				break;
			case 2:
				$this->load->view('round2_view');
				break;
/*		case 2:
				$teams=$this->vieweradapter->topScorers(3);
				$this->load->view('round2',array('teams'=>$teams));
				break;
			case 3:
				$this->load->view('round2scoreboard_1');
				break;
			default:
				call_user_func_array( array($this,$functionName) , $args);
				break;
*/		}
	}
}