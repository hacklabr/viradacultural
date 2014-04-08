<div id="countdown" style="visibility:hidden" class="col-md-2">
	<div>
		Faltam
	</div>
	<div class="circle">{days}</div>
	<div>dias</div>
	<div class="circle">{hours}</div>
	<div>horas</div>
	<div class="circle">{minutes}</div>
	<div>min<span id="countdown-info">{info}</span></div>
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


<script>
//when DOM is ready, fire!
document.addEventListener("DOMContentLoaded", function() {

	var template = null,
            strCurrentDate, //TODO get from server
            strEventDate = '2014-05-17 18:00';

	updateCountdown();

	setInterval(updateCountdown, 1000);

	function updateCountdown(){
                var data = moment(strCurrentDate).countdown(moment(strEventDate), countdown.DAYS | countdown.HOURS | countdown.MINUTES | countdown.SECONDS);
                //var data = countdown(strCurrentDate, strEventDate);
		var el = document.querySelector('#countdown');
		el.style.visibility = 'visible';
		if(!template)
			template = el.innerHTML;
		var result = template;
		data.info = (!showInfo) ? '' : '<br> <small style="font:10px courier;">e '+data.seconds + ' segundos até <br> ' + moment(strEventDate).format('MMM Do YYYY, H:mm:ss')+'</small>';
		for(key in data){
			result = result.replace('{'+key+'}', data[key]);
		}
		el.innerHTML = result;
	}

        var i = document.querySelector('#countdown-info');
        var showInfo = false;
        i.style.display = 'none';
        document.addEventListener('keyup', function(e){
            if(e.ctrlKey && e.keyCode == 32){
                showInfo = !showInfo;
                i.style.display = (i.style.display == 'none') ? 'block' : 'none';
            }
        });

});

</script>