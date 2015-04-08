<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/IntegrationTest.php';

use WireMock\Client\WireMock;

class CreateEventTests extends IntegrationTests {
	
	protected $base_url = "http://kalenteri.larp.dev";
	protected $wireMock;
	protected $webDriver;
	protected $capabilities;
	
  public function setUp() {
	  $sauceUser = getenv("SAUCE_USERNAME");
  	$sauceKey = getenv("SAUCE_ACCESS_KEY");
  	$travisJobNumber = getenv("TRAVIS_JOB_NUMBER");
  	$travisBuildNumber = getenv("TRAVIS_BUILD_NUMBER");
  	$this->capabilities = DesiredCapabilities::chrome();
  	 
  	if (!empty($sauceUser) && !empty($sauceKey) && !empty($travisJobNumber) && !empty($travisBuildNumber)) {
  		// Travis / Sauce Labs
  		$this->webDriver = $this->createSauceLabsWebDriver($this->capabilities, $sauceUser, $sauceKey, $travisJobNumber, $travisBuildNumber);
  	} else {
  		// Local
  		$this->webDriver = $this->createLocalWebDriver($this->capabilities);
  	}
  	 
  	$this->wireMock = $this->createFnIWireMock();
  }
  
  public function tearDown() {
   	$this->webDriver->quit();
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
    $this->verifyPostRequest(1, '/fni/rest/illusion/events', $this->createEventJson(null,
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
    );
    
    // Verify new user
    $this->verifyPostRequest(1, '/fni/rest/users/users.*', $this->createUserJson(null, "John", "Doe", null, "fi", $organizerEmail));

    // Verify organizer
    $this->verifyPostRequest(1, '/fni/rest/illusion/events/123/participants', $this->createEventParticipantJson(null, 1234, "ORGANIZER", null));
    
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
    
  	$this->findElement("#save")->click();

  	// Verify API calls
    
    // Verify new event
    
  	$this->verifyPostRequest(1, '/fni/rest/illusion/events', 
  	  $this->createEventJson(null,
  		  false,
  			$name,
  			$infoDesc,
  			null,
  			null,
  			null,
  			"INVITE_ONLY",
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
  	$this->verifyPostRequest(1, '/fni/rest/users/users.*', $this->createUserJson(null, "John", "Doe", null, "fi", $organizerEmail));
    
    // Verify organizer
  	$this->verifyPostRequest(1, '/fni/rest/illusion/events/123/participants', $this->createEventParticipantJson(null, 1234, "ORGANIZER", null));
    
  	$this->assertContains('Tapahtuma lähetetty onnistuneesti', $this->findElement(".container div.row:nth-of-type(2) h1")->getText());
  	
  	$this->deleteAllEvents();	
  }

  public function testCreateEventAdmin() {
  	$this->loginAdmin();
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

  public function testCreateEventAdminFnI() {
  	$this->loginAdmin();
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
  	$this->verifyPostRequest(1, '/fni/rest/illusion/events', $this->createEventJson(null,
  			true,
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
  	);
  	
  	// Verify new user
  	$this->verifyPostRequest(1, '/fni/rest/users/users.*', $this->createUserJson(null, "John", "Doe", null, "fi", $organizerEmail));
  	
  	// Verify organizer
  	$this->verifyPostRequest(1, '/fni/rest/illusion/events/123/participants', $this->createEventParticipantJson(null, 1234, "ORGANIZER", null));
  	
  	$this->assertContains('Tapahtuma lähetetty onnistuneesti', $this->findElement(".container div.row:nth-of-type(2) h1")->getText());
  	
  	$this->deleteAllEvents();
  }
}
?>