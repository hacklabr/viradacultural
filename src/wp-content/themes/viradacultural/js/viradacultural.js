var hl = {};


(function($){

    FastClick.attach(document.body);

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
    });

    $(document).ready(function(){

        $('.btn span').tooltip();

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

        $('#search-submit').click(function() {
            $('#pages-search').submit();
        });


    });

    hl.carrousel = {
        init: function(selector){
            selector = selector || '.hl-carrousel';

            if($(selector).data('hl-carrousel-ready'))
                return false;
            $(selector).data('hl-carrousel-ready', true);

            $(selector).css({
                position: 'relative',
                overflow: 'hidden'
            }).find('.hl-wrap>*').css({
                float: 'left'
            });

            $(selector).each(function(){
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
        }
    }
})(jQuery);
