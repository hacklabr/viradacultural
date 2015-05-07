<?php
/*
Template Name: Nas redes
*/


add_action('wp_print_scripts', function () {
    wp_enqueue_script('nasredes', get_stylesheet_directory_uri().'/js/nasredes.js','jquery');
});

?>

<?php get_header(); ?>

<?php

    require ('includes/Simple-Database-PHP-Class/Db.php');
    require ('includes/extra-db-config.php');
    
    $db = new Db('mysql',
        $db_config['virada_nas_redes']['host'],
        $db_config['virada_nas_redes']['name'],
        $db_config['virada_nas_redes']['user'],
        $db_config['virada_nas_redes']['pass']
    );


?>

<div class="container-fluid container-menu-large">
	<section id="main-section" class="row">

        <?php
            $items = $db->query('SELECT * FROM items ORDER BY date DESC LIMIT 50', array());
            if($items->count()){
                while ( $item = $items->fetch() ){
                    $dateCreated = date_create($item->date);
                    $item->dateTimeFormatted = date_format($dateCreated, 'd-m-Y - H:i');
                    $item->dateFormatted = date_format($dateCreated, 'Y-m-d');
                    include 'parts/loop-redes.php';
                }
            }else{
                ?><p>Nada encontrado. Publique no twitter ou Instagram com a hashtag #<?php echo get_theme_option('hashtag'); ?></p><?php

            }
        ?>

	</section>
    <button type="button" class="btn btn-default btn-show-more clear col-md-12" id="load-more">Carregar mais</button>
	<!-- #main-section -->
	<?php get_footer(); ?>
</div>
<!-- .container-fluid -->
<?php html::part('countdown'); ?>
