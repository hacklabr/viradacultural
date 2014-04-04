<?php 

$object = get_query_var('virada_object'); ?>
<?php get_header(); ?>
<nav id="programacao-navbar" class="navbar navbar-fixed-top">
	SINGLE DE LOCAL OU "MINHA VIRADA"
</nav>
<div class="container-fluid">
    SELECIONADO: 
    <?php if (get_query_var('minhavirada')): ?>
        Minha virada do usuario '<?php echo $object; ?>'
    <?php else: ?>
        Single do espaço '<?php echo $object; ?>'
    <?php endif; ?>
           
</div>
<!-- .container-fluid -->
