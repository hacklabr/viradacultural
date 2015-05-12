<?php
// copiar esse arquivo para extra-db-config.php
$db_config = array(
    'minha_virada' => array(
        'name' => defined('MINHA_VIRADA__DB_NAME') ?    MINHA_VIRADA__DB_NAME : 'minha_virada',
        'user' => defined('MINHA_VIRADA__USER') ?       MINHA_VIRADA__USER : 'root',
        'pass' => defined('MINHA_VIRADA__PASS') ?       MINHA_VIRADA__PASS : '',
        'host' => defined('MINHA_VIRADA__HOST') ?       MINHA_VIRADA__HOST : 'localhost',
    ),
    'virada_nas_redes' => array(
        'name' => defined('NAS_REDES__DB_NAME') ? NAS_REDES__DB_NAME : 'nas_redes',
        'user' => defined('NAS_REDES__USER') ?    NAS_REDES__USER : 'root',
        'pass' => defined('NAS_REDES__PASS') ?    NAS_REDES__PASS : '',
        'host' => defined('NAS_REDES__HOST') ?    NAS_REDES__HOST : 'localhost',
    ),
);