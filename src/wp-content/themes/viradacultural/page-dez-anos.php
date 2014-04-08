<?php
/*
Template Name: 10 anos
*/
?>

<?php get_header(); ?>
<div class="container-fluid">
    <div class="row">
        <section id="main-section" class="col-md-10 col-md-offset-2 virada-10-anos">
            <?php if ( have_posts()) : while ( have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix');?>>
                    <!-- <header>
                        <h1><?php the_title();?></h1>
                        <p><?php edit_post_link( __( 'Edit', 'viradacultural' ), '', '' ); ?></p>
                    </header>
                    <div class="post-content clearfix">
                        <?php the_content(); ?>
                        <?php wp_link_pages( array( 'before' => '<nav class="page-link">' . __( 'Pages:', 'viradacultural' ), 'after' => '</nav>' ) ); ?>    
                    </div>
                    <div class="background-image">
                        <?php if ( has_post_thumbnail() ) the_post_thumbnail(); ?>
                    </div> -->
                    <!-- .post-content -->
                    
                    <?php
                        $children = new WP_Query( array( 'post_parent' => $post->ID, 'post_type' => 'page', 'orderby' => 'menu_order', 'order' => 'ASC', 'nopaging' => true));
                        if( $children->have_posts() ) : while( $children->have_posts() ) : $children->the_post();
                    ?>
                        <article class="row children">
                            <header>
                                <h1><?php the_title(); ?></h1>
                            </header>
                            <figure>
                                <?php the_post_thumbnail("full", array("class" => "background-image")); ?>
                            </figure>
                            <section>
                                <?php the_content(); ?>
                            </section>
                            <button class="btn btn-large btn-success">Baixar programação</button>
                        </article>
                    
                    <?php endwhile; endif; ?>
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
<?php // html::part('countdown'); ?>
