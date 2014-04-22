<?php get_header(); ?>
<div class="container-fluid container-menu-large">
	<section id="main-section" class="row">
		<?php if ( have_posts()) : while ( have_posts()) : the_post(); ?>

			<?php html::part('loop', 'single'); ?>

		<?php endwhile; ?>

			<nav id="posts-nav" class="col-md-8 col-md-offset-2 clearfix">
					<?php previous_post_link('%link'); ?>
					<?php next_post_link('%link'); ?>
			</nav>
			<!-- #posts-nav -->

		<?php else : ?>
			<p><?php _e('No results found.', 'viradacultural'); ?></p>
		<?php endif; ?>
	</section>
	<!-- #main-section -->
	<?php get_footer(); ?>
</div>
<!-- .container-fluid -->
<?php html::part('countdown'); ?>

