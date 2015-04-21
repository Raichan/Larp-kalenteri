<?php

use League\OAuth2\Server\Exception\InvalidClientException;
require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../dat/controller.php';
require_once __DIR__ . '/model.php';
require_once __DIR__ . '/oauth2.php';

$app = new \Slim\Slim();

$session_storage = new SessionStorage();
$access_token_storage = new AccessTokenStorage();
$client_storage = new ClientStorage();
$scope_storage = new ScopeStorage();

$oauth_server = new \League\OAuth2\Server\AuthorizationServer;
$oauth_server->setSessionStorage($session_storage);
$oauth_server->setAccessTokenStorage($access_token_storage);
$oauth_server->setClientStorage($client_storage);
$oauth_server->setScopeStorage($scope_storage);
$oauth_server->addGrantType(new \League\OAuth2\Server\Grant\ClientCredentialsGrant());

$resource_server = new \League\OAuth2\Server\ResourceServer(
	$session_storage,
	$access_token_storage,
	$client_storage,
  $scope_storage
);

function authenticate($resource_server) {
	return function () use ( $resource_server ) {
		try {
			$headers = getallheaders();
			$token = isset($headers['Authorization']) ? trim(preg_replace('/^(?:\s+)?Bearer\s/', '', $headers['Authorization'])) : null;
			$resource_server->isValidRequest(true, $token);
		} catch (\League\OAuth2\Server\Exception\AccessDeniedException $e) {
			$app = \Slim\Slim::getInstance();
			$app->status(403);
			$response = $app->response()->body($e->getMessage());
			$app->stop();
		} catch (\League\OAuth2\Server\Exception\InvalidRequestException $e) {
			$app = \Slim\Slim::getInstance();
			$app->status(403);
			$response = $app->response()->body($e->getMessage());
			$app->stop();
		} catch (\League\OAuth2\Server\Exception\OAuthException $e) {
  		$app = \Slim\Slim::getInstance();
  		$app->status($e->errorType);
  		$response = $app->response()->body($e->getMessage());
  	  $app->stop();
  	} catch (\Exception $e) {
  		$app = \Slim\Slim::getInstance();
  		$app->status(500);
  		$response = $app->response()->body($e->getMessage());
  		$app->stop();
  	}
  };
}

/**
 * Ping
 */
$app->get('/ping', function () use ($app) {
	$response = $app->response();
	$app->status(200);
	$response->body("pong");
});

/**
 * Create event
 */
$app->post('/events/', authenticate($resource_server), function () use ($app) {
	$response->status(501);
});

/**
 * List events
 */
$app->get('/events/', authenticate($resource_server), function () use ($app) {
	$status = $app->request()->params('status');
		
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
$app->get('/events/:id', authenticate($resource_server), function ($id) use ($app) {
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
$app->put('/events/:id', authenticate($resource_server), function ($id) use ($app) {
	$response->status(501);
})->name('id')->conditions(array('id' => '[0-9]{1,}'));

/**
 * Delete an event
 */
$app->delete('/events/:id', authenticate($resource_server), function ($id) use ($app) {
	$response->status(501);
})->name('id')->conditions(array('id' => '[0-9]{1,}'));

/**
 * Access token
 */
$app->post('/oauth2/token', function () use ($app, $oauth_server) {
	$response = $app->response();
	
	try {
		$token = $oauth_server->issueAccessToken();
		$app->status(200);
		$response->body(json_encode($token));
		$response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Cache-Control', 'no-store');
		$response->headers->set('Pragma', 'no-store');
	} catch (InvalidClientException $e) {
	  $app = \Slim\Slim::getInstance();
		$app->status(401);
		$app->response()->body("Unauthorized");
		$app->stop();
	} catch (\Exception $e) {
		$app = \Slim\Slim::getInstance();
		$app->status(500);
		$app->response()->body($e->getMessage());
		$app->stop();
	}

});

$app->run();
    
?>