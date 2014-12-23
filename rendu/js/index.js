var timer, stopTimer,
	result = document.getElementById('result'),
	sec    = document.getElementById('sec'),
	start  = document.getElementById('start'),
	stop   = document.getElementById('stop'),
	plus   = document.getElementById('plus'),
	minus  = document.getElementById('minus'),
	n      = +result.innerHTML;
	
// events
start.addEventListener('click', function() {
	startTimer(n);
}, false);

stop.addEventListener('click', function() {
	stopTimer();
}, false);

plus.addEventListener('click', function() {
	result.innerHTML = ++n;
}, false);

minus.addEventListener('click', function() {
	result.innerHTML = --n;
}, false);

// functions
function startTimer(n) {
	var i = n-1; // fix 1 sec start delay
  document.getElementById('pm').style.display = 'none'; // hide arrows

	timer = setInterval( function() {
		result.innerHTML = i--;
     
     stopTimer = function() {
       clearInterval(timer);
       result.innerHTML = i + 1;
     }
		
     if (i < 5) {
			result.style.color = '#ED3E42';
			sec.style.color = '#ED3E42';
		} // hurry up!
		
		if (i < 0) { stopTimer(); } // finish
		
		function updateProgress() {
			var canvas = document.getElementById('progress');
			var context = canvas.getContext('2d');
			var centerX = canvas.width / 2;
			var centerY = canvas.height / 2;
			var radius = 80;
			var circ = Math.PI * 2; // 360deg
			var percent = i / n; // i%
			context.beginPath();
			context.arc(centerX, centerY, radius, ((circ) * percent), circ, false);
			context.lineWidth = 10;
			if (i < 5) {
				context.strokeStyle = '#ED3E42';
			} else {
				context.strokeStyle = '#00CE9B';
			}
			context.stroke();
		} // progress
		
		updateProgress();
    
	}, 1000); // every sec

}