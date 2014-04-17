<?php
$atracao = get_query_var('virada_object');
?>
<?php get_header(); ?>
<div class="container-fluid container-menu-large" ng-controller='evento'>
    <section id="main-section" class="row">
        <img ng-src="{{conf.baseURL}}/wp-content/uploads/2014/04/Virada-Cultural-2013_pequeno_cidadão-foto_sylvia_masini-17.jpg" alt="{{event.name}}"/>
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
                <a target="_blank" href="http://maps.google.com/maps?q=teatro municipal de sao paulo, Praça Ramos de Azevedo, s/n, São Paulo&hl=pt-BR&ll=-23.5451833,-46.6397523&z=17z">
                    <button class="btn btn-primary btn-xs"><span class="icon icon_pin"></span> Ver no mapa</button>
                </a>
                <br><br>
                <iframe width="100%" height="220" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?hl=pt-BR&amp;geocode=&amp;q=Teatro Municipal, Praça Ramos de Azevedo, s/n - Republica São Paulo - SP 01037-010, Brasil&amp;sll=-23.545235,-46.638615&amp;ie=UTF8&amp;hq=Teatro Municipal, Praça Ramos de Azevedo, s/n - Republica São Paulo - SP 01037-010, Brasil&amp;hnear=&amp;radius=15000&amp;t=m&amp;ll=-23.545235,-46.638615&amp;z=17&amp;output=embed&amp;iwloc=near&amp;language=pt-BR&amp;region=br"></iframe>
            </div>
        </article>
        <!-- .event-single -->
    </section>
    <!-- #main-section -->
    <?php get_footer(); ?>
</div>
<!-- .container-fluid -->
<?php html::part('countdown'); ?>