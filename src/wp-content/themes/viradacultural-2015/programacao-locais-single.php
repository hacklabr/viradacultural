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

<div ng-controller="espaco">

    <div class="container-fluid container-menu-large">
        <section id='programacao-loading'></section>
        <section id="main-section" class="row">
            <article id="space-00" class="space-single">
                <header>
                    <h1>{{space.name}}</h1>
                </header>
                <img class="center-block" ng-src="{{conf.templateURL}}/img/virada-icon-2x.png">
                <div class="timeline clearfix">
                    <div class="event-group" ng-repeat="event in spaceEvents">
                        <div class="timeline-time" ng-if="event.duration === '24h00'">24 horas</div>
                        <div class="timeline-time" ng-if="event.duration !== '24h00'">{{event.startsAt}}</div>
                        <article class="event clearfix event-grid js-event-{{event.id}}" ng-class="{'no-thumb' : !event.defaultImageThumb, 'evento-24h': event.duration === '24h00'}">
                            <a href="{{event.url}}">
                                <div class="event-content clearfix">
                                    <h1>{{event.name}}</h1>
                                </div>
                                <img ng-src="{{event.defaultImageThumb}}"/>
                            </a>
                            <div class="friends-group js-lista-amigos"> </div>
                            <a class="icon favorite favorite-wait favorite-event-{{event.id}}" ng-click="favorite(event.id)"><!--qdo selecionado adicionar classe 'active'--></a>
                        </article>
                    </div>
                </div>
                <!-- .timeline -->
                <div class="servico col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
                    <p>
                        <span><span>Endereço:</span> {{space.endereco}}<br></span>
                        <span><span>Telefone:</span> {{space.telefonePublico}}<br></span>
                        <span ng-if='space.acessibilidade'><span>Acessibilidade:</span> Sim<br></span>
                    </p>

                    <iframe width="100%" height="220" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                            ng-src="{{getTrustedURI(mapUrl)}}"></iframe>
                    <p class="hidden-md hidden-lg">
                        <a class="btn btn-primary btn-xs" target="_blank" href="{{mapUrl}}">
                            <span class="icon icon_pin"></span> Ver no mapa
                        </a>
                    </p>
                </div>
            </article>
            <!-- .event-single -->
        </section>
        <!-- #main-section -->
        <?php get_footer(); ?>
    </div>
    <!-- .container-fluid -->
</div>
<?php html::part('countdown'); ?>
