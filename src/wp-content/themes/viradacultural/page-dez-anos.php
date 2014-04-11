<?php
/*
Template Name: 10 anos
*/
?>

<?php get_header(); ?>
<div class="container-fluid">
    <div class="row">
        <section id="main-section" class="col-md-offset-1 virada-10-anos">
            <?php if ( have_posts()) : while ( have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('row parent');?>>

                    <header>
                        <div class="block">
                            <div class="centered textcenter">
                                <?php html::image("logo-roxo-1024.png", "", array("class" => "img-responsive")); ?>
                            </div>
                        </div>
                    </header>

                    <section>
                        <div class="block">
                            <div class="centered textcenter" style="width: 90%;">
                                <div class="content col-md-8 col-md-offset-2"><?php the_content(); ?></div>
                            </div>
                        </div>
                    </section>

                    <figure>
                        <?php if ( has_post_thumbnail() ) the_post_thumbnail("large", array("class" => "background-image")); ?>
                    </figure>
                </article>

                <?php
                    $children = new WP_Query( array( 'post_parent' => $post->ID, 'post_type' => 'page', 'orderby' => 'menu_order', 'order' => 'ASC', 'nopaging' => true));
                    if( $children->have_posts() ) : while( $children->have_posts() ) : $children->the_post();
                ?>
                    <article id="post-<?php the_ID(); ?>" data-nav='#nav-<?php the_ID(); ?>' <?php post_class('row children');?>>
                        <figure id='figure-<?php the_ID(); ?>'>
                            <?php the_post_thumbnail("large", array("class" => "background-image")); ?>
                        </figure>
                        <hr style="z-index:10000; position: relative;">

                        <header>
                            <h1><?php the_title(); ?></h1>
                        </header>
                        <section class="col-md-4 col-md-offset-8 clearfix">
                            <?php the_content(); ?>
                            <p><button class="btn btn-large btn-success">Baixar programação</button></p>
                        </section>
                    </article>

                <?php endwhile; endif; ?>
                <!-- .page -->
            <?php endwhile; ?>
            <?php else : ?>
               <p><?php _e('No results found.', 'viradacultural'); ?></p>
            <?php endif; ?>
        </section>
        <!-- #main-section -->
        <style> a.active span { background:red !important; }</style>
        <nav id="years-nav" class="block">
            <div class="centered">
                <a id='nav-home' href=""><span class="year">HOME</span></a>
                <?php if( $children->have_posts() ) : while( $children->have_posts() ) : $children->the_post(); ?>
                    <a id='nav-<?php the_ID() ?>' href="#"><span class="year"><?php the_title(); ?></span></a>
                <?php endwhile; endif; ?>
            </div>
        </nav>
    </div>
    <?php get_footer(); ?>
</div>
<!-- .container-fluid -->

<script type="text/javascript" charset="utf-8">
(function($){
    $(document).ready(function() {
        var $win             = $(window),
            $bg              = $("figure > img"),
            $navBar          = $('#site-navbar'),
            $footer          = $('#main-footer'),
            aspectRatio      = $bg.width() / $bg.height(),
            win_height       = $win.height(),
            navbar_height    = $navBar.height(),
            article_height = win_height - navbar_height;

        $("#main-section > article").css({'position': 'fixed', 'top': 1000});
        $("#main-section > article figure").css({'position': 'fixed', 'top': 0});

        function resize() {
            article_height = win_height - navbar_height;
            win_height = $win.height();

            $("#main-section > article").height(article_height);
            $("#main-section > article.parent").height(article_height * 2);
            $("#main-section > article.parent .block").height(article_height);
            $("#main-section > article.parent .block > .centered > img").css({height: win_height - navbar_height * 2, width: "auto"});


//            if ( ($win.width() / win_height) < aspectRatio ) {
//                $bg
//                    .removeClass()
//                    .addClass('bgheight');
//            } else {
//                $bg
//                    .removeClass()
//                    .addClass('bgwidth');
//            }

            $('body').css('height',  article_height * ($("#main-section > article").length + 2) + navbar_height);
        }

        $win.resize(resize).trigger("resize");

        $("#main-section > article.parent").animascroll({
            startAt: 0,
            finishAt: function(){ console.log(win_height); return win_height; },
            animation: function(p){
                $(this).css('top', $.PVAL(0, -win_height, p));
            }
        });

        $("#main-section > article.children").each(function(i){
            var index = i+2;
            var $nav = $($(this).data('nav'));
            var $this = $(this);
            var $figure = $this.find('figure');

            $this.animascroll({
                startAt: function(){
                    return index * article_height;
                },
                finishAt: function(){
                    return (index + 1) * article_height;
                },
                animation: function(p){
                    $this.css('top', $.PVAL(win_height, navbar_height, p));
                    if(p >= 50){
                        $('#years-nav a.active').removeClass('active');
                        $nav.addClass('active');
                    }

                }
            }).animascroll({
                startAt: function(){
                    return index * article_height + article_height/2;
                },
                finishAt: function(){
                    return (index + 1) * article_height - article_height/8;
                },
                animation: function(p){
                    $figure.css('opacity',$.PVAL(0,1,p));
                }
            });
        });




        // $("article > figure > img").each(function(index) {
        //     $(this).attr("id", "parallax-image-"+index);
        //     index++;
        // })
        // for (var i = 0; i < $("article").size(); i++) {
        //     $("#main-section").append("<div id='trigger-"+i+"' class='trigger'></div>");
        // }
        // var controller = new ScrollMagic();
        // var scenes = [];
        // var tweens = [];
        // for (var i = 0; i < $("article").size(); i++) {
        //     if (i == 0) {
        //         tweens[i] = TweenMax.fromTo("#parallax-image-"+i, 0.5, { "opacity": 1 }, { "opacity": 1 } )
        //         scenes[i] = new ScrollScene({triggerElement: "#trigger-"+i, duration: 0, offset: $win.height() }).setTween(tweens[i]).addTo(controller);
        //     } else {
        //         tweens[i] = TweenMax.fromTo("#parallax-image-"+i, 0.5, { "opacity": 0, "visibility": "hidden" }, { "opacity": 1, "visibility": "visible" } )
        //         scenes[i] = new ScrollScene({triggerElement: "#trigger-"+i, duration: 0, offset: ($win.height() - 76) * i }).setTween(tweens[i]).addTo(controller);
        //     }
        //     scenes[i].addIndicators();
        // }
    })
})(jQuery);
</script>