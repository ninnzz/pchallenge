<html>
<?php
$this->load->view('includes/header');
//this is a comment for testingfghjkl;tyuikl;
?>
<br/>
<br/>
<div class='container'>
    <?php if($this->session->userdata['user']->scope && $this->session->userdata['user']->scope === "all"){ ?>
        <h2>Add Badge</h2>
        <div class='row-fluid'>

        </div>

        <div class='row-fluid well'>
            <form>
                <table>
                    <tr>
                        <td><h6>Badge Name</h6></td>
                        <td><input type="text" name="b_name"/></td>
                    </tr>
                    <tr>
                        <td><h6>Badge Count</h6></td>
                        <td><input type="number" name="b_name" min="1" max="10"/></td>
                    </tr>
                    <tr>
                        <td><h6>Badge Type</h6></td>
                        <td>
                            <select name="b_type">
                                <option value="sd">SD</option>
                                <option value="c">C</option>
                                <option value="ab">AB</option>
                                <option value="ls">LS</option>
                                <option value="aia">AIA</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><h6>Badge Query</h6></td>
                        <td><input type="text" name="b_query"</td>
                    </tr>
                    <tr>
                        <td><input type="submit"></td>
                    </tr>
                </table>
            </form>
        </div>
        <?php }
        else{ echo "<h3>Invalid Scope</h3>"; }?>
    </div>
<?php
$this->load->view('includes/footer');
?>
</html>