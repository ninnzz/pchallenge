<?php
	$this->load->view('includes/header');
	$app_config = $app_config[0];

?>
<br/>
<br/>
<div class='container'>
<?php if($this->session->userdata['user']->scope && $this->session->userdata['user']->scope === "all"){ ?>
<h2>App Config</h2>
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

	<form action="/app/reset" method="post" class='well'>
		<input type='hidden' name='reset_app' value='1' />
		<label class='label label-warning'>Warning: Clicking this button will reset current application instance and all the game data may be loss...!</label>
		<input type='submit' value='Reset Application' class='btn btn-large btn-danger' style='width:100%;' onclick='if(!confirm("Are you sure you want to reset application?")) return false'/>
	</form>
	<p>
		<a href="/app/reset_round1"><button class='btn btn-danger' onclick='if(!confirm("Are you sure you want to reset round 1?")) return false'>Reset Round 1</button></a>
		<a href="/app/reset_round2"><button class='btn btn-danger' onclick='if(!confirm("Are you sure you want to reset round 2?")) return false'>Reset Round 2</button></a>
		<a href="/app/remove_events"><button class='btn btn-danger' onclick='if(!confirm("Are you sure you want to remove all events?")) return false'>Remove Events</button></a>
	</p>
	<form action="/app/update_config" method="post" class='well'>
		<input type="hidden" name="req" value="1" />
		<table>
			<tr><td colspan='2'><span class='label label-success '>General Config</span></td></tr>
			<tr><td>Application State:</td><td>
					<select name='app_state' />
						<option value='pre' <?php if($app_config->app_state == 'pre') echo "selected";?> >Preparation</option>
						<option value='stopped' <?php if($app_config->app_state == 'stopped') echo "selected";?>>Stopped</option>
						<option value='paused' <?php if($app_config->app_state == 'paused') echo "selected";?>>Paused</option>
						<option value='round_1' <?php if($app_config->app_state == 'round_1') echo "selected";?>>Round 1</option>
						<option value='round_1m' <?php if($app_config->app_state == 'round_1m') echo "selected";?>>Round 1(Special Mode)</option>
						<option value='round_2' <?php if($app_config->app_state == 'round_2') echo "selected";?>>Round 2</option>
					</select>
				</td></tr>
			<tr><td colspan='2'><span class='label label-success'>Round 1 Config</span></td></tr>
			<tr><td></td></tr			<tr><td>Round 1 Question Count:</td><td><input type='text' name='round1_question_count' value="<?php echo $app_config->round1_question_count; ?>" /></td></tr>
			<tr><td>Round 1 Timer Limit(minutes):</td><td><input type='text' name='round1_timer' value="<?php echo $app_config->round1_timer; ?>" /></td></tr>
			<tr><td colspan='2'><span class='label label-success'>Round2</span></td></tr>
			<tr><td>Round 2 Question Count:</td><td><input type='text' name='round2_question_count' value="<?php echo $app_config->round2_question_count; ?>" /></td></tr>
			<tr><td colspan='2'><span class='label label-success'>Badge</span></td></tr>
			<tr><td>Badge Count:</td><td><input type='text' name='badge_count' value="<?php echo $app_config->badge_count; ?>" /></td></tr>
			
			<tr><td colspan='2'><input type="submit" class='btn btn-danger' value='Set Application Settings' /></td></tr>
		</table>	
	</form>
	</div>
	
</div>
<?php } else{ echo "<h3>Invalid Scope</h3>"; }?>
<?php
	$this->load->view('includes/footer');
?>