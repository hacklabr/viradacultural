<!-- .container-fluid -->

<?php get_header(); ?>
<div ng-controller="espaco">
    <div class="container-fluid container-menu-large">
        <section id="main-section" class="row">
            <article id="space-00" class="space-single">
                <header>
                    <h1>{{space.name}}</h1>
                </header>
                <img class="center-block" ng-src="{{conf.templateURL}}/img/virada-icon-2x.png">
                <div class="timeline clearfix">
                    <div class="event-group" ng-repeat="event in spaceEvents">
                        <div class="timeline-time">{{event.startsAt}}</div>
                        <article class="event clearfix event-grid">
                                <img ng-src="{{conf.baseURL}}/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg"/>
                                <div class="event-content clearfix">
                                    <h1><a href="{{eventUrl(event.id)}}">{{event.name}}</a></h1>
                                    <a class="icon favorite favorite-event-{{event.id}}" ng-click="favorite(event.id)"><!--qdo selecionado adicionar classe 'active'--></a>
                                </div>
                            </article>
                    </div>
                </div>
                <!-- .timeline -->
                <div class="servico">
                    <p>
                        <span>Endereço:</span> {{space.endereco}}<br>
                        <span>Telefone:</span> {{space.telefonePublico}}<br>
                        <span>Acessibilidade:</span> {{space.acessibilidade}}<br>
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
</div>
<?php html::part('countdown'); ?>
