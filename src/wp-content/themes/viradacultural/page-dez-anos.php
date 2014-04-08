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
                        <h1><?php the_title();?></h1>
                    </header>
                    <figure>
                        <?php if ( has_post_thumbnail() ) the_post_thumbnail("full", array("class" => "background-image")); ?>
                    </figure>
                    <section class="block col-md-8 col-md-offset-2">
                        <div class="centered">
                            <?php the_content(); ?>
                            <p><?php edit_post_link( __( 'Edit', 'viradacultural' ), '', '' ); ?></p>
                        </div>
                    </section>
                </article>

                <?php
                    $children = new WP_Query( array( 'post_parent' => $post->ID, 'post_type' => 'page', 'orderby' => 'menu_order', 'order' => 'ASC', 'nopaging' => true));
                    if( $children->have_posts() ) : while( $children->have_posts() ) : $children->the_post();
                ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('row children');?>>
                        <header>
                            <h1><?php the_title(); ?></h1>
                        </header>
                        <figure>
                            <?php the_post_thumbnail("full", array("class" => "background-image")); ?>
                        </figure>
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
        <nav id="years-nav" class="block">
            <div class="centered">
                <?php if( $children->have_posts() ) : while( $children->have_posts() ) : $children->the_post(); ?>
                    <a href="#post-<?php the_ID(); ?>"><span class="year"><?php the_title(); ?></span></a>
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
        var theWindow        = $(window),
            $bg              = $("figure > img"),
            aspectRatio      = $bg.width() / $bg.height();

        $("#main-section > article").height(theWindow.height() - 55);
        $("#main-section > article.parent > .block").height(theWindow.height() - 100);

        function resizeBg() {
            if ( (theWindow.width() / theWindow.height()) < aspectRatio ) {
                $bg
                    .removeClass()
                    .addClass('bgheight');
            } else {
                $bg
                    .removeClass()
                    .addClass('bgwidth');
            }
        }
        theWindow.resize(resizeBg).trigger("resize");

        $("article > figure > img").each(function(index) {
            $(this).attr("id", "parallax-image-"+index);
            index++;
        })

        for (var i = 0; i < $("article").size(); i++) {
            $("#main-section").append("<div id='trigger-"+i+"' class='trigger'></div>");
        }

        var controller = new ScrollMagic();
        
        var scenes = [];
        var tweens = [];
        for (var i = 0; i < $("article").size(); i++) {
            if (i == 0) {
                tweens[i] = TweenMax.fromTo("#parallax-image-"+i, 0.5, { "opacity": 1 }, { "opacity": 1 } )
                scenes[i] = new ScrollScene({triggerElement: "#trigger-"+i, duration: 0, offset: -(theWindow.height() - 50) }).setTween(tweens[i]).addTo(controller);
            } else {
                tweens[i] = TweenMax.fromTo("#parallax-image-"+i, 0.5, { "opacity": 0, "visibility": "hidden" }, { "opacity": 1, "visibility": "visible" } )
                scenes[i] = new ScrollScene({triggerElement: "#trigger-"+i, duration: 0, offset: (theWindow.height() - 55) * i }).setTween(tweens[i]).addTo(controller);
            }
            // scenes[i].addIndicators();
        }
    })
})(jQuery);
</script>