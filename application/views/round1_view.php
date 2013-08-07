
<?php $this->load->view('includes/header2'); ?>
  
<div id = "round1Timer">Timer</div><br/><br/><br/>
<div id = "newsfeed">asdfasd</div>
<div id = "text"></div>

<!--Load JQUERY from Google's network -->
<script> 
	var something;
	var counter = 0;
	var temp, temp2;
	var asdf=0;

	setInterval(function(){
		counter++;
		counter%=10;

		if(counter%2 == 0){
		events.setCurrentEvent('update_newsfeed()');
		router.setMethod('get');
		router.setTargetUrl('/events/latest');
		router.setParams(something);
		router.connect();
		}


		else if(counter%2 == 1){
		events.setCurrentEvent('update()');
		router.setMethod('get');
		router.setTargetUrl('/round1/team_score');
		router.setParams(something);
		router.connect();
		}
	}, 100);

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