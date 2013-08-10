
<?php $this->load->view('includes/header2'); ?>

<script src="/js/timer.js"></script>
<script>
	var debug=false;
	
	function setState(state){
		if(state=="pre"){
			$("#round1Timer").hide();
			$("#newsfeed").hide();
			$("#text").hide();
			
			$("#pre").show();
			
			$("#countdown").hide();
			
			if(debug)
				console.log("setState(pre)");
		}
		else if(state=="round_1"){
			$("#round1Timer").show();
			$("#newsfeed").show();
			$("#text").show();
			
			$("#pre").hide();
			
			$("#countdown").hide();
			
			if(debug)
				console.log("setState(round1)");
		}
		else if(state=="countdown"){
			$("#countdown").show();
			
			$("#round1Timer").hide();
			$("#newsfeed").hide();
			$("#text").hide();
			
			$("#pre").hide();
			
			if(debug)
				console.log("setState(countdown)");
		}
	}
</script>

<div id="pre"> Papers are something, pens are something. Yehey get 1/4! </div>
<div id="countdown">countdown</div>
<div id = "round1Timer">Timer</div><br/><br/><br/>
<div id = "newsfeed"></div>
<div id = "text"></div>

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
		setInterval(function(){
    	$.get("/events/latest", function (latest_news) {
    		temp2 =latest_news;
    		var latest_json = eval("(" + latest_news + ")");
	    	var json_json = latest_json.data;
	    	temp = json_json;
	    	$("#newsfeed").html(temp[0].evnt);
//	    	var message = json_json=>[0].evnt;
//          	$("#newsfeed").html(message);
    	});
      },
      //The delay before the data is refreshed
      100);
		
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
					}
				);
			}
			else if(current_state=="round1" && new_state=="paused"){
			
			}
    	});
	}
	
	function update(){
		setInterval(function(){
    	$.get("/round1/team_score", function (team_scores) {
    		var teamscores_json = eval("(" + team_scores + ")");
	    	var message = teamscores_json.message+"<br/>";

			for ( var i = 0, state=teamscores_json.round1_state, l = state.length; i < l; i++){
				message = message + state[i].team_name+ " = "+ state[i].points + " points <br/>";
			}

          	$("#text").html(message);
    	});
      },
      //The delay before the data is refreshed
      100);
	}
</script>

<?php
	$this->load->view('includes/footer');
?>