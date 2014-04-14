<!-- .container-fluid -->

<?php

$object = get_query_var('virada_object');

if ($object) {
    $userinfo = minhaVirada::loadJSON($object);
}

?>

<?php get_header(); ?>
<div ng-controller="espaco">
    <div class="container-fluid container-menu-large">
        <section id="main-section" class="row">

            <?php if (isset($userinfo->events) && is_array($userinfo->events) && sizeof($userinfo->events) > 0): ?>

                <article id="space-00" class="space-single">
                    <header>
                        <h1><?php echo isset($userinfo->name) ? $userinfo->name : 'Minha Virada'; ?></h1>
                    </header>
                    <img class="center-block" ng-src="{{conf.templateURL}}/img/virada-icon-2x.png">

                    <?php if (isset($userinfo->picture)): ?>
                        <img src="<?php echo $userinfo->picture; ?> " />
                    <?php endif; ?>

                    <?php var_dump($userinfo->events); ?>

                    <div class="timeline clearfix">
                        <div class="event-group" ng-repeat="event in spaceEvents">
                            <div class="timeline-time">{{event.startsAt}}</div>
                            <article class="event clearfix event-grid">
                                <img ng-src="{{conf.baseURL}}/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg"/>
                                <div class="event-content clearfix">
                                    <h1><a href="{{eventUrl(event.id)}}">{{event.name}}</a></h1>
                                    <a class="icon favorite favorite-event-{{event.id}}" href="#" ng-click="favorite(event.id)"><!--qdo selecionado adicionar classe 'active'--></a>
                                </div>
                            </article>
                        </div>
                    </div>
                    <!-- .timeline -->
                </article>

            <?php else: // usuario nao logado ou usuario q ainda não tem nenhum evento ?>

                <?php query_posts('pagename=minha-virada'); ?>

                <?php if ( have_posts()) : while ( have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix');?>>
                        <header>
                            <h1><?php the_title();?></h1>
                            <p><?php edit_post_link( __( 'Edit', 'viradacultural' ), '', '' ); ?></p>
                        </header>
                        <img class="center-block" ng-src="{{conf.templateURL}}/img/virada-icon-2x.png">

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

            <?php endif; ?>

        </section>
        <!-- #main-section -->
        <?php get_footer(); ?>
    </div>
    <!-- .container-fluid -->
</div>
<?php html::part('countdown'); ?>
