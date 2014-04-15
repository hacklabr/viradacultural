<!-- .container-fluid -->

<?php get_header(); ?>
<div ng-controller="minha-virada" class="js-page-minha-virada">
    <div class="container-fluid container-menu-large">
        <section id="main-section" class="row">

                <article id="user-timeline" class="space-single">
                    <header>
                        <h1>{{user_name}}</h1>
                    </header>
                    <img class="center-block" ng-src="{{conf.templateURL}}/img/virada-icon-2x.png">

                    
                    <img src="{{user_picture}}" />

                    <div class="timeline clearfix">
                        <div class="event-group" id="event-group-{{event.id}}" ng-repeat="event in userEvents">
                            <div class="timeline-time">{{event.startsAt}}</div>
                            <article class="event clearfix event-grid">
                                <img ng-src="{{conf.baseURL}}/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg"/>
                                <div class="event-content clearfix">
                                    <h1><a href="{{eventUrl(event.id)}}">{{event.name}}</a></h1>
                                    <a class="icon favorite favorite-event-{{event.id}}" ng-click="favorite(event.id)" ng-if="itsme"><!--qdo selecionado adicionar classe 'active'--></a>
                                </div>
                            </article>
                        </div>
                    </div>
                    <!-- .timeline -->
                </article>

                <?php query_posts('pagename=minha-virada'); ?>

                <?php if ( have_posts()) : while ( have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix');?>  ng-if="(!hasEvents && connected && itsme) || home ">
                        <header>
                            <h1><?php the_title();?></h1>
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
