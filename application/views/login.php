<?php
	$this->load->view('includes/header');
?>
<br/>
<br/>
<br/>
<div class='container'>
		<?php
			if(isset($response->message)){
		?>
			<div class='alert'>
				<?php
					echo $response->message;
				?>
			</div>
		<?php } ?>
</div>
<?php
	$this->load->view('includes/footer');
?>