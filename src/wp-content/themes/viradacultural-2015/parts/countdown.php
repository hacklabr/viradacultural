<div id="countdown" class="col-md-2 hidden-sm hidden-xs">
    <div>Faltam</div>
    <input class="knob days" data-displayfield="days" data-field="hours" data-min="0" data-max="24" data-fgcolor="#fb3f2a"/>
    <div>dias</div>
    <input class="knob hours" data-displayfield="hours" data-field="m" data-min="0" data-max="60" data-fgcolor="#fb3f2a"/>
    <div>horas</div>
    <input class="knob minutes" data-displayfield="minutes" data-field="s" data-min="0" data-max="600" data-fgcolor="#fb3f2a"/>
    <div>min</div>
    <footer>
        <time>
            <div>20|21</div>
            <div>Junho</div>
            <div>2015</div>
        </time>
        <div class="rede-sociais">

            <?php $redes = get_theme_option('social_networks'); $redesbuttons = array('facebook', 'twitter', 'googleplus', 'youtube', 'flickr', 'instagram'); ?>

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
//when DOM is ready, execute
jQuery(document).ready(function() {

    var strCurrentDate, //TODO get from server
    strEventDate = '2015-06-20 18:00',
    $countdownElement = jQuery('#countdown'),
    $knobMinutes = jQuery('.knob.minutes');

    updateCountdown();
    setInterval(updateCountdown, 100);

    //init knob and display text
    jQuery('.knob').each(function() {
        var $el = jQuery(this);
        $el.data('width', '72');
        $el.data('height', '72');
        $el.data('readonly', true);
        $el.data('thickness', '.18');
        $el.data('step', '1');
        $el.data('displayinput', false);
        //$el.data('rotation') = 'anticlockwise';
        //Interet Explorer doesn't suppor jQuery Knob background color. Causes a bug drawing a canvas circle, not an arc, so set it transparent
        if(navigator.appName != 'Microsoft Internet Explorer' && !(navigator.appName == 'Netscape' && navigator.userAgent.indexOf('Trident') !== -1))
            $el.data('bgcolor', '#ccc');
        else
            $el.data('bgcolor', 'transparent');
        $el.knob();
        //creates an element for displaying the text outside of knob
        this.insertAdjacentHTML('beforebegin', '<div class="countdown-text  circle '+$el.data('displayfield')+'" data-displayfield="'+$el.data('displayfield')+'">&nbsp;</div>');
    });

    function getCountdownData(){
        //get current time data using Moment.JS and Countdown.JS;
        var data = moment(strCurrentDate).countdown(moment(strEventDate), countdown.DAYS | countdown.HOURS | countdown.MINUTES | countdown.SECONDS | countdown.MILLISECONDS );
        data.m = data.hours > 0 ? data.minutes : 0;
        return data;
    }

    var hasUpdatedOnce = false;
    var counter;
    function updateCountdown(){

        var data = getCountdownData();

        //Synchronize the seconds every minute and also updateAllButMinutes
        if(counter && data.seconds >= 0 && data.milliseconds >= 0)
            counter--;
        else{
            counter = data.seconds*10 + (Math.round(data.milliseconds/100)-1);
            updateAllButMinutes(data);
        }

        data.s = counter;


        //update seconds of minutes every cycle
        $knobMinutes.val(data[$knobMinutes.data('field')]);
        $knobMinutes.trigger('change'); //for knob to work ...
        $knobMinutes.parent().find('.countdown-text').html(data[$knobMinutes.data('displayfield')]);

        //If it's the first update, set the container visible and updateAllButMinutes
        if(!hasUpdatedOnce){
            $countdownElement.css('visibility', 'visible');
            updateAllButMinutes(data);
        }

        hasUpdatedOnce = true;
    }

    function updateAllButMinutes(data){
        jQuery('.knob').not('.minutes').each( function() {
            jQuery(this).val( data[ jQuery(this).data('field') ] );
            jQuery(this).trigger('change'); //for knob to work ...
        });
        jQuery('.countdown-text').not('.minutes').each( function() {
            this.innerHTML = data[ jQuery(this).data('displayfield') ];
        });
    }

    //Add a listener to window/tab focus to reset the counter so everything updates when the user leaves and get back focusing the window - tested in latest Chrome, Firefox and IE (11)
    window.addEventListener('focus', function(){
        var data = getCountdownData();
        counter = data.seconds*10 + (Math.round(data.milliseconds/100)-1);
        updateAllButMinutes(data);
    },false);

});


</script>

<script type="text/html" id="proximas-atracoes-template">
    <article class="event event-list">
        <a href="<%=url%>"><%=name%></a>
        <div class="event-space"><a href="<%=spaceUrl(spaceId)%>"><span class="icon icon_pin"></span><%=spaceName%></a></div>
    </article>
</script>
