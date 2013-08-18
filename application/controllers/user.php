<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('app_model');
		$this->load->model('round1_model');
		$this->load->model('event_model');
		$this->load->model('badge_model');
		$this->load->model('team_model');
		$this->user_model->auth();
	}

	public function index(){

		$user = $this->session->userdata['user'];
		$this->load->view('admin',array('user'=>$user));
	}
	public function add_team(){

		date_default_timezone_set('EST');
		$date = new DateTime();
		$d = $date->format('Ymd');

		if(isset($_POST['req'])){
			if($_POST['team_name'] != "" && $_POST['members'] != "" && $_POST['contact'] !=""){
				if($this->user_model->is_valid_teamname($_POST['team_name'])){
					$params['team_id'] = md5($_POST['team_name']);
					$params['team_name'] = $_POST['team_name'];
					$params['team_members'] = $_POST['members'];
					$params['contact'] = $_POST['contact'];
					$params['date_created'] = $d; 

					$res = $this->user_model->add_team($params);
					if($res){
						$data = (object)array('status'=>'ok','message'=>'Team Added :: '.$params['team_name'].'.');
						$this->load->view('add_team',array('response'=>$data));
					} else{
						$data = (object)array('status'=>'error','message'=>'Something went wrong in the DB, try again.');
						$this->load->view('add_team',array('response'=>$data));
					}
				} else{
					$data = (object)array('status'=>'error','message'=>'Team name already taken.');
					$this->load->view('add_team',array('response'=>$data));					
				}

			} else{
				$data = (object)array('status'=>'error','message'=>'Missing Teamname/members/contact');
				$this->load->view('add_team',array('response'=>$data));
			}

		} else {
			$this->load->view('add_team');
		}
	}

	public function edit_badge(){	
		foreach($this->badge_model->getBadges() as $badge){
			$badge_options[] = array($badge->id => $badge->name);
		}
		$data["badge_options"] = $badge_options;
		$data["q_count"] = $this->round1_model->getNumberOfQuestions();
		$this->load->view('edit_badge',$data);
	}

	public function modify_badge(){
		if(isset($_POST['id']) && isset($_POST['questions_selected'])){
			$data['id'] = $_POST['id'];
			$data['questions_selected'] = $_POST['questions_selected'];
			$data['questions'] = $_POST['questions'];
			$this->badge_model->setQuestionsToBadges($_POST['id'],$_POST['questions_selected'],$_POST['questions']);
		}
		redirect('../user/badge?id='.$data['id'],'refresh');
	}

	public function add_user(){
		date_default_timezone_set('EST');
		$date = new DateTime();
		$d = $date->format('Ymd');

		$users = $this->user_model->get_user_list();

		if(isset($_POST['req'])){
			if($_POST['uname'] != "" && $_POST['password'] != "" && $_POST['role'] !=""){
				if($this->user_model->is_valid_username($_POST['uname'])){
					$params['uname'] = $_POST['uname'];
					$params['password'] = md5($_POST['password']);
					$params['scope'] = $_POST['role'];			

					$res = $this->user_model->add_user($params);
					if($res){
						$data = (object)array('status'=>'ok','message'=>'User Added :: '.$params['uname'].'.');
						$this->load->view('add_user',array('response'=>$data,'user_list'=>$users));
					} else{
						$data = (object)array('status'=>'error','message'=>'Something went wrong in the DB, try again.');
						$this->load->view('add_user',array('response'=>$data,'user_list'=>$users));
					}
				} else{
					$data = (object)array('status'=>'error','message'=>'Username already taken.');
					$this->load->view('add_user',array('response'=>$data,'user_list'=>$users));	
				}
			} else{
				$data = (object)array('status'=>'error','message'=>'Missing Username/Password/Role parameter.');
				$this->load->view('add_user',array('response'=>$data,'user_list'=>$users));	
			}
		} else{
			$this->load->view('add_user',array('user_list'=>$users));
		}
	}

	public function app_config(){
		$app_config = $this->app_model->get_app_config();
		$this->load->view('app_config',array('app_config'=>$app_config));
	}

	public function reset_app(){
		$reset = $this->app_model->reset_app();
		if($reset){
			$app_config = $this->app_model->get_app_config();
			$data = (object)array('status'=>'ok','message'=>'Application has been reset! All config are set to default.');
			$this->load->view('app_config',array('response'=>$data,'app_config'=>$app_config));
		} else {
			$app_config = $this->app_model->get_app_config();
			$data = (object)array('status'=>'error','message'=>'Failed to reset database');
			$this->load->view('app_config',array('response'=>$data,'app_config'=>$app_config));
		}
	}
	public function update_app_config(){
		$params['app_state'] = $_POST['app_state'];
		$params['badge_count'] = $_POST['badge_count'];
		$params['round1_question_count'] = $_POST['round1_question_count'];
		$params['round2_question_count'] = $_POST['round2_question_count'];
		$params['round1_timer'] = $_POST['round1_timer'];
		$res = $this->app_model->set_app_config($params);
		if($res){
			$app_config = $this->app_model->get_app_config();
			$data = (object)array('status'=>'ok','message'=>'Config updated');
			$this->load->view('app_config',array('response'=>$data,'app_config'=>$app_config));
		} else {
			$app_config = $this->app_model->get_app_config();
			$data = (object)array('status'=>'error','message'=>'Failed to update application config');
			$this->load->view('app_config',array('response'=>$data,'app_config'=>$app_config));
		}
	}
	/*************ROUND1 QUESTION SETTINGS*******************/
	public function edit_round1(){
		$q_count = $this->app_model->get_qcount_r1();

		if($q_count == 0){
			$data = (object)array('status'=>'error','message'=>'Question Count is set to 0. Generate a new question set.');
			$this->load->view('edit_round1',array('response'=>$data,'q_count'=>$q_count));
		} else {
			$data = (object)array('status'=>'ok');
			$this->load->view('edit_round1',array('response'=>$data,'q_count'=>$q_count));
		}
	}

	public function edit_round1_by_question(){
		$q_count = $this->app_model->get_qcount_r1();	
		
		$data = (object)array('status'=>'ok');
		$this->load->view('edit_round1_by_question',array('response'=>$data,'q_count'=>$q_count));
	}

	public function edit_round1_by_difficulty(){
		$q_count = $this->app_model->get_qcount_r1();
		
		$data = (object)array('status'=>'ok');
		$this->load->view('edit_round1_by_difficulty',array('response'=>$data,'q_count'=>$q_count));
	}

	public function edit_round1_by_badge(){		
		$q_count = $this->app_model->get_qcount_r1();

		$data = (object)array('status'=>'ok');
		$this->load->view('edit_round1_by_badge',array('response'=>$data,'q_count'=>$q_count));
	}

	public function gen_round1(){
		$app_config = $this->app_model->get_app_config();
		$r1_count = $app_config[0]->round1_question_count;	
		if($r1_count == 0){
			$data = (object)array('status'=>'error','message'=>'Question Count is set to 0. Edit application settings');
			$this->load->view('edit_round1',array('response'=>$data,'q_count'=>$r1_count));
		} else {
			$res = $this->app_model->gen_round1($r1_count);
			if($res){
				$q_count = $this->app_model->get_qcount_r1();
				$data = (object)array('status'=>'ok','message'=>'Generated new set of questions. Difficulty is set to easy. Points is set to 0, Badge is set to none.');
				$this->load->view('edit_round1',array('response'=>$data,'q_count'=>$q_count));
			} else{
				$data = (object)array('status'=>'error','message'=>'Something went wrong while updating. Please generate new question set.');
				$this->load->view('edit_round1',array('response'=>$data,'q_count'=>0));
			}
		}
	}
	public function get_round1_question(){
		if(isset($_POST['q_number'])){
			$q_count = $this->app_model->get_qcount_r1();
			$question = $this->app_model->get_question_r1($_POST['q_number']);
			$badge_types = $this->badge_model->getBadgeType($_POST['q_number']);
			$data = (object)array('status'=>'ok','message'=>'Question set to question number:'.$_POST['q_number']);
			$this->load->view('edit_round1_by_question',array('response'=>$data,'q_count'=>$q_count,'question'=>$question,'badge_types'=>$badge_types));
			
		} else{
			echo "Invalid Access..!!";
		}	
	}

	public function update_round1_badge(){
		$q_count = $this->app_model->get_qcount_r1();
		if(trim($_POST['question_numbers']) != '' && isset($_POST['badge_types'])){
			$string = $_POST['question_numbers'];
			$badge_types = $_POST['badge_types'];
			$tok = strtok($string,',');
			while($tok != false){
				$q_numbers[] = $tok;
				$tok = strtok(',');
			}
			foreach($q_numbers as $q_number){
				if(!strpos($q_number,'-')){
					$params = array('q_number'=>$q_number,'badge_types'=>$badge_types);
					$this->round1_model->update_question_badge($params);
				}
				else{
					$tok = strtok($q_number,'-');
					while($tok != false){
						$range[] = $tok;
						$tok = strtok('-');	
					}
					for($i = $range[0] ; $i <= $range[1] ; $i++){
						$params = array('q_number'=>$i,'badge_types'=>$badge_types);
						$this->round1_model->update_question_badge($params);
					}
				}
			}
		}
		else{
			$data = (object)array('status'=>'error','message'=>'Empty input');
			$this->load->view('edit_round1_by_difficulty',array('response'=>$data,'q_count'=>$q_count));
		}
	}

	public function update_round1_difficulty(){
		$q_count = $this->app_model->get_qcount_r1();
		if(trim($_POST['question_numbers']) != ''){
			$string = $_POST['question_numbers'];
			$difficulty = $_POST['difficulty'];
			switch($difficulty){
				case 'e':
					$points = 30; break;
				case 'a':
					$points = 50; break;
				case 'd':
					$points = 70; break;
			}
			$tok = strtok($string,',');
			while($tok != false){
				$q_numbers[] = $tok;
				$tok = strtok(',');
			}
			foreach($q_numbers as $q_number){
				if(!strpos($q_number,'-')){
					$params = array('q_number'=>$q_number,'difficulty'=>$difficulty,'points'=>$points);
					$this->round1_model->update_question_difficulty($params);
				}
				else{
					$tok = strtok($q_number,'-');
					while($tok != false){
						$range[] = $tok;
						$tok = strtok('-');	
					}
					for($i = $range[0] ; $i <= $range[1] ; $i++){
						$params = array('q_number'=>$i,'difficulty'=>$difficulty,'points'=>$points);
						$this->round1_model->update_question_difficulty($params);
					}
				}
			}
		}
		else{
			$data = (object)array('status'=>'error','message'=>'Empty input');
			$this->load->view('edit_round1_by_difficulty',array('response'=>$data,'q_count'=>$q_count));
		}
	}

	public function update_round1_question(){
		$q_count = $this->app_model->get_qcount_r1();
		$question = $this->app_model->get_question_r1($_POST['q_number']);
		$badge_types = $this->badge_model->getBadgeType($_POST['q_number']);

		if(isset($_POST['q_multiplier']) && isset($_POST['points']) && $_POST['q_multiplier'] != '' && $_POST['points'] != ''){
			$question_params = array('q_multiplier' => $_POST['q_multiplier'],'points'=>$_POST['points'],'q_type'=>$_POST['q_type']);
			$res = $this->round1_model->update_question_round1($question_params,$_POST['q_number']);
			$this->round1_model->update_question_badge(array('q_number'=>$_POST['q_number'],'badge_types'=>$_POST['badge_types']));
			if($res){
				$question = $this->app_model->get_question_r1($_POST['q_number']);
				$data = (object)array('status'=>'ok','message'=>'Updated Question '.$_POST['q_number']);
				redirect('../user/edit_round1_by_question',refresh);
			$this->load->view('edit_round1',array('response'=>$data,'q_count'=>$q_count,'question'=>$question,'badge_types'=>$badge_types));
			}else{
				$data = (object)array('status'=>'error','message'=>'Failed to update');
			$this->load->view('edit_round1',array('response'=>$data,'q_count'=>$q_count,'question'=>$question,'badge_types'=>$badge_types));
			}
		} else {
			$data = (object)array('status'=>'error','message'=>'Missing some parameters');
			$this->load->view('edit_round1',array('response'=>$data,'q_count'=>$q_count,'question'=>$question,'badge_types'=>$badge_types));
		}
	}

	/************FOR ROUND 1 ENCODER****************/
	public function encoder_round1(){
		$team = $this->user_model->get_all_teams();
		$q_count = $this->app_model->get_qcount_r1();
		if($q_count > 0){
			$this->load->view('encoder_round1',array('teams'=>$team,'q_count'=>$q_count));

		} else {
			$data = (object)array('status'=>'error','message'=>'Round1 Question not initialized');
			$this->load->view('encoder_round1',array('response'=>$data,'teams'=>$team));	
		}
	}
	public function get_team_correct(){
		if(isset($_POST['team_id'])){
			$answered = $this->round1_model->get_answered_questions(array('team_id'=>$_POST['team_id']));
			$response['status'] = "ok";
			$response['message'] = "Answered Items";
			$response['data'] = $answered;
			echo json_encode($response);
		} else {
			$response['message'] = "Missing parameters";
			$response['status'] = "error";
			echo json_encode($response);
		}

	}
	public function addto_round1_answer(){
		date_default_timezone_set('EST');
		$date = new DateTime();
		$d = $date->format('H:i:s');	//change format later\
		if(isset($_POST['q_number']) && isset($_POST['team_id'])){
			$app_config = $this->app_model->get_app_config();
			$state = $app_config[0]->app_state;
			if($state == 'round_1m'){
				$is_fast = true;
			} else{
				$is_fast = false;
			}
			$params = array('team_id'=>$_POST['team_id'],'q_number'=>$_POST['q_number'],'answered_time'=>$d,'is_fast_round'=>$is_fast);
			$res = $this->round1_model->setAnswered($params);
			if($res){
				$q_e = $this->app_model->get_question_r1($_POST['q_number']);
				$pts = $q_e[0]->points;
				$t = $this->user_model->get_single_team($_POST['team_id']);	
				$name = $t[0]->team_name;
				$txt = "Team {$name} answered question number".$_POST['q_number']."(".$q_e[0]->q_type.") worth {$pts}pts";
				$params = array('evnt'=>$txt,'priority'=>1,'date_time'=>$d);
				$this->event_model->add_event($params);

				/**********ADD CHECKING FOR BADGE HERE************/
				$badge_types = $this->badge_model->getBadgeType($_POST['q_number']);
				
				if(!is_null($badge_types)){
					foreach($badge_types as $badge_type){
						if(!$this->badge_model->hasOwner($badge_type)){
							if($this->badge_model->hasCompletedBadgeFragments($t,$badge_type)){
								$response['has_completed_badge'] = "true";
								$response['badge_type'] = $badge_type;
								$response['team_id'] = $this->team_model->getTeamName(array('team_id'=>$_POST['team_id']));
								$this->badge_model->setOwner($_POST['team_id'],$badge_type,$d);
							}
						}
					}
				}
				$response['time_answered'] = $d;
				$response['status'] = "ok";
				$response['message'] = "Updated team answer";
				echo json_encode($response);
			} else{
				$response['status'] = "error";
				$response['message'] = "Something went wrong";
				echo json_encode($response);	
			}
		} else {
			$response['status'] = "error";
			$response['message'] = "Missing parameters";
			echo json_encode($response);
		}
	}

	public function delete_round1_answer(){
		if(isset($_POST['q_number']) && isset($_POST['team_id'])){
			$params = array('team_id'=>$_POST['team_id'],'q_number'=>$_POST['q_number']);
			$res = $this->round1_model->deleteAnswered($params);
			if($res){
				$badge_types = $this->badge_model->getBadgeType($_POST['q_number']);
				if(!is_null($badge_types)){
					foreach($badge_types as $badge_type){
						if($this->badge_model->hasOwner($badge_type) == $params['team_id']){
							$response['has_removed_badge'] = "false";
							$response['bage_type'] = $badge_type;
							$response['team_id'] = $this->team_model->getTeamName(array('team_id'=>$_POST['team_id']));
							$this->badge_model->setOwner(NULL,$badge_type,NULL);
						}
					}
				}
				$response['status'] = "ok";
				$response['message'] = "Deleted team answer";
				echo json_encode($response);
			} else{
				$response['status'] = "error";
				$response['message'] = "Something went wrong";
				echo json_encode($response);	
			}
		} else {
			$response['status'] = "error";
			$response['message'] = "Missing parameters";
			echo json_encode($response);
		}
	}
	/*****************ROUND 2**********************/
	public function edit_round2(){
		$app_conf = $this->app_model->get_app_config();
		$q_count = $app_conf[0]->round2_question_count;
		if($q_count == 0){
			$data = (object)array('status'=>'error','message'=>'Question Count is set to 0. Generate a new question set.');
			$this->load->view('edit_round2',array('response'=>$data,'q_count'=>$q_count));
		} else {
			$data = (object)array('status'=>'ok');
			$this->load->view('edit_round2',array('response'=>$data,'q_count'=>$q_count));
		}
	}
	public function get_round2_question(){
		if(isset($_POST['q_number'])){
			$q_count = $this->app_model->get_qcount_r1();
			$question = $this->app_model->get_question_r1($_POST['q_number']);
			$data = (object)array('status'=>'ok','message'=>'Question set to question number:'.$_POST['q_number']);
			$this->load->view('edit_round1',array('response'=>$data,'q_count'=>$q_count,'question'=>$question));
			
		} else{
			echo "Invalid Access..!!";
		}	
	}

}