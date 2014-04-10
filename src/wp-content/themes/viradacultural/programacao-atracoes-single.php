<?php
$atracao = get_query_var('virada_object');
?>
<?php get_header(); ?> asd
<nav id="programacao-navbar" class="navbar navbar-fixed-top">
    <div class="container-fluid" >
        <div class="col-md-8 col-md-offset-2"><h1>Atrações</h1></div>
    </div>
</nav>
<div class="container-fluid" ng-controller='evento'>
    <div class="row">
        <section id="main-section" class="col-md-8 col-md-offset-2">
            <img src="{{conf.baseURL}}/wp-content/uploads/2014/04/Virada-Cultural-2013_pequeno_cidadão-foto_sylvia_masini-17.jpg" alt="{{event.name}}"/>
            <article id="event-00" class="event-single">
                <header>
                    <h1>{{event.name}}</h1>
                </header>
                <div class="post-content clearfix">
                    {{event.description}}
                </div>
                <!-- .post-content -->
                <div class="servico">
                    <p>
                        <span>Local:</span> <a href="{{spaceUrl(space.id)}}">{{space.name}}</a><br>
                        <span>Endereço:</span> {{space.endereco}}<br>
                        <span>Data:</span> {{brDate(event.startsOn)}}<br>
                        <span>Horário:</span> {{event.startsAt}}<br>
                        <span>Linguagem:</span> @TODO: LINGUAGEM <br>
                        <span>Classificação:</span> {{event.classificacaoEtaria}}<br>
                        <span>Acessibilidade:</span> {{event.acessibilidade}}<br>
                    </p>
                    <button class="btn btn-primary btn-xs"><span class="icon icon_pin"></span> Ver no mapa</button>
                </div>
            </article>
            <!-- .event-single -->
        </section>
        <!-- #main-section -->
        <?php get_footer(); ?>
    </div>
    <!-- .row -->
</div>
<!-- .container-fluid -->
<?php html::part('countdown'); ?>