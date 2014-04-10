<!-- .container-fluid -->

<?php get_header(); ?>
<nav id="programacao-navbar" class="navbar navbar-fixed-top">
    <div class="container-fluid" >
        <div class="col-md-8 col-md-offset-2">
            <?php if (get_query_var('minhavirada')): ?>
                <h1>Minha virada <span class="icon arrow_carrot-2right"></span> '<?php echo $object; ?>'</h1>
            <?php else: ?>
                <h1>Programação <span class="icon arrow_carrot-2right"></span> '<?php echo $object; ?>'</h1>
            <?php endif; ?>         
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <section id="main-section" class="col-md-8 col-md-offset-2">
            <article id="space-00" class="space-single">
                <header>
                    <h1>Nome do local</h1>
                </header>
                <img class="center-block" src="<?php bloginfo( 'stylesheet_directory' ) ?>/img/virada-icon-2x.png">
                <div class="timeline clearfix">

                    <div class="event-group">
                        <div class="event-time">00:00</div>
                        <article class="event event-grid clearfix">
                            <img src="http://localhost/viradacultural/wp-content/uploads/2014/04/Virada-Cultural-2013_pequeno_cidadão-foto_sylvia_masini-17-320x210.jpg"/>
                            <div class="event-content clearfix">
                                <h1><a href="<?php bloginfo( 'url' ); ?>/programacao/atracoes/slug-da-atracao">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
                                <footer class="clearfix">
                                    <span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
                                    <a class="alignright icon icon_star" href="#"></a>
                                </footer>
                            </div>
                        </article>
                    </div>
                    <div class="event-group">
                        <div class="event-time">00:00</div>
                        <article class="event event-grid clearfix">
                            <img src="http://localhost/viradacultural/wp-content/uploads/2014/04/Virada-Cultural-2013_pequeno_cidadão-foto_sylvia_masini-17-320x210.jpg"/>
                            <div class="event-content clearfix">
                                <h1><a href="<?php bloginfo( 'url' ); ?>/programacao/atracoes/slug-da-atracao">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
                                <footer class="clearfix">
                                    <span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
                                    <a class="alignright icon icon_star" href="#"></a>
                                </footer>
                            </div>
                        </article>
                    </div>
                    <div class="event-group">
                        <div class="event-time">00:00</div>
                        <article class="event event-grid clearfix">
                            <img src="http://localhost/viradacultural/wp-content/uploads/2014/04/Virada-Cultural-2013_pequeno_cidadão-foto_sylvia_masini-17-320x210.jpg"/>
                            <div class="event-content clearfix">
                                <h1><a href="<?php bloginfo( 'url' ); ?>/programacao/atracoes/slug-da-atracao">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
                                <footer class="clearfix">
                                    <span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
                                    <a class="alignright icon icon_star" href="#"></a>
                                </footer>
                            </div>
                        </article>
                    </div>
                    <div class="event-group">
                        <div class="event-time">00:00</div>
                        <article class="event event-grid clearfix">
                            <img src="http://localhost/viradacultural/wp-content/uploads/2014/04/Virada-Cultural-2013_pequeno_cidadão-foto_sylvia_masini-17-320x210.jpg"/>
                            <div class="event-content clearfix">
                                <h1><a href="<?php bloginfo( 'url' ); ?>/programacao/atracoes/slug-da-atracao">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
                                <footer class="clearfix">
                                    <span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
                                    <a class="alignright icon icon_star" href="#"></a>
                                </footer>
                            </div>
                        </article>
                    </div>
                    <div class="event-group">
                        <div class="event-time">00:00</div>
                        <article class="event event-grid clearfix">
                            <img src="http://localhost/viradacultural/wp-content/uploads/2014/04/Virada-Cultural-2013_pequeno_cidadão-foto_sylvia_masini-17-320x210.jpg"/>
                            <div class="event-content clearfix">
                                <h1><a href="<?php bloginfo( 'url' ); ?>/programacao/atracoes/slug-da-atracao">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
                                <footer class="clearfix">
                                    <span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
                                    <a class="alignright icon icon_star" href="#"></a>
                                </footer>
                            </div>
                        </article>
                    </div>
                </div>
                <!-- .timeline -->
                <div class="servico">
                    <p>
                        <span>Endereço:</span> R. dos Bobos, 0<br>
                        <span>Telefone:</span> 0000 0000<br>
                        <span>Acessibilidade:</span> lorem ipsum<br>
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
