<!-- .container-fluid -->

<?php get_header(); ?>
<div ng-controller="espaco">
    <nav id="programacao-navbar" class="navbar navbar-fixed-top">
        <div class="container-fluid" >
            <div class="col-md-8 col-md-offset-2">
                <?php if (get_query_var('minhavirada')): ?>
                    <h1>Minha virada <span class="icon arrow_carrot-2right"></span> '<?php echo $object; ?>'</h1>
                <?php else: ?>
                    <h1>Programação <span class="icon arrow_carrot-2right"></span> '{{space.name}}'</h1>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <section id="main-section" class="col-md-8 col-md-offset-2">
                <article id="space-00" class="space-single">
                    <header>
                        <h1>{{space.name}}</h1>
                    </header>
                    <img class="center-block" src="{{conf.templateURL}}/img/virada-icon-2x.png">
                    <div class="timeline clearfix">
                        <div class="event-group" ng-repeat="event in spaceEvents">
                            <div class="event-time">{{event.startsAt}}</div>
                            <article class="event event-grid clearfix">
                                <img src="{{conf.baseURL}}/wp-content/uploads/2014/04/Virada-Cultural-2013_pequeno_cidadão-foto_sylvia_masini-17-320x210.jpg"/>
                                <div class="event-content clearfix">
                                    <h1><a href="{{eventUrl(event.id)}}">{{event.name}}</a></h1>
                                    <footer class="clearfix">
                                        <span class="alignleft"><span class="icon icon_clock"></span> <time>{{event.startsAt}}</time></span>
                                        <a class="alignright icon icon_star" href="#"></a>
                                    </footer>
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
</div>
<?php html::part('countdown'); ?>
