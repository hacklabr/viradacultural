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
