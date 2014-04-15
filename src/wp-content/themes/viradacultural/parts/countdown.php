<div id="countdown" style="visibility:hidden" class="col-md-2 hidden-sm hidden-xs">
    <div>Faltam</div>
    <input class="knob days" data-displayfield="days" data-field="hours" data-min="0" data-max="24" data-fgcolor="#ee2c72"/>
    <div>dias</div>
    <input class="knob hours" data-displayfield="hours" data-field="m" data-min="0" data-max="60" data-fgcolor="#ffc20e"/>
    <div>horas</div>
    <input class="knob minutes" data-displayfield="minutes" data-field="s" data-min="0" data-max="600" data-fgcolor="#893494"/>
    <div>min</div>
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
        strEventDate = '2014-05-17 18:00',
        countdownElement = document.querySelector('#countdown');

        updateCountdown();
        setInterval(updateCountdown, 100);

    //init knob and displayfield patch
    [].forEach.call(countdownElement.querySelectorAll('.knob'), function(el) {
        el.dataset.width = el.dataset.height = '72';
        el.dataset.readonly = true;
        el.dataset.thickness = '.18';
        el.dataset.bgcolor= '#ccc';
        el.dataset.step = '1';
        el.dataset.displayinput = false;
        //el.dataset.rotation = 'anticlockwise';
        jQuery(el).knob();
        el.insertAdjacentHTML('beforebegin', '<div class="countdown-text  circle '+el.dataset.displayfield+'" data-displayfield="'+el.dataset.displayfield+'">&nbsp;</div>');
    });
    var counter;
    function updateCountdown(){

        var data = moment(strCurrentDate).countdown(moment(strEventDate), countdown.DAYS | countdown.HOURS | countdown.MINUTES | countdown.SECONDS | countdown.MILLISECONDS);

        if(counter && data.seconds >= 0 && data.milliseconds >= 0) counter--; else counter = data.seconds*10 + (Math.round(data.milliseconds/100)-1);

        data.s = counter;
        data.m = data.hours > 0 ? data.minutes : 0;

        //console.log(data.seconds, counter, data.milliseconds, data.s);
        [].forEach.call(countdownElement.querySelectorAll('.knob'), function(el) {
            //console.log(el.dataset.field, data[el.dataset.field])
            el.value = data[el.dataset.field];
            jQuery(el).trigger('change'); //for knob to work ...
        });
        [].forEach.call(countdownElement.querySelectorAll('.countdown-text'), function(el) {
            el.innerText = data[el.dataset.displayfield];
        });
        countdownElement.style.visibility = 'visible';
    }

});

</script>