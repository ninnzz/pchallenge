<?php $this->load->view("includes/header.php"); ?>

<br/><br/><br/>
		<!-- Display the table for team number, team name, and bet fields -->
		<table class="span4">
			<form action="round2/edit_bet" method="post" target="result">
			<tr>
				<td>#</td>
				<td>Team Name</td>
				<td>Question Number:<br/>
					<select name="question_number">
						<option value="0" selected>0</option>
						<?php for($index = 1; $index <= $question_count; $index++) { ?>
							<option value="<?php echo $index; ?>"><?php echo $index; ?></option>
						<?php } ?>
					</select>
				</td>
			</tr>
				
			<tr>
				<td></td>
				<td></td>
				<td>Bet</td>
			</tr>
			
			<?php for($index=0,$teamCount=sizeof($team_data);$index < $teamCount; $index++) { ?>
			<tr>
				<td><?php echo $team_data[$index]->team_no; ?></td>
				<td><?php echo $team_data[$index]->team_name; ?></td>
				<td>
					<!-- Use team id to check the team id that correspond to the bet text field -->
					<input type="hidden" name="<?php echo $index; ?>" value="<?php echo $team_data[$index]->team_id; ?>"/>
					<input type="text" name="<?php echo $team_data[$index]->team_id; ?>" placeholder="<?php echo $team_data[$index]->team_name; ?>"/>
				</td>
			</tr>
			<?php } ?>
			

			<tr>
				<td></td>
				<td></td>
				<td><input type="submit" class="btn btn-success" name="submit" value="Submit Bets"/></td>
			</tr>
			</form>
		</table>

		<table>
			<form action="round2/update_score" method="post" target="result">
				<input type="hidden" name="badge_in_effect" value="Badge1"/>
			<tr>
				<td>Question Number:<br/>
					<select name="question_number">
						<option value="0" selected>0</option>
						<?php for($index = 1; $index <= $question_count; $index++) { ?>
							<option value="<?php echo $index; ?>"><?php echo $index; ?></option>
						<?php } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td>Correct</td>
			</tr>
			
			<?php for($index=0;$index < $teamCount; $index++) { ?>
			<tr>
				<td>
					<!-- Use team id to check the team id that correspond to the textboxes -->
					<input type="hidden" name="<?php echo $index; ?>" value="<?php echo $team_data[$index]->team_id; ?>"/>
					<input type="text" name="<?php echo $team_data[$index]->team_id; ?>" placeholder="<?php echo $team_data[$index]->team_name; ?>"/>
				</td>
			</tr>
			<?php } ?>
			
			<tr>
				<td><input type="submit" class="btn btn-success" name="submit" value="Update Scores"/></td>
			</tr>
			</form>	
		</table>

		<!-- Displays the result of the query -->
		<div id="result">
			Result:<br/>
			<iframe name="result" style="width:30%;height:40px;"></iframe>
		</div>

		<h2>Use Badge</h2>

		<script>
			function useBadge(badge){
				var confirmUse = confirm("Use " + badge.value);

				if(confirmUse){
					badge.disabled = "disabled";
					window.location = "use_badge";
				}
			}

		</script>
		<!-- Displays the table for badges -->
		<!-- To be modified based on badge database -->
		<table class="span3">
			<tr>
				<td>Badge Name [Owner]</td>
			</tr>

			</tr>
				<td>
					<?php for($index = 0,$badgeCount = sizeof($badges); $index < $badgeCount; $index++) { ?>
						<button class="btn btn-success" style="width:100%;text-align:left;" value="<?php echo $badges[$index]['badge_name']; ?>" onclick="useBadge(this)"
							<?php
								echo $badges[$index]['is_used'] ? "disabled" : "";
							?>
							>
							<?php echo $badges[$index]['badge_name'] . " [" . $badges[$index]['badge_owner'] . "]"; ?>
						</button>
							<br/>

					<?php } ?>
				</td>
			</tr>
		</table>

<?php $this->load->view("includes/footer.php"); ?>