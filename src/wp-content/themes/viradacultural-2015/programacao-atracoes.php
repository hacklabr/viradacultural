<?php get_header(); ?>
<nav id="programacao-navbar" class="navbar navbar-fixed-top">
    <div class="container-fluid">
        <div class="col-md-offset-1">
            <h1>Programação - Atrações</h1>
            <div id="view-btn-group" class="btn-group">
                <button id="grid-view" type="button" class="btn btn-secondary active"><span class="icon icon_grid-2x2"></span></button>
                <button id="list-view" type="button" class="btn btn-secondary"><span class="icon icon_menu-square_alt"></span></button>
            </div>
            <form id="programacao-search" class="programacao-navbar-item" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Digite uma palavra-chave" ng-model='searchText' ng-change='unaccentSearchText = unaccent(searchText)'>
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="button"><span class="icon icon_search"></span></button>
                    </span>
                </div>
            </form>
            <form class="clearfix programacao-navbar-item" role="time-filter">
                <div class="input-group bootstrap-timepicker">
                    <input id="timepicker-start" type="text" class="form-control timepicker-field" data-minute-step="5" data-show-meridian="false">
                    <span class="input-group-addon"><span class="icon icon_clock"></span></span>
                </div>
                <span class="navbar-left navbar-text"> às </span>
                <div class="input-group bootstrap-timepicker">
                    <input id="timepicker-end" type="text" class="form-control timepicker-field" data-minute-step="5" data-show-meridian="false">
                    <span class="input-group-addon"><span class="icon icon_clock"></span></span>
                </div>
            </form>
            <?php
                $pdf = get_theme_option('pdf-programacao');
                if ($pdf):
            ?>
                <div class="programacao-navbar-item">
                    <a href="<?php echo $pdf; ?>" role="button" class="btn btn-primary"><span class="icon icon_download"></span> Baixar PDF</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <section id="main-section" class="panel-group col-md-11 col-md-offset-1">           
            <article class="event event-grid clearfix">
                <img src="../../wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg"/>
                <div class="event-content clearfix">
                    <h1><a href="<?php bloginfo( 'url' ); ?>/programacao/atracoes/slug-da-atracao">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
                    <footer class="clearfix">
                        <span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
                        <a class="alignright icon icon_star" href="#"></a>
                    </footer>
                </div>
            </article>
        </section>
        <!-- #main-section -->
        <?php get_footer(); ?>
    </div>
    <!-- .row -->
</div>
<!-- .container-fluid -->

