<?php
// copiar esse arquivo para extra-db-config.php

$db_config = array(
    'minha_virada' => array(
        'name' => 'minha_virada',
        'user' => 'root',
        'pass' => '',
        'host' => 'localhost'
    ),
    'nas_redes' => array(
        'name' => 'nas_redes',
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



