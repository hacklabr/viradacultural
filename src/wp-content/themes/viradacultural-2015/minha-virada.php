<!-- .container-fluid -->

<?php get_header(); ?>

<!-- friendsModal -->
<div class="modal fade" id="friendsModal" tabindex="-1" role="dialog" aria-labelledby="friendsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">xxx amigos também marcaram 'Nome da atração'</h4>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    <!-- link pra página Minha Virada do amigo -->
                    <a href="#" class="list-group-item">
                        <!-- avatar do amigo-->
                        <img class="friend-avatar img-circle" src="" alt="Nome do amigo" />
                        <div class="friend-name">
                            Nome do amigo
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

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
                        <div class="event-group js-event-{{event.id}}" id="event-group-{{event.id}}" ng-repeat="event in userEvents" on-finish-render="minhavirada_finishRender">
                            <div class="timeline-time" ng-if="event.duration === '24h00'">24 horas</div>
                            <div class="timeline-time" ng-if="event.duration !== '24h00'">{{event.startsAt}}</div>
                            <article class="event clearfix event-grid" ng-class="{'no-thumb' : !event.defaultImageThumb, 'evento-24h': event.duration === '24h00'}">
                                <a href="{{event.url}}">
                                    <div class="event-content clearfix">
                                        <h1>{{event.name}}</h1>
                                    </div>
                                    <img ng-src="{{event.defaultImageThumb}}"/>
                                </a>
                                <div class="friends-group js-lista-amigos"></div>
                                <a class="icon favorite favorite-wait favorite-event-{{event.id}}" ng-click="favorite(event.id)"><!--qdo selecionado adicionar classe 'active'--></a>
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
