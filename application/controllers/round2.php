<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Round2 extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('app_model');
		$this->load->model('round2_model');
        $this->load->model('badge_model');
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

    public function get_base_scores(){
        $res = $this->round2_model->getBaseScores();
        echo json_encode($res);
    }

    public function get_scores(){
        $res = $this->round2_model->getScores();
        echo json_encode($res);
    }

	/*****************ROUND 2 EDITING**********************/
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

    public function edit_by_question(){
        $app_conf = $this->app_model->getAppConfig();
        $q_count = $app_conf[0]->round2_question_count;

        $data = (object)array('status'=>'ok');
        $this->load->view('edit_round2',array('response'=>$data,'q_count'=>$q_count));
    }

	public function get_question(){
        if(isset($_GET['q_number'])){
            $app_conf = $this->app_model->getAppConfig();
            $q_count = $app_conf[0]->round2_question_count;
            $question = $this->app_model->getQuestionR2($_GET['q_number']);
            if($question == null){
                $question = array((object)array('q_number' => $_GET['q_number'],'q_type' => 'e',
                    'multiplier' => '', 'points' => '', 'prev_timer' => '',
                    'badge_timer' => '', 'bet_timer' => '', 'q_timer' => '',
                    'body' => '', 'answer' => ''));
            }
            $data = (object)array('status'=>'ok','message'=>'Question set to number:'.$_GET['q_number']);
            $this->load->view('edit_round2',array('response'=>$data,'q_count'=>$q_count,'question'=>$question));
        } else{
            echo "Invalid Access..!!";
        }
	}

	public function update_question(){
        $app_conf = $this->app_model->getAppConfig();
        $q_count = $app_conf[0]->round2_question_count;
        $question = $this->app_model->getQuestionR2($_POST['q_number']);
		if(isset($_POST['multiplier']) && isset($_POST['points']) && $_POST['multiplier'] != '' && $_POST['points'] != ''){
			$params = array('q_number' => $_POST['q_number'], 'multiplier' => $_POST['multiplier'],'points'=>$_POST['points'],'badge_timer'=>$_POST['badge_timer'],'q_type'=>$_POST['q_type'][0],'prev_timer'=>$_POST['prev_timer'],'bet_timer'=>$_POST['bet_timer'],'q_timer'=>$_POST['q_timer'],'body'=>$_POST['body'],'answer'=>$_POST['answer']);
			if($this->app_model->isQuestionAlreadyExist('questions_round2',$_POST['q_number'])){
                $res = $this->app_model->updateRound2Question($params,$_POST['q_number']);
            }else{
                $res = $this->app_model->insertRound2Question($params);
			}
			if($res){
                $this->session->set_flashdata('data',(object)array('status'=>'ok','message'=>'Updated Question '.$_POST['q_number'].'.'));
                redirect('round2/get_question?q_number='.$_POST['q_number'],'refresh');
			}else{
				$data = (object)array('status'=>'error','message'=>'Failed to update');
				$this->load->view('edit_round2',array('response'=>$data,'q_count'=>$q_count,'question'=>$question));
			}
		} else {
			$data = (object)array('status'=>'error','message'=>'Missing some parameters');
			$this->load->view('edit_round2',array('response'=>$data,'q_count'=>$q_count,'question'=>$question));
		}
	}

	function getScore(){
		$res = $this->round2_model->getScores();

		$i=0;
		foreach( $res as $key){
			$arr[$i]['team_name'] = $key->team_name;
			$arr[$i]['points'] = $key->points;
			$arr[$i++]['team_id'] = $key->team_id;
		}
		echo json_encode($arr);
	}

	function getBaseScore(){
		$res = $this->round2_model->getBaseScores();

		$i=0;
		foreach( $res as $key){
			$arr[$i]['team_name'] = $key->team_name;
			$arr[$i]['points'] = $key->points;
			$arr[$i++]['team_id'] = $key->team_id;
		}
		echo json_encode($arr);
	}

	function loadScores(){
		$res1 = $this->round2_model->getScores();
		$res = $this->round2_model->getBaseScores();
		$i=0;
		foreach($res as $key){
			$arr[$i]['team_name'] = $key->team_name;
			$arr[$i]['points'] = $key->points;
			foreach( $res1 as $key1){
				if($key1->team_id == $key->team_id){
						$arr[$i]['points'] = $key->points + $key1->points;
				}
			}
			$arr[$i++]['team_id'] = $key->team_id;
		}
		for ($i = 1 ; $i < count($arr); $i++) {
    		$d = $i;

    		while ( $d > 0 && $arr[$d]['points']> $arr[$d-1]['points']) {
     			$t = $arr[$d];
      			$arr[$d]=$arr[$d-1];
      			$arr[$d-1]= $t;
      		$d--;
    		}
    	}
		echo json_encode($arr);
	}

	function isCorrect(){
		$res = $this->round2_model->isCorrect();
		$i=0;
		foreach( $res as $key){
			$arr[$i]['team_id'] = $key->team_id;
			$arr[$i++]['team_name'] = $key->team_name;
		}
		echo json_encode($arr);
	}

	function encoder_round2(){
		$data["teams"] = $this->team_model->getAllTeams();
        $data["badges"] = $this->badge_model->getBadges();
		$data["question_count"] = $this->round2_model->getTotalQuestions('questions_round2');
		$this->load->view("encoder_round2", $data);
	}

    function use_badge($badge_in_effect){
        $owner = $this->badge_model->getOwner($badge_in_effect);
        if($owner != NULL){
            if($badge_in_effect == 'ABS'){
                $res1 = $this->round2_model->getScores();
                $res2 = $this->round2_model->getBaseScores();
                $owner_bet = 0;
                foreach($res1 as $key1){
                    foreach($res2 as $key2){
                        if($key2->team_id == $key1->team_id && $key2->team_id != $owner){
                            if($key2->points + $key1->points > 30){
                                $owner_bet += 20;
                                if($_POST[$key2->team_id] == 1){
                                    $query = "UPDATE answered_round2 SET bet = bet-20 WHERE team_id='team-id' AND badge_in_effect='ABS'";
                                }else{
                                    $query = "UPDATE answered_round2 SET bet = bet+20 WHERE team_id='team-id' AND badge_in_effect='ABS'";
                                }
                                $this->badge_model->executeBadge($key2->team_id,$query);
                            }
                        }
                    }
                }
                if($_POST[$owner] == 1){
                    $query = "UPDATE answered_round2 SET bet = '{$owner_bet}' WHERE team_id='team-id' AND badge_in_effect='ABS'";
                    if($this->badge_model->executeBadge($owner,$query))
                        echo "Badge has been successfully executed.";
                    else
                        echo "Badge failed to execute.";
                }
            }else{
                $query = $this->badge_model->getQuery($badge_in_effect);
                $this->badge_model->executeBadge($owner,$query);
            }
            $this->badge_model->setOwner(NULL,$badge_in_effect,NULL);
        }
    }

    function get_scores_encoder($team_id){
        $res1 = $this->round2_model->getScores();
        $res2 = $this->round2_model->getBaseScores();
        foreach($res1 as $key1){
            foreach($res2 as $key2){
                if($team_id == $key2->team_id && $key2->team_id == $key1->team_id){
                    return $key2->points + $key1->points;
                }
            }
        }
    }

	function update_round2(){
		if(isset($_POST["submit"])){
            $question_number = $_POST["question_number"];
            $res = TRUE;

            switch($_POST['option']){
                case "bet":
                    $str = trim($_POST['text']);
                    $str = str_replace("\n",";",$str);
                    $arr = explode(";",trim($str));

                    foreach($arr as $el){
                        $entry = explode(",",$el);
                        $team_no = $entry[0];
                        $bet = $entry[1];

                        $team_id = $this->team_model->getTeamIdByNo($team_no);
                        if(is_null($team_id)){
                            echo "ERROR: Team ".$team_no." does not exist.<br/>";
                        }
                        if($bet % 10 != 0){
                            echo "ERROR: Team ".$team_no."'s bet is not divisible by 10.<br/>";
                        }
                        if(!is_null($team_id) && $bet % 10 ==0){
                            $params = array('q_number'=>$question_number,'team_id'=>$team_id,'is_correct'=>0,'bet'=>$bet);

                            $team_in_db = $this->round2_model->isTeamAlreadyExist('answered_round2', $question_number, $team_id);
                            if($team_in_db > 0)
                                $res = $this->round2_model->editBet($params);
                            else
                                $res = $this->round2_model->insertBet($params);
                            echo "Team ".$team_no."'s bet set to ".$bet."<br/>";
                        }
                    }
                    echo $res ? "<br/>Bets submitted for Question Number $question_number." : "Something went wrong.";
                    break;
                case "correct":
                    $badge_in_effect = $this->round2_model->getBadgeInEffect($question_number);
                    $str = trim($_POST['text']);
                    $str = str_replace("\n",";",$str);
                    $arr = explode(";",trim($str));
                    foreach($arr as $el){
                        $entry = explode(",",$el);
                        $team_no = $entry[0];
                        $is_correct = $entry[1];

                        $team_id = $this->team_model->getTeamIdByNo($team_no);
                        if(is_null($team_id)){
                            echo "ERROR: Team ".$team_no." does not exist.<br/>";
                        }
                        else if($is_correct == 0 || $is_correct == 1){
                            $team_id = $this->team_model->getTeamIdByNo($team_no);
                            $params = array('q_number'=>$question_number,'team_id'=>$team_id,'is_correct'=>$is_correct,'badge_in_effect'=>$badge_in_effect);

                            $team_in_db = $this->round2_model->isTeamAlreadyExist('answered_round2', $question_number, $team_id);
                            if($team_in_db > 0)
                                $res = $this->round2_model->updateScore($params);
                            else
                                $res = $this->round2_model->insertScore($params);
                            $curr_score = $this->get_scores_encoder($team_id);
                            if($badge_in_effect == NULL){
                                echo $is_correct == 1?
                                    "CORRECT: "."Team ".$team_no."'s updated score = ".$curr_score." ; bet = ".$this->round2_model->getBet($question_number,$team_id)."<br/>"
                                    :
                                    "WRONG: "."Team ".$team_no."'s updated score = ".$curr_score." ; bet = ".$this->round2_model->getBet($question_number,$team_id)."<br/>";
                            }else{
                                if($badge_in_effect == NULL) "ERROR: Team ".$team_no." has wrong input for is_correct.<br/>";
                            }
                        }
                    }
                    if($badge_in_effect != NULL){
                        $this->use_badge($badge_in_effect);
                        foreach($arr as $el){
                            $entry = explode(",",$el);
                            $team_no = $entry[0];
                            $is_correct = $entry[1];
                            $team_id = $this->team_model->getTeamIdByNo($team_no);
                            $curr_score = $this->get_scores_encoder($team_id);
                            $owner = $this->badge_model->getOwner($badge_in_effect);
                            if($is_correct == 0 || $is_correct == 1){
                                echo $is_correct == 1 ?
                                    "CORRECT: "."Team ".$team_no."'s updated score = ".$curr_score." ; bet = ".$this->round2_model->getBet($question_number,$team_id)."<br/>"
                                    :
                                    "WRONG: "."Team ".$team_no."'s updated score = ".$curr_score." ; bet = ".$this->round2_model->getBet($question_number,$team_id)."<br/>";
                            }else{
                                echo "ERROR: Team ".$team_no." has wrong input for is_correct.<br/>";
                            }
                        }
                    }
                    echo $res ? "<br/>"."Scores updated for Question Number $question_number." : "Something went wrong";
                    break;
            }
        }
	}

    function set_badge(){
        if(isset($_POST['badge_id'])){
            if($this->badge_model->hasOwner($_POST['badge_id'])){
                $this->round2_model->setBadgeInEffect($_POST['badge_id'],$_POST['question_number']);
                $response['status'] = "ok";
                $response['message'] = "Badge ".$_POST['badge_id']." has been set";
            }else{
                $response['status'] = "error";
                $response['message'] = "Something went wrong";
            }
            echo json_encode($response);
        }
    }
}