<?php
add_action('admin_menu', function (){
    $topLevelMenuLabel = 'Ordem dos Espaços';
    $page_title = 'Ordem dos Espaços';
    $menu_title = 'Ordem dos Espaços';

    $cb = function(){ render_virada_page_order_page(); };

    /* Top level menu */
    add_submenu_page('virada_space_order', $page_title, $menu_title, 'manage_options', 'virada_space_order', $cb);

    add_menu_page($topLevelMenuLabel, $topLevelMenuLabel, 'manage_options', 'virada_space_order', $cb);

    wp_enqueue_script('jquery-ui-sortable');
});


function render_virada_page_order_page(){
    $path = realpath(ABSPATH . '../jsons') . '/';
    $filename =  $path . 'spaces-order.json';

    $spaces = json_decode(file_get_contents($path . 'spaces.json'));

    $mensagem = "";
    if($_POST){
        $json = json_encode(array_values($_POST['order']));
        file_put_contents($filename, $json);
        $mensagem = "Ordem Salva";
    }


    if(file_exists($filename)){
        $order = json_decode(file_get_contents($filename));
    }else{
        $order = array();
    }

    foreach($spaces as $i => $space)
        foreach($order as $o)
            if($space->id == $o->id)
                unset($spaces[$i]);


    foreach($spaces as $space){
        $obj = new stdClass;
        $obj->id = $space->id;
        $obj->name = $space->name;
        $order[] = $obj;
    }

    ?>
<style>
    .button-primary { position:fixed; top:75px; right:50px; }
    .js-sortable-item { cursor: move; }
</style>
<script type="text/javascript">
    (function($){
        $(function(){
            $('.js-sortable-container').sortable();
        });
    })(jQuery);
</script>
    <div class="wrap span-20">
        <h2>Ordem dos Espaços</h2>
        <?php if($mensagem): ?>
            <div class="updated below-h2">
                <p><?php echo $mensagem; ?></p>
            </div>
        <?php endif; ?>
        <form method="post">
            <input type="submit" class="button-primary" style="" value="Salvar Ordem" />
            <ul class="js-sortable-container">
              <?php foreach($order as $i => $sp): ?>
                <li class="js-sortable-item" >
                    <input type="hidden" name="order[<?php echo $i ?>][id]" value='<?php echo $sp->id; ?>' />
                    <input type="hidden" name="order[<?php echo $i ?>][name]" value='<?php echo $sp->name; ?>' />
                    <?php echo $sp->name; ?>
                </li>
              <?php endforeach; ?>
            </ul>
        </form>
    </div>

<?php }