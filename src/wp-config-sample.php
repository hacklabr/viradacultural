<?php
/** 
 * As configurações básicas do WordPress.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
 * Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
 *
 * Esse arquivo é usado pelo script ed criação wp-config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "wp-config.php" e preencher os valores.
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar essas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'viradacultural');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'root');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', '');

/** nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8');

/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

define('DOMAIN_CURRENT_SITE', 'localhost/viradacultural');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'f9Mc =ZD#{=AUjO6Z+wyQ`$]fuw%%=UZ7_vVw>3FhS{FS-XLp<Xk^LY!F8@Fe0%C');
define('SECURE_AUTH_KEY',  '-q-{lawEBwLW}h75|D?; $Q6W2w =*5[--@sEn.k~_!2?e*l~(?5KW97$#<:9KR6');
define('LOGGED_IN_KEY',    'ZIf>EiYCdwo#0i2n**~tfaI~J=OUA y+4[JQ,4sv+?Meb:84Hc|-gw6O|dXbB{=p');
define('NONCE_KEY',        ':4yhOjQ8,4u3ccrL)RzPGd_|&h>O@d1[d.cTr%{[V-v+|uAJ=e`r0%/qw]r~Ej@*');
define('AUTH_SALT',        '9oY2j0A7?oS=>ShI1.j=h`HF.$eqN={|Fwj4>@Pfpc$koFWbA#,+?#^FIi;F-TrP');
define('SECURE_AUTH_SALT', '-DJ{l.fyNAL @?q/e>eiP7^+vRyj:Bt&VB%fFTS8CtQ!yD7%jz>q1{Zt2Q++;}3/');
define('LOGGED_IN_SALT',   ',Xg,0-%y6t4@fVDDe2xZ&^Y 9Td?|ye3gW<h_sja?JE1ZzT[W*+/;Aj;QLB{YOQe');
define('NONCE_SALT',       'H|}Q wc5@Zbh,?KZb2-%zsn4%uk!QQ}n=#I^!6vX<6b+XBy=zx+VxOODvO[kUI+X');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';

/**
 * O idioma localizado do WordPress é o inglês por padrão.
 *
 * Altere esta definição para localizar o WordPress. Um arquivo MO correspondente ao
 * idioma escolhido deve ser instalado em wp-content/languages. Por exemplo, instale
 * pt_BR.mo em wp-content/languages e altere WPLANG para 'pt_BR' para habilitar o suporte
 * ao português do Brasil.
 */
define('WPLANG', 'pt_BR');

/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
 * é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');
