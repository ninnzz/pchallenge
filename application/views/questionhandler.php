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
					$("#result").html(obj['state']);
					console.log("test");
				});
			}

			function setNextQuestion(){
					$.post('setNextQuestion', function(data) {
						console.log(data);
					});
			}

			function setPreviousQuestion(){
					$.post('setPreviousQuestion', function(data) {
						console.log(data);
					});
			}
		
			
			/*function setState(message){
				console.log(message);
				team_id="65ba841e01d6db7733e90a5b7f9e6f80";
				router.setMethod('post');
				router.setTargetUrl('/user/get_team_correct');
				router.setParams({'team_id':team_id});
				events.setCurrentEvent('setQuestion(data)');
				events.setErrorEvent('alert("Something went wrong");console.log(data);');
				router.connect();
			}

			function setQuestion(data){

				console.log(data)
			}*/
		</script>
	</head>
	<body>
		Result:<br/>
		<div>
			<div><br>Current round 2 state:<br></div>
			<div  id="result" name="result"></div>
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