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
	    ->post('/oauth2/token', [
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
  		$response = $client->post('/oauth2/token', [
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
  		$client->post('/oauth2/token', [
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
  	$this->assertUrlInaccessibleWithoutToken('/rest/events');
  }
  
  public function testListEventsInvalidToken() {
  	$this->assertUrlInaccessibleWithInvalidToken('/rest/events');
  }
  
  public function testPing() {
  	$client = $this->createAuthorizedClient();
  	$response = $client->get('/rest/ping');
		$this->assertEquals(200, $response->getStatusCode());
		$this->assertEquals("pong", $response->getBody());
  }
  
  public function testListGenres() {
  	$client = $this->createAuthorizedClient();
  	 
  	$response = $client->get('/rest/genres/');
  	$this->assertEquals(200, $response->getStatusCode());
  	$this->assertNotNull($response->json());
  	$events = $response->json();
  	$this->assertEquals(18, sizeof($events));
  	$this->assertEquals("fantasy", $events[0]['id']);
  	$this->assertEquals("Fantasia", $events[0]['name']['fi']);
  	$this->assertEquals("Fantasy", $events[0]['name']['en']);
  }
  
  public function testListTypes() {
  	$client = $this->createAuthorizedClient();
  	 
  	$response = $client->get('/rest/types/');
  	$this->assertEquals(200, $response->getStatusCode());
  	$this->assertNotNull($response->json());
  	$events = $response->json();
  	$this->assertEquals(4, sizeof($events));
  	$this->assertEquals("2", $events[0]['id']);
  	$this->assertEquals("Larpit", $events[0]['name']['fi']);
  	$this->assertEquals("Larps", $events[0]['name']['en']);
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
  	
	  $response = $client->get('/rest/events');
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
  	 
  	$response = $client->get('/rest/events', [
  	  "query" => [ "status" => "PENDING" ]		
  	]);
  	
  	$this->assertEquals(200, $response->getStatusCode());
  	$this->assertNotNull($response->json());
  	$events = $response->json();
  	$this->assertEquals(1, sizeof($events));
  	$this->assertEquals("Second", $events[0]['name']);
  	$this->assertEquals("PENDING", $events[0]['status']);
  	$this->assertEquals($this->getISODate(2015, 2, 1), $events[0]['start']);
  	$this->assertEquals($this->getISODate(2015, 2, 2), $events[0]['end']);
  }
  
  public function testGetEventNoToken() {
  	$this->assertUrlInaccessibleWithoutToken('/rest/events/123');
  }
  
  public function testGetEventInvalidToken() {
  	$this->assertUrlInaccessibleWithInvalidToken('/rest/events/123');
  }
  
  public function testGetEventNotFound() {
    $client = $this->createAuthorizedClient();
  	$this->assertUrlNotFound($client, '/rest/events/123');
  	$this->assertUrlNotFound($client, '/rest/events/abc');
  	$this->assertUrlNotFound($client, '/rest/events/!');
  }
  
  public function testGetEvent() {
  	$id = $this->createEvent("First", "4",
  			$this->getTimestamp(2015, 1, 1), $this->getTimestamp(2015, 1, 2),
  			null, null, null, "3", "Example", null, null, null, null, false,
  			false, false, false, null, "info", null, "organizer@example.com",
  			null, null, "ACTIVE", "password", null, false);
  	
  	$client = $this->createAuthorizedClient();
  	 
  	$response = $client->get('/rest/events/' . $id);
  	
  	$this->assertEquals(200, $response->getStatusCode());
  	$this->assertNotNull($response->json());
  	$events = $response->json();
  	$this->assertEquals("First", $events['name']);
  	$this->assertEquals("ACTIVE", $events['status']);
  	$this->assertEquals($this->getISODate(2015, 1, 1), $events['start']);
  	$this->assertEquals($this->getISODate(2015, 1, 2), $events['end']);
  }
  
  public function testCreateEventNoToken() {
    $this->assertPostForbiddenWithoutToken('/rest/events');
  }
  
  public function testCreateEventInvalidToken() {
    $this->assertPostForbiddenInvalidToken('/rest/events');
  }
  
  public function testCreateEvent() {
  	$payload = json_decode('{"id":null,"name":"Create","type":4,"start":"2015-01-01T00:00:00+00:00","end":"2015-01-02T00:00:00+00:00","textDate":null,"signUpStart":null,"signUpEnd":null,"locationDropDown":"3","location":"Example","iconURL":null,"genres":[],"cost":null,"ageLimit":null,"beginnerFriendly":false,"storyDescription":null,"infoDescription":"info","organizerName":null,"organizerEmail":"organizer@example.com","link1":null,"link2":null,"status":"ACTIVE","password":"password","eventFull":false,"invitationOnly":false,"languageFree":false,"illusionId":null}');
  	
  	$client = $this->createAuthorizedClient();
  	 
    $response = $client->post('/rest/events/', [
      'json' => $payload
    ]);
  	
    $this->assertEquals(200, $response->getStatusCode());
	  $this->assertNotNull($response->json());
	  $events = $response->json();
	  $this->assertEquals("Create", $events['name']);
	  $this->assertEquals("ACTIVE", $events['status']);
	  $this->assertEquals($this->getISODate(2015, 1, 1), $events['start']);
	  $this->assertEquals($this->getISODate(2015, 1, 2), $events['end']);
  }

  public function testDeleteEventNoToken() {
  	$this->assertDeleteForbiddenInvalidToken('/rest/events/123');
  }
  
  public function testDeleteEventInvalidToken() {
  	$this->assertDeleteForbiddenInvalidToken('/rest/events/123');
  }
  
  public function testDeleteEventNotFound() {
    $client = $this->createAuthorizedClient();
  	$this->assertDeleteNotFound($client, '/rest/events/123');
  	$this->assertDeleteNotFound($client, '/rest/events/abc');
  	$this->assertDeleteNotFound($client, '/rest/events/!');
  }
  
  public function testDeleteEvent() {
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
  	 
  	$response = $client->get('/rest/events');
  	$this->assertEquals(200, $response->getStatusCode());
  	$this->assertNotNull($response->json());
  	$events = $response->json();
  	$this->assertEquals(2, sizeof($events));
  	$this->assertEquals("First", $events[0]['name']);
  	$this->assertEquals("Second", $events[1]['name']);
  	
  	$response = $client->delete('/rest/events/' . $events[0]['id']);
  	$this->assertEquals(204, $response->getStatusCode());
  	
  	$response = $client->get('/rest/events');
  	$this->assertEquals(200, $response->getStatusCode());
  	$this->assertNotNull($response->json());
  	$events = $response->json();
  	$this->assertEquals(1, sizeof($events));
  	$this->assertEquals("Second", $events[0]['name']);
  }

  public function testUpdateEventNoToken() {
  	$this->assertPutForbiddenInvalidToken('/rest/events/123');
  }
  
  public function testUpdateEventInvalidToken() {
  	$this->assertPutForbiddenInvalidToken('/rest/events/123');
  }
  
  public function testUpdateEventNotFound() {
    $client = $this->createAuthorizedClient();
  	$this->assertPutNotFound($client, '/rest/events/123');
  	$this->assertPutNotFound($client, '/rest/events/abc');
  	$this->assertPutNotFound($client, '/rest/events/!');
  }
  
  public function testUpdateEvent() {
  	$id = $this->createEvent("Original", "4",
  			$this->getTimestamp(2015, 1, 1), $this->getTimestamp(2015, 1, 2),
  			null, null, null, "3", "Example", null, null, null, null, false,
  			false, false, false, null, "info", null, "organizer@example.com",
  			null, null, "ACTIVE", "password", null, false);
  	
  	$payload = json_decode('{"id":null,"name":"Updated","type":4,"start":"2015-01-01T00:00:00+00:00","end":"2015-01-02T00:00:00+00:00","textDate":null,"signUpStart":null,"signUpEnd":null,"locationDropDown":"3","location":"Example","iconURL":null,"genres":[],"cost":null,"ageLimit":null,"beginnerFriendly":false,"storyDescription":null,"infoDescription":"info","organizerName":null,"organizerEmail":"organizer@example.com","link1":null,"link2":null,"status":"ACTIVE","password":"password","eventFull":false,"invitationOnly":false,"languageFree":false,"illusionId":null}');
  	
  	$client = $this->createAuthorizedClient();
  	
  	$this->assertEquals($client->get('/rest/events/' . $id)->json()['name'], "Original");
  	 
    $response = $client->put('/rest/events/' . $id, [
      'json' => $payload
    ]);
  	
    $this->assertEquals(200, $response->getStatusCode());
	  $this->assertNotNull($response->json());
	  $events = $response->json();
	  $this->assertEquals("Updated", $events['name']);
	  $this->assertEventName($id, "Updated");
	  
	  $this->assertEquals($client->get('/rest/events/' . $id)->json()['name'], "Updated");
  }
  
  private function createAuthorizedClient() {
  	$handler = new GuzzleHttp\Ring\Client\StreamHandler();
  	
  	$oauth2Client = new GuzzleHttp\Client([
  		'handler' => $handler,
  		'base_url' => "$this->base_url"
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
  
  private function assertUrlNotFound($client, $url) {
  	try {
    	$response = $client->get($url);
  	} catch (ClientException $e) {
  	  $this->assertEquals(404, $e->getResponse()->getStatusCode());
  	}
  }

  private function assertUrlInaccessibleWithoutToken($url) {
  	$client = new GuzzleHttp\Client([
  			'base_url' => $this->base_url
  	]);
  
  	try {
  		$response = $client->get($url);
  		$this->fail("Accessed $url without an access token");
  	} catch (RequestException $e) {
  		$this->assertEquals(403, $e->getResponse()->getStatusCode());
  	}
  }
  
  private function assertUrlInaccessibleWithInvalidToken($url) {
  	$client = new GuzzleHttp\Client([
  			'base_url' => $this->base_url,
  			'defaults' => [
  					'headers' => ['Authorization' => 'Bearer Foo Bar']
  			]
  	]);
  
  	try {
  		$response = $client->get($url);
  		$this->fail("Accessed $url with an invalid access token");
  	} catch (RequestException $e) {
  		$this->assertEquals(403, $e->getResponse()->getStatusCode());
  	}
  }

  private function assertPostForbiddenWithoutToken($url) {
  	$client = new GuzzleHttp\Client([
  			'base_url' => $this->base_url
  	]);
  
  	try {
  		$response = $client->post($url);
  		$this->fail("Accessed $url without an access token");
  	} catch (RequestException $e) {
  		$this->assertEquals(403, $e->getResponse()->getStatusCode());
  	}
  }
  
  private function assertPostForbiddenInvalidToken($url) {
  	$client = new GuzzleHttp\Client([
  			'base_url' => $this->base_url,
  			'defaults' => [
  					'headers' => ['Authorization' => 'Bearer Foo Bar']
  			]
  	]);
  
  	try {
  		$response = $client->post($url);
  		$this->fail("Accessed $url with an invalid access token");
  	} catch (RequestException $e) {
  		$this->assertEquals(403, $e->getResponse()->getStatusCode());
  	}
  }

  private function assertDeleteForbiddenWithoutToken($url) {
  	$client = new GuzzleHttp\Client([
  			'base_url' => $this->base_url
  	]);
  
  	try {
  		$response = $client->delete($url);
  		$this->fail("Accessed $url without an access token");
  	} catch (RequestException $e) {
  		$this->assertEquals(403, $e->getResponse()->getStatusCode());
  	}
  }
  
  private function assertDeleteForbiddenInvalidToken($url) {
  	$client = new GuzzleHttp\Client([
  			'base_url' => $this->base_url,
  			'defaults' => [
  					'headers' => ['Authorization' => 'Bearer Foo Bar']
  			]
  	]);
  
  	try {
  		$response = $client->delete($url);
  		$this->fail("Accessed $url with an invalid access token");
  	} catch (RequestException $e) {
  		$this->assertEquals(403, $e->getResponse()->getStatusCode());
  	}
  }
  
  private function assertDeleteNotFound($client, $url) {
  	try {
    	$response = $client->delete($url);
  	} catch (ClientException $e) {
  	  $this->assertEquals(404, $e->getResponse()->getStatusCode());
  	}
  }

  private function assertPutForbiddenWithoutToken($url) {
  	$client = new GuzzleHttp\Client([
  			'base_url' => $this->base_url
  	]);
  
  	try {
  		$response = $client->put($url);
  		$this->fail("Accessed $url without an access token");
  	} catch (RequestException $e) {
  		$this->assertEquals(403, $e->getResponse()->getStatusCode());
  	}
  }
  
  private function assertPutForbiddenInvalidToken($url) {
  	$client = new GuzzleHttp\Client([
  			'base_url' => $this->base_url,
  			'defaults' => [
  					'headers' => ['Authorization' => 'Bearer Foo Bar']
  			]
  	]);
  
  	try {
  		$response = $client->put($url);
  		$this->fail("Accessed $url with an invalid access token");
  	} catch (RequestException $e) {
  		$this->assertEquals(403, $e->getResponse()->getStatusCode());
  	}
  }
  
  private function assertPutNotFound($client, $url) {
  	try {
    	$response = $client->put($url);
  	} catch (ClientException $e) {
  	  $this->assertEquals(404, $e->getResponse()->getStatusCode());
  	}
  }
  
}
?>