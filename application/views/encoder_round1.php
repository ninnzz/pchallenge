<?php
	$this->load->view('includes/header');
?>
<br/>
<br/>
<div class='container'>
<?php if($this->session->userdata['user']->scope && $this->session->userdata['user']->scope === "encoder"){ ?>
<h2>Encoder (Round1)</h2>
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

	
	</div>
	
</div>
<?php } else{ echo "<h3>Invalid Scope</h3>"; }?>
<?php
print_r($teams);
	$this->load->view('includes/footer');
?>