<?php get_header(); ?>
<div class="container-fluid">
	<div class="row">
		<section id="main-section" class="col-md-8 col-md-offset-2">
			<?php if ( have_posts()) : while ( have_posts()) : the_post(); ?>

				<?php html::part('loop', 'single'); ?>

			<?php endwhile; ?>

				<?php if ( $wp_query->max_num_pages > 1 ) : ?>
					<nav id="posts-nav" class="clearfix">
						<div class="alignleft"><?php previous_post_link('%link', __('&laquo; Previous post', 'viradacultural')); ?></div>
						<div class="alignright"><?php next_post_link('%link', __('Next post &raquo;', 'viradacultural')); ?></div>
					</nav>
					<!-- #posts-nav -->
				<?php endif; ?>

			<?php else : ?>
			   <p><?php _e('No results found.', 'viradacultural'); ?></p>
			<?php endif; ?>
		</section>
		<!-- #main-section -->
		<?php get_footer(); ?>
	</div>
	<!-- .row -->
</div>
<!-- .container-fluid -->
<?php html::part('countdown'); ?>

