<?php

	$num=10;
	$q_type="Easy";
?>
<script src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/routes.js" ></script>
<script>
	var debug=false;

	$(document).ready(function() {
		getState();
	});

	function getState(){
		$.post('getState', function(data) {
			//console.log(data)
			obj = JSON.parse(data);
			setState(obj['state']);
			//console.log(obj['state']);
			setTimeout("getState();",1000);
		});
	}

	function getQuestion(){
		
	}
	
	function setState(state){
		if(state=="init"){
			$("#questionType").show();
			$("#duration").show();
			$("#badgeText").hide();
			$("#betText").hide();
			$("#timer").hide();
			
			$("#question").hide();
			$("#questionTimer").hide();
			
			$("#answer").hide();
			$("#scores").hide();
			
			if(debug)
				console.log("setState(init)");
		}
		else if(state=="preview"){
			$("#questionType").hide();
			$("#duration").hide();
			$("#badgeText").hide();
			$("#betText").hide();
			$("#timer").hide();
			
			$("#question").show();
			$("#questionTimer").show();
			
			$("#answer").hide();
			$("#scores").hide();
			
			if(debug)
				console.log("setState(preview)");
		}
		else if(state=="badge"){
			$("#questionType").hide();
			$("#duration").hide();
			$("#badgeText").show();
			$("#betText").hide();
			$("#timer").show();
			
			$("#question").hide();
			$("#questionTimer").hide();
			
			$("#answer").hide();
			$("#scores").hide();
			
			if(debug)
				console.log("setState(badge)");
		}
		else if(state=="bet"){
			$("#questionType").hide();
			$("#duration").hide();
			$("#badgeText").hide();
			$("#betText").show();
			$("#timer").show();
			
			$("#question").hide();
			$("#questionTimer").hide();
			
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
			
			$("#question").show();
			$("#questionTimer").hide();
			
			$("#answer").hide();
			$("#scores").hide();
			
			if(debug)
				console.log("setState(show_question)");
		}
		else if(state=="timer"){
			$("#questionType").hide();
			$("#duration").hide();
			$("#badgeText").hide();
			$("#betText").hide();
			$("#timer").hide();
			
			$("#question").show();
			$("#questionTimer").show();
			
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
			
			$("#question").show();
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
		<script type="text/javascript" src="/js/jquery.min.js"></script>
	</head>
	<body>
		<div id="outer">		
			<div id="upper">
				<div id="q_header">Question No.<?php echo "$num";?> (<?php echo "$q_type"?>)</div>
				<div id="q_proper">What is the output?<br>main(){ int x=7;<br> float d= (9/4 + (x*2.50)) + 11;<br> printf("%.2f",d)}</div>
				<div id="questionType">QuestionType</div>
				<div id="duration">Duration</div>
				<div id="badgeText">BadgeText</div>
				<div id="betText">BetText</div>
				<div id="timer">Timer</div>
			
				<div id="question">Question</div>
				<div id="questionTimer">QuestionTimer</div>
				
				<div id="answer">Answer</div>
				<div id="scores">Scores</div>
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