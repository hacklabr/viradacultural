<?php
$atracao = get_query_var('virada_object');
?>
<?php get_header(); ?>
<nav id="programacao-navbar" class="navbar navbar-fixed-top">
    <div class="container-fluid" >
        <div class="col-md-8 col-md-offset-2"><h1>Atrações</h1></div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <section id="main-section" class="col-md-8 col-md-offset-2">
            <img src="http://localhost/viradacultural/wp-content/uploads/2014/04/Virada-Cultural-2013_pequeno_cidadão-foto_sylvia_masini-17.jpg" alt="<?php echo $atracao; ?>"/>
            <article id="event-00" class="event-single">
                <header>
                    <h1><?php echo $atracao; ?></h1>
                </header>
                <div class="post-content clearfix">
                    <p>(Descrição longa)</p>
                    <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>

                    <p>Suco de cevadiss, é um leite divinis, qui tem lupuliz, matis, aguis e fermentis. Interagi no mé, cursus quis, vehicula ac nisi. Aenean vel dui dui. Nullam leo erat, aliquet quis tempus a, posuere ut mi. Ut scelerisque neque et turpis posuere pulvinar pellentesque nibh ullamcorper. Pharetra in mattis molestie, volutpat elementum justo. Aenean ut ante turpis. Pellentesque laoreet mé vel lectus scelerisque interdum cursus velit auctor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac mauris lectus, non scelerisque augue. Aenean justo massa.</p>
                </div>
                <!-- .post-content -->
                <div class="servico">
                    <p>
                        <span>Local:</span> <a href="#">Nome do Espaço</a><br>
                        <span>Data:</span> 17/05/2014<br>
                        <span>Horário:</span> 00:00<br>
                        <span>Linguagem:</span> música<br>
                        <span>Classificação:</span> livre<br>
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