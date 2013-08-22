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

	/*****************ROUND 2 VIEWER**********************/
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
		$this->round2_model->setNextQuestion();
		$res = $this->round2_model->getCurrentQuestionRound2();
		$arr['q_number'] = $res;
		echo json_encode($arr);
	}

	function setPreviousQuestion(){
		$this->round2_model->setPreviousQuestion();
		$res = $this->round2_model->getCurrentQuestionRound2();
		$arr['q_number'] = $res;
		echo json_encode($arr);
	}


	function getCurrentQuestionRound2(){
		$res = $this->round2_model->getCurrentQuestionRound2();
		$arr['q_number'] = $res;
		echo json_encode($arr);	
	}

	/*****************ROUND 2 EDTING**********************/
	public function edit_round2(){
		$app_conf = $this->app_model->getAppConfig();
		$q_count = $app_conf[0]->round2_question_count;
		if($q_count == 0){
			$data = (object)array('status'=>'error','message'=>'Question Count is set to 0. Generate a new question set.');
			$this->load->view('edit_round2',array('response'=>$data,'q_count'=>$q_count));
		} else {
			$data = (object)array('status'=>'ok');
			$this->load->view('edit_round2',array('response'=>$data,'q_count'=>$q_count));
		}
	}

	function getQuestionDetails(){
		$res = $this->round2_model->getQuestionDetails();
		$arr['q_type'] = $res->q_type;
		$arr['q_number'] = $res->q_number;
		$arr['q_timer'] = $res->q_timer;
		$arr['body'] = $res->body;
		$arr['answer'] = $res->answer;
		echo json_encode($arr);
	}

	public function get_round2_question(){
		if(isset($_POST['q_number'])){
			$app_conf = $this->app_model->getAppConfig();
			$q_count = $app_conf[0]->round2_question_count;
			$question = $this->app_model->getQuestionR2($_POST['q_number']);
			
			if(count($question) == 0){
				$data = (object)array('status'=>'ok','message'=>'No data for question'.$_POST['q_number'].' yet. Please update question data.!');
			}
				$data = (object)array('status'=>'ok','message'=>'Question set to question number:'.$_POST['q_number']);
			$this->load->view('edit_round2',array('response'=>$data,'q_count'=>$q_count,'question'=>$question,'q_num'=>$_POST['q_number']));
			
		} else{
			echo "Invalid Access..!!";
		}	
	}

	public function update_round2_question(){
		$app_conf = $this->app_model->getAppConfig();
		$q_count = $app_conf[0]->round2_question_count;
		$question = $this->app_model->getQuestionR2($_POST['q_number']);
		if(isset($_POST['multiplier']) && isset($_POST['points']) && $_POST['multiplier'] != '' && $_POST['points'] != ''){
			$params = array('multiplier' => $_POST['multiplier'],'points'=>$_POST['points'],'badge_timer'=>$_POST['badge_timer'],'q_type'=>$_POST['q_type'],'prev_timer'=>$_POST['prev_timer'],'bet_timer'=>$_POST['bet_timer'],'q_timer'=>$_POST['q_timer'],'body'=>$_POST['body'],'answer'=>$_POST['answer']);
			if(count($question) == 0){
				$params['q_number'] = $_POST['q_number'];
				$res = $this->app_model->insertRound2Question($params);
			} else{
				$res = $this->app_model->updateRound2Question($params,$_POST['q_number']);
			}
			if($res){
				$question = $this->app_model->getQuestionR2($_POST['q_number']);
				$data = (object)array('status'=>'ok','message'=>'Updated Question For Round2');
				$this->load->view('edit_round2',array('response'=>$data,'q_count'=>$q_count,'question'=>$question,'q_num'=>$_POST['q_number']));
			}else{
				$data = (object)array('status'=>'error','message'=>'Failed to update');
				$this->load->view('edit_round2',array('response'=>$data,'q_count'=>$q_count,'question'=>$question));	
			}
		} else {
			$data = (object)array('status'=>'error','message'=>'Missing some parameters');
			$this->load->view('edit_round2',array('response'=>$data,'q_count'=>$q_count,'question'=>$question));
		}
	}

	/************ENCODER AND BET MODULES FOR ROUND2***************************/
	// public function encoder_round2(){
	// 	$app_conf = $this->app_model->getAppConfig();
	// 	$q_count = $app_conf[0]->round2_question_count;
	// 	$team = $this->team_model->getAllTeams();
	// 	if($q_count > 0){
	// 		$this->load->view('encoder_round2',array('teams'=>$team,'q_count'=>$q_count-1));

	function getScore(){
		$res = $this->round2_model->get_scores();

		foreach( $res as $key){
			echo $key->team_id."<br>";
			echo $key->points."<br>";
		}
	}


	// 	} else {
	// 		$data = (object)array('status'=>'error','message'=>'Round2 Question not initialized');
	// 		$this->load->view('encoder_round2',array('response'=>$data,'teams'=>$team));	
	// 	}
	// }
	
	public function get_team_answers_round2(){
		$app_conf = $this->app_model->getAppConfig();
		$q_count = $app_conf[0]->round2_question_count;
		$team = $this->team_model->getAllTeams();
		if(isset($_POST['q_number']) && $_POST['q_number'] != ""){


		} else{
			$response['status'] = "error";
			$response['message'] = "Missing parameters";
			echo json_encode($response);
		}
	}

	function encoder_round2(){
		$data["team_data"] = $this->team_model->getAllTeams();
		
		//Badges
		$data["badges"] = array(
							0 => array("id" => 0, "badge_name" => "Badge 1", "badge_owner" => "Team 1", "is_used" => 0),
							1 => array("id" => 1,"badge_name" => "Badge 2", "badge_owner" => "Team 2", "is_used" => 1),
							2 => array("id" => 2, "badge_name" => "Badge 3", "badge_owner" => "Team 3", "is_used" => 0),
							3 => array("id" => 3, "badge_name" => "Badge 4", "badge_owner" => "Team 4", "is_used" => 1)
						  );
		
		$data["question_count"] = $this->round2_model->getTotalQuestions('questions_round2');

		$this->load->view("encoder_round2", $data);
	}

	function edit_bet(){
		if(isset($_POST["submit"]) && $_POST["question_number"] != 0){
			$team_count = sizeof($this->team_model->getAllTeams());
			$question_number = $_POST["question_number"];

			for($index = 0; $index < $team_count; $index++){
				$team_id = $_POST[$index];
				$bet = $_POST[$team_id] == "" ? "" : $_POST[$team_id];

				$team_in_db = $this->round2_model->isTeamAlreadyExist('bets', $question_number, $team_id);
				
				if($bet != ""){
					$team_in_db > 0 ? $this->round2_model->editBet($question_number,$team_id,$bet) : $this->round2_model->insertBet($question_number,$team_id,$bet);
					$successful = true;
				}elseif($team_in_db <= 0 && $bet == ""){
					$bet = 0;
					$this->round2_model->insertBet($question_number,$team_id,$bet);
					$successful = true;
				}else{
					$successful = false;
				}
			}
		
			echo $successful ? "Bets submitted for Question Number $question_number." : "";
		}
	}

	function update_score(){
		if(isset($_POST["submit"]) && $_POST["question_number"] != 0){
			$team_count = sizeof($this->user_model->getAllTeams());
			$question_number = $_POST["question_number"];
			$question_points = $this->round2_model->getPoints($question_number);
			$badge_in_effect = $_POST["badge_in_effect"];

			for($index = 0; $index < $team_count; $index++){
				$team_id = $_POST[$index];
				$is_correct = $_POST[$team_id] == "" ? "" : $_POST[$team_id];
				$bet = $this->round2_model->getBet($question_number, $team_id);
				
				$team_in_db = $this->round2_model->isTeamAlreadyExist('answered_round2', $question_number, $team_id);
				
				if($is_correct != ""){
					$team_in_db > 0 ? $this->round2_model->updateScore($question_number,$team_id,$is_correct,$bet,$badge_in_effect,$question_points) :$this->round2_model->insert_score($question_number,$team_id,$is_correct,$bet,$badge_in_effect,$question_points);
					$successful = true;
				}else{
					$successful = false;
				}
			}
			
			echo $successful ? "Scores updated for Question Number $question_number." : "";
		}
	}

	function use_badge(){
		//Use badge
		redirect("round2/encoder_round2");
	}
}