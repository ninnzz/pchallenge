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
	$(document).ready(function() {
		getState();
	});

	function getState(){
		$.post('getState', function(data) {
			console.log(data)
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
			if(hideData==false) setState(obj['state']);
			setTimeout("getState();",1000);
		});
	}

	function getQuestionDetails(){
		$.post('getQuestionDetails', function(data) {
			console.log(data)
			obj = JSON.parse(data);
			$("#q_number").html('Question Number: '+(obj['q_number']));
			$("#duration").html((obj['q_timer'])+' seconds');
			if(obj['q_type']=='e')
				$("#questionType").html('Question Type: Easy');
			else if (obj['q_type'=='a']) 
				$("#questionType").html('Question Type: Average');
			else if (obj['q_type'] == 'd')
				$("#questionType").html('Question Type: Difficult');
			$("#question").html((obj['body']));
			$("#answer").html('Answer: ' + (obj['answer']));
			//console.log(obj['state']);
			current_question_timer = obj['q_timer'];
		});
		
	}


	function hideAllDetails(){
		$("#questionType").hide();
		$("#q_number").hide();
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
		if(state=="init"){
			getQuestionDetails();
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
			$("#questionType").hide();
			$("#duration").hide();
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
			$("#badgeText").show();
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
			$("#betText").show();
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
			$("#timer").hide();
			$("#q_number").show();
			$("#question").show();
			$("#questionTimer").hide();
			
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
			$("#question").hide();
			$("#questionTimer").hide();
			
			$("#answer").show();
			$("#scores").hide();
			
			if(debug)
				console.log("setState(show_answer)");
		}else if(state=="scores"){
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
				<div id="q_header"><div id="q_number"></div></div>
				<div id="q_proper"></div>
				<div id="questionType">QuestionType</div>
				<div id="duration">Duration</div>
				<div id="betText">Betting Timer</div>
				<div id="badgeText">Badge Timer</div>
				<div id="timer"></div>
			
				<div id="question">Question</div>
				<div id="questionTimer">QuestionTimer</div>
				
				<div id="answer">Answer</div>
				<div id="scores">Scores</div>
				<div id="timesup">Time's Up</div>
				
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