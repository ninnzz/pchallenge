<?php
	$this->load->view('includes/header');
?>
<br/>
<br/>
<div class='container'>
<h2>User Roles</h2>
	<div class='row-fluid'>

		<?php
			if(isset($response->message)){
		?>
	 		<div class='alert text-center'>
				<?php
					echo $response->message;
				?>
			</div>
		<?php } ?>

	<form action="" method="post" class='well'>
		<span class='label label-success'>New User</span>
		<input type="hidden" name="req" value="1" />
		<table>
			<tr><td>Username:</td><td><input type='text' name='uname' /></td></tr>
			<tr><td>Password:</td><td><input type='password' name='password' /></td></tr>
			<tr><td>Role:</td><td>
				<select name='role'>
					<option value='mod'>Moderator</option>
					<option value='encoder'>Encoder</option>
					<option value='mc'>Mc</option>
				</select>
			</td></tr>
			<tr><td colspan='2'><input type="submit" class='btn btn-danger' value='Add user' /></td></tr>
		</table>
	</form>
	</div>
	<div class='row-fluid well'>
		<span class='label label-info'>Use list</span>
		

	</div>
</div>

<?php
	$this->load->view('includes/footer');
?>