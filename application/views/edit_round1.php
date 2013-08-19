<?php
	$this->load->view('includes/header');

?>
<br/>
<br/>
<div class='container'>
<?php if($this->session->userdata['user']->scope && $this->session->userdata['user']->scope === "all"){ ?>
<h2>Round 1 Questions</h2>
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

		<form action="/round1/gen" method="post" class='well'>
			<input type='hidden' name='reset_app' value='1' />
			<label class='label label-info'>Use only if application is reinitialized or for emergency reset purposes only.</label>
			<input type='submit' value='GENERATE ROUND1 QUESTION SET' class='btn btn-large btn-danger' style='width:100%;text-align:center;'/>
		</form>
	</div>
	<div class='row-fluid'>
		<a href="/round1/edit_by_difficulty"><button class="btn">Difficulty</button></a>
		<a href="/round1/edit_by_badge"><button class="btn">Badge</button></a>
		<a href="/round1/edit_by_question"><button class="btn">Question</button></a>
	</div>
</div>
<?php } else{ echo "<h3>Invalid Scope</h3>"; }?>
<?php
	$this->load->view('includes/footer');
?>