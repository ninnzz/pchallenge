<?php
	$this->load->view('includes/header');
?>
<br/>
<br/>
<br/>
<div id='container-fluid'>
<h2> Add Team</h2>

	<?php
		if(isset($response->message)){
	?>
 		<div class='alert text-center'>
			<?php
				echo $response->message;
			?>
		</div>
	<?php } ?>

<form action="" method="post">
	<input type="hidden" name="req" value="1" />
	<table>
		<tr><td>Team Name</td><td><input type='text' name='team_name' /></td></tr>
		<tr><td>Team Members(Separated by comma)</td><td>
			<textarea name='members' rows=5 cols=10 >Member1,Member2.....</textarea></td></tr>
		<tr><td>Contact number</td><td><input type='text' name='contact' /></td></tr>
		<tr><td colspan='2'><input type="submit" class='btn btn-danger' value='Register Team' /></td></tr>
	</table>
</form>

</div>
<?php
	$this->load->view('includes/footer');
?>