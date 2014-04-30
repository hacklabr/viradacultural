<?php
// copiar esse arquivo para extra-db-config.php

$db_config = array(
    'minha_virada' => array(
        'name' => 'minha_virada',
        'user' => 'root',
        'pass' => '',
        'host' => 'localhost'
    ),
    'virada_nas_redes' => array(
        'name' => 'virada_nas_redes',
        'user' => 'root',
        'pass' => '',
        'host' => 'localhost'
    ),
);

/* Criar essas tabelas:

No banco minha_virada:

CREATE TABLE IF NOT EXISTS users (
user_id INT NOT NULL PRIMARY KEY,
data VARCHAR(2048)
);

No banco nas_redes:

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