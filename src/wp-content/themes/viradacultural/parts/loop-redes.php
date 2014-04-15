<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix grid-post post-redes col-lg-3 col-md-6 col-sm-4 col-xs-12 bottom left right')?> <?php if ($ajaxhide) echo 'style="display:none"'; ?> >
<?php if (get_post_type() == 'twitter_cpt'): ?>
    <div class="post-content">    
        <div class="post-type-icon"><span class="icon social_twitter"></span></div>
        <header>
            <p>
            <a href="<?php echo 'http://twitter.com/', get_post_meta(get_the_ID(), 'author_username', true); ?>">@<?php echo get_post_meta(get_the_ID(), 'author_username', true); ?></a><br>
            <time class="post-time" datetime="<?php the_time('Y-m-d'); ?>" pubdate><?php the_time( 'd-m-Y - H:i' ); ?></time>
            </p>
        </header>
        <?php the_content(); ?> 
        
    </div>
<?php else: ?>
    <div class="post-img">
        <div class="post-img-cover"></div>
        <?php the_content(); ?>
    </div>
        <div class="post-type-icon"><span class="icon social_instagram"></span></div>
        <footer>
            <p>
                <a href="<?php echo 'http://instagram.com/', get_post_meta(get_the_ID(), 'author_username', true); ?>"><?php echo get_post_meta(get_the_ID(), 'author_username', true); ?></a><br>
                <time class="post-time" datetime="<?php the_time('Y-m-d'); ?>" pubdate><?php the_time( 'd-m-Y - H:i' ); ?></time>
            </p>
        </footer>
<?php endif; ?>

</article>
<!-- .post -->


                
