<?php
	$this->load->view('includes/header');

?>
<br/>
<br/>
<div class='container'>
<?php if($this->session->userdata['user']->scope && $this->session->userdata['user']->scope === "all"){ ?>
<h2><a href="/round1/edit">Round 1 Questions</a></h2>
<h4>Set by badge</h4>
	<div class='row-fluid'>
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
		<a href="/round1/edit_by_badge"><button class="btn btn-success">Badge</button></a>
		<a href="/round1/edit_by_type"><button class="btn">Type</button></a>
		<a href="/round1/edit_by_question"><button class="btn">Question</button></a>
	</div>
	<?php if($q_count != 0){?>
	<div class='row-fluid well'>
		<p>
			<h6>Current question count: <?=$q_count?></h6>
		</p>
		<p>
			<a href="/badge/listings"><button class="btn btn-success">See Badge Count</button></a>
		</p>
		<form action="/round1/update_badge" method="post">
			<span class='label label-success'>Question Numbers</span>
			<p>
				(e.g. 1,3-7,10,13)
			</p>
			<p>
				<input type='text' name='question_numbers'/>
			</p>
			<p>
				<span class='label label-success'>Individual Badges</span>
			</p>
			<p>
				<input type='radio' name='badge_types[]' value='ABS'/>abSORTion<br/>
				<input type='radio' name='badge_types[]' value='OOP'/>Oops, Added It Again<br/>
				<input type='radio' name='badge_types[]' value='SEG'/>Segmentation Difficult<br/>
			</p>
			<p>
				<span class='label label-success'>Additional Badges</span>
			</p>
			<p>
				<input type='checkbox' name='badge_types[]' value='COL'/>Collectibles<br/>
				<input type='checkbox' name='badge_types[]' value='LUC'/>Lucky Star<br/>
			</p>
			<p>
				<input type='submit' class='btn btn-success'/>
			</p>
		</form>
	</div>
	<?php }?>
</div>
<?php } else{ echo "<h3>Invalid Scope</h3>"; }?>
<?php
	$this->load->view('includes/footer');
?>