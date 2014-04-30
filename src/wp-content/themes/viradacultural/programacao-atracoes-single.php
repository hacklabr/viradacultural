<?php get_header(); ?>
<div class="container-fluid container-menu-large" ng-controller='evento'>
    <section id="main-section" class="row">
        <img class="img-destacada-single-atracao" ng-src="{{event.defaultImage}}" alt="{{event.name}}"/>
        <article id="event-00" class="event-single col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
            <header>
                <h1>{{event.name}}</h1>
            </header>
            <div class="post-content clearfix">
                <p>{{event.shortDescription}}</p>
            </div>
            <div class="post-content clearfix">
                <p>{{event.description}}</p>
            </div>
            <!-- .post-content -->
            <div class="servico">
                <p>
                    <span><span>Local:</span> <a href="{{space.url}}">{{space.name}}</a><br></span>
                    <span><span>Endereço:</span> {{space.endereco}}<br></span>
                    <span><span>Data:</span> {{brDate(event.startsOn)}}<br></span>
                    <span><span>Horário:</span> {{event.startsAt}}<br></span>
                    <span><span>Linguagem:</span> {{event.terms.linguagem.join(', ')}} <br></span>
                    <span><span>Classificação:</span> {{event.classificacaoEtaria}}<br></span>
                    <span><span>Acessibilidade:</span> {{event.acessibilidade}}<br></span>
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
