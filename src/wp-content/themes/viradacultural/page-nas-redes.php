<?php
/*
Template Name: Nas redes
*/
global $paged;
query_posts(array(
	'post_type' => array('instagram_cpt', 'twitter_cpt'),
	'posts_per_page' => 80,
	'paged' => $paged,
    'orderby' => 'ID',
    'order' => 'DESC'
));

add_action('wp_print_scripts', function () {
    wp_enqueue_script('nasredes', get_stylesheet_directory_uri().'/js/nasredes.js','jquery');
});

?>

<?php get_header(); ?>

<div class="container-fluid">
	<div class="row">
        
		<section id="main-section" class="col-md-8 col-md-offset-2">
            
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php html::part('loop-redes'); ?>
            <?php endwhile; ?>
                				
            <?php else : ?>
                <p>Nada encontrado. Publique no twitter ou Instagram com a hashtag #<?php echo get_theme_option('hashtag'); ?></p>              
            <?php endif; ?>
		</section>
        <div class="col-md-8 col-md-offset-2">
            <button type="button" class="btn btn-default clear" id="load-more">Carregar mais</button>
        </div>
		<!-- #main-section -->
		<?php get_footer(); ?>
	</div>
	<!-- .row -->         
</div>
<!-- .container-fluid -->
<?php html::part('countdown'); ?>
