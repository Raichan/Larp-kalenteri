<?php

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../dat/controller.php';
require_once __DIR__ . '/model.php';

$app = new \Slim\Slim();

/**
 * Create event
 */
$app->post('/events/', function () use ($app) {
	$response->status(501);
});

/**
 * List events
 */
$app->get('/events/', function () use ($app) {
	$result = [];
		
	$event_ids = null;
	if (isset($status)) {
		$event_ids = getEventIdsByStatus($status);
	} else {
		$event_ids = getEventIds();
	}
	
	foreach ($event_ids as $event_id) {
		$result[] = Event::fromEventData(getEventData($event_id))->toObject();
	}
	
	$response = $app->response();
  $response['Content-Type'] = 'application/json';
  $response->status(200);
  $response->body(json_encode($result));
});

/**
 * Find an event
 */
$app->get('/events/:id', function ($id) use ($app) {
	$event_data = getEventData($id);
	$event = $event_data != null ? Event::fromEventData($event_data)->toObject() : null;
		
	if ($event) {
		$response = $app->response();
	  $response['Content-Type'] = 'application/json';
	  $response->status(200);
	  $response->body(json_encode($event));
	} else {
  	$app->status(404);
	  $response->body("Not Found");
	}
	
})->name('id')->conditions(array('id' => '[0-9]{1,}'));

/**
 * Update an event
 */
$app->put('/events/:id', function ($id) use ($app) {
	$response->status(501);
})->name('id')->conditions(array('id' => '[0-9]{1,}'));

/**
 * Delete an event
 */
$app->delete('/events/:id', function ($id) use ($app) {
	$response->status(501);
})->name('id')->conditions(array('id' => '[0-9]{1,}'));

$app->run();
    
?>