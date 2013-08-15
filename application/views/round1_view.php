
<?php $this->load->view('includes/header2'); ?>

<script src="/js/timer.js"></script>
<script>
	var debug=false;
	
	function setState(state){
		if(state=="pre"){
			$("#round1Timer").hide();
			$("#newsfeed").hide();
			$("#scores").hide();
			$("#achievement").hide();
			$("#sponsors").hide();
			
			$("#pre").show();
			
			$("#countdown").hide();
			
			if(debug)
				console.log("setState(pre)");
		}
		else if(state=="round_1"){
			$("#round1Timer").show();
			$("#newsfeed").show();
			$("#scores").show();
			$("#sponsors").show();
			$("#pre").hide();
			
			$("#countdown").hide();
			
			if(debug)
				console.log("setState(round1)");
		}
		else if(state=="countdown"){
			$("#countdown").show();
			
			$("#round1Timer").hide();
			$("#newsfeed").hide();
			$("#scores").hide();
			
			$("#pre").hide();
			
			if(debug)
				console.log("setState(countdown)");
		}
	}
</script>


<div id="container">
	<div id="pre">
		<p>Pens are pointy</p>
		<p>Papers are thin</p>
		<p>Get 1/4! is close by</p>
		<p>Join now and win</p>
	</div>
	<div id="countdown">countdown</div>
	<div id="newsfeed">
		<div id="nftitle">
			<h1>NEWS FEED:</h1>
		</div>
		<div id="feed">
			
		</div>
	</div>
	<div id="sponsors" class="span3">
		<div id="exclusive">
		</div>
		<div class="span3">
			<div id="slider" class="carousel slide">
				<div class="carousel-inner">
					<div class="item active">
						<img src="/img/gold/Tresto.png">
					</div>
					<div class="item">
						<img src="/img/gold/Proximity.png">
					</div>
					<div class="item">
						<img src="/img/gold/Kamlanders.png">
					</div>
					<div class="item">
						<img src="/img/gold/Etiquetta.png">
					</div>
					<div class="item">
						<img src="/img/gold/DecorLand.png">
					</div>
					<div class="item">
						<img src="/img/gold/DecoHair.png">
					</div>
				</div>
				<a class="left carousel-control" href="#slider" data-slide="prev"></a>
				<a class="right carousel-control" href="#slider" data-slide="next"></a>
			</div>
		</div>
	</div>
	<div id="scores">
		<div id="team_scores">
			TEAM SCORES
		</div>
		<?php for($i= 0; $i<20; $i++){?>
			<div id="team<?php echo $i?>" style="
				border-width: 2px;
				border-style: solid;
				border-color: black; 
				border-radius: 10px;
				line-height: 30px;
				margin-top: 0.5%;"> 
			</div>
		<?php }?>
	</div>

	<div id="round1Timer" class="span3">Add timer here</div>
	<div id="achievement">Add badge here</div>
</div>

<!--Load JQUERY from Google's network -->
<script> 
	var counter = 0;
	var temp, temp2;
	current_state="pre";

	setState(current_state);
	
	setInterval(function(){
		counter++;
		counter%=10;

		if(counter%2 == 0){
			events.setCurrentEvent('update_newsfeed()');
			router.setMethod('get');
			router.setTargetUrl('/events/latest');
			router.connect();
		}


		else if(counter%2 == 1){
			events.setCurrentEvent('update()');
			router.setMethod('get');
			router.setTargetUrl('/round1/team_score');
			router.connect();
		}
	}, 100);
	
	//reads states from round1/state/, and reacts accordingly
	setInterval(function(){
		events.setCurrentEvent('state_reactor()');
		router.setMethod('get');
		router.setTargetUrl('/round1/state');
		router.connect();
	}, 1000);

	function update_newsfeed(){
    	$.get("/events/latest", function (latest_news) {
    		temp2 =latest_news;
    		var latest_json = eval("(" + latest_news + ")");
	    	var json_json = latest_json.data;
	    	temp = json_json;
	    	$("#feed").html(temp[0].evnt);
//	    	var message = json_json=>[0].evnt;
//          	$("#newsfeed").html(message);
    	});
	}

	// if round1/state says the state has changed, react accordingly
	function state_reactor(){
		$.get("/round1/state", function (state) {
    		var state_json = eval("(" + state + ")");
	    	var new_state = state_json.round1_state;
			
			if(debug){
				console.log("current_state:"+current_state);
				console.log("new_state:"+new_state);
			}
			
			//state transition to round1
			if(current_state=="pre" && new_state=="round_1"){	
				current_state="countdown";
				setState("countdown");

				//"countdown"==id of div to present countdown on
				// 10 = seconds
				countdown("countdown", 10, 
					function(){
						current_state="round_1";
						setState(current_state);
						
						countdown("round1Timer", 45*60, function(){});
					}
				);
			}
			else if(current_state=="round1" && new_state=="paused"){
			
			}
    	});
	}
	
	function update(){
    	$.get("/round1/team_score", function (team_scores) {
    		var teamscores_json = eval("(" + team_scores + ")");
	    	var message = teamscores_json.message+"<br/>";
	    	var rank;

			for ( var i = 0, state=teamscores_json.round1_state, l = state.length; i < l; i++){
				
				message = state[i].team_name+ " = "+ state[i].points + " points <br/>";
          	$("#"+"team"+i).html(message);
          	}
    	});
	}
	$(function(){
		$('#slider').carousel();
	})
</script>

<?php
	$this->load->view('includes/footer');
?>

