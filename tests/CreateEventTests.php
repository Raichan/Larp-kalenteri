<?php

require __DIR__ . '/../vendor/autoload.php';

use WireMock\Client\WireMock;
use WireMock\Client\JsonValueMatchingStrategy;

class CreateEventTests extends PHPUnit_Framework_TestCase {
	
	private $base_url = "http://localhost";
	protected $webDriver;

  public function setUp() {
	  $sauceUser = getenv("SAUCE_USERNAME");
  	$sauceKey = getenv("SAUCE_ACCESS_KEY");
  	$sauceTunnel = getenv("TRAVIS_JOB_NUMBER");
  	
  	if (!empty($sauceUser) && !empty($sauceKey) && !empty($sauceTunnel)) {
  		// Travis / Sauce Labs
  		$capabilities = DesiredCapabilities::firefox();
//   		$capabilities->setCapability("tunnel-identifier", $sauceTunnel);
  		$this->webDriver = RemoteWebDriver::create("http://$sauceUser:$sauceKey@ondemand.saucelabs.com:80/wd/hub", $capabilities);
  	} else {
  		// Local
  		$this->webDriver = RemoteWebDriver::create("http://localhost:4444/wd/hub", array(\WebDriverCapabilityType::BROWSER_NAME => 'firefox'));
  	}
  }
  
  public function tearDown() {
   	$this->webDriver->quit();
  }
  
  public function testCreateEvent() {
  	$wireMock = WireMock::create("test.forgeandillusion.net", '8080');
  	$this->assertEquals($wireMock->isAlive(), true, "WireMock is not alive");
  	$wireMock->reset();
  	
    $this->webDriver->get("$this->base_url/createEvent.php");
    $this->assertContains('LARP.fi Tapahtumakalenteri', $this->webDriver->getTitle());

    $name = "Test Event";
    $description = "Event for automatic testing";
    $location = "Testia";
    $organizerName = "John Doe";
    $organizerEmail = "john.doe@example.com";
    $startUI = "01/01/2015";
    $endUI = "02/01/2015";
    $startREST = $this->getISODate(2015, 1, 1);
    $endREST = $this->getISODate(2015, 1, 2);
    
    // FnI API stubs
    
		$this->stubAccessToken($wireMock, "fake-token");
    $this->stubEventGenres($wireMock);
    $this->stubEventTypes($wireMock);
    $this->stubUsersFindEmpty($wireMock, $organizerEmail);
    
    $wireMock->stubFor(WireMock::post(WireMock::urlEqualTo('/fni/rest/illusion/events'))
      ->willReturn(WireMock::aResponse()
    	  ->withStatus(200)
    		  ->withHeader('Content-Type', 'application/json')
    			->withBody($this->createEventJson(123, 
    					false, 
    					$name, 
    					null, 
    					$this->getISODate(2015, 1, 1), 
    					"test_event", 
    					"test_event@muc.example.com", 
    					"OPEN", 
    					null, 
    					null, 
    					$location, 
    					null, 
    					false, 
    					null, 
    					1, 
    					null,
    					null, 
    					null,
    					$startREST, 
    					$endREST, 
    					[]))
    		)
    );
    
    $wireMock->stubFor(WireMock::post(WireMock::urlMatching('/fni/rest/users/users.*'))
      ->willReturn(WireMock::aResponse()
    	  ->withStatus(200)
    		  ->withHeader('Content-Type', 'application/json')
    			->withBody($this->createUserJson(1234, "John", "Doe", null, "fi", $organizerEmail))
    		)
    );
    
    $wireMock->stubFor(WireMock::post(WireMock::urlEqualTo('/fni/rest/illusion/events/123/participants'))
      ->willReturn(WireMock::aResponse()
    	  ->withStatus(200)
    		  ->withHeader('Content-Type', 'application/json')
    			->withBody($this->createEventParticipantJson(12345, 1234, 'ORGANIZER', null))
    		)
    );
    
    // Create event
    
    $this->findElement("#eventname")->sendKeys($name);
    $this->findElement("#datestart")->sendKeys($startUI);
    $this->findElement("#dateend")->sendKeys($endUI);
    $this->findElement("#location2")->sendKeys($location);
    $this->findElement("#infodesc")->sendKeys($description);
    $this->findElement("#organizername")->sendKeys($organizerName);
    $this->findElement("#organizeremail")->sendKeys($organizerEmail);
    $this->findElement("#save")->click();
    
    // Verify API calls
    
    // Verify new event
    $wireMock->verify(1, 
      WireMock::postRequestedFor(WireMock::urlEqualTo('/fni/rest/illusion/events'))
     		-> withRequestBody(WireMock::equalToJson($this->createEventJson(null,
    		  false,
    		  $name,
	    		$description,
	    		null,
	    		null,
	    		null,
	    		"OPEN",
	    		null,
	    		"EUR",
	    		$location,
	    		null,
	    		false,
	    		null,
	    		1,
	    		null,
	    		null,
	    		null,
	    		$startREST,
	    		$endREST,
	    		[])
     		)
     	)
    );
    
    // Verify new user
    $wireMock->verify(1, 
      WireMock::postRequestedFor(WireMock::urlMatching('/fni/rest/users/users.*'))
     		-> withRequestBody(WireMock::equalToJson($this->createUserJson(null, "John", "Doe", null, "fi", $organizerEmail)))
    );
    
    // Verify organizer
    
    $wireMock->verify(1, 
      WireMock::postRequestedFor(WireMock::urlEqualTo('/fni/rest/illusion/events/123/participants'))
     		-> withRequestBody(WireMock::equalToJson($this->createEventParticipantJson(null, 1234, "ORGANIZER", null)))
    );
    
    $this->assertContains('Tapahtuma lähetetty onnistuneesti', $this->findElement(".container div.row:nth-of-type(2) h1")->getText());
  }
  
  private function getISODate($year, $month, $day) {
  	return (new DateTime())
  	  ->setTimezone(new DateTimeZone("UTC"))
  	  ->setDate($year, $month, $day)
  	  ->setTime(0, 0, 0)
  	  ->format('c');
  }
  
  protected function stubAccessToken($wireMock, $token) {
  	$wireMock->stubFor(WireMock::post(WireMock::urlEqualTo('/fni/oauth2/token'))
  			->willReturn(WireMock::aResponse()
  					->withStatus(200)
  					->withHeader('Content-Type', 'application/json')
  					->withBody('{"expires_in":3600,"access_token":"' . $token . '"}')
  			)
  	);
  }
  
  protected function stubEventTypes($wireMock) {
  	$wireMock->stubFor(WireMock::get(WireMock::urlEqualTo('/fni/rest/illusion/types'))
  			->willReturn(WireMock::aResponse()
  					->withStatus(200)
  					->withHeader('Content-Type', 'application/json')
  					->withBody('[{"id":1,"name":"Larpit"},{"id":2,"name":"Conit ja miitit"},{"id":3,"name":"Kurssit ja tyÃ¶pajat"},{"id":4,"name":"Muut"}]')
  			)
  	);
  }
  
  protected function stubEventGenres($wireMock) {
  	$wireMock->stubFor(WireMock::get(WireMock::urlEqualTo('/fni/rest/illusion/types'))
  			->willReturn(WireMock::aResponse()
  					->withStatus(200)
  					->withHeader('Content-Type', 'application/json')
  					->withBody('[{"id":1,"name":"Fantasia"},{"id":2,"name":"Sci-fi"},{"id":3,"name":"Cyberpunk"},{"id":4,"name":"Steampunk"},{"id":5,"name":"Post-apokalyptinen"},{"id":6,"name":"Historiallinen"},{"id":7,"name":"JÃ¤nnitys"},{"id":8,"name":"Kauhu"},{"id":9,"name":"Realismi"},{"id":10,"name":"Kaupunkipeli"},{"id":11,"name":"Uuskumma"},{"id":12,"name":"Toiminta"},{"id":13,"name":"Draama"},{"id":14,"name":"Huumori"}]')
  			)
  	);
  }
  
  protected function stubUsersFindEmpty($wireMock, $email) {
  	$encodedEmail = urlencode($email);
  	
  	$wireMock->stubFor(WireMock::get(WireMock::urlEqualTo("/fni/rest/users/users?email=$encodedEmail"))
  			->willReturn(WireMock::aResponse()
  					->withStatus(204)
  			)
  	);
  }
  
  protected function findElement($selector) {
  	return $this->webDriver->findElement(WebDriverBy::cssSelector($selector));
  }
  
  private function createEventJson($id, $published, $name, $description, $created, $urlName, $xmppRoom, $joinMode,
  		$signUpFee, $signUpFeeCurrency, $location, $ageLimit, $beginnerFriendly, $imageUrl, $typeId, $signUpStartDate, $signUpEndDate,
  		$domain, $start, $end, $genreIds) {
		return json_encode([
  		'id' => $id,
			'published' => $published,
			'name' => $name,
  	  'description' => $description,
			'created' => $created,
  	  'urlName' => $urlName,
			'xmppRoom' => $xmppRoom,
  	  'joinMode' => $joinMode,
			'signUpFee' => $signUpFee,
  	  'signUpFeeCurrency' => $signUpFeeCurrency,
			'location' => $location,
  	  'ageLimit' => $ageLimit,
			'beginnerFriendly' => $beginnerFriendly,
  	  'imageUrl' => $imageUrl,
			'typeId' => $typeId,
  	  'signUpStartDate' => $signUpStartDate,
			'signUpEndDate' => $signUpEndDate,
  	  'domain' => $domain,
			'start' => $start,
  	  'end' => $end,
			'genreIds' => $genreIds
		]);
  }
  
  private function createUserJson($id, $firstName, $lastName, $nickname, $locale, $emails) {
		return json_encode([
  		'id' => $id,
			'firstName' => $firstName,
			'lastName' => $lastName,
  	  'nickname' => $nickname,
			'locale' => $locale,
  	  'emails' => array($emails)
		]);
  }
  
  private function createEventParticipantJson($id, $userId, $role, $displayName) {
		return json_encode([
  		'id' => $id,
			'userId' => $userId,
			'role' => $role,
  	  'displayName' => $displayName
		]);
  }
  
}
?>