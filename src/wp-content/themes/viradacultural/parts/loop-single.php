<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix col-md-10 col-md-offset-1');?>>
	<header>
		<h1><?php the_title();?></h1>
		<p>
			
			<time class="post-time" datetime="<?php the_time('Y-m-d'); ?>" pubdate><?php the_time( 'd-m-Y' ); ?></time>
			<?php edit_post_link( __( 'Edit', 'viradacultural' ), '| ', '' ); ?>
		</p>
	</header>
	<div class="post-content clearfix">
		<?php virada_the_post_type_icon();?>
		<?php the_content(); ?>
		<?php do_action('virada-single-after-content', get_the_ID()); ?>
		<?php wp_link_pages( array( 'before' => '<nav class="page-link">' . __( 'Pages:', 'viradacultural' ), 'after' => '</nav>' ) ); ?>
	</div>
	<!-- .post-content -->
	<footer class="clearfix">
		<?php if ('noticias' == get_post_type() || 'imprensa' == get_post_type()) { ?>
			<p>Comunicação - Virada Cultural</p>
		<?php } else { ?>
			<div id="author-info" class="clearfix">
				<?php the_author_posts_link(); ?>
				<div>
					<div class="author-photo">
						<?php echo get_avatar($post->post_author, '60');?>
					</div>
						<p>
						<?php the_author_meta('description');?></p>
				</div>
			</div>
		<?php } ?>
	</footer>
	<?php //comments_template(); ?>
	<?php if ('post' == get_post_type()): ?>
		<div class="comments">
		<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-numposts="5" data-colorscheme="light"></div>
		</div>
	<?php endif; ?>
	<!-- comentários -->
</article>
<!-- .post -->

