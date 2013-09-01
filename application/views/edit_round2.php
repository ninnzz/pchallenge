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
        <?php
        if($this->session->flashdata('data')){
            ?>
            <div class='alert text-center'>
                <?php
                echo $this->session->flashdata('data')->message;
                ?>
            </div>
        <?php }?>
	</div>
	<?php if($q_count != 0){?>
	<div class='row-fluid well'>
		<form action="/round2/get_question" method="get">
		<span class='label label-success'>Question Number</span><br/><br/>
            <select name='q_number' id='question_number'>
			<?php
				for($i=1;$i<=$q_count;$i++){
                    if(isset($_GET['q_number']) && $i == $_GET['q_number'])
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
		<form action="/round2/update_question" method="post">
		<input type='hidden' name='q_number' value='<?php echo $question[0]->q_number;?>'/>
		<table>
			<tr><td><h6>Difficulty</h6></td><td>
				<select name='q_type' id='difficulty'>
					<option value='easy' <?php if($question[0]->q_type=='e')echo 'selected';?>>Easy</option>
					<option value='average' <?php if($question[0]->q_type=='a')echo 'selected';?>>Average</option>
					<option value='difficult' <?php if($question[0]->q_type=='d')echo 'selected';?>>Difficult</option>
				</select>
				</td></tr>
			<tr>
                <td><h6>Multiplier(set to 1)</h6></td>
                <td><input required name='multiplier' type='text' id='multiplier' value='<?php if($question[0]->q_number)echo $question[0]->multiplier;?>' />
                </td>
            </tr>
			<tr>
                <td><h6>Corresponding Points</h6></td>
                <td><input required name='points' type='text' id='points' value='<?php if($question[0]->q_number)echo $question[0]->points;?>' /></td>
            </tr>
			<tr>
                <td><h6>Preview Timer</h6></td>
                <td><input required name='prev_timer' type='text' id='prev_timer' value='<?php if($question[0]->q_number)echo $question[0]->prev_timer;?>'/>
                </td></tr>
			<tr>
                <td><h6>Badge Timer</h6></td>
                <td><input required name='badge_timer' type='text' id='badge_timer' value='<?php if($question[0]->q_number)echo $question[0]->badge_timer;?>'/></td>
            </tr>
			<tr>
                <td><h6>Bet Timer</h6></td>
                <td><input required name='bet_timer' type='text' id='bet_timer' value='<?php if($question[0]->q_number)echo $question[0]->bet_timer;?>'/></td>
            </tr>
			<tr>
                <td><h6>Question Timer</h6></td>
                <td><input required name='q_timer' type='text' id='q_timer' value='<?php if($question[0]->q_number)echo $question[0]->q_timer;?>'/></td>
            </tr>
			<tr>
                <td><h6>Question Body</h6></td>
                <td><textarea required name='body' id='body'><?php if($question[0]->q_number)echo $question[0]->body;?></textarea></td>
            </tr>
			<tr>
                <td><h6>Answer</h6></td>
                <td><textarea required name='answer' id='answer'><?php if($question[0]->q_number)echo $question[0]->answer;?></textarea>
                </td>
            </tr>
			<tr>
                <td colspan='2'><input type='submit' class='btn btn-success btn-large' value='Update Question' /></td>
            </tr>
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