<?php get_header(); ?>

<!-- friendsModal -->
<div class="modal fade" id="friendsModal" tabindex="-1" role="dialog" aria-labelledby="friendsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">xxx amigos também marcaram essa atração</h4>
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

<div class="container-fluid container-menu-large" ng-controller='evento'>
    <section id='programacao-loading'></section>
    <section id="main-section" class="row">
        <img class="img-destacada-single-atracao" ng-src="{{event.defaultImage}}" alt="{{event.name}}" ng-if='event.defaultImage'/>
        <article id="event-00" class="event-single col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
            <header>
                <h1>{{event.name}}</h1>
                <h3 ng-if="event.subTitle">{{event.subTitle}}</h3>
            </header>
            <div class="post-content clearfix">
                <div class="post-type-icon">
                    <?php html::image('virada-icon-1x.png') ?>
                </div>
                <p>{{event.shortDescription}}</p>
            </div>
            <div class="post-content clearfix">
                <p>{{event.description}}</p>
            </div>
            <footer>
                <div class="friends-group">
                    XXX amigos marcaram esta atração.
                    <a href="#" class="friend" data-toggle="tooltip" data-placement="bottom" title="Nome do amigo"><!--img com link pra minha virada respectiva --></a>
                    <a href="#" class="friend" data-toggle="tooltip" data-placement="bottom" title="Nome do amigo"><!--img com link pra minha virada respectiva --></a>
                    <a href="#" class="friend" data-toggle="tooltip" data-placement="bottom" title="Nome do amigo"><!--img com link pra minha virada respectiva --></a>
                    <a href="#" class="friend" data-toggle="modal" data-target="#friendsModal"><div data-toggle="tooltip" data-placement="bottom" title="Nome dos amigos">+000</div></a><!-- link pra modal com lista de todos amigos quando exceder 3 amigos-->
                </div>
            </footer>
            <!-- .post-content -->
            <div class="servico">
                <p>
                    <span><span>Local:</span> <a href="{{space.url}}">{{space.name}}</a><br></span>
                    <span><span>Endereço:</span> {{space.endereco}}<br></span>
                    <span><span>Data:</span> {{brDate(event.startsOn)}}<br></span>
                    <span><span>Horário:</span> {{event.startsAt}}<br></span>
                    <span ng-if='event.terms.linguagem.length > 0'><span>Linguagem:</span> {{event.terms.linguagem.join(', ')}} <br></span>
                    <span ng-if='event.classificacaoEtaria'><span>Classificação:</span> {{event.classificacaoEtaria}}<br></span>
                    <span ng-if='event.acessibilidade.length > 0'><span>Acessibilidade:</span> {{event.acessibilidade.join(', ')}}<br></span>
                    <span ng-if="event.price"><span>Ingresso:</span> {{event.price}}<br></span>
                    <span ng-if="event.project.id != 632"><span>Projeto:</span> <a href="{{event.project.singleUrl}}">{{event.project.name}}</a><br></span>
                </p>
                <div class="hidden">URL : {{mapUrl}}</div>

                <!-- src="{{mapUrl}}" -->
                <iframe class="hidden-sm hidden-xs" width="100%" height="220" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
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
<?php html::part('countdown'); ?>
