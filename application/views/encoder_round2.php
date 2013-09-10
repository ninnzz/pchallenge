<?php $this->load->view("includes/header.php"); ?>

<?php if($this->session->userdata['user']->scope && $this->session->userdata['user']->scope === "all"){ ?>

<br/><br/><br/>
    <!-- Display the table for team number, team name, and bet fields -->
    <table class="span4">
        <form action="edit_bet" method="post" target="result">
        <tr>
            <td>#</td>
            <td>Team Name</td>
            <td>Question Number:<br/>
                <select id="question_number" name="question_number">
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
        <form action="update_score" method="post" target="result">
            <input type="hidden" name="badge_in_effect"/>
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
                <select name="<?php echo $team_data[$index]->team_id; ?>">
                    <option value="" selected>null</option>
                    <option value="0">NO</option>
                    <option value="1">YES</option>
                </select>
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
        <iframe name="result" style="width:50%;height:70px;"></iframe>
    </div>

    <h2>Use Badge</h2>
    <table class="span3">
        </tr>
            <td>
                <?php foreach($badges as $badge) { ?>
                    <button data-id="<?php echo $badge->id;?>" class = "btn btn-success" style="width:100%;text-align:left;"
                        value="<?php echo $badge->name; ?>" <?php if($badge->team_name == NULL) echo "disabled"?>
                        onclick="useBadge(this)">
                            <?php echo $badge->name.' ('.$badge->team_name.')';?>
                    </button>
                    <br/>
                <?php }?>
            </td>
        </tr>
    </table>

    <script type="text/javascript" src="/js/routes.js" ></script>
    <script type="text/javascript">
        function useBadge(badge){
            var confirmUse = confirm("Use " + badge.value);
            var a = document.getElementById("question_number");
            q_num = a.options[a.selectedIndex].value;
            if(confirmUse){
                badge.disabled = "disabled";
                badge_id = badge.getAttribute('data-id');
                router.setMethod('post');
                router.setTargetUrl('/round2/set_badge');
                router.setParams({'badge_id':badge_id,'question_number':q_num});
                router.connect();
            }
        }
    </script>
<?php } else{ echo "<h3>Invalid Scope</h3>"; }?>
<?php $this->load->view("includes/footer.php"); ?>
