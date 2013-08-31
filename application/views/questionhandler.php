<?php
	define("READY_NEXT_QUESTION", "READY_NEXT_QUESTION");
?>

<?php $this->load->view('includes/header2'); ?>

<script>
    function setState(message){

        $.post('setState',{"message":message}, function(data) {
            obj = JSON.parse(data);
            console.log(obj);
            if(obj['state']=='init'){
                $("#result").html('Ready Next Question');
                $.post('getCurrentQuestionRound2', function(data) {
                    obj = JSON.parse(data);
                    $("#q_number").html(obj['q_number']);
                });
            }
            else if(obj['state']=='preview')
                $("#result").html('Flash Question');
            else if(obj['state']=='badge')
                $("#result").html('Badge Timer');
            else if(obj['state']=='bet')
                $("#result").html('Betting Timer');
            else if(obj['state']=='show_question')
                $("#result").html('Display Question');
            else if(obj['state']=='show_question')
                $("#result").html('Display Team Summary');
            //$("#result").html(obj['state']);
            console.log("test");
        });
    }

    function setNextQuestion(){
            $.post('setNextQuestion', function(data) {
                obj = JSON.parse(data);
                $("#q_number").html(obj['q_number']);
            });
    }

    function setPreviousQuestion(){
            $.post('setPreviousQuestion', function(data) {
                obj = JSON.parse(data);
                console.log(obj['q_number']);
                $("#q_number").html(obj['q_number']);
            });
    }
</script>

<div class="container">

    <div class="hero-unit">
        <h3>Current round 2 state : </h3>
        <div  id="result" name="result"></div>
        <div  id="q_number" name="q_number"></div>
    </div>

    <br/>

    <!--<form method="post" action="<?php echo base_url(); ?>index.php/main/processRound2Query" target="result">-->
        <div class="row">
            <div class="span6 text-center">
                <button class="btn" onclick="setState('init')"> Ready Next Question </button>
            </div>

            <div class="span6 text-center">
                <!--put status of ready next question here-->
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="span6 text-center">
                <button class="btn" onclick="setPreviousQuestion()"><i class="icon-step-backward"></i> Previous Question </button>
                &nbsp;
                <button class="btn" onclick="setNextQuestion()"><i class="icon-step-forward"></i> Next Question </button>
            </div>

            <div class="span6 text-center">
                <!--put status of ready next question here-->
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="span6 text-center">
                <button class="btn" onclick="setState('preview')"> Flash Question </button>
            </div>

            <div class="span6 text-center">
                <!--put status of ready next question here-->
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="span6 text-center">
                <button class="btn" onclick="setState('badge')"> Badge Timer </button>
            </div>

            <div class="span6 text-center">
                <!--put status of ready next question here-->
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="span6 text-center">
                <button class="btn" onclick="setState('bet')"> Betting Timer </button>
            </div>

            <div class="span6 text-center">
                <!--put status of ready next question here-->
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="span6 text-center">
                <button class="btn" onclick="setState('show_question')"> Display Question </button>
            </div>

            <div class="span6 text-center">
                <!--put status of ready next question here-->
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="span6 text-center">
                <button class="btn" onclick="setState('timer')"> Answering Timer </button>
            </div>

            <div class="span6 text-center">
                <!--put status of ready next question here-->
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="span6 text-center">
                <button class="btn" onclick="setState('show_answer')"> Display Answer </button>
            </div>

            <div class="span6 text-center">
                <!--put status of ready next question here-->
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="span6 text-center">
                <button class="btn" onclick="setState('scores')"> Display Team Summary </button>
            </div>

            <div class="span6 text-center">
                <!--put status of ready next question here-->
            </div>
        </div>
    <!--</form>-->

</div>

<?php $this->load->view('includes/footer'); ?>