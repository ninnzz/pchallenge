<?php
	$this->load->view('includes/header');

?>
<br/>
<br/>
<div class='container'>
<?php if($this->session->userdata['user']->scope && $this->session->userdata['user']->scope === "all"){ ?>
<h2>Badges</h2>
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
	
	<?php if($q_count != 0){?>
	<div class='row-fluid well'>
		<form action="/user/badge" method="get">
		<span class='label label-success'>Badge</span><br/><br/>
			<?
			if(isset($_GET['id'])){
				echo form_dropdown('id',$badge_options,$_GET['id']);
			}else{
				echo form_dropdown('id',$badge_options);
			}
			?>
		</select><br/><input type='submit' class='btn btn-success' value='Select'/>
		<?if(!isset($_GET['id'])){
			var_dump($badge_options[0]);
		}?>
		<span class='label label-success'>Badge Tally</span><br/><br/>

		</form>
	<?php }
	if(isset($_GET['id']))
	{
	?>
		<span class='label label-success'>Question Number</span><br/><br/>
		<form action="/user/badge_modify" method="post">
			<input type='hidden' name='id' value="<?php echo $_GET['id']?>"/>
			<table><?
				for($i = 0 , $k = 1; $i < 8 ; $i++){
				?>
				<tr><?
					for($j = 0 ; $j < 6 ; $j++){
						?>
						<td style="padding: 5px;"><?
						if($k<10)echo "0".$k++; else echo $k++;?>
						<input type='hidden' name='questions[]'
							<?
							if($this->badge_model->getBadgeType($k-1) == $_GET['id']) echo "value=".$k-1;
							else if($this->badge_model->getBadgeType($k-1) == 0) echo "";
							else echo "value='0'";
							?>/>
						<input type='checkbox' name='questions_selected[]' value="<?php echo $k-1;?>" 
							<?
							if($this->badge_model->getBadgeType($k-1) == $_GET['id']) echo "checked";
							else if($this->badge_model->getBadgeType($k-1) == "") echo "";
							else echo " disabled";
							?>/><?
						}?>
						</td><?
					}
					?>
				</tr><?
				?>
			</table>
		<br/><input type='submit' class='btn btn-success' value='Submit'/>
		<?
		//add question to badge	
	}
	?>
	</div>
<?php } else{ echo "<h3>Invalid Scope</h3>"; }?>

<?php
	$this->load->view('includes/footer');
?>