<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Badge extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('badge_model');
        //$this->user_model->auth(); //add this function if you want to make it private
    }

    public function listings(){
    	$badge_types = array('ABS','COL','LUC','OOP','SEG');
    	foreach($badge_types as $badge_type){
	    	$data[$badge_type] = array('questions'=>$this->badge_model->getQuestionsByBadge($badge_type),'count'=>$this->badge_model->getCount($badge_type));
    	}
        $this->load->view("badge_list",$data);
    }
}

