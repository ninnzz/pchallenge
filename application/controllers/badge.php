<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Badge extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('badge_model');
        //$this->user_model->auth(); //add this function if you want to make it private
    }

    public function listings(){
    	$badges = $this->badge_model->getBadges();
    	foreach($badges as $badge){
            $data[] = array(
                'badge_name'=>$badge->name,
                'questions'=>$this->badge_model->getQuestionsByBadge($badge->id),
                'count'=>$this->badge_model->getCount($badge->id));
    	}
        $this->load->view("badge_list",array('data'=>$data));
    }
}

