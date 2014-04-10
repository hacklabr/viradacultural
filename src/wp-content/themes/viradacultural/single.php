<?php get_header(); ?>
<div class="container-fluid">
	<div class="row">
		<section id="main-section" class="col-md-8 col-md-offset-2">
			<?php if ( have_posts()) : while ( have_posts()) : the_post(); ?>

				<?php html::part('loop', 'single'); ?>

			<?php endwhile; ?>

				<nav id="posts-nav" class="clearfix">
					<div class="alignleft">
						<?php previous_post_link('%link', '<span class="icon arrow_triangle-left"></span><span class="label">Post anterior</span>'); ?>
					</div>
					<div class="alignright">
						<?php next_post_link('%link', '<span class="icon arrow_triangle-right"></span><span class="label">Próximo post</span>'); ?>
					</div>
				</nav>
				<!-- #posts-nav -->

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

