<?php
	$this->load->view('includes/header');
?>

<br/>
<br/>
<div class='container'>
<?php if($this->session->userdata['user']->scope && $this->session->userdata['user']->scope === "all"){ ?>
<h2>Encoder (Round1)</h2>
	<div class='row-fluid'>

		<?php
			if(isset($response->message)){
		?>
	 		<div class='alert text-center'>
				<?php
					echo $response->message;
				?>
			</div>
		<?php }?>

	
	</div>
	<div class='row-fluid'>
		<div id='numbers' class='well' >
			<span class='label label-success'>Questions</span>
			<div id='q-container'>
				<?php if(isset($q_count) && $q_count > 0){
					for($i=1;$i<=$q_count;$i++){
				?>
				<button class='btn btn-small' data-active='0' data-id='<?=$i;?>' onclick='toggleQuestion(this)' style='width:5%;margin:2px;'><?=$i?></button>
				<?php }}?>
			</div>
		</div>
		<div id='teams'>
			<span class='label label-success'>Correct</span>
			<span class='label label-warning'>Incorrect/Did Not Answer</span>
			<hr/>
			<span class='label label-important'>Leave blank for teams who did not bet</span>
			<br/>
			<br/>
			<div style='display:inline;' id='teams-div'>
				<table>
					<div class="input-prepend input-append">	
					<?php for($i = 0 ; $i < count($teams) ; $i+=2){?>
						<tr><?
						for($j = 0 ; $j < 2 ; $j++){
							if($i+$j < count($teams)){?>
								<td><button style='width:200px' data-id='<?=$t->team_id?>' onclick='setTeam(this)' class='btn btn-warning'><?='('.$teams[$i+$j]->team_no.')'.$teams[$i+$j]->team_name;?></button></td>
								<td><input class="span6" id="appendedPrependedInput" type="text" style='width:100%' /></td>
							<?}
						}?>
					<?php }?>
					</div>
				</table>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="/js/routes.js" ></script>
	<script type='text/javascript'>
		var current_team = null;
		var curr_item = null;
		var total_question = <?=$q_count;?>;

		function setTeam(obj){
			if(current_team != null){
				current_team.className = 'btn btn-small btn-info';
			}
			current_team = obj;
			team_id = obj.getAttribute('data-id');
			router.setMethod('post');
			router.setTargetUrl('/team/get_team_correct');
			router.setParams({'team_id':team_id});
			events.setCurrentEvent('setQuestion(data)');
			events.setErrorEvent('alert("Something went wrong");console.log(data);');
			router.connect();
		}
		function setQuestion(data){
			var j = 1;
			var prt = document.getElementById('q-container');
			var content = "";
			prt.innerHTML = "";
			qs = data.data;
			console.log(qs);
			for(i=1;i<=total_question;i++){
				if(data.data.length != 0 && typeof(qs[j]) != 'undefined' && (qs[j].q_number)*1 == i){
					j++;
					content += "<button class='btn btn-small btn-success' data-active='1' data-id='"+i+"' onclick='toggleAnswer(this)' style='width:5%;margin:2px;'>"+i+"</button>"
				} else {
					content += "<button class='btn btn-small' data-active='0' data-id='"+i+"' onclick='toggleAnswer(this)' style='width:5%;margin:2px;'>"+i+"</button>"
				}
			}
			prt.innerHTML = content;
			//put some loading for the question buttons here
			current_team.className = 'btn btn-small btn-danger';
		}
		function toggleQuestion(obj){
			if(curr_item != null){
				curr_item.className = 'btn btn-small';
			}
			curr_item = obj;
			obj.disabled = true;
			obj.innerHTML = "....";
			q_id = obj.getAttribute('data-id');

			router.setMethod('post');
			router.setTargetUrl('/round2/get_team_answers_round2');
			events.setCurrentEvent('setupTeams(data)');
			router.setParams({'q_number':q_id});
			events.setErrorEvent('alert("Something went wrong");console.log(data);curr_item.disabled = false;curr_item.className="btn btn-small";curr_item.innerHTML=q_id');
			router.connect();
			
		}
		function setupTeams(data){
			console.log(data);
			curr_item.disabled = false;
			curr_item.innerHTML = curr_item.getAttribute('data-id');
			curr_item.className = "btn btn-small btn-success";
		}
		function itemToggle(data,opt){
			console.log(data);
			curr_item.disabled = false;
			curr_item.innerHTML = curr_item.getAttribute('data-id');

			if(data.status === 'ok'){
				if(opt == 0){
					curr_item.setAttribute('data-active','1');
					curr_item.className = "btn btn-small btn-success";
				} else {
					curr_item.setAttribute('data-active','0');
					curr_item.className = "btn btn-small";
				}
			}else{
				alert("Failed updating answer");
			}		
		}
	</script>
</div>
<?php } else{ echo "<h3>Invalid Scope</h3>"; }?>
<?php
	$this->load->view('includes/footer');
?>