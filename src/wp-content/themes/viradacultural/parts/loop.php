<?php 
$has_thumb = has_post_thumbnail(); 
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix grid-post' . ( $has_thumb ? ' has-thumbnail' : '' ));?>>
	<?php if ( $has_thumb ) { the_post_thumbnail('thumbnail'); } ?>	 
	<div class="post-content">
		<? print apply_filters( 'taxonomy-images-list-the-terms', '', array(
	    'after'        => '</div>',
	    'after_image'  => '',
	    'before'       => '<div class="category-icon">',
	    'before_image' => '',
	    ) );?>
		<header>
			<p>
				<!--<a class="comments-number" href="<?php comments_link(); ?>"title="comentários"><?php comments_number('0','1','%');?></a>
				<?php _e('By', 'viradacultural'); ?> <?php the_author_posts_link(); ?> <?php _e('on', 'viradacultural'); ?>-->
				<time class="post-time" datetime="<?php the_time('Y-m-d'); ?>" pubdate><?php the_time( 'd-m-Y' ); ?></time>
				<?php edit_post_link( __( 'Edit', 'viradacultural' ), '| ', '' ); ?>
			</p>
			<h1><a href="<?php the_permalink();?>" title="<?php the_title_attribute();?>"><?php the_title();?></a></h1>
		</header>
		<div class="post-entry clearfix">			
			<?php the_excerpt(); ?>
		</div>
		<!--<footer class="clearfix">	
			<p class="taxonomies">			
				<span><?php _e('Categories', 'viradacultural'); ?>:</span> <?php the_category(', ');?><br />
				<?php the_tags('<span>Tags:</span> ', ', '); ?>
			</p>		
		</footer> -->
	</div>
</article>
<!-- .post -->
    			
