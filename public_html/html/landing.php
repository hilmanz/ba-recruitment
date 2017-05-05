<script>
$(document).ready(function() { 
 	$( ".decideNow_grey" ).delay( 30000 ).fadeOut( 1000 );
 	$( ".decideNow_red" ).delay( 30000 ).fadeIn( 1000 );	
	var counter = 30;
	var interval = setInterval(function() {
		counter--;
		$('span.timers').html(counter);
		// Display 'counter' wherever you want to display it.
		if (counter == 0) {
 			$( ".timerBox" ).fadeOut( 1000 );
			// Display a login box
			clearInterval(interval);
		}
	}, 1000);

});
</script>
<div id="container">
   <div id="contentVideo">
   		<div id="title"></div>
        <div id="videoLanding">
              <video id="video-landing" class="video-js vjs-default-skin" controls preload="none" width="720" height="480"
                  poster="images/bg_vid.png"
                  data-setup="{}">
                <source src="video/landing.mp4" type='video/mp4' />
              </video>
        </div><!-- end #videoLanding -->
        <div id="WatchNow" class="goyang"></div>
        <div id="btnAct">
            <a href="http://www.bc-sba.com/home/decidenow?sourceid=marlboro" class="decideNow decideNow_red" style="display:none;">&nbsp;</a>
            <a class="decideNow decideNow_grey">&nbsp;</a>
        	<p class="timerBox">Please wait for <span class="timers">30</span> seconds</p>
        </div>
   </div><!-- end #content -->
</div><!-- end #container -->