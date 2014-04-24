<?php
if(file_exists(__DIR__ . '/api-config.php')){
	include __DIR__ . '/api-config.php';
}else{
	define('API_URL', "http://localhost:8000/api/");
	define('PROJECT_ID', 4);
}

$get_spaces_url= API_URL . "space/find?@select=id,name,shortDescription,endereco,location&@files=(avatar.viradaSmall,avatar.viradaBig):url&type=EQ(501)&@order=name";
$get_events_url= API_URL . "event/find?@select=id,name,shortDescription,description,classificacaoEtaria,terms&@files=(avatar.viradaSmall,avatar.viradaBig):url&project=EQ(@Project:" . PROJECT_ID . ")";

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

// fake images
$image_categories = array(
	'abstract',
	'animals',
	'business',
	'cats',
	'city',
	'food',
	'nightlife',
	'fashion',
	'people',
	'nature',
	'sports',
	'technics',
	'transport'
);
$count = 0;
foreach($occurrences as $occ){
	$rule = $occ->rule;
	$e = $events_by_id[$occ->eventId];
	$e->spaceId = $rule->spaceId;

    $e->startsAt = $rule->startsAt;
	$e->startsOn = $rule->startsOn;

	$small_image_property = '@files:avatar.viradaSmall';
	$big_image_property = '@files:avatar.viradaBig';

	if(property_exists($e, $small_image_property)){
		$e->defaultImage = $e->$big_image_property->url;
		$e->defaultImageThumb = $e->$big_image_property->url;
	}else{
		$category = $image_categories[array_rand($image_categories)];
		$e->defaultImage = "http://lorempixel.com/1024/768/{$category}/?id={$e->id}" . rand(1,10);
		$e->defaultImageThumb = "http://lorempixel.com/221/166/{$category}/?id={$e->id}" . rand(1,10);
	}
	
    $result_events[] = $e;
}

file_put_contents('events.json', json_encode($result_events));
file_put_contents('spaces.json', json_encode($spaces));
