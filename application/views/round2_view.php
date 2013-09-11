<?php

	$num=10;
	$q_type="Easy";
?>
<script src="/js/jquery.min.js"></script>
<script src="/js/timer.js"></script>
<link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
<script type="text/javascript" src="/js/routes.js" ></script>
<script>
	var debug=false;
	var current_state= 0;
	var changeState=false;
	var current_question_timer=0;
	var hideData = false;
	var scores_round1;
	var scores_round2;
	$(document).ready(function() {
		getState();
	});

	function getState(){
		$.post('/round2/getState', function(data) {
			console.log(data);
			obj = JSON.parse(data);
			
			//console.log(obj['state']);
			if(current_state==0){
				current_state=obj['state'];
				changeState=true;
			}
			else if(current_state!=obj['state']){
				changeState=true;
				current_state=obj['state'];
				hideData=false;
			}
			else 
				changeState=false;
			console.log(changeState);
			if(hideData==false && changeState==true) 
				setState(obj['state']);
				if(obj['state'] == 'scores' && changeState==true)
					loadScores();
				else if(obj['state'] != 'scores' && changeState==true){
                    $("#part1").empty();
                    $("#part2").empty();
                }
			setTimeout("getState();",1000);
		});
	}

	/*
	function loadScores(){
		$.post('/round2/loadScores', function(data) {
			obj = JSON.parse(data);
			for(i=0;i<obj.length;i++)
				$('#scores').append('<tr><td>'+(obj[i]['team_name'])+'</td><td id='+obj[i]['team_id']+'>'+(obj[i]['points'])+'</tr>');
				//$('#scores').hide();
			//addScores();
			isCorrect();
		});
		
	}
	*/

	function loadScores(){
		$.post('/round2/loadScores', function(data) {
			obj = JSON.parse(data);
            console.log(obj);
			for(i = 0; i < obj.length; i++){
				var team_name = obj[i]['team_name'];

				if(team_name.length > 20){
                	team_name = team_name.substring(0,25) + "...";
            	}

				$("#"+"score_team"+i).html(team_name);
            	$("#"+"score_points"+i).html(obj[i]['points']);
                if(i<10)
                    $('#part1').append('<div id=team'+i+' class="team_style '+obj[i]['team_id']+'">'+
                    '<div class="team_num"><p>'+(i+1)+'</p></div>'+
                    '<div id="score_team'+i+'" style="width: 75%; float:left; font-size:150%; margin-top: 1%;">'+team_name+'</div>'+
                    '<div id="score_points'+i+'" style="float: right; margin-right: 2%; font-size: 150%; margin-top: 1%;">'+obj[i]['points']+'</div>'+
                    '</div>');
                else
                    $('#part2').append('<div id=team'+i+' class="team_style '+obj[i]['team_id']+'">'+
                        '<div class="team_num"><p>'+(i+1)+'</p></div>'+
                        '<div id="score_team'+i+'" style="width: 75%; float:left; font-size:150%; margin-top: 1%;">'+team_name+'</div>'+
                        '<div id="score_points'+i+'" style="float: right; margin-right: 2%; font-size: 150%; margin-top: 1%;">'+obj[i]['points']+'</div>'+
                        '</div>');
			}
				//$('#scores').hide();
			//  addScores();
			isCorrect();
		});
		
	}

	/*function addScores(){
		$.post('getScore', function(data) {
			console.log('pwede');
			obj = JSON.parse(data);
			for(i=0;i<obj.length;i++){
				selector = '#'+obj[i]['team_id'];
				//console.log(selector + ' selector');
				var score_round1 = $(selector).html();
				score = parseInt(score_round1) + parseInt(obj[i]['points']);
				//console.log('add' + score);
				$(selector).html(score);
			}
			isCorrect();
		});
		
	}*/


	function getQuestionDetails(){
		$.post('/round2/getQuestionDetails', function(data) {
			console.log(data);
			obj = JSON.parse(data);
			$("#q_number").html('Question Number: ' + (obj['q_number']));
			$("#duration").html((obj['q_timer'])+' seconds');
			if(obj['q_type']=='e')
				$("#questionType").html('Question Type: Easy');
			else if (obj['q_type'] =='a')
				$("#questionType").html('Question Type: Average');
			else if (obj['q_type'] == 'd')
				$("#questionType").html('Question Type: Difficult');
			$("#question").html((obj['body']));
			$("#answer").html('Answer: ' + (obj['answer']));
			//console.log(obj['state']);
			current_question_timer = obj['q_timer'];
		});
		
	}

	function isCorrect(){
		$.post('/round2/isCorrect', function(data) {

			obj = JSON.parse(data);
            console.log("asdasdasd");
			for(i=0;i<obj.length;i++){
				selector = '.'+obj[i]['team_id'];
				console.log(selector + ' selector');
				$(selector).addClass('correct');
			}
		});
    }


	function hideAllDetails(){
		//$("#q_header").hide();
		$("#questionType").hide();
		//$("#q_number").hide();
		$("#duration").hide();
		$("#badgeText").hide();
		$("#betText").hide();
		$("#timer").hide();
		$("#question").hide();
		$("#questionTimer").hide();
		
		$("#answer").hide();
		$("#scores").hide();
		$("#timesup").show();
		hideData = true;
		
	}
	
	function setState(state){
		$("#timesup").hide();
//		$("#scores").show();
		if(state=="init"){
			getQuestionDetails();
			$("#q_header").animate({width: 'toggle'});
			$("#questionType").show();
			$("#duration").show();
			$("#badgeText").hide();
			$("#betText").hide();
			$("#timer").hide();
			$("#q_number").show();
			$("#question").hide();
			$("#questionTimer").hide();
			$("#answer").hide();
			$("#scores").hide();
			if(debug)
				console.log("setState(init)");
		}
		else if(state=="preview"){
			getQuestionDetails();
			if(changeState==true) countdown('timer', 5, hideAllDetails);
			$("#questionType").show();
			$("#duration").show();
			$("#badgeText").hide();
			$("#betText").hide();
			$("#timer").show();
			$("#question").show();
			$("#questionTimer").hide();
			$("#answer").hide();
			$("#scores").hide();
			$("#q_number").show();
			
			if(debug)
				console.log("setState(preview)");
		}
		else if(state=="badge"){
			$("#questionType").hide();
			if(changeState==true) countdown('timer', 10, hideAllDetails);
			$("#duration").hide();
			$("#badgeText").animate({width: 'toggle'});
			$("#betText").hide();
			$("#timer").show();
			$("#question").hide();
			$("#questionTimer").hide();
			
			$("#answer").hide();
			$("#scores").hide();
			$("#q_number").show();
			if(debug)
				console.log("setState(badge)");
		}
		else if(state=="bet"){
			$("#questionType").hide();
			if(changeState==true) countdown('timer', 10, hideAllDetails);
			$("#duration").hide();
			$("#badgeText").hide();
			$("#betText").animate({width: 'toggle'});
			$("#timer").show();
			$("#q_number").show();
			$("#question").hide();
			$("#questionTimer").hide();
			$("#q_number").show();
			$("#answer").hide();
			$("#scores").hide();
			
			if(debug)
				console.log("setState(bet)");
		}
		else if(state=="show_question"){
			$("#questionType").hide();
			$("#duration").hide();
			$("#badgeText").hide();
			$("#betText").hide();
			$("#timer").hide()
			$("#q_number").show();
			$("#question").show();
			$("#questionTimer").show();
			$("#answer").hide();
			$("#scores").hide();
			
			if(debug)
				console.log("setState(show_question)");
		}
		else if(state=="timer"){
			if(changeState==true) countdown('timer', current_question_timer, hideAllDetails);
			$("#questionType").hide();
			$("#duration").hide();
			$("#badgeText").hide();
			$("#betText").hide();
			$("#timer").show();
			$("#q_number").show();	
			$("#question").show();
			$("#answer").hide();
			$("#scores").hide();
			
			if(debug)
				console.log("setState(timer)");
		}else if(state=="show_answer"){
			$("#questionType").hide();
			$("#duration").hide();
			$("#badgeText").hide();
			$("#betText").hide();
			$("#timer").hide();
			$("#q_number").show();
			$("#question").show();
			$("#questionTimer").hide();
			$("#answer").show();
			$("#scores").hide();
			$("#q_header").animate({width: 'toggle'});
			if(debug)
				console.log("setState(show_answer)");
		}else if(state=="scores"){
			$("#q_header").hide();
			$("#questionType").hide();
			$("#duration").hide();
			$("#badgeText").hide();
			$("#betText").hide();
			$("#timer").hide();
			$("#q_number").hide();
			$("#question").hide();
			$("#questionTimer").hide();
			$("#answer").hide();
			$("#scores").show();

            $.get("/round2/")
			
			if(debug)
				console.log("setState(scores)");
		}
	}
</script>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="/css/round2_view.css">
		<link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
		<script type="text/javascript" src="/js/jquery.min.js"></script>
	</head>
	<body>
		<div id="outer">		
			<div id="upper">
				<div id="q_header">
				<div id="q_number"></div></div>
				<div id="q_proper"></div>
				<div id="question">Question</div>
				<div id="questionType">QuestionType</div>
				<div id="duration">Duration</div>
				<div id="betText">Place your bets now!</div>
				<div id="badgeText">Who wants to use a badge?</div>
				<div id="questionTimer"></div>
				<div id="timer"></div>
				<div id="answer">Answer</div>
				<div id="timesup">Time's Up!</div>
				<div id="scores">
				<div id="team_scores">
					TEAM SCORES
				</div>
				<div id="part1" style="width: 48%; green; height: 98%; float:left; padding: 1% 1%;">
				</div>
				<div id="part2" style="width: 48%; height: 98%; float:left; padding: 1% 1%;">
				</div>

			</div>
			</div>
			<div id="lower">
					<div id="left">
						<center>Exclusive Partner</center>
					</div>
					<div id="center">
						<center>Major Sponsors</center>
					</div>
					<div id="right">
						<center>Minor Sponsors</center>
					</div>	
			</div>
		</div>

	</body>

	<script>setState("preview");</script>
</html>