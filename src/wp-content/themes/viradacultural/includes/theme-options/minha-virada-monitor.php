<?php


function minha_virada_menu() {

    // Por padrão criamos uma página exclusiva para as opções desse site
    // Mas se quiser você pode colocar ela embaixo de aparencia, opções, ou o q vc quiser. O modelo para todos os casos estão comentados abaixo

    $topLevelMenuLabel = 'Minhas Viradas';
    $page_title = 'Minhas Viradas';
    $menu_title = 'Minhas Viradas';

    /* Top level menu */
    add_submenu_page('minha_virada', $page_title, $menu_title, 'manage_options', 'minha_virada', 'minha_virada_page_callback_function');
    add_menu_page($topLevelMenuLabel, $topLevelMenuLabel, 'manage_options', 'minha_virada', 'minha_virada_page_callback_function');

    /* Menu embaixo de um menu existente */
    //add_dashboard_page($page_title, $menu_title, 'manage_options', 'minha_virada', 'minha_virada_page_callback_function');
    //add_posts_page($page_title, $menu_title, 'manage_options', 'minha_virada', 'minha_virada_page_callback_function');
    //add_plugin_page($page_title, $menu_title, 'manage_options', 'minha_virada', 'minha_virada_page_callback_function');
    //add_media_page($page_title, $menu_title, 'manage_options', 'minha_virada', 'minha_virada_page_callback_function');
    //add_links_page($page_title, $menu_title, 'manage_options', 'minha_virada', 'minha_virada_page_callback_function');
    //add_pages_page($page_title, $menu_title, 'manage_options', 'minha_virada', 'minha_virada_page_callback_function');
    //add_comments_page($page_title, $menu_title, 'manage_options', 'minha_virada', 'minha_virada_page_callback_function');
    //add_plugins_page($page_title, $menu_title, 'manage_options', 'minha_virada', 'minha_virada_page_callback_function');
    //add_users_page($page_title, $menu_title, 'manage_options', 'minha_virada', 'minha_virada_page_callback_function');
    //add_management_page($page_title, $menu_title, 'manage_options', 'minha_virada', 'minha_virada_page_callback_function');
    //add_options_page($page_title, $menu_title, 'manage_options', 'minha_virada', 'minha_virada_page_callback_function');
    //add_theme_page($page_title, $menu_title, 'manage_options', 'minha_virada', 'minha_virada_page_callback_function');
}


function minha_virada_page_callback_function() {

    // Crie o formulário. Abaixo você vai ver exemplos de campos de texto, textarea e checkbox. Crie quantos você quiser
    include(TEMPLATEPATH . '/includes/extra-db-config.php');
    $minhasViradas = new wpdb($db_config['minha_virada']['user'],
        $db_config['minha_virada']['pass'],
        $db_config['minha_virada']['name'], 
        $db_config['minha_virada']['host'] );
    
    $total = $minhasViradas->get_var("SELECT COUNT(user_id) FROM users");   
    
    
    if (isset($_GET['show']) && $_GET['show'] == 'all')
        $viradas = $minhasViradas->get_results("SELECT * FROM users");        
             
    $events = 0;
    ?>
    <div class="wrap span-20">
        <h2>Minhas Viradas</h2>
        <h3>Total de <?php echo $total; ?> pessoas</h3>
        <ul>
        <?php if (isset($_GET['show']) && $_GET['show'] == 'all'): ?>
            <?php foreach ($viradas as $v): $user = json_decode($v->data);  ?>
            
                <li>
                    <a href="<?php echo site_url('minha-virada/##'), $v->user_id; ?>"><?php echo $user->name; ?></a> - 
                    <?php if (isset($user->events) && is_array($user->events) && sizeof($user->events) > 0): ?>
                        
                        <?php foreach ($user->events as $e): $events++;?>
                            
                            <a href="<?php echo site_url('programacao/atracao/##'), $e; ?>"><?php echo $e; ?></a>
                            
                        <?php endforeach; ?>
                        
                    <?php endif; ?>
                </li>
            
            <?php endforeach; ?>
            </ul>
            
            <h3>Total de <?php echo $events; ?> eventos marcados</h3>
        <?php endif; ?>
    </div>

<?php } 

add_action('admin_menu', 'minha_virada_menu');

