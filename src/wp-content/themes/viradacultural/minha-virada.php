<!-- .container-fluid -->

<?php get_header(); ?>
<div ng-controller="minha-virada" class="js-page-minha-virada">
    <div class="container-fluid container-menu-large">
        <section id="main-section" class="row">
                <section id='programacao-loading'></section>
                <article id="user-timeline" class="space-single">
                    <header>
                        <h1>{{user_name}}</h1>
                    </header>

                    <div class="user-photo" style="{{user_picture}}"></div>

                    <div class="timeline clearfix">
                        <div class="event-group" id="event-group-{{event.id}}" ng-repeat="event in userEvents">
                            <div class="timeline-time" ng-if="event.duration === '24h00'">24 horas</div>
                            <div class="timeline-time" ng-if="event.duration !== '24h00'">{{event.startsAt}}</div>
                            <article class="event clearfix event-grid" ng-class="{'no-thumb' : !event.defaultImageThumb, 'evento-24h': event.duration === '24h00'}">
                                <img ng-src="{{event.defaultImageThumb}}"/>
                                <a href="{{event.url}}">
                                    <div class="event-content clearfix">
                                        <h1>{{event.name}}</h1>
                                    </div>
                                </a>
                                <a class="icon favorite favorite-event-{{event.id}}" ng-click="favorite(event.id)" ng-if="itsme"><!--qdo selecionado adicionar classe 'active'--></a>
                            </article>
                        </div>
                    </div>
                    <!-- .timeline -->
                </article>

                <?php query_posts('pagename=minha-virada'); ?>

                <?php if ( have_posts()) : while ( have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" ng-if="(!hasEvents && connected && itsme) || home " <?php post_class('clearfix col-md-8 col-md-offset-2');?>>
                        <header>

                            <p><?php edit_post_link( __( 'Edit', 'viradacultural' ), '', '' ); ?></p>
                        </header>

                        <div class="post-content clearfix">
                            <?php the_content(); ?>
                        </div>
                        <!-- .post-content -->
                    </article>
                    <!-- .page -->
                <?php endwhile; ?>
                <?php endif; ?>



        </section>
        <!-- #main-section -->
        <?php get_footer(); ?>
    </div>
    <!-- .container-fluid -->
</div>
<?php html::part('countdown'); ?>
