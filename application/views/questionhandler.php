<?php
	echo "Question handler";
	define("READY_NEXT_QUESTION", "READY_NEXT_QUESTION");
?>

<html>
	<head>
		<script type="text/javascript" src="/js/routes.js" ></script>
		<script src="/js/jquery.min.js"></script>
		<script type="text/javascript">
		
			function setState(message){
				
				$.post('setState',{"message":message}, function(data) {
					obj = JSON.parse(data);
					console.log(obj);
					if(obj['state']=='init'){
						$("#result").html('Ready Next Question');
						$.post('getCurrentQuestionRound2', function(data) {
							obj = JSON.parse(data);
							$("#q_number").html(obj['q_number']);
						});
					}
					else if(obj['state']=='preview')
						$("#result").html('Flash Question');
					else if(obj['state']=='badge')
						$("#result").html('Badge Timer');
					else if(obj['state']=='bet')
						$("#result").html('Betting Timer');
					else if(obj['state']=='show_question')
						$("#result").html('Display Question');
					//$("#result").html(obj['state']);
					console.log("test");
				});
			}

			function setNextQuestion(){
					$.post('setNextQuestion', function(data) {
						obj = JSON.parse(data);
						$("#q_number").html(obj['q_number']);
					});
			}

			function setPreviousQuestion(){
					$.post('setPreviousQuestion', function(data) {
						obj = JSON.parse(data);
						console.log(obj['q_number']);
						$("#q_number").html(obj['q_number']);
					});
			}
		
		</script>
	</head>
	<body>
		Result:<br/>
		<div>
			<div><br>Current round 2 state:<br></div>
			<div  id="result" name="result"></div>
			<div  id="q_number" name="q_number"></div>
		</div>
		<form method="post" action="<?php echo base_url(); ?>index.php/main/processRound2Query" target="result">
			<table>
				<tbody>
					<tr>
						<!--<td>Round 1</td>-->
						<td colspan="2"><input type="button" value="Ready Next Question"  onclick="setState('init')"></td>
						<td colspan="2"><input type="button" value="Next Question"  onclick="setNextQuestion()"></td>
						<td colspan="2"><input type="button" value="Previous Question"  onclick="setPreviousQuestion()"></td>
					</tr>
					<tr>
						<td colspan="2"><input type="button" value="Flash Question"  onclick="setState('preview')"></td>
						<td colspan="2"><input type="button" value="Badge Timer" onclick="setState('badge')"></td>
						<td colspan="2"><input type="button" value="Betting Timer"  onclick="setState('bet')"></td>
						<td colspan="2"><input type="button" value="Display Question"  onclick="setState('show_question')"></td>
						<td colspan="2"><input type="button" value="Answering Timer"  onclick="setState('timer')"></td>
						<td colspan="2"><input type="button" value="Display Answer"  onclick="setState('show_answer')"></td>
						<td colspan="2"><input type="button" value="Display Team Summary" onclick="setState('scores')"></td>

					</tr>
				</tbody>
			</table>
		</form>
	</body>
</html>