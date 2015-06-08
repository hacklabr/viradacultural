<?php

if (file_exists(__DIR__ . '/api-config.php')) {
    include __DIR__ . '/api-config.php';
}
if(!defined('API_URL')) define('API_URL', "http://mapas.local/api/");

if(!defined('PROJECT_ID')) define('PROJECT_ID', 632);

if(!defined('REPLACE_IMAGES_URL_FROM')) define('REPLACE_IMAGES_URL_FROM', 'http://mapasculturais.hacklab.com.br//files/');

if(!defined('REPLACE_IMAGES_URL_TO')) define('REPLACE_IMAGES_URL_TO', 'http://viradacultural.prefeitura.sp.gov.br/imagens/');

if(!defined('DATE_FROM')) define('DATE_FROM', '2015-06-20');
if(!defined('DATE_TO')) define('DATE_TO', '2015-06-21');

$children_project_ids = file_get_contents(API_URL . "project/getChildrenIds/" . PROJECT_ID);
$children_project_ids[] = 632;

$project_ids = implode(',',$children_project_ids);

$get_spaces_url = API_URL . "space/findByEvents?@select=id,name,shortDescription,endereco,location&@files=(avatar.viradaSmall,avatar.viradaBig):url&@order=name&@from=2014-05-17&@to=2014-05-18&project=IN({$project_ids})";
$get_events_url = API_URL . "event/find?@select=id,name,shortDescription,description,classificacaoEtaria,terms,traducaoLibras,descricaoSonora&@files=(avatar.viradaSmall,avatar.viradaBig):url&project=IN({$project_ids})";

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

$occurrences_json = file_get_contents(API_URL . "eventOccurrence/find?@select=id,space.id,eventId,rule&event=IN($event_ids)&@order=_startsAt");

$occurrences = json_decode($occurrences_json);

$result_events = array();

$count = 0;
foreach ($occurrences as $occ) {
    $rule = $occ->rule;
    $e = $events_by_id[$occ->eventId];
    $e->spaceId = $occ->space->id;
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
