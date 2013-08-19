<?php
	$this->load->view('includes/header');

?>
<br/>
<br/>
<div class='container'>
	<?php if($this->session->userdata['user']->scope && $this->session->userdata['user']->scope === "all"){ ?>
	<h2>Round 1 Questions</h2>
	
	<div class='row-fluid'>
		<a href="../round1/edit_by_badge"><button class="btn btn-success">Go back</button></a>
	</div>
	
	<div class='row-fluid well'>
		<p>
			<h5>abSORTion (<?=$ABS["count"]?>)</h5>
			<?foreach($ABS["questions"] as $ABS_element){
				echo $ABS_element->q_number.", ";
			}?>
		</p>
		<p>
			<h5>Collectibles (<?=$COL["count"]?>)</h5>
			<?foreach($COL["questions"] as $COL_element){
				echo $COL_element->q_number.", ";
			}?>
		</p>
		<p>
			<h5>Lucky Star (<?=$LUC["count"]?>)</h5>
			<?foreach($LUC["questions"] as $LUC_element){
				echo $LUC_element->q_number.", ";
			}?>
		</p>
		<p>
			<h5>Oops, Added It Again (<?=$OOP["count"]?>)</h5>
			<?foreach($OOP["questions"] as $OOP_element){
				echo $OOP_element->q_number.", ";
			}?>
		</p>
		<p>
			<h5>Segmentation Difficult (<?=$SEG["count"]?>)</h5>
			<?foreach($SEG["questions"] as $SEG_element){
				echo $SEG_element->q_number.", ";
			}?>
		</p>
	</div>

</div>
<?php } else{ echo "<h3>Invalid Scope</h3>"; }?>
<?php
	$this->load->view('includes/footer');
?>