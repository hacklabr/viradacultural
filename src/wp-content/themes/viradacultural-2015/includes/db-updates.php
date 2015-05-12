<?php

if (congelado_db_update('db-update-nas-redes-time')) {
    // execute algum código aqui

    include (__DIR__.'/Simple-Database-PHP-Class/Db.php');
    include (__DIR__.'/extra-db-config.php');
    $db = new Db('mysql',
        $db_config['virada_nas_redes']['host'],
        $db_config['virada_nas_redes']['name'],
        $db_config['virada_nas_redes']['user'],
        $db_config['virada_nas_redes']['pass']
    );

	$db->query( "UPDATE items SET date = SUBTIME(date, '03:00:00')", array());
}


if(congelado_db_update('create minha virada table')){
    global $wpdb;

    $wpdb->query("CREATE TABLE IF NOT EXISTS users (
                    user_id bigint(20) NOT NULL PRIMARY KEY,
                    data VARBINARY(65000)
                );");
}


if(congelado_db_update('recreate nas redes table')){
    global $wpdb;

    $wpdb->query("
        CREATE TABLE `items` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `ref_id` varchar(100) NOT NULL,
            `type` varchar(20) NOT NULL,
            `content` text NOT NULL,
            `date` datetime NOT NULL,
            `author_username` varchar(255) NOT NULL,
            `author_fullname` varchar(255) NOT NULL,
            `text` varchar(255) DEFAULT NULL,
            `link` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id`)
        );

        ");

    $wpdb->query("create index date on items (date);");
    $wpdb->query("create index type_ref_id on items (type, ref_id);");
}