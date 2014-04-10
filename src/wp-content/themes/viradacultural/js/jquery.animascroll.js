(function($) {
    $.animascrollElementCount = 0;
    $.PVAL = function(min, max, percentage){
        if(percentage > 100) percentage = 100;
        if(percentage < 0 || isNaN(percentage)) percentage = 0;

        var range = max-min;
        return (percentage*range/100) + min;
    };
    
    var getAnimationStatus = function (scroll, start, finish){
        if(scroll <= start)
            return -1; // before animation

        else if(scroll >= finish)
            return 1; // after animation

        else
            return 0; // inside animation
    };

    var getScrollPercentage = function (scroll, start, finish){
        return (scroll - start)*100/(finish - start);
    };
    
    $.fn.animascroll = function(options) {
        $(this).each(function(){
            
            $.animascrollElementCount++;
            var element = this;
            
            (function(options){
                var startAt = options.startAt;
                var finishAt = options.finishAt;
                
                if(typeof options.startAt === 'number')
                    options.startAt = function(){
                        return startAt;
                    };
            
                if(typeof options.finishAt === 'number'){
                    options.finishAt = function(){
                        return finishAt;
                    };
                }
                
            })(options);
            
            
            options = $.extend({
                type:'vertical',
                scrollElement: $(window),
                startAt: function (){
                    return 0;
                }, 
                finishAt: function (){
                    return $(document).height();
                }, 
                animation: function(){}, 
                onStart: function (){}, 
                onFinish: function(){}, 
                onStartRewind: function(){}, 
                onFinishRewind: function(){},
                id: $.animascrollElementCount
            }, options);
            
            
            var last_animation_status = getAnimationStatus(scroll, options.startAt.apply(element, [options]), options.finishAt.apply(element, [options]));
            
            var d0 = false;
            var d100 = false;
            var body_height = $(document.body).height();
            var do_animation = function() {
                var b_height = $(document.body).height();
                var body_height_changed =  body_height !== b_height;
                body_height = b_height;
                
                var start = options.startAt.apply(element, [options]);
                var finish = options.finishAt.apply(element, [options]);
                
                var scroll = options.type === 'vertical' ? options.scrollElement.scrollTop() : options.scrollElement.scrollLeft();
                
                var scroll_percentage = getScrollPercentage(scroll, start, finish);
                
                var animation_status = getAnimationStatus(scroll, start, finish);
                
                // on start animation
                if(last_animation_status === -1 && animation_status >= 0){
                    options.onStart.apply(element, [options]);
                }
                
                // on finish animation
                if(last_animation_status < 1 && animation_status === 1){
                    options.onFinish.apply(element, [options]);
                }
                
                // on start rewind
                if(last_animation_status === 1 && animation_status <= 0  ){
                    options.onStartRewind.apply(element, [options]);
                }
                
                // on finish rewind
                if(last_animation_status !== -1 && animation_status === -1){
                    options.onFinishRewind.apply(element, [options]);
                }

                last_animation_status = animation_status;
                
                if(animation_status === 0 && !isNaN(scroll_percentage) || body_height_changed){
                    d0 = false;
                    d100 = false;
                    options.animation.apply(element,[scroll_percentage,options]);
                }else if(animation_status === -1 && !d0 || body_height_changed){
                    d0 = true;
                    d100 = false;
                    options.animation.apply(element,[0,options]);
                }else if(animation_status === 1 && !d100 || body_height_changed){
                    d100 = true;
                    d0 = false;
                    options.animation.apply(element,[100,options]);
                }
            };
            
            options.scrollElement.bind('scroll', do_animation);
            $(window).bind('resize', do_animation);
            $(document).bind('ready', do_animation);
            $(document).bind('load', do_animation);
            
        });
        
        return this;
    };
        
})(jQuery);