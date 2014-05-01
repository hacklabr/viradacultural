<?php

include ('Simple-Database-PHP-Class/Db.php');
include ('extra-db-config.php');

$action = $_REQUEST['action'];

if ($action == 'get_nasredes_posts') {


    $db = new Db('mysql',
        $db_config['virada_nas_redes']['host'],
        $db_config['virada_nas_redes']['name'],
        $db_config['virada_nas_redes']['user'],
        $db_config['virada_nas_redes']['pass']
    );

    $last_id = $_POST['last_id'];
    $what = $_POST['what'];

    $queryEnd = $what == 'newer' ? '> :last_id ORDER BY id DESC' : '< :last_id ORDER BY id DESC LIMIT 50';

    $items = $db->query( 'SELECT * FROM items WHERE id ' . $queryEnd, array( 'last_id' => $last_id ) );

    if ($items->count()){
        while ($item = $items->fetch()) {
            $dateCreated = date_create($item->date);
            $item->dateTimeFormatted = date_format($dateCreated, 'd-m-Y - H:i');
            $item->dateFormatted = date_format($dateCreated, 'Y-m-d');
            $ajaxhide = $what == 'newer';
            include '../parts/loop-redes.php';
        }
    }

}
