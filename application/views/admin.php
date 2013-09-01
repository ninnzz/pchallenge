<?php
	$this->load->view('includes/header');
?>
<br/>
<br/>
<br/>
<div class='container'>
	
	<center>

		<a href="/app/config"><button class="btn">App Config</button></a>
		<a href="/team/add"><button class="btn">Teams</button></a>
		<a href="/user/add_user"><button class="btn">Add User</button></a>
		<a href="/round1/edit"><button class="btn">Edit Round1 Questions</button></a>
		<a href="/round2/edit_by_question"><button class="btn">Edit Round2 Questions</button></a>
		<a href="/round1/encoder"><button class="btn">Encoder (Round1)</button></a>
		<a href="/round2/encoder_round2"><button class="btn">Encoder (Round2)</button></a>
	</center>
</div>

<?php
	$this->load->view('includes/footer');
?>