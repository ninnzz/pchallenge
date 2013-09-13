<?php $this->load->view("includes/header.php"); ?>

<?php if($this->session->userdata['user']->scope && $this->session->userdata['user']->scope === "all"){ ?>
    <br/><br/><br/>
    <h2>&nbsp&nbsp&nbspEncoder (Round 2)</h2>
    <!-- Display the table for team number, team name, and bet fields -->
    <table class="span4">
        <form action="update_round2" method="post" target="result">
        <tr>
            <td>
                Format for bet:<br/>&nbsp&nbsp&nbsp&nbsp<b>team_no,bet</b>(one line per entry)
            </td>
        </tr>
        <tr>
            <td>
                Format for correct teams:<br/>&nbsp&nbsp&nbsp&nbsp<b>team_no,boolean_if_correct(1 - yes, 0 - no)</b><br/>
                &nbsp&nbsp&nbsp&nbsp(one line per entry)
            </td>
        </tr>
        <tr>
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
            <td>
                <input type='radio' name='option' value='bet' checked><b>Bet</b>
                <input type='radio' name='option' value='correct'><b>Correct Teams</b>
            </td>
        </tr>
        <tr>
            <td>
                <textarea id="text" name="text" rows="10" cols="5" style="resize:no"></textarea>
            </td>
        </tr>
        <tr>
            <td><input type="submit" class="btn btn-success" name="submit" value="Submit" onclick="return validateInput();"/></td>
        </tr>
        </form>
    </table>
    <!-- Displays the result of the query -->

    <div id="result">
        <h4>Result</h4>
        <iframe name="result" style="width:50%;height:150px;"></iframe>
    </div>

    <div id="teams">
       <h4>Teams</h4>
        <table>
            <?php
            for($i = 0 ; $i < count($teams) ; $i+=2){
                echo "<tr>";
                echo "<td style='padding: 5px'>".$teams[$i]->team_no."</td>";
                echo "<td style='padding: 5px'>".$teams[$i]->team_name."</td>";
                if($i+1 < count($teams)){
                    echo "<td style='padding: 5px'>".$teams[$i+1]->team_no."</td>";
                    echo "<td style='padding: 5px'>".$teams[$i+1]->team_name."</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
    </div>
    <h4>Badges on Standby</h4>
    <table class="span3">
        <tr>
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
        <tr>
            <td>
                <?php
                if(count($badges) == 0){
                    echo "No badges available.";
                }
                ?>
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

        function validateInput(){
            var text = document.getElementById("text");
            var pattern = new RegExp("^(?:([0-9]+,[0-9]+)\n?)+$");
            if(pattern.test(text.value)){
                return true;
            }else{
                alert("Input string error");
                return false;
            }
        }
    </script>
<?php } else{ echo "<h3>Invalid Scope</h3>"; }?>
<?php $this->load->view("includes/footer.php"); ?>
