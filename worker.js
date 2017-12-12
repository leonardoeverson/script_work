var check = false;
function countdown(){
	//console.log('teste')

	if(check){
		var tmp = $('.hora');
		for(i = 0; i < tmp.length;i++){
			var times = tmp[i].value.split(":");

			var hour = times[0];
			var minutes = times[1];
			var seconds = times[2];
			seconds = Number(seconds) - 1;	

			if(seconds < 0){
				seconds = 59;
			}

			if(Number(seconds) == 0){
				minutes = Number(minutes) - 1;

			}

			if(Number(minutes) == 0){
				if(Number(hour) > 0){
					hour = Number(hour) - 1;
				}
			}

			tmp[i].value = hour + ":"+ minutes +":"+ seconds;

			postMessage(temp[i].value)
		}

	}

	setInterval(function(){countdown()},1000);
}

self.addEventListener("message",function(e){
	console.log(e)
})

countdown();