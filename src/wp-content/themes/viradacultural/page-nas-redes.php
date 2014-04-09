<?php
/*
Template Name: Nas redes
*/
global $paged;
query_posts(array(
	'post_type' => array('instagram_cpt', 'twitter_cpt'),
	'posts_per_page' => 80,
	'paged' => $paged
));
?>

<?php get_header(); ?>
<div class="container-fluid">
	<div class="row">
		<section id="main-section" class="col-md-8 col-md-offset-2">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php html::part('loop-redes'); ?>
                <?php endwhile; ?>
                <?php if ($wp_query->max_num_pages > 1) : ?>
                    <nav id="posts-nav" class="clearfix">
                        <div class="alignleft"><?php next_posts_link(__('&laquo; Previous posts', 'viradacultural')); ?></div>
                        <div class="alignright"><?php previous_posts_link(__('Next posts &raquo;', 'viradacultural')); ?></div>
                    </nav>
                    <!-- #posts-nav -->
                <?php endif; ?>					
            <?php else : ?>
                <p>Nada encontrado. Publique no twitter ou Instagram com a hashtag #<?php echo get_theme_option('hashtag'); ?></p>              
            <?php endif; ?>
		</section>
		<!-- #main-section -->
		<?php get_footer(); ?>
	</div>
	<!-- .row -->         
</div>
<!-- .container-fluid -->
<?php html::part('countdown'); ?>
