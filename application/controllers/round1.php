<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Round1 extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('app_model');
		$this->load->model('round1_model');
		$this->load->model('event_model');
		$this->load->model('badge_model');
		$this->load->model('team_model');
		//$this->user_model->auth(); //add this function if you want to make it private
	}

	/************FOR ROUND 1 VIEWER****************/
	public function state(){
		$res = $this->app_model->getAppConfig();
		$response['status'] = "ok";
		$response['message'] = "App config";
		$response['round1_state'] = $res[0]->app_state;
		echo json_encode($response);
	}

	public function timer(){
		$res = $this->app_model->getAppConfig();
		$response['status'] = "ok";
		$response['message'] = "Round1 timer";
		$response['round1_state'] = $res[0]->round1_timer;
		echo json_encode($response);	
	}

	public function team_score(){
		$res = $this->round1_model->getScores();
		$response['status'] = "ok";
		$response['message'] = "Score List";
		$response['round1_state'] = $res;
		echo json_encode($response);	
	}

	/************FOR ROUND 1 ENCODER****************/
	public function encoder(){
		$team = $this->team_model->getAllTeams();
		$q_count = $this->app_model->getQCountR1();
		if($q_count > 0){
			$this->load->view('encoder_round1',array('teams'=>$team,'q_count'=>$q_count-1));

		} else {
			$data = (object)array('status'=>'error','message'=>'Round1 Question not initialized');
			$this->load->view('encoder_round1',array('response'=>$data,'teams'=>$team));	
		}
	}
	public function add_to_answer(){
		date_default_timezone_set('EST');
		$date = new DateTime();
		$d = $date->format('U = H:i:s');
		if(isset($_POST['q_number']) && isset($_POST['team_id'])){
			$app_config = $this->app_model->getAppConfig();
			$state = $app_config[0]->app_state;
			if($state == 'round_1m'){
				$is_fast = true;
			} else{
				$is_fast = false;
			}
			$params = array('team_id'=>$_POST['team_id'],'q_number'=>$_POST['q_number'],'answered_time'=>$d,'is_fast_round'=>$is_fast);
			$res = $this->round1_model->setAnswered($params);
			if($res){
				$q_e = $this->app_model->getQuestionR1($_POST['q_number']);
				$pts = $q_e[0]->points;
				$t = $this->team_model->getSingleTeam($_POST['team_id']);	
				$name = $t[0]->team_name;
				$txt = "Team {$name} answered question number".$_POST['q_number']."(".$q_e[0]->q_diff.") worth {$pts}pts";
				$params = array('evnt'=>$txt,'priority'=>1,'date_time'=>$d);
				$this->event_model->addEvent($params);

				/**********ADD CHECKING FOR BADGE HERE************/
				$badge_types = $this->badge_model->getBadgeType($_POST['q_number']);
				
				if(!is_null($badge_types)){
					foreach($badge_types as $badge_type){
						if(!$this->badge_model->hasOwner($badge_type)){
							$params = array('team'=>$t,'badge_type'=>$badge_type,'q_type'=>$q_e[0]->q_type);
							if($this->badge_model->hasCompletedBadgeFragments($params)){
								$badge_name = $this->badge_model->getBadgeName($badge_type);
                                $response['badge_completion'] = "Team {$name} obtained the {$badge_name->name} badge.";
                                $params = array('evnt'=>$response['badge_completion'],'priority'=>1,'date_time'=>$d);
                                $this->badge_model->setOwner($response['team_id'],$badge_type,$d);
                                $this->event_model->addEvent($params);
                            }
						}
					}
				}
				$response['message'] = $txt;
				$response['time_answered'] = $d;
				$response['status'] = "ok";
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

	public function delete_answer(){
		if(isset($_POST['q_number']) && isset($_POST['team_id'])){
			$params = array('team_id'=>$_POST['team_id'],'q_number'=>$_POST['q_number']);
			$res = $this->round1_model->deleteAnswered($params);
			
			$q_e = $this->app_model->getQuestionR1($_POST['q_number']);
			$pts = $q_e[0]->points;

			if($res){
				$badge_types = $this->badge_model->getBadgeType($_POST['q_number']);
					if(!is_null($badge_types)){
					foreach($badge_types as $badge_type){
						if($this->badge_model->hasOwner($badge_type) == $params['team_id']){
							$response['has_removed_badge'] = "true";
							$response['badge_type'] = $badge_type;
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

	/*************FOR ROUND1 QUESTION SETTINGS*******************/
	public function edit(){
		$q_count = $this->app_model->getQCountR1();

		if($q_count == 0){
			$data = (object)array('status'=>'error','message'=>'Question Count is set to 0. Generate a new question set.');
			$this->load->view('edit_round1',array('response'=>$data,'q_count'=>$q_count));
		} else {
			$data = (object)array('status'=>'ok');
			$this->load->view('edit_round1',array('response'=>$data,'q_count'=>$q_count));
		}
	}

	public function edit_by_badge(){		
		$q_count = $this->app_model->getQCountR1();
		$data = (object)array('status'=>'ok');
		$this->load->view('edit_round1_by_badge',array('response'=>$data,'q_count'=>$q_count));
	}

	public function edit_by_difficulty(){
		$q_count = $this->app_model->getQCountR1();
		
		$data = (object)array('status'=>'ok');
		$this->load->view('edit_round1_by_difficulty',array('response'=>$data,'q_count'=>$q_count));
	}

	public function edit_by_question(){
		$q_count = $this->app_model->getQCountR1();	
		
		$data = (object)array('status'=>'ok');
		$this->load->view('edit_round1_by_question',array('response'=>$data,'q_count'=>$q_count));
	}

	public function edit_by_type(){
		$q_count = $this->app_model->getQCountR1();	
		
		$data = (object)array('status'=>'ok');
		$this->load->view('edit_round1_by_type',array('response'=>$data,'q_count'=>$q_count));
	}

	public function gen(){
		$app_config = $this->app_model->getAppConfig();
		$r1_count = $app_config[0]->round1_question_count;	
		if($r1_count == 0){
			$data = (object)array('status'=>'error','message'=>'Question Count is set to 0. Edit application settings');
			$this->load->view('edit_round1',array('response'=>$data,'q_count'=>$r1_count));
		} else {
			$res = $this->app_model->genRound1($r1_count);
			if($res){
				$q_count = $this->app_model->getQCountR1();
				$data = (object)array('status'=>'ok','message'=>'Generated new set of questions. Difficulty is set to easy. Points is set to 0, Badge is set to none.');
				$this->load->view('edit_round1',array('response'=>$data,'q_count'=>$q_count));
			} else{
				$data = (object)array('status'=>'error','message'=>'Something went wrong while updating. Please generate new question set.');
				$this->load->view('edit_round1',array('response'=>$data,'q_count'=>0));
			}
		}
	}
	public function get_question(){
		if(isset($_GET['q_number'])){
			$q_count = $this->app_model->getQCountR1();
			$question = $this->app_model->getQuestionR1($_GET['q_number']);
			$badge_types = $this->badge_model->getBadgeType($_GET['q_number']);
			$data = (object)array('status'=>'ok','message'=>'Question set to question number:'.$_GET['q_number']);
			$this->load->view('edit_round1_by_question',array('response'=>$data,'q_count'=>$q_count,'question'=>$question,'badge_types'=>$badge_types));
			
		} else{
			echo "Invalid Access..!!";
		}	
	}

    public function init_score(){
        if($this->team_model->getTotalNumberOfTeams() > 0){
            $this->team_model->initializeScores();
        }
    }

	public function update_badge(){
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
					$this->round1_model->updateQuestionBadge($params);
				}
				else{
					$tok = strtok($q_number,'-');
					while($tok != false){
						$range[] = $tok;
						$tok = strtok('-');	
					}
					for($i = $range[0] ; $i <= $range[1] ; $i++){
						$params = array('q_number'=>$i,'badge_types'=>$badge_types);
						$this->round1_model->updateQuestionBadge($params);
					}
					unset($range);
				}
			}
			$this->session->set_flashdata('data',(object)array('status'=>'ok','message'=>'Badges per question was updated successfly.'));
			redirect('../round1/edit_by_badge');
		}
		else{
			$this->session->set_flashdata('data',(object)array('status'=>'error','message'=>'Empty input'));
			redirect('../round1/edit_by_badge');
		}
	}

	public function update_difficulty(){
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
					$this->round1_model->updateQuestionDifficulty($params);
				}
				else{
					$tok = strtok($q_number,'-');
					while($tok != false){
						$range[] = $tok;
						$tok = strtok('-');	
					}
					for($i = $range[0] ; $i <= $range[1] ; $i++){
						$params = array('q_number'=>$i,'difficulty'=>$difficulty,'points'=>$points);
						$this->round1_model->updateQuestionDifficulty($params);
					}
				}
			}
			$this->session->set_flashdata('data',(object)array('status'=>'ok','message'=>'Difficulty per question was updated successfly.'));
			redirect('../round1/edit_by_difficulty');
		}
		else{
			$this->session->set_flashdata('data',(object)array('status'=>'error','message'=>'Empty input'));
			redirect('../round1/edit_by_difficulty');
		}
	}

	public function update_question(){
		$q_count = $this->app_model->getQCountR1();
		$question = $this->app_model->getQuestionR1($_POST['q_number']);
		$badge_types = $this->badge_model->getBadgeType($_POST['q_number']);

		if(isset($_POST['q_multiplier']) && isset($_POST['points']) && $_POST['q_multiplier'] != '' && $_POST['points'] != ''){
			$question_params = array('q_multiplier' => $_POST['q_multiplier'],'points'=>$_POST['points'],''=>$_POST['q_diff']);
			$res1 = $this->round1_model->updateRound1Question($question_params,$_POST['q_number']);
			$res2 = $this->round1_model->updateQuestionBadge(array('q_number'=>$_POST['q_number'],'badge_types'=>$_POST['badge_types']));
			if($res1 && $res2){
				$question = $this->app_model->getQuestionR1($_POST['q_number']);
				$data = (object)array('status'=>'ok','message'=>'Updated Question '.$_POST['q_number']);
				$this->load->view('edit_round1_by_question',array('response'=>$data,'q_count'=>$q_count,'question'=>$question,'badge_types'=>$badge_types));
			}else{
				$data = (object)array('status'=>'error','message'=>'Failed to update');
				$this->load->view('edit_round1_by_question',array('response'=>$data,'q_count'=>$q_count,'question'=>$question,'badge_types'=>$badge_types));
			}
		} else {
			$data = (object)array('status'=>'error','message'=>'Missing some parameters');
			$this->load->view('edit_round1_by_question',array('response'=>$data,'q_count'=>$q_count,'question'=>$question,'badge_types'=>$badge_types));
		}
	}

	public function update_type(){
		if(trim($_POST['question_numbers']) != ''){
			$string = $_POST['question_numbers'];
			$type = $_POST['type'];

			$tok = strtok($string,',');
			while($tok != false){
				$q_numbers[] = $tok;
				$tok = strtok(',');
			}
			foreach($q_numbers as $q_number){
				if(!strpos($q_number,'-')){
					$params = array('q_number'=>$q_number,'type'=>$type);
					$this->round1_model->updateQuestionType($params);
				}
				else{
					$tok = strtok($q_number,'-');
					while($tok != false){
						$range[] = $tok;
						$tok = strtok('-');	
					}
					for($i = $range[0] ; $i <= $range[1] ; $i++){
						$params = array('q_number'=>$i,'type'=>$type);
						$this->round1_model->updateQuestionType($params);
					}
				}
			}
			$this->session->set_flashdata('data',(object)array('status'=>'ok','message'=>'Type per question was updated successfly.'));
			redirect('../round1/edit_by_type');
		}
		else{
			$this->session->set_flashdata('data',(object)array('status'=>'error','message'=>'Empty input'));
			redirect('../round1/edit_by_type');
		}
	}
}