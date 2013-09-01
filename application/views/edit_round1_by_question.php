<?php
	$this->load->view('includes/header');

?>
<br/>
<br/>
<div class='container'>
<?php if($this->session->userdata['user']->scope && $this->session->userdata['user']->scope === "all"){ ?>
<h2><a href="/round1/edit">Round 1 Questions</a></h2>
<h4>Set by question</h4>
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
	<div class='row-fluid'>
		<a href="/round1/edit_by_difficulty"><button class="btn">Difficulty</button></a>
		<a href="/round1/edit_by_badge"><button class="btn">Badge</button></a>
		<a href="/round1/edit_by_type"><button class="btn">Type</button></a>
		<a href="/round1/edit_by_question"><button class="btn btn-success">Question</button></a>
	</div>
	<?php if($q_count != 0){?>
	<div class='row-fluid well'>
		<p>
			<h6>Current question count: <?= $q_count?></h6>
		</p>
		<form action="/round1/get_question" method="get">
			<span class='label label-success'>Question Number</span><br/><br/>
			<select name='q_number' id='question_number'>
				<?php
					for($i=0;$i<$q_count;$i++){
						if(isset($question[0]->q_number) && $question[0]->q_number == $i)
							echo "<option value='".$i."' selected>".$i."</option>";
						else
							echo "<option value='".$i."'>".$i."</option>";
					}
				?>
			</select><br/>
			<input type='submit' class='btn btn-success' value='select'/>
		</form>
		<?php if(isset($question)){?>
		<form action="/round1/update_question" method="post">
			<input type='hidden' name='q_number' value='<?php if($question[0]->q_number)echo $question[0]->q_number;?>'/>
			<table>
				<tr><td><h6>Difficulty</h6></td><td>
					<select name='q_diff' id='difficulty'>
						<option value='e' <?php if($question[0]->q_diff=='e')echo 'selected';?>>Easy</option>
						<option value='a' <?php if($question[0]->q_diff=='a')echo 'selected';?>>Average</option>
						<option value='d' <?php if($question[0]->q_diff=='d')echo 'selected';?>>Difficult</option>
					</select>
					</td></tr>
				<tr><td><h6>Multiplier(set to 1)</h6></td><td><input name='q_multiplier' type='text' id='multiplier' value='<?php if($question[0]->q_number)echo $question[0]->q_multiplier;?>' /></td></tr>
				<tr><td><h6>Corresponding Points</h6></td>
					<td>
						<select name='points'>
							<option value='30' <?php if($question[0]->points==30)echo 'selected';?>>30</option>
							<option value='50' <?php if($question[0]->points==50)echo 'selected';?>>50</option>
							<option value='70' <?php if($question[0]->points==70)echo 'selected';?>>70</option>
						</select>
					</td>
				</tr>
				<tr><td><h6>Type</h6></td>
					<td>
						<select name='q_type' id='type'>
							<option value='#d' <?php if($question[0]->q_type=='#d')echo 'selected';?>>#define</option>
							<option value='pr' <?php if($question[0]->q_type=='pr')echo 'selected';?>>printf</option>
							<option value='pa' <?php if($question[0]->q_type=='pa')echo 'selected';?>>pattern</option>
							<option value='re' <?php if($question[0]->q_type=='re')echo 'selected';?>>recursion</option>
							<option value='so' <?php if($question[0]->q_type=='so')echo 'selected';?>>sorting</option>
							<option value='NULL' <?php if($question[0]->q_type==NULL)echo 'selected';?>>no type</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><h6>Badges</td>
					<td>
						<input type='radio' name='badge_types[]' value='ABS' <?if(!is_null($badge_types)&&in_array("ABS",$badge_types)) echo "checked"?>/>abSORTion<br/>
						<input type='radio' name='badge_types[]' value='OOP' <?if(!is_null($badge_types)&&in_array("OOP",$badge_types)) echo "checked"?>/>Oops, Added It Again<br/>
						<input type='radio' name='badge_types[]' value='SEG' <?if(!is_null($badge_types)&&in_array("SEG",$badge_types)) echo "checked"?>/>Segmentation Difficult<br/>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type='checkbox' name='badge_types[]' value='COL' <?if(!is_null($badge_types)&&in_array("COL",$badge_types)) echo "checked"?>/>Collectibles<br/>
						<input type='checkbox' name='badge_types[]' value='LUC' <?if(!is_null($badge_types)&&in_array("LUC",$badge_types)) echo "checked"?>/>Lucky Star<br/>
					</td>
				</tr>
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