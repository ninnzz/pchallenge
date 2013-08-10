// Usage : call countdown("id", seconds, callback) once to make a div with id="id" count from seconds to 0
//	callback = function to call if countdown is done
function countdown(id, seconds, callback){
	var minutes_left = Math.floor(seconds/60);
	var seconds_left = seconds%60;
	var minutes_str = minutes_left;
	var seconds_str = seconds_left;
	
	if(minutes_left<10)
		minutes_str = "0"+minutes_left;
		
	if(seconds_left<10)
		seconds_str = "0"+seconds_left;
	
	$("#"+id).html(minutes_str+":"+seconds_str);
	
	if(seconds_left>0 || minutes_left>0){
		if(debug)
			console.log('countdown('+id+', '+(minutes_left*60+seconds_left-1)+', '+callback+');');
		
		setTimeout(function(){
			countdown(id, minutes_left*60+seconds_left-1, callback);
		},1000);
	}
	else{
		if(debug)
			console.log('time_left==0');
		callback();
	}
}