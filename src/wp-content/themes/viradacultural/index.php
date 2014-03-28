<?php get_header(); ?>
 <?php 
    // teste de parte cacheada
html::part('cache-test',array("__CACHE" => 604800, 'color' => '#f88'));
html::part('cache-test',array("__CACHE" => 10, 'color' => '#ff8'));
?>

<div class="wrap clearfix">
    <?php get_sidebar(); ?>
    <section id="main-section" class="col-8">
        cidade: <?php form::cidade_uf_autocomplete(array('cidade'=>4205407, 'uf'=>42)); ?>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php html::part('loop'); ?>
            <?php endwhile; ?>
            <?php if ($wp_query->max_num_pages > 1) : ?>
                <nav id="posts-nav" class="clearfix">
                    <div class="alignleft"><?php next_posts_link(__('&laquo; Previous posts', 'viradacultural')); ?></div>
                    <div class="alignright"><?php previous_posts_link(__('Next posts &raquo;', 'viradacultural')); ?></div>
                </nav>
                <!-- #posts-nav -->
            <?php endif; ?>					
        <?php else : ?>
            <p><?php _e('No results found.', 'viradacultural'); ?></p>              
        <?php endif; ?>
    </section>
    <!-- #main-section -->	          
</div>


<!-- .wrap --> 

<?php get_footer(); ?>
