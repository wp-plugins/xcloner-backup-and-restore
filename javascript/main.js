var timer = 5;

function autoClick(){
		window.location = document.getElementById('cLink').href;
		}

function countdown(){

	 document.getElementById('countdown').innerText = timer;
	 if(timer > 0)
		timer = timer - 1;

	}

function cLink_load(){

	var time  = 5000;

	countdown();

	setTimeout('autoClick();', time);
	setInterval('countdown()', 1000);
	}
