<?php
	$this->load->view('includes/header');

?>
<br/>
<br/>
<div class='container'>
<?php if($this->session->userdata['user']->scope && $this->session->userdata['user']->scope === "all"){ ?>
<h2>Round2 Questions</h2>
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
	<?php if($q_count != 0){?>
	<div class='row-fluid well'>
		<form action="/user/get_round2_question" method="post">
		<span class='label label-success'>Question Number</span><br/><br/><select name='q_number' id='question_number'>
			<?php
				for($i=1;$i<=$q_count;$i++){
					if(isset($question[0]->q_number) && $question[0]->q_number == $i)
						echo "<option value='".$i."' selected>".$i."</option>";
					else
						echo "<option value='".$i."'>".$i."</option>";
				}
			?>
		</select><br/><input type='submit' class='btn btn-success' value='select'/>
		</form>
		<br/>
		<br/>
		<?php if(isset($question)){?>
		<form action="/user/update_round1_question" method="post">
		<input type='hidden' name='q_number' value='<?php if($question[0]->q_number)echo $question[0]->q_number;?>'/>
		<table>
			<tr><td><h6>Difficulty</h6></td><td>
				<select name='q_type' id='dificulty'>
					<option value='e' <?php if($question[0]->q_type=='e')echo 'selected';?>>Easy</option>
					<option value='a' <?php if($question[0]->q_type=='a')echo 'selected';?>>Average</option>
					<option value='d' <?php if($question[0]->q_type=='d')echo 'selected';?>>Difficult</option>
				</select>
				</td></tr>
			<tr><td><h6>Multiplier(set to 1)</h6></td><td><input name='q_multiplier' type='text' id='multiplier' value='<?php if($question[0]->q_number)echo $question[0]->q_multiplier;?>' /></td></tr>
			<tr><td><h6>Corresponding Points</h6></td><td><input name='points' type='text' id='points' value='<?php if($question[0]->q_number)echo $question[0]->points;?>' /></td></tr>
			<tr><td><h6>Badge Type(custom defined)</h6></td><td><input name='badge_type' type='text' id='badge' value='<?php if($question[0]->q_number)echo $question[0]->badge_type;?>'/></td></tr>
			<tr><td colspan='2'><input type='submit' class='btn btn-success btn-large' value='Update Question' /></td></tr>
		</table>
		</form>
		<?php }?>
	</div>
	<?php }?>
</div>
<?php } else{ echo "<h3>Invalid Scope</h3>"; }?>
<?php
	$this->load->view('includes/footer');
?>