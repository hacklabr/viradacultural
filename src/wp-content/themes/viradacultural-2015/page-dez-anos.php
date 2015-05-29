<?php
/*
Template Name: 10 anos
*/
?>

<?php get_header(); ?>
<script type="text/javascript">
    var imgs = {};
</script>
<div class="container-fluid container-menu-minified">
    <div class="row">
        <section id="main-section" class="virada-10-anos">
            <?php if ( have_posts()) : while ( have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('row parent');?>>

                    <header>
                        <div class="block">
                            <div class="centered text-center">
                                <?php html::image("logo-large.png", "", array("class" => "img-responsive")); ?>
                            </div>
                        </div>
                    </header>

                    <script type="text/javascript">
                    imgs['<?php the_ID(); ?>'] = {};
                    <?php
                        $fig_id = "bg-" . get_the_ID();
                        $imgs = array();

                        if( has_post_thumbnail() ){
                            $imgs[1080] = wp_get_attachment_image_src(get_post_thumbnail_id(), "i1080");
                            $imgs[900]  = wp_get_attachment_image_src(get_post_thumbnail_id(), "i900");
                            $imgs[800]  = wp_get_attachment_image_src(get_post_thumbnail_id(), "i800");
                            $imgs[768]  = wp_get_attachment_image_src(get_post_thumbnail_id(), "i768");
                            $imgs[480]  = wp_get_attachment_image_src(get_post_thumbnail_id(), "i480");
                            $imgs[320]  = wp_get_attachment_image_src(get_post_thumbnail_id(), "i320");
                            foreach($imgs as $size => $img)
                                echo "\nimgs[" . get_the_ID() . "][{$size}] = '{$img[0]}';";
                        }
                    ?>
                    </script>
                    <figure id='<?php $fig_id ?>' class="hidden" >
                    </figure>
                </article>

                <?php
                    $children = new WP_Query( array( 'post_parent' => $post->ID, 'post_type' => 'page', 'orderby' => 'menu_order', 'order' => 'DESC', 'nopaging' => true));
                    if( $children->have_posts() ) : while( $children->have_posts() ) : $children->the_post();
                ?>
                    <script type="text/javascript">
                    imgs['<?php the_ID(); ?>'] = {};
                    <?php
                        $fig_id = "bg-" . get_the_ID();
                        $imgs = array();

                        if( has_post_thumbnail() ){
                            $imgs[1080] = wp_get_attachment_image_src(get_post_thumbnail_id(), "i1080");
                            $imgs[900]  = wp_get_attachment_image_src(get_post_thumbnail_id(), "i900");
                            $imgs[800]  = wp_get_attachment_image_src(get_post_thumbnail_id(), "i800");
                            $imgs[768]  = wp_get_attachment_image_src(get_post_thumbnail_id(), "i768");
                            $imgs[480]  = wp_get_attachment_image_src(get_post_thumbnail_id(), "i480");
                            $imgs[320]  = wp_get_attachment_image_src(get_post_thumbnail_id(), "i320");
                            foreach($imgs as $size => $img)
                                echo "\nimgs[" . get_the_ID() . "][{$size}] = '{$img[0]}';";
                        }
                    ?>
                    </script>
                    <article id="post-<?php the_ID(); ?>" data-id="<?php the_ID(); ?>" data-nav='#nav-<?php the_ID(); ?>' <?php post_class('row children');?>>
                        <header class="js-article-header">
                            <h1><?php the_title(); ?></h1>
                        </header>
                        <figure id='figure-<?php the_ID(); ?>'></figure>
                        <section class="block js-content">
                            <div class="centered text-left">
                                <?php the_content(); ?>
                                <?php if(get_post_meta($post->ID, 'url_do_pdf', true)): ?>
                                    <p class="text-right"><a href="<?php echo get_post_meta($post->ID, 'url_do_pdf', true);?>" class="btn btn-large btn-success">Baixar programação</a></p>
                                <?php endif; ?>
                            </div>
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
        <nav id="years-nav" class="visible-lg">
            <div id='nav-home' class="year block">
                <div class="centered"><span class="icon icon_house"></span></div>
            </div>
            <?php if( $children->have_posts() ) : while( $children->have_posts() ) : $children->the_post(); ?>
                <div id='nav-<?php the_ID() ?>' class="year block" data-target="post-<?php the_ID(); ?>">
                    <div class="centered"><?php the_title(); ?></div>
                </div>
            <?php endwhile; endif; ?>
        </nav>
    </div>
    <?php  get_footer(); ?>
</div>
<!-- .container-fluid -->


<script type="text/javascript" charset="utf-8">
(function($){

    $(document).ready(function() {

        var $win             = $(window),
            $bg              = $("figure > img"),
            $navBar          = $('#site-navbar'),
            $header          = $('#main-header'),
            $footer          = $('#main-footer'),
            aspectRatio      = $bg.width() / $bg.height(),
            win_height       = $win.height(),
            win_width        = $win.width(),
            navbar_height    = $navBar.height(),
            header_width     = $header.width(),
            area_util        = win_height - navbar_height,
            tops             = {},
            last;


        if (!hl.isMobile()) {
            $("#main-section > article").css({'position': 'fixed', 'top': 1000});
            $("#main-section > article figure").css({'position': 'fixed', 'top': 0});
            $(".js-article-header").css({'position': 'fixed', 'top': navbar_height});
        }

        function resize() {
            area_util = win_height - navbar_height;
            win_height = $win.height();
            win_width  = $win.width();
            navbar_height = $navBar.is(':visible') ? $navBar.height() : 0;

            // Altura do artigo pai
            $("#main-section > article.parent").height(area_util);
            // Altura da seção do artigo pai
            $("#main-section > article.parent .block").height(area_util);

            if (!hl.isMobile()) {
                // Altura da seção principal
                $("#main-section").height(area_util)
                // Altura e largura dos artigos
                $("#main-section > article").height(area_util).width(win_width - header_width);
                // Altura da imagem do artigo pai
                $("#main-section > article.parent .block > .centered > img").css({height: win_height - navbar_height * 2, width: "auto"});
                // Margem do header do artigo pai
                $("#main-section > article.parent > header").css({ marginTop: navbar_height });
            }

            // Ano
            $("#years-nav").css({height: area_util, top: navbar_height});

            var total = 0;

            last = {
                start: 0,
                finish: 0
            };

            $("#main-section > article.children").each(function(){
                var url;
                var id = $(this).data('id');

                var cheight = $(this).find('.js-content').outerHeight();
                var height = area_util + cheight;

                tops[this.id] = {
                    start: last.finish + 100,
                    finish: last.finish + height + 100,
                    height: height,
                    contentHeight: cheight
                };
                last = tops[this.id];
                total += height;

                $(this).data('top', tops[this.id]);

                if(hl.isMobile()){
                    for(var size in imgs[id]){
                        if(size >= win_height && size * 1.777778 >= win_width && url)
                            break;

                        url = imgs[id][size];
                    }
                }else{
                    for(var size in imgs[id]){
                        url = imgs[id][size];
                        if(size >= win_height && size * 1.777778 >= win_width)
                            break;
                    }
                }


                if (!hl.isMobile()) {
                    $(this).find('figure').css({
                        background: 'url(' + url + ') center center no-repeat',
                        width: win_width,
                        height: win_height
                    });
                } else {
                    if (win_height > win_width) {
                        $(this).find('figure').css({
                            background: 'url(' + url + ') center center no-repeat',
                            width: win_width,
                            height: win_height
                        });
                    } else {
                        $(this).find('figure').css({
                            background: 'url(' + url + ') center center no-repeat',
                            width: win_width - 115,
                            height: win_height
                        });
                    }
                }

            });

            $('body').css('height',  last.finish + win_height);

        }

        $win.resize(resize).trigger("resize");
        $win.load(resize);

        if (hl.isMobile()) {
            return;
        }

        $(window).scroll(function(){
            var st = $(window).scrollTop();
            var activeId = '#nav-home';
            for(var id in tops){
                if(st > tops[id].start + 100)
                    activeId = $('#' + id).data('nav')

            };
            $('#years-nav .active').removeClass('active');
            $(activeId).addClass('active');
        });

        $('#years-nav>div').click(function(){
            var top;
            if($(this).data('target'))
                top = tops[$(this).data('target')].start + tops[$(this).data('target')].contentHeight;
            else
                top = 0;

            $('html, body').animate({scrollTop: top}, 500);
        });

        // vai para a posição certa do scroll no caso de o hash ser o id de algum post
        if(document.location.hash){
            if($(document.location.hash).length && $(document.location.hash).data('top'))
                $(window).scrollTop($(document.location.hash).data('top').top);
            else
                $(window).scrollTop(0);
        }



        $("#main-section > article.parent").animascroll({
            startAt: 0,
            finishAt: function(){return win_height; },
            animation: function(p){
                $(this).css('top', $.PVAL(0, -win_height, p));
            }
        });


        $("#main-section > article.children").each(function(i){
            var index = i+2;
            var $nav = $($(this).data('nav'));
            var $this = $(this);
            var $figure = $this.find('figure');
            var $article_header = $this.find('.js-article-header');

            $this.animascroll({
                startAt: function(){
                    return tops[this.id].start;
                },
                finishAt: function(){
                    return tops[this.id].finish;
                },
                animation: function(p){
                    $this.css('top', $.PVAL(win_height, -tops[this.id].contentHeight + navbar_height, p));
                }
            }).animascroll({
                startAt: function(){
                    return tops[this.id].start;
                },
                finishAt: function(){
                    return tops[this.id].start + tops[this.id].contentHeight;
                },
                animation: function(p){
                    var val = $.PVAL(0,1,p);
                    $figure.css({
                        'opacity': val,
                        //top: $.PVAL(10,-10,p)
                    });
                    if (val <= 0) {
                        $figure.hide();
                    }
                    if (val > 0) {
                        $figure.show();
                    }

                    $article_header.css('opacity', val);
                }
            });
        });

        $('#main-footer').css({
            position: 'fixed',
            right:0,
            left: $('#main-nav').width()
        }).animascroll({
            startAt: function(){
                return last.finish - $(this).outerHeight();
            },
            finishAt: function(){
                return last.finish;
            },
            animation: function(p){
                $(this).css('top', $.PVAL(win_height, win_height - $(this).outerHeight(), p));
            }
        });
    })
})(jQuery);
</script>
