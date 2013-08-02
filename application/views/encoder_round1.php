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
		<div id='numbers' class='well' class=''>
			<span class='label label-success'>Questions</span>
			<div id='q-container'>
				<?php if(isset($q_count) && $q_count > 0){
					for($i=1;$i<=$q_count;$i++){
				?>
				<button class='btn btn-small' data-active='0' data-id='<?=$i;?>' onclick='toggleAnswer(this)' style='width:5%;margin:2px;'><?=$i?></button>
				<?php }}?>
			</div>
		</div>
		<div id='teams'>
			<span class='label label-success'>Teams</span>

			<?php foreach($teams as $t){?>
				<button data-id='<?=$t->team_id?>' onclick='setTeam(this)' style='margin:2px;' class='btn btn-small btn-info'><?=$t->team_name;?></button>

			<?php }?>

		</div>
	</div>
	<script type="text/javascript" src="/js/routes.js" ></script>
	<script type='text/javascript'>
		var current_team = null;
		var curr_item = null;
		var total_question = <?=$q_count;?>;

		function toggleAnswer(obj){
			console.log(obj);
		}
		function setTeam(obj){
			if(current_team != null){
				current_team.className = 'btn btn-small btn-info';
			}
			current_team = obj;
			team_id = obj.getAttribute('data-id');
			router.setMethod('post');
			router.setTargetUrl('/user/get_team_correct');
			router.setParams({'team_id':team_id});
			events.setCurrentEvent('setQuestion(data)');
			events.setErrorEvent('alert("Something went wrong");console.log(data);');
			router.connect();
		}
		function setQuestion(data){
			var j = 0;
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
		function toggleAnswer(obj){
			if(current_team == null){
				alert("No team selected");
			} else {
				curr_item = obj;
				obj.disabled = true;
				obj.innerHTML = "....";
				team_id = current_team.getAttribute('data-id');
				active = obj.getAttribute('data-active');
				q_id = obj.getAttribute('data-id');

				router.setMethod('post');
				if(active === '1'){
					router.setTargetUrl('/user/delete_round1_answer');
					events.setCurrentEvent('itemToggle(data,1)');
				} else{
					events.setCurrentEvent('itemToggle(data,0)');
					router.setTargetUrl('/user/addto_round1_answer');
				}
				router.setParams({'q_number':q_id,'team_id':team_id});
				events.setErrorEvent('alert("Something went wrong");console.log(data);curr_item.disabled = false;');
				router.connect();
			}
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