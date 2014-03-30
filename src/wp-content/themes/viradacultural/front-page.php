<?php get_header(); ?>
<div class="container-fluid">
	<div class="row">
		<section id="main-section" class="col-md-8 col-md-offset-2">
		<?php $homefeatures = new WP_Query( 'posts_per_page=-1&meta_key=_home&meta_value=1&ignore_sticky_posts=1' ); ?>

			<div id="front-page-carousel" class="carousel slide" data-ride="carousel">
				<?php if ($homefeatures->have_posts()) : ?>
					<!-- Indicators -->
					<ol class="carousel-indicators">
						<li data-target="#front-page-carousel" data-slide-to="0" class="active"></li>
						<li data-target="#front-page-carousel" data-slide-to="1"></li>
					</ol>

					<!-- Wrapper for slides -->
					<div class="carousel-inner">
						<?php while ($homefeatures->have_posts()) : $homefeatures->the_post(); ?>
							<div class="item active">
								<?php if ( has_post_thumbnail() ) : ?> 
									<?php the_post_thumbnail('large', 'true'); ?>				 
								<?php endif; ?>
								<div class="carousel-caption">
									<h1><a href="<?php the_permalink();?>" title="<?php the_title_attribute();?>"><?php the_title();?></a></h1>
								</div>
							</div>
						<?php endwhile; ?>
					</div>

					<!-- Controls -->
					<a class="left carousel-control" href="#front-page-carousel" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
					</a>
					<a class="right carousel-control" href="#front-page-carousel" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span>
					</a>
				<?php else :?>
                    <p>Nenhum destaque encontrado.</p>
				<?php endif; ?> 
			</div>
			<?php wp_reset_postdata(); ?>

			<?php if ( have_posts()) : while ( have_posts()) : the_post(); ?>			
				<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix');?>>	  
					<header>                       
						<h1><a href="<?php the_permalink();?>" title="<?php the_title_attribute();?>"><?php the_title();?></a></h1>
						<p><?php edit_post_link( __( 'Edit', 'viradacultural' ), '', '' ); ?></p>				
					</header>
					<div class="post-content clearfix">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<nav class="page-link">' . __( 'Pages:', 'viradacultural' ), 'after' => '</nav>' ) ); ?>	
					</div>
					<!-- .post-content -->
				</article>
				<!-- .page -->
			<?php endwhile; ?>				
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
