
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
            $("#achievement").show();
            if(debug)
                console.log("setState(round1)");
        }

        else if(state=="countdown"){
            $("#countdown").show();
            $("#round1Timer").hide();
            $("#newsfeed").hide();
            $("#scores").hide();
            $("#pre").hide();
            $("#sponsors").hide();
            $("#achievement").hide();
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
			NEWS<br/>FEED:
		</div>
		<div id="feed">
			
		</div>
		<div id="sub_feed">
		</div>
	</div>
	<div id="sponsors">
		<div id="exclusive">
			<p>Exclusive Partner:</p>
			<img id="image" src="/img/azeus1.png">
		</div>
		<div id="logos" class="span3">
			<p>Sponsors:</p>
			<div id="slider" class="carousel slide">
				<div class="carousel-inner">
					<div class="item">
						<img src="/img/silver/ristretto.png" width="75%" height="75%" />
					</div>
					<div class="item active">
						<img src="/img/nonlocal/chikka.png" width="75%" height="75%" />
					</div>
					<div class="item">
						<img src="/img/gold/tresto.png" width="75%" height="75%" />
					</div>
					<div class="item">
						<img src="/img/gold/proximity.png" width="75%" height="75%" />
					</div>
					<div class="item">
						<img src="/img/gold/kamlanders.png" width="75%" height="75%" />
					</div>
					<div class="item">
						<img src="/img/gold/etiquetta.png" width="75%" height="75%" />
					</div>
					<div class="item">
						<img src="/img/gold/decorland.png" width="75%" height="75%" />
					</div>
					<div class="item">
						<img src="/img/gold/decohair.png" width="75%" height="75%" />
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="scores">
		<div id="team_scores">
			TEAM SCORES
		</div>
		<div id="part1" style="width: 48%; green; height: 98%; float:left; padding: 1% 1%;">
			<?php for($i= 0; $i<10; $i++){?>
			<div id="team<?php echo $i?>" class="team_style">
				<div class="team_num"><p><?php echo $i+1 ?></p></div>
				<div id="score_team<?php echo $i?>" style="width: 75%; float:left; font-size:150%; margin-top: 0.75%;"></div>
				<div id="score_points<?php echo $i?>" style="float: right; margin-right: 2%; font-size: 160%;"></div>
			</div>
			<?php }?>
		</div>
		<div id="part2" style="width: 48%; height: 98%; float:left; padding: 1% 1%;">
			<?php for($i = 10; $i<20; $i++){?>
			<div id="team<?php echo $i?>" class="team_style">
				<div class="team_num"><p><?php echo $i+1 ?></p></div>
				<div id="score_team<?php echo $i?>" style="width: 75%; float:left; font-size:150%; margin-top: 0.75%;"></div>
				<div id="score_points<?php echo $i?>" style="float: right; margin-right: 2%; font-size:150%;"></div>
			</div>
			<?php }?>
		</div>		
	</div>

	<div id="round1Timer">Add timer here</div>
	<div id="achievement">
		<div id="achievement_title">
			TEAM ACHIEVEMENTS
		</div>
		<div class="badge_container">
            <div id="badge_slider" class="carousel slide">
                <div class="carousel-inner"height="150px" width="300px">
                    <!--div class="laman item" height="100%" width="100%">

                        <div class="badge_pic">
                            <img src="/img/badge/Collectibles.png" height="85%" width="90%" />
                        </div>
                        <div class="badge_title">
                            Badge Title
                        </div>
                        <div class="badge_owner">
                            Badge Owner
                        </div>

                    </div-->
                </div>
            </div>

		</div>
	</div>
</div>
<!--Load JQUERY from Google's network -->
<script>
var counter = 0;
var start_time = null;
var event_queue = [];
var event_lifetime = 3000; //how long a main event should stay in main feed until the secondary one overrides it (milliseconds)
var last_event;
var last_badge;

current_state="pre";

setState(current_state);

//reads states from round1/state/, and reacts accordingly
setInterval(function(){
    events.setCurrentEvent('state_reactor()');
    router.setMethod('get');
    router.setTargetUrl('/round1/state');
    router.connect();
}, 1000);

function update_newsfeed(){
    /*$.get("/events/all", function (all_news) {
        var all_json = eval("(" + all_news + ")");
        var lastevent_date_time = last_event? last_event.date_time:null;

        //if there is no new event, return
        if(last_event && last_event.evnt==all_json.data[0].evnt){
            return;
        }

        if(start_time!=null && start_time < all_json.data[0].date_time){

            for(var i=latest_json.data.length;i>0;i--){
                var event_to_process=all_json.data[i];
                if(event_to_process.date_time!=last_event.date_time){
                    if(event_queue.length==0){
                        event_queue.push({msg:event_to_process.evnt, fading:false});
                        renew_newsfeed();
                        console.log('initial event');
                    }
                    else if(!event_queue[0].fading){
                        event_queue[0].fading = true;
                        event_queue.push({msg:event_to_process.evnt, fading:false});
                        renew_newsfeed();
                        reload_newsfeed();
                        console.log('add event and start to reload');
                    }
                    else{
                        event_queue.push({msg:event_to_process.evnt, fading:false});
                        console.log('add event');
                    }
                }
            }
            last_event = all_json.data[0];
        }


    });*/

    $.get("/events/latest", function (latest_news) {
        var latest_json = eval("(" + latest_news + ")");

        if(last_event==latest_json.data[0].evnt){
            return;
        }

        if(start_time!=null && start_time < latest_json.data[0].date_time){
            last_event = latest_json.data[0].evnt;

            if(event_queue.length==0){
                event_queue.push({msg:latest_json.data[0].evnt, fading:false});
                renew_newsfeed();
                console.log('initial event');
            }
            else if(!event_queue[0].fading){
                event_queue[0].fading = true;
                event_queue.push({msg:latest_json.data[0].evnt, fading:false});
                renew_newsfeed();
                reload_newsfeed();
                console.log('add event and start to reload');
            }
            else{
                event_queue.push({msg:latest_json.data[0].evnt, fading:false});
                console.log('add event');
            }
        }
    });
}

function update_achievements(){
    $.get("/events/badge", function (latest_badge) {
        var latest_json2 = eval("(" + latest_badge + ")");
        //(latest_json2);
        if(latest_json2.data[0] == null || last_badge==latest_json2.data[0].evnt){
            return;
        }

        else if(last_badge!=latest_json2.data[0].evnt){
            var image_path;
            var badge_title;
            last_badge = latest_json2.data[0].evnt;
            console.log(last_badge);



            if(last_badge.match("Collectibles") != null){
                image_path = "/img/badge/Collectibles.png";
                badge_title = "Collectibles";
            }else if(last_badge.match("Segmentation") != null){
                image_path = "/img/badge/SegFault.png";
                badge_title = "Segmentation Difficult";
            }else if(last_badge.match("abSORTion") != null){
                image_path = "/img/badge/abSORTion2.png";
                badge_title = "abSORTion";
            }else if(last_badge.match("Oops, Added It Again") != null){
                image_path = "/img/badge/Oops.png";
                badge_title = "Oops, Added It Again";
            }else if(last_badge.match("Lucky") != null){
                image_path = "/img/badge/LuckyStar.png";
                badge_title = "Lucky Star";
            }

            $("#badge_slider > div").append(
                "<div class='laman item' height='100%' width='100%'>"+
                "<div class='badge_pic'>"+
                "<img src='"+image_path+"' height='85%' width='90%' />"+
                "</div>" +
                "<div class='badge_title'>"+
                    badge_title+
                "</div>"+
                "<div class='badge_owner'>"+
                    "Owner here"+
                "</div>"+
                "</div>"
            );

//          $('#badge_slider').carousel().click();
            $('#badge_slider').carousel('pause');
            $("#badge_slider").carousel({interval:2000});
            /*$('body').append(
                "<link rel='stylesheet' type='text/css' href='/css/bootstrap.min.css'>"+
                "<link rel='stylesheet' type='text/css' href='/css/bootstrap-responsive.min.css'>"+
                "<link rel='stylesheet' type='text/css' href='/css/style.css'>"+
                "<link rel='stylesheet' type='text/css' href='/css/vertical_slider.css'>"
            );*/
//           $('#badge_slider').carousel().click();
 //          $('#badge_slider').carousel();
            console.log("Executed here!");
        }
    });
}

function reload_newsfeed(){
    setTimeout(function(){
        event_queue.splice(0,1);
        renew_newsfeed();

        if(event_queue.length>1 && !event_queue[0].fading){
            event_queue[0].fading=true;
            reload_newsfeed();
        }
    }, event_lifetime);
}

function renew_newsfeed(){
    if(event_queue[0]){
        $("#feed").html(event_queue[0].msg);
    }
    if(event_queue[1]){
        $("#sub_feed").html(event_queue[1].msg);
    }
    else{
        $("#sub_feed").html("");
    }
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
                    $("#countdown").html("Round 1");
                    setTimeout(function(){
                        current_state="round_1";
                        setState(current_state);
                        startGameLoop();
                        countdown("round1Timer", 45*60, function(){
                            current_state="countdown";
                            setState(current_state);
                            $("#countdown").html("Time's up!");
                        });
                    }, 1000);
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
        var team_name = teamscores_json.message+"<br/>";
        var team_points;

        for ( var i = 0, state=teamscores_json.round1_state, l = state.length; i < l; i++){
            team_name = state[i].team_name;
            if(team_name.length > 20){
                team_name = team_name.substring(0,17) + "...";
            }
            team_points = state[i].points;
            $("#"+"score_team"+i).html(team_name);
            $("#"+"score_points"+i).html(team_points);
        }
    });

    /*$.get("/round1/team_score", function (team_details) {
     var teamscores_json = eval("(" + team_details + ")");
     var team_name;
     var all_team_names = teamscores_json.round1_state.team_names;
     var team_points;
     var i;

     //console.log("# of teams : "+all_team_names.length);

     for (i = 0, state=teamscores_json.round1_state.team_scores, l = state.length; i < l; i++){
     team_name = state[i].team_name;
     if(team_name.length > 20){
     team_name = team_name.substring(0,17) + "...";
     }
     team_points = state[i].points;
     $("#"+"score_team"+i).html(team_name);
     $("#"+"score_points"+i).html(team_points);

     /*for(var j=0;j<all_team_names.length;j++){
     if(all_team_names[j].team_name==team_name){
     all_team_names.splice(j,1);
     j--;
     break;
     }
     }
     }

     //console.log("no score teams : "+all_team_names.length);

     for(var j=0;j<all_team_names.length;j++){
     team_name = all_team_names[j].team_name;
     if(team_name.length > 20){
     team_name = team_name.substring(0,17) + "...";
     }
     $("#"+"score_team"+(j+i)).html(team_name);
     $("#"+"score_points"+(j+i)).html("0");
     }
     });*/
}

function startGameLoop(){
    start_time = Date.now()*0.001;

    setInterval(function(){
        counter++;
        counter%=3;

        if(counter == 0){
            events.setCurrentEvent('update_newsfeed()');
            router.setMethod('get');
            router.setParams();
            router.setTargetUrl('/events/latest');
            router.connect();
        }


        else if(counter == 1){
            events.setCurrentEvent('update()');
            router.setMethod('get');
            router.setTargetUrl('/round1/team_score');
            router.connect();
        }

        else if(counter == 2){
            events.setCurrentEvent('update_achievements()');
            router.setMethod('get');
            router.setTargetUrl('/events/badge');
            router.connect();
        }



    }, 100);

//    $('#badge_slider').carousel();

    //makes the carousel start automatically, without needing a manual mouse click
    $('#slider').carousel().click();
//    $('#badge_slider').carousel().click();
}

</script>

<?php
$this->load->view('includes/footer');
?>

