<?php

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/storages.php';

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

/**
 * Access token
 */
$app->post('/token', function () use ($app, $oauth_server) {
	$response = $app->response();
	
	try {
		$token = $oauth_server->issueAccessToken();
		$app->status(200);
		$response->body(json_encode($token));
		$response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Cache-Control', 'no-store');
		$response->headers->set('Pragma', 'no-store');
	} catch (League\OAuth2\Server\Exception\InvalidClientException $e) {
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