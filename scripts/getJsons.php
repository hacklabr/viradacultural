<?php
define('API_URL', "http://192.168.0.51:8000/api/");
define('PROJECT_ID', 15);

$get_spaces_url= API_URL . "space/find?@select=id,name,shortDescription,location&@files=(avatar,gallery):url&type=EQ(501)&@order=name";
$get_events_url= API_URL . "event/find?@select=id,name,shortDescription,description,classificacaoEtaria,terms&@files=(avatar,gallery):url&project=EQ(@Project:" . PROJECT_ID . ")";

echo "\nbaixando eventos $get_events_url\n\n";
$events_json = file_get_contents($get_events_url);

echo "\nbaixando espaços $get_spaces_url\n\n";
$spaces_json = file_get_contents($get_spaces_url);

$spaces = json_decode($spaces_json);
$events = array();
$events_by_id = array();

foreach(json_decode($events_json) as $e){
	$events[] = $e;
	$events_by_id[$e->id] = $e;
	$event_ids[] = $e->id;
}

$event_ids = implode(',',$event_ids);

$occurrences_json = file_get_contents(API_URL . "eventOccurrence/find?@select=id,eventId,rule&event=IN($event_ids)&@order=_startsAt");

$occurrences = json_decode($occurrences_json);

$result_events = array();

foreach($occurrences as $occ){
	$rule = $occ->rule;
	$e = $events_by_id[$occ->eventId];
	$e->spaceId = $rule->spaceId;
        $e->startsAt = $rule->startsAt;
	$e->startsOn = $rule->startsOn;
        $result_events[] = $e;
}

file_put_contents('events.json', json_encode($result_events));
file_put_contents('spaces.json', json_encode($spaces));
