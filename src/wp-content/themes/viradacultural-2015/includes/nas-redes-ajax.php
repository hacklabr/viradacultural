<?php

require ('Simple-Database-PHP-Class/Db.php');

require ('extra-db-config.php');

$action = $_REQUEST['action'];

if ($action == 'get_nasredes_posts') {


    $db = new Db('mysql',
        $db_config['virada_nas_redes']['host'],
        $db_config['virada_nas_redes']['name'],
        $db_config['virada_nas_redes']['user'],
        $db_config['virada_nas_redes']['pass']
    );

    $last_date = $_POST['last_date'];
    $what = $_POST['what'];

    $queryEnd = $what == 'newer' ? '> :last_date ORDER BY date DESC' : '< :last_date ORDER BY date DESC LIMIT 50';

    $items = $db->query( 'SELECT * FROM items WHERE date ' . $queryEnd, array( 'last_date' => $last_date ) );

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
