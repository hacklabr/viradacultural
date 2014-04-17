<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix col-md-8 col-md-offset-2');?>>
	<header>
		<h1><?php the_title();?></h1>
		<p>
			<?php _e('By', 'viradacultural'); ?> <?php the_author_posts_link(); ?> <?php _e('on', 'viradacultural'); ?>
			<time class="post-time" datetime="<?php the_time('Y-m-d'); ?>" pubdate><?php the_time( get_option('date_format') ); ?></time>
			<?php edit_post_link( __( 'Edit', 'viradacultural' ), '| ', '' ); ?>
		</p>
	</header>
	<div class="post-content clearfix">
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
				<div class="author-photo alignleft">
					<?php echo get_avatar($post->post_author, '56');?>
				</div>
				<div class="alignleft">
					<p><?php the_author_posts_link(); ?><br />
					<?php the_author_meta('description');?></p>
				</div>
			</div>
		<?php } ?>
		<p class="taxonomies">
			<span><?php _e('Categories', 'viradacultural'); ?>:</span> <?php the_category(', ');?><br />
			<?php the_tags('<span>Tags:</span> ', ', '); ?>
		</p>
	</footer>
	<?php //comments_template(); ?>
	<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-numposts="5" data-colorscheme="light"></div>
	<!-- comentários -->
</article>
<!-- .post -->

