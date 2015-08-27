<?php

function get_theme_default_options() {

    // Coloquei aqui o nome e o valor padrão de cada opção que você criar

    return array(
        'social_networks' => array(
            'facebook' => 'http://facebook.com/viradacultura',
            'twitter' => 'http://twitter.com/viradacultural',
            'googleplus' => 'http://googleplus.com/viradacultural',
            'youtube' => 'https://www.youtube.com/channel/UC3YGHwBrBVurwJ7bbwWAS2A',
            'flickr' => 'https://www.flickr.com/photos/viradacultural2014',
            'instagram' => 'https://instagram.com/smculturasp/',
        ),
        'hashtag' => 'viradacultural',
        'programacao_published' => false
    );
}

function theme_options_menu() {

    // Por padrão criamos uma página exclusiva para as opções desse site
    // Mas se quiser você pode colocar ela embaixo de aparencia, opções, ou o q vc quiser. O modelo para todos os casos estão comentados abaixo

    $topLevelMenuLabel = 'viradacultural';
    $page_title = 'Opções';
    $menu_title = 'Opções';

    /* Top level menu */
    add_submenu_page('theme_options', $page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    add_menu_page($topLevelMenuLabel, $topLevelMenuLabel, 'manage_options', 'theme_options', 'theme_options_page_callback_function');

    /* Menu embaixo de um menu existente */
    //add_dashboard_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_posts_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_plugin_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_media_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_links_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_pages_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_comments_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_plugins_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_users_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_management_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_options_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_theme_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
}

function theme_options_validate_callback_function($input) {

    // Se necessário, faça aqui alguma validação ao salvar seu formulário
    return $input;
}

function theme_options_page_callback_function() {

    // Crie o formulário. Abaixo você vai ver exemplos de campos de texto, textarea e checkbox. Crie quantos você quiser
    ?>
    <div>
        <h2><?php echo __('Theme Options', 'viradacultural'); ?></h2>

        <form action="options.php" method="post" class="clear prepend-top">
    <?php settings_fields('theme_options_options'); ?>
    <?php $options = wp_parse_args(get_option('theme_options'), get_theme_default_options()); ?>

            <div>
                <h3> Transparência </h3>
                <p>
                    <label for="transparencia_url"><strong>Url da página de transparência <em>(deixe em branco para não exibir o botão)</em></strong></label><br/>
                    <input type="text" id="transparencia_url" class="text" name="theme_options[transparencia_url]" value="<?php echo htmlspecialchars($options['transparencia_url']) ?>"  style="width: 80%"/>
                </p>
                
                <h3>Programação</h3>

                <p>Se isto estiver marcado, qualquer visitante poderá ver o site. Caso contrário, apenas usuários conectados poderão vê-la.</p>

                <input type="checkbox" id="programacao_published" class="text" name="theme_options[programacao_published]" value="1" <?php checked(true, get_theme_option('programacao_published'), true); ?>/>
                <label for="programacao_published"><strong>Tornar a programação pública</strong></label><br/>

                <h3>PDF da Programação</h3>
                <p>Coloque o link (com http) para o arquivo PDF da Programação que estará disponível para download a partir da página da Programação</p>
                <p>Para fazer upload de um arquivo, visite a seção <a href="<?php echo admin_url('media-new.php'); ?>">Mídia</a> aqui no admin.</p>
                <div>

                    <label for="pdf-programacao"><strong>Link para PDF da programação</strong></label><br/>
                    <input type="text" id="pdf-programacao" class="text" name="theme_options[pdf-programacao]" value="<?php echo htmlspecialchars($options['pdf-programacao']); ?>" style="width: 80%"/>


                </div>

                <h3>Redes Sociais</h3>
                <p>Insira os links (com http) para as páginas da Virada nas Redes Sociais</p>
                <div>


                    <label for="facebook"><strong><?php _e("Facebook", "viradacultural"); ?></strong></label><br/>
                    <input type="text" id="facebook" class="text" name="theme_options[social_networks][facebook]" value="<?php echo htmlspecialchars($options['social_networks']['facebook']); ?>" style="width: 80%"/>
                    <br/><br/>
                    <label for="twitter"><strong><?php _e("Twitter", "viradacultural"); ?></strong></label><br/>
                    <input type="text" id="twitter" class="text" name="theme_options[social_networks][twitter]" value="<?php echo htmlspecialchars($options['social_networks']['twitter']); ?>" style="width: 80%"/>
                    <br/><br/>
                    <label for="googleplus"><strong><?php _e("Google +", "viradacultural"); ?></strong></label><br/>
                    <input type="text" id="googleplus" class="text" name="theme_options[social_networks][googleplus]" value="<?php echo htmlspecialchars($options['social_networks']['googleplus']); ?>" style="width: 80%"/>
                    <br/><br/>
                    <label for="youtube"><strong><?php _e("Youtube", "viradacultural"); ?></strong></label><br/>
                    <input type="text" id="youtube" class="text" name="theme_options[social_networks][youtube]" value="<?php echo htmlspecialchars($options['social_networks']['youtube']); ?>" style="width: 80%"/>
                    <br/><br/>
                    <label for="flickr"><strong><?php _e("Flickr", "viradacultural"); ?></strong></label><br/>
                    <input type="text" id="flickr" class="text" name="theme_options[social_networks][flickr]" value="<?php echo htmlspecialchars($options['social_networks']['flickr']); ?>" style="width: 80%"/>
                    <br/><br/>
                    <label for="instagram"><strong><?php _e("Instagram", "viradacultural"); ?></strong></label><br/>
                    <input type="text" id="instagram" class="text" name="theme_options[social_networks][instagram]" value="<?php echo htmlspecialchars($options['social_networks']['instagram']); ?>" style="width: 80%"/>
                    <br/><br/>

                </div>

                <h3>Hashtag</h3>
                <p>Hashtag que será agreagada do twitter e instagram na página "Nas Redes"</p>
                <div class="span-6 last">


                    <label for="hashtag"><strong>#</strong></label><br/>
                    <input type="text" id="hashtag" class="text" name="theme_options[hashtag]" value="<?php echo htmlspecialchars($options['hashtag']); ?>" style="width: 80%"/>


                </div>



            </div>

            <p>
                <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'viradacultural'); ?>" />
            </p>
        </form>
    </div>

<?php }

function get_theme_option($option_name) {
    $option = wp_parse_args(
            get_option('theme_options'), get_theme_default_options()
    );
    return isset($option[$option_name]) ? $option[$option_name] : false;
}

add_action('admin_init', 'theme_options_init');
add_action('admin_menu', 'theme_options_menu');

function theme_options_init() {
    register_setting('theme_options_options', 'theme_options', 'theme_options_validate_callback_function');
}
