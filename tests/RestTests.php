<?php

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/IntegrationTest.php';

use WireMock\Client\WireMock;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

class RestTests extends IntegrationTest {
	
  public function setUp() {
  	$this->createOAuthClient("Itest client", "itest-client-id", "itest-client-secret");
  }
  
  public function tearDown() {
   	$this->deleteOAuthClient("itest-client-id");
	  $this->deleteAllEvents();
  }
  
  public function testObtainAccessToken() {
  	$client = new GuzzleHttp\Client([
	    'base_url' => $this->base_url
	  ]);
	  	
	  $response = $client
	    ->post('/rest/api.php/access_token', [
	  	  'body' => [
	  	    "grant_type" => "client_credentials",
	  	    "client_id" => "itest-client-id",
	  	    "client_secret" => "itest-client-secret"
	  	 	]
	  	 ])
	    ->getBody()
	 	  ->getContents();
	    
	  $this->assertNotEmpty($response);
	  $token = json_decode($response);
	  $this->assertNotNull($token);
	  $this->assertNotEmpty($token->access_token);
	  $this->assertEquals("Bearer", $token->token_type);
	  $this->assertEquals("3600", $token->expires_in);
  }
  
  public function testAccessTokenInvalidClientId() {
  	$client = new GuzzleHttp\Client([
  			'base_url' => $this->base_url
  	]);
  	 
  	try {
  		$client->post('/rest/api.php/access_token', [
  				'body' => [
  						"grant_type" => "client_credentials",
  						"client_id" => "itest-client-id-invalid",
  						"client_secret" => "itest-client-secret"
  				]
  		]);
  
  		$this->fail("Access token obtained with invalid credentials");
  	} catch (RequestException $e) {
  		$this->assertEquals(401, $e->getResponse()->getStatusCode());
  	}
  }
  
  public function testAccessTokenInvalidClientSecret() {
  	$client = new GuzzleHttp\Client([
  			'base_url' => $this->base_url
  	]);
  	 
  	try {
  		$client->post('/rest/api.php/access_token', [
  				'body' => [
  						"grant_type" => "client_credentials",
  						"client_id" => "itest-client-id",
  						"client_secret" => "itest-client-secret-invalid"
  				]
  		]);
  
  		$this->fail("Access token obtained with invalid credentials");
  	} catch (RequestException $e) {
  		$this->assertEquals(401, $e->getResponse()->getStatusCode());
  	}
  }
  
  public function testListEventsNoToken() {
  	$client = new GuzzleHttp\Client([
  	  'base_url' => $this->base_url
  	]);
  	
  	try {
      $response = $client->get('/rest/api.php/events');
      $this->fail("Accessed events list without a access token");
  	} catch (RequestException $e) {
  		$this->assertEquals(403, $e->getResponse()->getStatusCode());
  	}
  }
  
  public function testListEventsInvalidToken() {
  	$client = new GuzzleHttp\Client([
  	  'base_url' => $this->base_url,
  		'headers' => ['access_token' => 'Foo Bar']
  	]);
  	
  	try {
      $response = $client->get('/rest/api.php/events');
      $this->fail("Accessed events list without a access token");
  	} catch (RequestException $e) {
  		$this->assertEquals(403, $e->getResponse()->getStatusCode());
  	}
  }
  
  public function testListEvents() {
  	$this->createEvent("First", "4",
  			$this->getTimestamp(2015, 1, 1), $this->getTimestamp(2015, 1, 2),
  			null, null, null, "3", "Example", null, null, null, null, false,
  			false, false, false, null, "info", null, "organizer@example.com",
  			null, null, "ACTIVE", "password", null, false);
  	
  	$this->createEvent("Second", "5", 
  		$this->getTimestamp(2015, 2, 1), $this->getTimestamp(2015, 2, 2), 
  		null, null, null, "4", "Demo", null, null, null, null, false,
  		false, false, false, null, "info two", null, "organizer@example.com",
  		null, null, "PENDING", "secret", null, false);
  	 
  	$client = $this->createAuthorizedClient();
  	
	  $response = $client->get('/rest/api.php/events');
    $this->assertEquals(200, $response->getStatusCode());
    $this->assertNotNull($response->json());
	  $events = $response->json();
	  $this->assertEquals(2, sizeof($events));
	  $this->assertEquals("First", $events[0]['name']);
	  $this->assertEquals("ACTIVE", $events[0]['status']);
	  $this->assertEquals("Second", $events[1]['name']);
	  $this->assertEquals("PENDING", $events[1]['status']);
  }

  public function testListEventsByStatus() {
  	$this->createEvent("First", "4",
  			$this->getTimestamp(2015, 1, 1), $this->getTimestamp(2015, 1, 2),
  			null, null, null, "3", "Example", null, null, null, null, false,
  			false, false, false, null, "info", null, "organizer@example.com",
  			null, null, "ACTIVE", "password", null, false);
  	 
  	$this->createEvent("Second", "5",
  			$this->getTimestamp(2015, 2, 1), $this->getTimestamp(2015, 2, 2),
  			null, null, null, "4", "Demo", null, null, null, null, false,
  			false, false, false, null, "info two", null, "organizer@example.com",
  			null, null, "PENDING", "secret", null, false);
  
  	$client = $this->createAuthorizedClient();
  	 
  	$response = $client->get('/rest/api.php/events', [
  	  "query" => [ "status" => "PENDING" ]		
  	]);
  	
  	$this->assertEquals(200, $response->getStatusCode());
  	$this->assertNotNull($response->json());
  	$events = $response->json();
  	$this->assertEquals(1, sizeof($events));
  	$this->assertEquals("Second", $events[0]['name']);
  	$this->assertEquals("PENDING", $events[0]['status']);
  }
  
  private function createAuthorizedClient() {
  	$handler = new GuzzleHttp\Ring\Client\StreamHandler();
  	
  	$oauth2Client = new GuzzleHttp\Client([
  		'handler' => $handler,
  		'base_url' => "$this->base_url/rest/api.php/"
  	]);
  	
  	$config = [
  		'client_id' => 'itest-client-id',
  		'client_secret' => 'itest-client-secret'
  	];
  	
  	$token = new CommerceGuys\Guzzle\Oauth2\GrantType\ClientCredentials($oauth2Client, $config);
  	$refresh_token = new CommerceGuys\Guzzle\Oauth2\GrantType\RefreshToken($oauth2Client, $config);
  	$oauth2 = new CommerceGuys\Guzzle\Oauth2\Oauth2Subscriber($token, $refresh_token);
  	
  	return new GuzzleHttp\Client([
  		'base_url' => "$this->base_url",
  		'handler' => $handler,
  		'defaults' => [
  		  'auth' => 'oauth2',
  			'subscribers' => [$oauth2]
  		]
  	]);
  }
  
}
?>