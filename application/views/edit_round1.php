<?php
	$this->load->view('includes/header');

?>
<br/>
<br/>
<div class='container'>
<?php if($this->session->userdata['user']->scope && $this->session->userdata['user']->scope === "all"){ ?>
<h2>App Config</h2>
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

		<form action="/user/reset_app" method="post" class='well'>
			<input type='hidden' name='reset_app' value='1' />
			<label class='label label-info'>Use only if application is reinitialized or for emergency reset purposes only.</label>
			<input type='submit' value='GENERATE ROUND1 QUESTION SET' class='btn btn-large btn-danger' style='width:100%;text-align:center;'/>
		</form>
	</div>
	<div class='row-fluid well'>
		<span class='label label-success'>Question Number</span><br/><br/><select id='question_number'>
		</select>
		<br/>
		<br/>
		<table>
			<tr><td><h6>Difficulty</h6></td><td>
				<select id='dificulty'>
					<option value='e'>Easy</option>
					<option value='a'>Average</option>
					<option value='d'>Difficult</option>
				</select>
				</td></tr>
			<tr><td><h6>Multiplier(set to 1)</h6></td><td><input type='text' id='multiplier' value='1' /></td></tr>
			<tr><td><h6>Corresponding Points</h6></td><td><input type='text' id='points' /></td></tr>
			<tr><td><h6>Badge Type(custom defined)</h6></td><td><input type='text' id='badge' /></td></tr>
			<tr><td colspan='2'><button class='btn btn-success btn-large'>Update Question</button></td></tr>
		</table>
	</div>
</div>
<?php } else{ echo "<h3>Invalid Scope</h3>"; }?>
<?php
	$this->load->view('includes/footer');
?>