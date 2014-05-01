<?php

include ('Simple-Database-PHP-Class/Db.php');
include ('extra-db-config.php');

$action = $_REQUEST['action'];

if ($action == 'minhavirada_updateJSON') {

    if( is_array($_POST['dados'])) {
        if (isset($_POST['dados']['events']) && is_array($_POST['dados']['events'])) {
            foreach ($_POST['dados']['events'] as $k => $v)
                $_POST['dados']['events'][$k] = intval($v);
        }
        
        
        $_POST['dados']['modalDismissed'] = isset($_POST['dados']['modalDismissed']) && $_POST['dados']['modalDismissed'] == 'true' ? true : false;
        
        $db = new Db(
            'mysql', 
            $db_config['minha_virada']['host'], 
            $db_config['minha_virada']['name'], 
            $db_config['minha_virada']['user'],
            $db_config['minha_virada']['pass']
        );
        
        $check = $db->read('users', $_POST['dados']['uid'])->fetch();
        
        if (!$check) {
            $db->create( 'users', array('user_id' => $_POST['dados']['uid'], 'data' => json_encode($_POST['dados'])) );
        } else {
            $db->update('users', 'data', json_encode($_POST['dados']), $_POST['dados']['uid']);
        }
        
    }

}

if ($action == 'minhavirada_getJSON') {

    if( $_GET['uid'] ) {
        
        $db = new Db(
            'mysql', 
            $db_config['minha_virada']['host'], 
            $db_config['minha_virada']['name'], 
            $db_config['minha_virada']['user'],
            $db_config['minha_virada']['pass']
        );
        
        $user = $db->read('users', $_GET['uid'])->fetch();
        header('Content-Type: application/json');
        if ($user) {
            
            echo $user->data;
        } else {
            echo json_encode(array());
        }
        
    }

}


