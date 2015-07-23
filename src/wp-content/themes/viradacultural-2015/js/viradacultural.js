document.location.hash = document.location.hash.replace('%23', '#');

var eventUrl = function(eventId){
    return GlobalConfiguration.baseURL + '/programacao/atracao/##' + eventId;
};

var spaceUrl = function(spaceId){
    return GlobalConfiguration.baseURL + '/programacao/local/##' + spaceId;
};


var hl = {
    isMobile: function(){
        if (navigator.userAgent.match(/Android/i)
                || navigator.userAgent.match(/webOS/i)
                || navigator.userAgent.match(/iPhone/i)
                || navigator.userAgent.match(/iPad/i)
                || navigator.userAgent.match(/iPod/i)
                || navigator.userAgent.match(/BlackBerry/i)
                || navigator.userAgent.match(/Windows Phone/i)
                ) {
            return true;
        }
        else {
            return false;
        }
    }
};

(function($){
    function adjustCarrousselHome(){
            $('#front-page-carousel .item').each(function(){
                if (!hl.isMobile()) {
                    $(this).css('height', Math.floor($("#front-page-carousel").width() * (4/6) - 75));
                } else {
                    $(this).css('height', Math.floor($("#front-page-carousel").width() * (4/6) ));
                }
            });
    }


    $(document).ready(function() {

        $.smartbanner({
            title: 'Virada Cultural 2015', // What the title of the app should be in the banner (defaults to <title>)
            author: 'Instituto TIM', // What the author of the app should be in the banner (defaults to <meta name="author"> or hostname)
            price: 'Gratuíto', // Price of the app
            appStoreLanguage: 'pt-br', // Language code for App Store
//            inAppStore: 'On the App Store', // Text of price for iOS
//            inGooglePlay: 'In Google Play', // Text of price for Android
//            inAmazonAppStore: 'In the Amazon Appstore',
//            inWindowsStore: 'In the Windows Store', // Text of price for Windows
//            GooglePlayParams: null, // Aditional parameters for the market
            icon: GlobalConfiguration.templateURL + '/img/icone-app.png', // The URL of the icon (defaults to <meta name="apple-touch-icon">)
//            iconGloss: null, // Force gloss effect for iOS even for precomposed
//            url: null, // The URL for the button. Keep null if you want the button to link to the app store.
            button: 'INSTALAR', // Text for the install button
//            scale: 'auto', // Scale based on viewport size (set to 1 to disable)
//            speedIn: 300, // Show animation speed of the banner
//            speedOut: 400, // Close animation speed of the banner
//            daysHidden: 15, // Duration to hide the banner after being closed (0 = always show banner)
//            daysReminder: 90, // Duration to hide the banner after "VIEW" is clicked *separate from when the close button is clicked* (0 = always show banner)
//            force: null, // Choose 'ios', 'android' or 'windows'. Don't do a browser check, just always show this banner
//            hideOnInstall: true, // Hide the banner after "VIEW" is clicked.
//            layer: false, // Display as overlay layer or slide down the page
//            iOSUniversalApp: true // If the iOS App is a universal app for both iPad and iPhone, display Smart Banner to iPad users, too.
//            appendToSelector: 'body' //Append the banner to a specific selector
        });


        //bootstrap tooltip
        $('[data-toggle="tooltip"]').tooltip();

        if (hl.isMobile()) {
            $('body').addClass('mobile');
        } else {
            $('body').addClass('desktop');
        }
        //adjustCarrousselHome();

        function replaceCountdown(){
            var start = moment('2015-06-20 18:00');
            var end = moment('2015-06-21 23:59');
            var now = moment();
            if (!window.$footer) {
                var $footer = $('#countdown footer');
            }
            
            if (now > end) {
                if (!$footer.data('replaced')) {
                    $footer.data("replaced", true);
                    $('#countdown').html('');
                    $('#countdown').append($footer);
                }
                return;
            } else if (now > start) {
                $('#countdown').replaceWith('<div id="proximas-atracoes" class="event-list col-md-2 hidden-sm hidden-xs">');
            }

            if(now > start && window.jsons['events'] && window.jsons['spaces'] && window.jsons['spaces-order']){
                var template = $('#proximas-atracoes-template').text();
                var events = {};
                var space_ids = window.jsons['spaces-order'].slice(0,10).map(function(e){ return parseInt(e.id); });
                var counter = 0;
                var $atracoes = $('#proximas-atracoes');

                $atracoes.html('');
                $.each(window.jsons.events, function(i,e){
                    if(space_ids.indexOf(parseInt(e.spaceId)) >= 0 && e.duration !== '24h00' && moment(e.startsOn + ' ' + e.startsAt) > moment().subtract('minutes', 15)){
                        events[e.startsAt] = events[e.startsAt] ? events[e.startsAt] : [];
                        events[e.startsAt].push(e);
                        //if (counter ==0)
                        //    $('#proximas-atracoes').prepend(e.startsAt);
                        counter++;
                        if (counter >= 5)
                                return false;
                    }
                });



                $.each(events, function(hora, eventos){
                    $atracoes.append('<div class="comecando"><span class="icon icon_clock"></span>' + hora + '</div>');
                    $.each(eventos, function(i, e){
                        e.url = eventUrl(e.id);
                        e.spaceName = window.entitiesById.spaces[e.spaceId] ? window.entitiesById.spaces[e.spaceId].name : '';
                        var html = Resig.render(template, e);
                        $('#proximas-atracoes').append(html);
                    });
                    //return false;
                });

                $('#proximas-atracoes').append('<p class="programacao-completa"><a class="btn btn-primary btn-xs" href="' + GlobalConfiguration.baseURL + '/programacao/">Programação completa</a></p>');
                $('#proximas-atracoes').append($footer);

            }
        }

        if($('#countdown').length){
            window.jsons = {};

            window.entitiesById = {
                'events': {},
                'spaces': {},
                'spaces-order': {}
            };

            $.each(['spaces-order', 'events', 'spaces'], function(i,entity){
                $.get(GlobalConfiguration.templateURL + '/app/' + entity + '.json?v=' + GlobalConfiguration.md5[entity], function(response){
                    if(typeof response === 'string'){
                        response = JSON.parse(response);
                    }

                    $.each(response, function(i,e){
                        window.entitiesById[entity][e.id] = e;
                    });
                    window.jsons[entity] = response;
                    //replaceCountdown(); comentando essa linha depois que a virada acabou
                });
            });

            /* Desativando replaceCountdown depois que a virada acabou */
            replaceCountdown();

            setInterval(replaceCountdown, 10000);
            // */


//            $('#countdown').html($('#countdown footer')); // depois que a virada acabou

        }
    });

    $(window).resize(adjustCarrousselHome);

    /*** Ajustando altura fixa dos posts em grid ****/
    window.adustGridHeight = function (ent) {
        if ($('article.js-adjust-height').size()) {
            if ( $('article.js-adjust-height.has-thumbnail').size() > 0 ) {
                var adjustToH = $('article.js-adjust-height.has-thumbnail').height();
            } else {
                var refH = $('.post-content').height();
                var refW = $('.js-adjust-height').width();
                var refP = parseInt(jQuery('.post-content').css('padding-top').replace('px', ''));
                var adjustToH = 10 + refH - refP + parseInt(refW*4/6);
            }
            $('article.js-adjust-height').css('height', adjustToH + 'px');
        }

        // Nas redes
        if ($('article.js-redes-adjust-height').size()) {
            var refH = 96;
            var refW = parseInt(jQuery('article.js-redes-adjust-height').css('width').replace('px', ''));
            var adjustToH = refH + refW;
            $('article.js-redes-adjust-height').css('height', adjustToH + 'px');
        }
    }

    $(window).load(function(){
        window.adustGridHeight();
        adjustCarrousselHome();
    });



    $(document).ready(function(){
        FastClick.attach(document.body);


        $('#programacao-loading').height( $(window).height() );

        $('#front-page-carousel .item:first, .carousel-indicators li:first').addClass('active');

        $('#front-page-carousel').carousel();

        // MENU ANIMATION
        // $("#main-header li.has-children").hover(
        //     function() {
        //         $("#main-header").removeClass().addClass("col-md-1");
        //     },
        //     function() {
        //         $("#main-header").removeClass().addClass("col-md-2");
        //     }
        // );

        $(window).resize(function() {
            window.adustGridHeight('resize');
        });
        /*************************************************/

        // véio
        $('#search-submit').click(function() {
            $('#pages-search').submit();
        });
        $('#busca-site').click(function() {
            $('#pages-search').submit();
        });
        $('#busca-programacao').click(function() {
            var term = $('#search-term').val();
            if (term)
                window.location.replace(GlobalConfiguration.baseURL + '/programacao/##' + term);
        });


    });

    hl.scrollCarrousel = {

        init: function(selector){
            selector = selector || '.hl-carrousel';

            if($(selector).data('hl-carrousel-ready'))
                return false;
            $(selector).data('hl-carrousel-ready', true);

            $(selector).find('.hl-nav, .hl-num-nav').remove();

            $(selector).css({
                position: 'relative',
                overflowY: 'hidden'
            }).find('.hl-wrap>*').css({
                float: 'left'
            });
            $(selector).find('.hl-wrap').parent().css({
                overflowX: 'auto'
            });

            $(selector).each(function(){
                var $this       = $(this),
                    $wrap       = $this.find('.hl-wrap'),
                    $items      = $this.find('.hl-wrap>*'),
                    $ref        = $this.find('.hl-ref'),
                    item_width  = 0,
                    outer        = 0,
                    margin_left   = 0,
                    margin_right  = 0,
                    padding_left  = 0,
                    padding_right = 0;


                var adjust = function(){
                    var wrap_width = 0;

                    if($this.width() === $this.data('last-width'))
                        return true;

                    $this.data('last-width', $this.width());

                    $wrap.css("margin-left", 0);

                    if($ref.length){
                        item_width      = $ref.width();
                        margin_left     = parseFloat($ref.css('margin-left'));
                        margin_right    = parseFloat($ref.css('margin-right'));
                        padding_left    = parseFloat($ref.css('padding-left'));
                        padding_right   = parseFloat($ref.css('padding-right'));
                        outer = margin_left + margin_right + padding_left + padding_right;
                    }else{
                        item_width = $wrap.find(">:first").outerWidth(true);
                    }

                    $items.each(function(){
                        wrap_width += item_width + outer;
                    });

                    $wrap.css('width', wrap_width);


                    $items.css({
                        width: item_width,
                        marginLeft: margin_left,
                        marginRight: margin_right,
                        paddingLeft: padding_left,
                        paddingRight: padding_right
                    });
                };

                adjust();
                $(window).resize(adjust);
            });
        }
    },

    hl.carrousel = {
        init: function(selector){
            selector = selector || '.hl-carrousel';


            setTimeout(function(){
                $(selector).css({
                    position: 'relative',
                    overflow: 'hidden'
                }).find('.hl-wrap>*').css({
                    float: 'left'
                });

                $(selector).each(function(){
                    if($(this).data('hl-carrousel-ready'))
                        return false;

                    $(this).data('hl-carrousel-ready', true);

                    var $this       = $(this),
                        $wrap       = $this.find('.hl-wrap'),
                        $items      = $this.find('.hl-wrap>*'),
                        $num_nav    = $this.find('.hl-num-nav'),
                        $ref        = $this.find('.hl-ref'),
                        inc         = $this.data('scroll-num'),
                        num_pages   = 0,
                        per_page    = inc,
                        item_width  = 0,
                        active_index = 0,
                        outer        = 0,
                        margin_left   = 0,
                        margin_right  = 0,
                        padding_left  = 0,
                        padding_right = 0;

                    $num_nav.find('.hl-num-nav-item').live('click', function(){
                        var index = $(this).data('index');
                        goto_page(index);
                    });

                    var goto_page = function(index){
                        var mleft = index * (item_width + outer) * per_page;
                        if(mleft > $wrap.width() - $wrap.parent().width() && $wrap.width() - $wrap.parent().width() > 0)
                            mleft = $wrap.width() - $wrap.parent().width();
                        $wrap.stop().animate({'margin-left': -mleft}, function(){
                            active_index = index;
                            $num_nav.find('.hl-num-nav-item').removeClass('current');
                            $num_nav.find('.hl-num-nav-item:eq('+index+')').addClass('current');
                            $this.data('carrousel-page', index);

                            $this.find('.hl-nav').removeClass('disabled');

                            if(active_index === 0)
                                $this.find('.hl-nav.prev').addClass('disabled');

                            if(active_index === num_pages - 1)
                                $this.find('.hl-nav.next').addClass('disabled');

                        });
                    };

                    var adjust = function(){
                        var wrap_width = 0;

                        if($this.width() === $this.data('last-width'))
                            return true;

                        $this.data('last-width', $this.width());

                        $wrap.css("margin-left", 0);

                        if($ref.length){
                            item_width      = $ref.width();
                            margin_left     = parseFloat($ref.css('margin-left'));
                            margin_right    = parseFloat($ref.css('margin-right'));
                            padding_left    = parseFloat($ref.css('padding-left'));
                            padding_right   = parseFloat($ref.css('padding-right'));
                            outer = margin_left + margin_right + padding_left + padding_right;
                        }else{
                            item_width = $wrap.find(">:first").outerWidth(true);
                        }

                        $items.each(function(){
                            wrap_width += item_width + outer;
                        });

                        $wrap.css('width', wrap_width);


                        $items.css({
                            width: item_width,
                            marginLeft: margin_left,
                            marginRight: margin_right,
                            paddingLeft: padding_left,
                            paddingRight: padding_right
                        });

                        if($num_nav.length){
                            if(!inc || inc === 'auto' || $num_nav.html()){
                                per_page = parseInt($items.length / ($wrap.width() / $wrap.parent().width()));
                                per_page = per_page > 0 ? per_page : 1;
                                num_pages = Math.ceil($items.length / per_page);
                            }else{
                                num_pages = Math.ceil($items.length / inc);
                            }

                            if(num_pages > 1){
                                var nav_tag = 'A';

                                if($num_nav.get(0).tagName === 'UL')
                                    nav_tag = 'LI';

                                if(num_pages !== $num_nav.find('.hl-num-nav-item').length){
                                    $num_nav.html('');
                                    for(var i = 0; i < num_pages; i++){
                                        $num_nav.append($('<'+nav_tag+'>').html(i+1).attr('class','hl-num-nav-item' + (i===0 ? ' current' : '')).data('index', i));
                                    }
                                }
                            }
                        }

                        $this.data('carrousel-num-pages', num_pages);
                    };

                    $this.find('.hl-nav').click(function(){
                        if($(this).hasClass('next')){
                            if(active_index + 1 >= num_pages){
                                if($this.data('cycle'))
                                    goto_page(0);
                            }else{
                                goto_page(active_index + 1);
                            }

                        }else if($(this).hasClass('prev')){
                            if(active_index <= 0){
                                if($this.data('cycle'))
                                    goto_page(num_pages-1);
                            }else{
                                goto_page(active_index - 1);
                            }
                        }
                    });

                    // touch events

                    if(typeof $.fn.swipe !== 'undefined'){
                        $this.swipeleft(function(){
                            $this.find('.hl-nav.next').click();
                        });

                        $this.swiperight(function(){
                            $this.find('.hl-nav.prev').click();
                        });

                    }

                    adjust();
                    $(window).resize(adjust);
                    goto_page(0);
                });
            });
        }
    }
})(jQuery);
