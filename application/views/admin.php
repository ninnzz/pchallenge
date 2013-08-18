<?php
	$this->load->view('includes/header');
?>
<br/>
<br/>
<br/>
<div class='container'>
	
	<center>

		<a href="/user/app_config"><button class="btn">App Config</button></a>
		<a href="/user/add_team"><button class="btn">Teams</button></a>
		<a href="/user/add_user"><button class="btn">Add User</button></a>
		<a href="/badge/listings"><button class="btn">Badges</button></a>
		<a href="/user/edit_round1"><button class="btn">Edit Round1 Questions</button></a>
		<a href="/user/edit_round2"><button class="btn">Edit Round2 Questions</button></a>
		<a href="/user/encoder_round1"><button class="btn">Encoder (Round1)</button></a>
		
	</center>
</div>

<?php
	$this->load->view('includes/footer');
?>