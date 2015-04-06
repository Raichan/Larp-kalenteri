<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../dat/config.php';

use WireMock\Client\WireMock;
use WireMock\Client\JsonValueMatchingStrategy;

class CreateEventTests extends PHPUnit_Framework_TestCase {
	
	private $base_url = "http://kalenteri.larp.dev";
	protected $wireMock;
	protected $webDriver;
	protected $capabilities;
	
  public function setUp() {
	  $sauceUser = getenv("SAUCE_USERNAME");
  	$sauceKey = getenv("SAUCE_ACCESS_KEY");
  	$travisJobNumber = getenv("TRAVIS_JOB_NUMBER");
  	$travisBuildNumber = getenv("TRAVIS_BUILD_NUMBER");
  	
  	if (!empty($sauceUser) && !empty($sauceKey) && !empty($travisJobNumber) && !empty($travisBuildNumber)) {
  		// Travis / Sauce Labs
  		$this->capabilities = DesiredCapabilities::chrome();
   		$this->capabilities->setCapability("tunnel-identifier", $travisJobNumber);
   		$this->capabilities->setCapability("name", $this->getName());
   		$this->capabilities->setCapability("build", $travisBuildNumber);
   		
  		$this->webDriver = RemoteWebDriver::create("http://$sauceUser:$sauceKey@ondemand.saucelabs.com:80/wd/hub", $this->capabilities);
  	} else {
  		echo "Using local webdriver";
  		// Local
  		$this->capabilities = DesiredCapabilities::chrome();
  		$this->webDriver = RemoteWebDriver::create("http://localhost:4444/wd/hub", $this->capabilities);
  	}
  	
  	$this->wireMock = WireMock::create("test.forgeandillusion.net", '8080');
  	$this->assertEquals($this->wireMock->isAlive(), true, "WireMock is not alive");
  }
  
  public function tearDown() {
   	$this->webDriver->quit();
  	$this->wireMock->reset();
  }
  
  public function testCreateEvent() {
  	 
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
  
  	// Create event
  
  	$this->findElement("#eventname")->sendKeys($name);
  	$this->findElement("#datestart")->sendKeys($startUI);
  	$this->findElement("#dateend")->sendKeys($endUI);
  	$this->findElement("#location2")->sendKeys($location);
  	$this->findElement("#infodesc")->sendKeys($description);
  	$this->findElement("#organizername")->sendKeys($organizerName);
  	$this->findElement("#organizeremail")->sendKeys($organizerEmail);	
  	$this->toggleCheckboxes("#illusionsync");
  	 
  	$this->findElement("#save")->click();
  
  	// Verify that event API call was not made
  	
  	$this->wireMock->verify(0, WireMock::postRequestedFor(WireMock::urlEqualTo('/fni/rest/illusion/events')));
  	
  	$this->assertContains('Tapahtuma lähetetty onnistuneesti', $this->findElement(".container div.row:nth-of-type(2) h1")->getText());
  	
  	$this->deleteAllEvents();	
  }
  
  public function testCreateEventFnI() {
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
    
		$this->stubAccessToken("fake-token");
    $this->stubEventGenres();
    $this->stubEventTypes();
    $this->stubUsersFindEmpty($organizerEmail);
    $this->stubUserCreate($this->createUserJson(1234, "John", "Doe", null, "fi", $organizerEmail));
    $this->stubEventParticipantCreate($this->createEventParticipantJson(12345, 1234, 'ORGANIZER', null));
    $this->stubEventCreate($this->createEventJson(123, 
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
    	[])
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
    $this->wireMock->verify(1, 
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
    $this->wireMock->verify(1, 
      WireMock::postRequestedFor(WireMock::urlMatching('/fni/rest/users/users.*'))
     		-> withRequestBody(WireMock::equalToJson($this->createUserJson(null, "John", "Doe", null, "fi", $organizerEmail)))
    );
    
    // Verify organizer
    
    $this->wireMock->verify(1, 
      WireMock::postRequestedFor(WireMock::urlEqualTo('/fni/rest/illusion/events/123/participants'))
     		-> withRequestBody(WireMock::equalToJson($this->createEventParticipantJson(null, 1234, "ORGANIZER", null)))
    );
    
    $this->assertContains('Tapahtuma lähetetty onnistuneesti', $this->findElement(".container div.row:nth-of-type(2) h1")->getText());

  	$this->deleteAllEvents();	
  }
    
  public function testCreateEventFillAll() {
  	$this->webDriver->get("$this->base_url/createEvent.php");
  	$this->assertContains('LARP.fi Tapahtumakalenteri', $this->webDriver->getTitle());
  
  	$name = "Test Event";
  	$type = 3; // Conit ja miitit
  	$startUI = "01/01/2015";
  	$endUI = "02/01/2015";
  	$signupStartUI = "03/01/2015";
  	$signupEndUI =  "04/01/2015";
  	$location1 = 7; // Lappi
  	$location2 = "Testia";
  	$icon = "http://upload.wikimedia.org/wikipedia/commons/3/34/Boj_na_mBPA.jpg";
  	$cost = "22";
  	$ageLimit = 16;
  	$storyDesc = "Uneventful test where participants may only watch whats happening";
  	$infoDesc = "Event for automatic testing";
  	$organizerName = "John Doe";
  	$organizerEmail = "john.doe@example.com";
    $website1 = "http://web1.example.com";
    $website2 = "http://web2.example.com";
    
    $this->findElement("#eventname")->sendKeys($name);
    $this->select("#eventtype", $type);
    $this->findElement("#datestart")->sendKeys($startUI);
    $this->findElement("#dateend")->sendKeys($endUI);
    $this->findElement("#signupstart")->sendKeys($signupStartUI);
    $this->findElement("#signupend")->sendKeys($signupEndUI);
    $this->select("#location1", $location1);
    $this->findElement("#location2")->sendKeys($location2);
    $this->findElement("#icon")->sendKeys($icon);
    $this->toggleCheckboxes("input[name*=\"genre\"]");
    $this->findElement("#cost")->sendKeys($cost);
    $this->findElement("#agelimit")->sendKeys($ageLimit);
    $this->toggleCheckboxes("#beginnerfriendly");
    $this->toggleCheckboxes("#eventfull");
    $this->toggleCheckboxes("#invitationonly");
    $this->toggleCheckboxes("#languagefree");
    $this->findElement("#storydesc")->sendKeys($storyDesc);
    $this->findElement("#infodesc")->sendKeys($infoDesc);
    $this->findElement("#organizername")->sendKeys($organizerName);
    $this->findElement("#organizeremail")->sendKeys($organizerEmail);
    $this->findElement("#website1")->sendKeys($website1);
    $this->findElement("#website2")->sendKeys($website2);
    $this->toggleCheckboxes("#illusionsync");
    
  	$this->findElement("#save")->click();
  
  	// Verify that event API call was not made
  	
  	$this->wireMock->verify(0, WireMock::postRequestedFor(WireMock::urlEqualTo('/fni/rest/illusion/events')));
  	
  	$this->assertContains('Tapahtuma lähetetty onnistuneesti', $this->findElement(".container div.row:nth-of-type(2) h1")->getText());
  	
  	$this->deleteAllEvents();	
  }
    
  public function testCreateEventFillAllFnI() {
  	$this->webDriver->get("$this->base_url/createEvent.php");
  	$this->assertContains('LARP.fi Tapahtumakalenteri', $this->webDriver->getTitle());
  
  	$name = "Fill All Test Event";
  	$type = 3; // Conit ja miitit
  	$restType = 2;
  	$startUI = "01/01/2015";
  	$endUI = "02/01/2015";
  	$startREST = $this->getISODate(2015, 1, 1);
  	$endREST = $this->getISODate(2015, 1, 2);
  	$signupStartUI = "03/01/2015";
  	$signupEndUI =  "04/01/2015";
  	$signupStartREST = $this->getISODate(2015, 1, 3);
  	$signupEndREST = $this->getISODate(2015, 1, 4);
  	$location1 = 7; // Lappi
  	$location2 = "Testia";
  	$icon = "http://upload.wikimedia.org/wikipedia/commons/3/34/Boj_na_mBPA.jpg";
  	$cost = "22";
  	$ageLimit = 16;
  	$storyDesc = "Uneventful test where participants may only watch whats happening";
  	$infoDesc = "Event for automatic testing";
  	$organizerName = "John Doe";
  	$organizerEmail = "john.doe@example.com";
    $website1 = "http://web1.example.com";
    $website2 = "http://web2.example.com";
    
    // FnI API stubs
    
		$this->stubAccessToken("fake-token");
    $this->stubEventGenres();
    $this->stubEventTypes();
    $this->stubUsersFindEmpty($organizerEmail);
    $this->stubUserCreate($this->createUserJson(1234, "John", "Doe", null, "fi", $organizerEmail));
    $this->stubEventParticipantCreate($this->createEventParticipantJson(12345, 1234, 'ORGANIZER', null));
    $this->stubEventCreate($this->createEventJson(123, 
      false, 
    	$name, 
    	$infoDesc,
    	$this->getISODate(2015, 1, 1), 
    	"test_event", 
    	"test_event@muc.example.com", 
    	"OPEN", 
    	null, 
    	null, 
    	$location2, 
    	$ageLimit,
    	true, 
      $icon,
      $restType,
      $signupStartREST,
      $signupEndREST,
     	null,
    	$startREST, 
    	$endREST, 
    	[1,2,3,4,5,6,7,8,9,10,11,12,13,14])
    );
    
    $this->findElement("#eventname")->sendKeys($name);
    $this->select("#eventtype", $type);
    $this->findElement("#datestart")->sendKeys($startUI);
    $this->findElement("#dateend")->sendKeys($endUI);
    $this->findElement("#signupstart")->sendKeys($signupStartUI);
    $this->findElement("#signupend")->sendKeys($signupEndUI);
    $this->select("#location1", $location1);
    $this->findElement("#location2")->sendKeys($location2);
    $this->findElement("#icon")->sendKeys($icon);
    $this->toggleCheckboxes("input[name*=\"genre\"]");
    $this->findElement("#cost")->sendKeys($cost);
    $this->findElement("#agelimit")->sendKeys($ageLimit);
    $this->toggleCheckboxes("#beginnerfriendly");
    $this->toggleCheckboxes("#eventfull");
    $this->toggleCheckboxes("#invitationonly");
    $this->toggleCheckboxes("#languagefree");
    $this->findElement("#storydesc")->sendKeys($storyDesc);
    $this->findElement("#infodesc")->sendKeys($infoDesc);
    $this->findElement("#organizername")->sendKeys($organizerName);
    $this->findElement("#organizeremail")->sendKeys($organizerEmail);
    $this->findElement("#website1")->sendKeys($website1);
    $this->findElement("#website2")->sendKeys($website2);
    $this->toggleCheckboxes("#illusionsync");
    
  	$this->findElement("#save")->click();

  	// Verify API calls
    
    // Verify new event
    
  	$this->verifyRequest(1, WireMock::postRequestedFor(WireMock::urlEqualTo('/fni/rest/illusion/events')), 
  	  $this->createEventJson(null,
  		  false,
  			$name,
  			$infoDesc,
  			null,
  			null,
  			null,
  			"OPEN",
  			null,
  			"EUR",
  			$location2,
  			$ageLimit,
  			true,
  			$icon,
  			$restType,
  			$signupStartREST,
  			$signupEndREST,
  			null,
  			$startREST,
  			$endREST,
  			[1,2,3,4,5,6,7,8,9,10,11,12,13,14])
  	);
    
    // Verify new user
    $this->wireMock->verify(1, 
      WireMock::postRequestedFor(WireMock::urlMatching('/fni/rest/users/users.*'))
     		-> withRequestBody(WireMock::equalToJson($this->createUserJson(null, "John", "Doe", null, "fi", $organizerEmail)))
    );
    
    // Verify organizer
    
    $this->wireMock->verify(1, 
      WireMock::postRequestedFor(WireMock::urlEqualTo('/fni/rest/illusion/events/123/participants'))
     		-> withRequestBody(WireMock::equalToJson($this->createEventParticipantJson(null, 1234, "ORGANIZER", null)))
    );
  	
  	$this->assertContains('Tapahtuma lähetetty onnistuneesti', $this->findElement(".container div.row:nth-of-type(2) h1")->getText());
  	
  	$this->deleteAllEvents();	
  }
  
  protected function verifyRequest($count, $requestPattern, $body) {
  	try {
  		$this->wireMock->verify($count, $requestPattern -> withRequestBody(WireMock::equalToJson($body) ));
  	} catch (VerificationException $e) {
  		foreach ($this->wireMock->findAll($requestPattern) as $logged) {
  			$this->fail("Request verification failed: Expected $body but received $logged->getBody()");
  		}
  	}
  }
  
  // TODO: testCreateEventAdmin()
  // TODO: testCreateEventAdminFnI()
  // TODO: testCreateEventFillAllAdmin()
  // TODO: testCreateEventFillAllAdminFnI()
  
  private function getISODate($year, $month, $day) {
  	return (new DateTime())
  	  ->setTimezone(new DateTimeZone("UTC"))
  	  ->setDate($year, $month, $day)
  	  ->setTime(0, 0, 0)
  	  ->format('c');
  }
  
  protected function stubAccessToken($token) {
  	$this->wireMock->stubFor(WireMock::post(WireMock::urlEqualTo('/fni/oauth2/token'))
  			->willReturn(WireMock::aResponse()
  					->withStatus(200)
  					->withHeader('Content-Type', 'application/json')
  					->withBody('{"expires_in":3600,"access_token":"' . $token . '"}')
  			)
  	);
  }
  
  protected function stubEventTypes() {
  	$this->wireMock->stubFor(WireMock::get(WireMock::urlEqualTo('/fni/rest/illusion/types'))
  			->willReturn(WireMock::aResponse()
  					->withStatus(200)
  					->withHeader('Content-Type', 'application/json')
  					->withBody('[{"id":1,"name":"Larpit"},{"id":2,"name":"Conit ja miitit"},{"id":3,"name":"Kurssit ja tyÃ¶pajat"},{"id":4,"name":"Muut"}]')
  			)
  	);
  }
  
  protected function stubEventGenres() {
  	$this->wireMock->stubFor(WireMock::get(WireMock::urlEqualTo('/fni/rest/illusion/types'))
  			->willReturn(WireMock::aResponse()
  					->withStatus(200)
  					->withHeader('Content-Type', 'application/json')
  					->withBody('[{"id":1,"name":"Fantasia"},{"id":2,"name":"Sci-fi"},{"id":3,"name":"Cyberpunk"},{"id":4,"name":"Steampunk"},{"id":5,"name":"Post-apokalyptinen"},{"id":6,"name":"Historiallinen"},{"id":7,"name":"JÃ¤nnitys"},{"id":8,"name":"Kauhu"},{"id":9,"name":"Realismi"},{"id":10,"name":"Kaupunkipeli"},{"id":11,"name":"Uuskumma"},{"id":12,"name":"Toiminta"},{"id":13,"name":"Draama"},{"id":14,"name":"Huumori"}]')
  			)
  	);
  }
  
  protected function stubUsersFindEmpty($email) {
  	$encodedEmail = urlencode($email);
  	
  	$this->wireMock->stubFor(WireMock::get(WireMock::urlEqualTo("/fni/rest/users/users?email=$encodedEmail"))
  			->willReturn(WireMock::aResponse()
  					->withStatus(204)
  			)
  	);
  }
  
	protected function stubEventCreate($body) {
  	$this->wireMock->stubFor(WireMock::post(WireMock::urlEqualTo('/fni/rest/illusion/events'))
  			->willReturn(WireMock::aResponse()
  					->withStatus(200)
  					->withHeader('Content-Type', 'application/json')
  					->withBody($body)
  			)
  	);
  }
  
  protected function stubUserCreate($body) {
  	$this->wireMock->stubFor(WireMock::post(WireMock::urlMatching('/fni/rest/users/users.*'))
  			->willReturn(WireMock::aResponse()
  					->withStatus(200)
  					->withHeader('Content-Type', 'application/json')
  					->withBody($body)
  			)
  	);
  }
  

  protected function stubEventParticipantCreate($body) {
	  $this->wireMock->stubFor(WireMock::post(WireMock::urlEqualTo('/fni/rest/illusion/events/123/participants'))
	  		->willReturn(WireMock::aResponse()
	  				->withStatus(200)
	  				->withHeader('Content-Type', 'application/json')
	  				->withBody($body)
	  		)
	  );
  }
  
  protected function findElement($selector) {
  	return $this->webDriver->findElement(WebDriverBy::cssSelector($selector));
  }
  
  protected function findElements($selector) {
  	return $this->webDriver->findElements(WebDriverBy::cssSelector($selector));
  }
  
  protected function select($selector, $value) {
  	$select = new WebDriverSelect($this->findElement($selector));
  	$select->selectByValue($value);
  }

  protected function toggleCheckboxes($selector) {
  	foreach ($this->findElements($selector) as $element) {
  		if ($this->capabilities->getBrowserName() == 'firefox') {
  			$element->click();
  		} else {
  			$element->sendKeys(WebDriverKeys::SPACE);
  		}
  	}
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
  
  private function deleteAllEvents() {
  	$d = "host=" . DB_SERVER . " port=" . DB_PORT . " dbname=" . DB_DATABASE . " user=" . DB_USER . " password=" . DB_PASSWORD;
  	$dbconn = pg_connect($d) or die('Could not connect to DB: ' . pg_last_error());
  	$result = pg_query("delete from events") or die('Query failed: ' . pg_last_error());
  }
}
?>