<?php
/*
Template Name: Credenciamento de imoprensa
*/
?>

<?php get_header(); ?>

<div class="container-fluid container-menu-large">
    <section id="main-section" class="row">
        <?php if ( have_posts()) : while ( have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix col-md-8 col-md-offset-2');?>>
                <header>
                    <h1><?php the_title();?></h1>
                    <p><?php edit_post_link( __( 'Edit', 'viradacultural' ), '', '' ); ?></p>
                </header>
                <div class="post-content clearfix">
                    <?php the_content(); ?>
                    <iframe class="form-horizontal col-md-12 col-lg-10 col-lg-offset-1" src="https://docs.google.com/forms/d/1VtJ9eQMYScyB2huYh9dzPdqbE_-2XHNML4IfUG1Q_qc/viewform?embedded=true" width="513" height="750" frameborder="0" marginheight="0" marginwidth="0">Loading...</iframe>
                    <!--
                    <form action="#" class="form-horizontal col-md-12 col-lg-10 col-lg-offset-1" role="form">
                        <div class="form-group">
                            <label for="nome" class="col-sm-4 control-label">Nome completo</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nome" placeholder="Nome completo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="rg" class="col-sm-4 control-label">Número do RG</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="rg" placeholder="Número do RG">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="veiculo" class="col-sm-4 control-label">Veículo (nome do jornal, site, etc)</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="veiculo" placeholder="Veículo (nome do jornal, site, etc)">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="telefone" class="col-sm-4 control-label">Telefone de contato</label>
                            <div class="col-sm-8">
                                <input type="tel" class="form-control" id="telefone" placeholder="Telefone de contato">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="celular" class="col-sm-4 control-label">Celular</label>
                            <div class="col-sm-8">
                                <input type="tel" class="form-control" id="celular" placeholder="Celular">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-4 control-label">E-mail</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" id="email" placeholder="E-mail">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-lg btn-primary">Enviar</button>
                            </div>
                        </div>
                    </form>
                    -->
                    <?php wp_link_pages( array( 'before' => '<nav class="page-link">' . __( 'Pages:', 'viradacultural' ), 'after' => '</nav>' ) ); ?>
                </div>
                <!-- .post-content -->
            </article>
            <!-- .page -->
        <?php endwhile; ?>
        <?php else : ?>
           <p><?php _e('No results found.', 'viradacultural'); ?></p>
        <?php endif; ?>
    </section>
    <!-- #main-section -->
    <?php get_footer(); ?>
</div>
<!-- .container-fluid -->
<?php html::part('countdown'); ?>
