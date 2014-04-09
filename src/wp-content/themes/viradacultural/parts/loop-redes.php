<?php 
$has_thumb = has_post_thumbnail(); 
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix grid-post' . ( get_post_type() == 'instagram_cpt' ? ' has-thumbnail' : '' ));?>>
	<?php the_content(); ?>
	
	<div class="post-content">
		<?php virada_the_post_type_icon();?>
		<header>
			<p>
				Publicado em <time class="post-time" datetime="<?php the_time('Y-m-d'); ?>" pubdate><?php the_time( 'j \d\e F à\s H:i' ); ?></time> por
				<a href="<?php echo get_post_type() == 'twitter_cpt' ? 'http://twitter.com/' : 'http://instagram.com/', get_post_meta(get_the_ID(), 'author_username', true); ?>"><?php echo get_post_meta(get_the_ID(), 'author_username', true); ?></a>
				
			</p>
			<h1></h1>
		</header>
		<div class="post-entry clearfix">			
			
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
    			
