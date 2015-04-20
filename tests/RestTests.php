<?php

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/IntegrationTest.php';

use WireMock\Client\WireMock;
use GuzzleHttp\Exception\RequestException;

class RestTests extends IntegrationTest {
	
  public function setUp() {
  	$this->createOAuthClient("Itest client", "itest-client-id", "itest-client-secret");
  }
  
  public function tearDown() {
   	$this->deleteOAuthClient("itest-client-id");
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
  
}
?>