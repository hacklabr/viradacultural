<div id="countdown" style="visibility:hidden" class="col-md-2">
	<div>
		Faltam
	</div>
	<div class="circle">{days}</div>
	<div>dias</div>
	<div class="circle">{hours}</div>
	<div>horas</div>
	<div class="circle">{minutes}</div>
	<div>min<span style="display: none;">{debug}</span></div>
	<footer>
		<time>
			<div>17-18</div>
			<div>maio</div>
			<div>2014</div>
		</time>
		<div class="rede-sociais">

            <?php $redes = get_theme_option('social_networks'); $redesbuttons = array('facebook', 'twitter', 'googleplus'); ?>

            <?php foreach ($redesbuttons as $button): ?>
                <?php if (isset($redes[$button]) && $redes[$button]): ?>
                    <a class="icon social_<?php echo $button; ?>_circle" href="<?php echo $redes[$button]; ?>" target="_blank"></a>
                <?php endif; ?>
            <?php endforeach; ?>


		</div>
	</footer>
</div>
<!-- #countdown -->

<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js" type="text/javascript"></script>
<script>
//when DOM is ready, fire!
document.addEventListener("DOMContentLoaded", function() {

	var template = null;
	var targetDateMomentArray = [2014, 4, 17, 18];

	updateCountdown();

	setInterval(updateCountdown, 1000);

	function updateCountdown(){
		var data = countdown(targetDateMomentArray);
		var el = document.querySelector('#countdown');
		el.style.visibility = 'visible';
		if(!template)
			template = el.innerHTML;
		var result = template;
		data.debug = '<br> <small style="font:10px courier;">e '+data.seconds + ' segundos até <br> ' + moment(targetDateMomentArray).format('MMM Do YYYY, H:mm:ss')+'</small>';
		for(key in data){
			result = result.replace('{'+key+'}', data[key]);
		}
		el.innerHTML = result;
	}


	function countdown (targetDateMomentArray) {
		//See: http://permalightnyc.com/experiments/countdown

	  	var now = moment(), // get the current moment
	    // May 28, 2013 @ 12:00AM
	    then = moment(targetDateMomentArray),
	    // get the difference from now to then in ms
	    ms = then.diff(now, 'milliseconds', true);
	    // If you need years, uncomment this line and make sure you add it to the concatonated phrase
	    /*
	    years = Math.floor(moment.duration(ms).asYears());
	    then = then.subtract('years', years);
	    */
	    // update the duration in ms
	    ms = then.diff(now, 'milliseconds', true);
	    // get the duration as months and round down
	    months = Math.floor(moment.duration(ms).asMonths());

	    // subtract months from the original moment (not sure why I had to offset by 1 day)
	    then = then.subtract('months', months).subtract('days', 1);
	    // update the duration in ms
	    ms = then.diff(now, 'milliseconds', true);
	    days = Math.floor(moment.duration(ms).asDays());

	    then = then.subtract('days', days);
	    // update the duration in ms
	    ms = then.diff(now, 'milliseconds', true);
	    hours = Math.floor(moment.duration(ms).asHours());

	    then = then.subtract('hours', hours);
	    // update the duration in ms
	    ms = then.diff(now, 'milliseconds', true);
	    minutes = Math.floor(moment.duration(ms).asMinutes());

	    then = then.subtract('minutes', minutes);
	    // update the duration in ms
	    ms = then.diff(now, 'milliseconds', true);
	    seconds = Math.floor(moment.duration(ms).asSeconds());

	    // concatonate the variables
	    //diff = '<span class="num">' + months + '</span> months<br><span class="num">' + days + '</span> days<br><span class="num">' + hours + '</span> hours<br><span class="num">' + minutes + '</span> minutes<br><span class="num">' + seconds + '</span> seconds&#133;';
	    //$('#relative').html(diff);
	//    console.log(diff);
		return {
			'days': days,
			'hours': hours,
			'minutes': minutes,
			'seconds': seconds
		};

	}
});

</script>