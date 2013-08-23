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
        <?foreach($data as $d){?>
            <p>
            <h5><?=$d['badge_name'].' ('.$d['count'].')'?></h5>
            <?foreach($d['questions'] as $q){
                echo $q->q_number.',';
            }?>
            </p>
        <?}?>
    </div>
</div>
<?php } else{ echo "<h3>Invalid Scope</h3>"; }?>
<?php
	$this->load->view('includes/footer');
?>