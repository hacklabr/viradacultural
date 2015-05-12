<?php 
$has_thumb = has_post_thumbnail(); 
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix grid-post col-lg-3 col-md-6 col-sm-4 col-xs-12 left right js-adjust-height' . ( $has_thumb ? ' has-thumbnail' : '' ));?>>
	<?php if ( $has_thumb ) :?>
		<div class="post-img"><div class="post-img-cover visible-lg"></div><?php the_post_thumbnail('thumbnail'); ?></div>
	<?php endif;?> 
	<div class="post-content">
		<?php virada_the_post_type_icon();?>
		<header>			
			<p>
				<!--<a class="comments-number" href="<?php comments_link(); ?>"title="comentários"><?php comments_number('0','1','%');?></a>
				<?php _e('By', 'viradacultural'); ?> <?php the_author_posts_link(); ?> <?php _e('on', 'viradacultural'); ?>-->
				<time class="post-time" datetime="<?php the_time('Y-m-d'); ?>" pubdate><?php the_time( 'd-m-Y' ); ?></time>
				<?php edit_post_link( __( 'Edit', 'viradacultural' ), '| ', '' ); ?>
			</p>
			<h1><a href="<?php the_permalink();?>" title="<?php the_title_attribute();?>"><?php the_title();?></a></h1>
		</header>
		<?php the_excerpt(); ?>
	</div>
</article>
<!-- .post -->
    			
