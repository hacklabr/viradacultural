<?php

if (file_exists(__DIR__ . '/api-config.php')) {
    include __DIR__ . '/api-config.php';
}
if(!defined('API_URL')) define('API_URL', "http://mapasculturais.hacklab.com.br/api/");

if(!defined('PROJECT_ID')) define('PROJECT_ID', 4);

if(!defined('AGENT_ID')) define('AGENT_ID', 428);

if(!defined('REPLACE_IMAGES_URL_FROM')) define('REPLACE_IMAGES_URL_FROM', 'http://mapasculturais.hacklab.com.br//files/');

if(!defined('REPLACE_IMAGES_URL_TO')) define('REPLACE_IMAGES_URL_TO', 'http://virada.sp.gov.br/imagens/');


$get_spaces_url = API_URL . "space/find?@select=id,name,shortDescription,endereco,location&@files=(avatar.viradaSmall,avatar.viradaBig):url&@order=name&owner=EQ(@Agent:" . AGENT_ID .")";
$get_events_url = API_URL . "event/find?@select=id,name,shortDescription,description,classificacaoEtaria,terms,traducaoLibras,descricaoSonora&@files=(avatar.viradaSmall,avatar.viradaBig):url&project=EQ(@Project:" . PROJECT_ID . ")";

echo "\nbaixando eventos $get_events_url\n\n";
$events_json = file_get_contents($get_events_url);

echo "\nbaixando espaços $get_spaces_url\n\n";
$spaces_json = file_get_contents($get_spaces_url);

$spaces = json_decode($spaces_json);
$events = array();
$events_by_id = array();

foreach (json_decode($events_json) as $e) {
    $events[] = $e;
    $events_by_id[$e->id] = $e;
    $event_ids[] = $e->id;
}

$event_ids = implode(',', $event_ids);

$occurrences_json = file_get_contents(API_URL . "eventOccurrence/find?@select=id,eventId,rule&event=IN($event_ids)&@order=_startsAt");

$occurrences = json_decode($occurrences_json);

$result_events = array();

$count = 0;
foreach ($occurrences as $occ) {
    $rule = $occ->rule;
    $e = $events_by_id[$occ->eventId];
    $e->spaceId = $rule->spaceId;

    $e->startsAt = $rule->startsAt;
    $e->startsOn = $rule->startsOn;
    $e->duration = @$rule->duration;
    $e->acessibilidade = array();
    if($e->traducaoLibras)
        $e->acessibilidade[] = 'Tradução para LIBRAS';

    if($e->descricaoSonora)
        $e->acessibilidade[] = 'Descrição sonora';


    $small_image_property = '@files:avatar.viradaSmall';
    $big_image_property = '@files:avatar.viradaBig';

    if (property_exists($e, $small_image_property)) {
        $e->defaultImage = str_replace(REPLACE_IMAGES_URL_FROM, REPLACE_IMAGES_URL_TO, $e->$big_image_property->url);
        $e->defaultImageThumb = str_replace(REPLACE_IMAGES_URL_FROM, REPLACE_IMAGES_URL_TO, $e->$small_image_property->url);
    } else {
        $e->defaultImage = '';
        $e->defaultImageThumb = '';
    }

    $result_events[] = $e;
}

file_put_contents(__DIR__ . '/events.json', json_encode($result_events));
file_put_contents(__DIR__ . '/spaces.json', json_encode($spaces));
