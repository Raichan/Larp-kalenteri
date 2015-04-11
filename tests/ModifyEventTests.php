<?php

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/IntegrationTest.php';

use WireMock\Client\WireMock;

class ModifyEventTests extends IntegrationTests {
	
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
  
  public function testModifyEvent() {
  	$name = "To be modified";
  	$type = "3"; // Conit ja miitit;
  	$start = $this->getTimestamp(2015, 1, 1);
  	$end = $this->getTimestamp(2015, 1, 2);
  	$locationDropDown = "7"; // Lappi;
  	$location = "Testiö";
  	$infoDesc = "Event for testing modification";
  	$organizerEmail = "john.doe@example.com";
  	$password = "password";
  	
  	$modName = "Modified name";
  	$modType = "4"; // Kurssit ja työpajat
   	$modStart = $this->getTimestamp(2015, 1, 3);
   	$modEnd = $this->getTimestamp(2015, 1, 4);
   	$modStartUI = $this->getUIDate(2015, 1, 3);
   	$modEndUI = $this->getUIDate(2015, 1, 4);
  	$modLocationDropDown = "6"; // Pohjois-Suomi
  	$modLocation = "Modified location";
  	$modInfoDesc = "Modified event for testing";
  	$modOrganizerEmail = "jane.doe@example.com";
  	
  	$this->createEvent(
  			$name, 
  			$type,
  			$start, 
  			$end, 
  			null, 
  			null, 
  			null, 
  			$locationDropDown,
  			$location,
  		  null, 
  			null, 
  			null, 
  			null, 
  			false, 
  			false, 
  			false, 
  			false, 
  			null,
  			$infoDesc, 
  			null, 
  			$organizerEmail, 
  			null, 
  			null, 
  			"ACTIVE", 
  			$password, 
  			null);
  	
  	$eventId = $this->findEventIdByPasswordAndStatus($password, "ACTIVE");
  	$this->assertEventName($eventId, $name);
  	$this->assertEventIllusionId($eventId, null);
  			
  	$this->webDriver->get("$this->base_url/modifyPassword.php");
  	$this->assertContains('LARP.fi Tapahtumakalenteri', $this->webDriver->getTitle());
  	$this->findElement("#modifyPassword")->sendKeys($password);
  	$this->findElement("form button")->click();

  	$this->assertContains('Muokkaa tapahtumaa', $this->findElement(".container h2")->getText());

  	$this->findElement("#eventname")->clear()->sendKeys($modName);
  	$this->findElement("#datestart")->clear()->sendKeys($modStartUI);
  	$this->findElement("#dateend")->clear()->sendKeys($modEndUI);
  	$this->select("#location1", $modLocationDropDown);
  	$this->findElement("#location2")->clear()->sendKeys($modLocation);
  	$this->findElement("#infodesc")->clear()->sendKeys($modInfoDesc);
  	$this->findElement("#organizeremail")->clear()->sendKeys($modOrganizerEmail);
  	$this->findElement("#save")->click();
  	
  	$this->waitElementVisible(".container div.row:nth-of-type(2) h1");
  	$this->assertContains('Tapahtumaa muokattu onnistuneesti', $this->findElement(".container div.row:nth-of-type(2) h1")->getText());
  	
  	$this->assertEventName($eventId, $name);
  	$this->assertEventIllusionId($eventId, null);
  	$this->deleteAllEvents();	
  }
  
  public function testModifyEventFnI() {
  	$name = "To be modified";
  	$type = "3"; // Conit ja miitit;
  	$start = $this->getTimestamp(2015, 1, 1);
  	$end = $this->getTimestamp(2015, 1, 2);
  	$locationDropDown = "7"; // Lappi;
  	$location = "Testiö";
  	$infoDesc = "Event for testing modification";
  	$organizerEmail = "john.doe@example.com";
  	$password = "password";
  	
  	$modName = "Modified name";
  	$modType = "4"; // Kurssit ja työpajat
   	$modStart = $this->getTimestamp(2015, 1, 3);
   	$modEnd = $this->getTimestamp(2015, 1, 4);
   	$modStartUI = $this->getUIDate(2015, 1, 3);
   	$modEndUI = $this->getUIDate(2015, 1, 4);
  	$modLocationDropDown = "6"; // Pohjois-Suomi
  	$modLocation = "Modified location";
  	$modInfoDesc = "Modified event for testing";
  	$modOrganizerEmail = "jane.doe@example.com";
  	 
  	$this->createEvent(
  			$name, 
  			$type,
  			$start, 
  			$end, 
  			null, 
  			null, 
  			null, 
  			$locationDropDown,
  			$location,
  		  null, 
  			null, 
  			null, 
  			null, 
  			false, 
  			false, 
  			false, 
  			false, 
  			null,
  			$infoDesc, 
  			null, 
  			$organizerEmail, 
  			null, 
  			null, 
  			"ACTIVE", 
  			$password, 
  			1234);
  	
  	$eventId = $this->findEventIdByPasswordAndStatus($password, "ACTIVE");
  	$this->assertEventName($eventId, $name);
  	$this->assertEventIllusionId($eventId, 1234);
  			
  	$this->webDriver->get("$this->base_url/modifyPassword.php");
  	$this->assertContains('LARP.fi Tapahtumakalenteri', $this->webDriver->getTitle());
  	$this->findElement("#modifyPassword")->sendKeys($password);
  	$this->findElement("form button")->click();

  	$this->assertContains('Muokkaa tapahtumaa', $this->findElement(".container h2")->getText());

  	$this->findElement("#eventname")->clear()->sendKeys($modName);
  	$this->findElement("#datestart")->clear()->sendKeys($modStartUI);
  	$this->findElement("#dateend")->clear()->sendKeys($modEndUI);
  	$this->select("#location1", $modLocationDropDown);
  	$this->findElement("#location2")->clear()->sendKeys($modLocation);
  	$this->findElement("#infodesc")->clear()->sendKeys($modInfoDesc);
  	$this->findElement("#organizeremail")->clear()->sendKeys($modOrganizerEmail);
  	$this->findElement("#save")->click();
  	
  	$this->waitElementVisible(".container div.row:nth-of-type(2) h1");
  	$this->assertContains('Tapahtumaa muokattu onnistuneesti', $this->findElement(".container div.row:nth-of-type(2) h1")->getText());
  	
  	$this->assertEventName($eventId, $name);
  	$this->assertEventIllusionId($eventId, 1234);
  	
  	$this->deleteAllEvents();	
  }
  
  public function testModifyEventFnICreate() {
  	$name = "To be modified";
  	$type = "3"; // Conit ja miitit;
  	$start = $this->getTimestamp(2015, 1, 1);
  	$end = $this->getTimestamp(2015, 1, 2);
  	$locationDropDown = "7"; // Lappi;
  	$location = "Testiö";
  	$infoDesc = "Event for testing modification";
  	$organizerEmail = "jane.doe@example.com";
  	$password = "password";
  	 
  	$modName = "Modified name";
  	$modType = "4"; // Kurssit ja työpajat
  	$modTypeREST = 3; 
  	$modStart = $this->getTimestamp(2015, 1, 3);
  	$modEnd = $this->getTimestamp(2015, 1, 4);
  	$modStartUI = $this->getUIDate(2015, 1, 3);
  	$modEndUI = $this->getUIDate(2015, 1, 4);
   	$modStartREST = $this->getISODate(2015, 1, 3);
   	$modEndREST = $this->getISODate(2015, 1, 4);
  	$modLocationDropDown = "6"; // Pohjois-Suomi
  	$modLocation = "Modified location";
  	$modInfoDesc = "Modified event for testing";
  	$modOrganizerEmail = "jane.doe@example.com";
  	
  	// FnI API stubs
  	
  	$this->stubAccessToken("fake-token");
  	$this->stubEventGenres();
  	$this->stubEventTypes();
  	$this->stubUsersFindEmpty($organizerEmail);
  	$this->stubUserCreate($this->createUserJson(1234, "Jane", "Doe", null, "fi", $organizerEmail));
  	$this->stubEventParticipantCreate(1234, $this->createEventParticipantJson(12345, 1234, 'ORGANIZER', null));
  	$this->stubEventCreate($this->createEventJson(1234, 
      false, 
    	$modName, 
    	$modInfoDesc,
    	$this->getISODate(2015, 1, 1), 
    	"test_event", 
    	"test_event@muc.example.com", 
    	"OPEN", 
    	null,
    	null, 
    	null, 
    	$modLocation, 
    	null,
    	false, 
      null,
      $modTypeREST,
      null,
      null,
     	null,
    	$modStartREST, 
    	$modEndREST, 
    	[])
    );
  	
  	$this->createEvent(
  			$name,
  			$type,
  			$start,
  			$end,
  			null,
  			null,
  			null,
  			$locationDropDown,
  			$location,
  			null,
  			null,
  			null,
  			null,
  			false,
  			false,
  			false,
  			false,
  			null,
  			$infoDesc,
  			null,
  			$organizerEmail,
  			null,
  			null,
  			"ACTIVE",
  			$password,
  			null);

  	$eventId = $this->findEventIdByPasswordAndStatus($password, "ACTIVE");
  	 
  	$this->assertEventName($eventId, $name);
  	$this->assertEventIllusionId($eventId, null);
  		
  	$this->webDriver->get("$this->base_url/modifyPassword.php");
  	$this->assertContains('LARP.fi Tapahtumakalenteri', $this->webDriver->getTitle());
  	$this->findElement("#modifyPassword")->sendKeys($password);
  	$this->findElement("form button")->click();
  	
  	$this->assertContains('Muokkaa tapahtumaa', $this->findElement(".container h2")->getText());
  	
  	$this->findElement("#eventname")->clear()->sendKeys($modName);
    $this->select("#eventtype", $modType);
  	$this->findElement("#datestart")->clear()->sendKeys($modStartUI);
  	$this->findElement("#dateend")->clear()->sendKeys($modEndUI);
  	$this->select("#location1", $modLocationDropDown);
  	$this->findElement("#location2")->clear()->sendKeys($modLocation);
  	$this->findElement("#infodesc")->clear()->sendKeys($modInfoDesc);
  	$this->findElement("#organizeremail")->clear()->sendKeys($modOrganizerEmail);
  	$this->assertFalse($this->findElement("#illusionsync")->isSelected());
  	$this->toggleCheckboxes("#illusionsync");
  	 
  	$this->findElement("#save")->click();
  	 
  	$this->waitElementVisible(".container div.row:nth-of-type(2) h1");
  	$this->assertContains('Tapahtumaa muokattu onnistuneesti', $this->findElement(".container div.row:nth-of-type(2) h1")->getText());
  	
  	$newEventId = $this->findEventIdByPasswordAndStatus($password, "MODIFIED");
  	$this->assertNotNull($newEventId);
  	$this->assertNotEquals($newEventId, $eventId);
  	 
  	$this->assertEventName($eventId, $name);
  	$this->assertEventIllusionId($eventId, null);

  	$this->assertEventName($newEventId, $modName);
  	$this->assertEventIllusionId($newEventId, 1234);

  	// Verify API calls
  	
  	// Verify new event
  	$this->verifyPostRequest(1, '/fni/rest/illusion/events', $this->createEventJson(null,
  			false,
  			$modName,
  			$modInfoDesc,
  			null,
  			null,
  			null,
  			"OPEN",
  			null,
  			null,
  			"EUR",
  			$modLocation,
  			null,
  			false,
  			null,
  			$modTypeREST,
  			null,
  			null,
  			null,
  			$modStartREST,
  			$modEndREST,
  			[])
  	);
  	 
  	$this->deleteAllEvents();
  }

  public function testAdminModifyEventFnICreate() {
  	$this->loginAdmin();
  	
  	$name = "To be modified";
  	$type = "3"; // Conit ja miitit;
  	$start = $this->getTimestamp(2015, 1, 1);
  	$end = $this->getTimestamp(2015, 1, 2);
  	$locationDropDown = "7"; // Lappi;
  	$location = "Testiö";
  	$infoDesc = "Event for testing modification";
  	$organizerEmail = "jane.doe@example.com";
  	$password = "password";
  
  	$modName = "Modified name";
  	$modType = "4"; // Kurssit ja työpajat
  	$modTypeREST = 3;
  	$modStart = $this->getTimestamp(2015, 1, 3);
  	$modEnd = $this->getTimestamp(2015, 1, 4);
  	$modStartUI = $this->getUIDate(2015, 1, 3);
  	$modEndUI = $this->getUIDate(2015, 1, 4);
  	$modStartREST = $this->getISODate(2015, 1, 3);
  	$modEndREST = $this->getISODate(2015, 1, 4);
  	$modLocationDropDown = "6"; // Pohjois-Suomi
  	$modLocation = "Modified location";
  	$modInfoDesc = "Modified event for testing";
  	$modOrganizerEmail = "jane.doe@example.com";
  	 
  	// FnI API stubs
  	 
  	$this->stubAccessToken("fake-token");
  	$this->stubEventGenres();
  	$this->stubEventTypes();
  	$this->stubUsersFindEmpty($organizerEmail);
  	$this->stubUserCreate($this->createUserJson(1234, "Jane", "Doe", null, "fi", $organizerEmail));
  	$this->stubEventParticipantCreate(1234, $this->createEventParticipantJson(12345, 1234, 'ORGANIZER', null));
  	$this->stubEventCreate($this->createEventJson(1234,
  			true,
  			$modName,
  			$modInfoDesc,
  			$this->getISODate(2015, 1, 1),
  			"test_event",
  			"test_event@muc.example.com",
  			"OPEN",
  			null,
  			null,
  			null,
  			$modLocation,
  			null,
  			false,
  			null,
  			$modTypeREST,
  			null,
  			null,
  			null,
  			$modStartREST,
  			$modEndREST,
  			[])
  	);
  	 
  	$this->createEvent(
  			$name,
  			$type,
  			$start,
  			$end,
  			null,
  			null,
  			null,
  			$locationDropDown,
  			$location,
  			null,
  			null,
  			null,
  			null,
  			false,
  			false,
  			false,
  			false,
  			null,
  			$infoDesc,
  			null,
  			$organizerEmail,
  			null,
  			null,
  			"ACTIVE",
  			$password,
  			null);
  
  	$eventId = $this->findEventIdByPasswordAndStatus($password, "ACTIVE");
  	$this->assertEventName($eventId, $name);
  	$this->assertEventIllusionId($eventId, null);
  
  	$this->webDriver->get("$this->base_url/modifyPassword.php");
  	$this->assertContains('LARP.fi Tapahtumakalenteri', $this->webDriver->getTitle());
  	$this->findElement("#modifyPassword")->sendKeys($password);
  	$this->findElement("form button")->click();
  	 
  	$this->assertContains('Muokkaa tapahtumaa', $this->findElement(".container h2")->getText());
  	 
  	$this->findElement("#eventname")->clear()->sendKeys($modName);
  	$this->select("#eventtype", $modType);
  	$this->findElement("#datestart")->clear()->sendKeys($modStartUI);
  	$this->findElement("#dateend")->clear()->sendKeys($modEndUI);
  	$this->select("#location1", $modLocationDropDown);
  	$this->findElement("#location2")->clear()->sendKeys($modLocation);
  	$this->findElement("#infodesc")->clear()->sendKeys($modInfoDesc);
  	$this->findElement("#organizeremail")->clear()->sendKeys($modOrganizerEmail);
  	$this->assertFalse($this->findElement("#illusionsync")->isSelected());
  	$this->toggleCheckboxes("#illusionsync");
  
  	$this->findElement("#save")->click();
  
  	$this->waitElementVisible(".container div.row:nth-of-type(2) h1");
  	$this->assertContains('Tapahtumaa muokattu onnistuneesti', $this->findElement(".container div.row:nth-of-type(2) h1")->getText());
  	 
  	$eventId = $this->findEventIdByPasswordAndStatus($password, "ACTIVE");
  	 
  	$this->assertEventName($eventId, $modName);
  	$this->assertEventIllusionId($eventId, 1234);
  
  	// Verify API calls
  	 
  	// Verify new event
  	$this->verifyPostRequest(1, '/fni/rest/illusion/events', $this->createEventJson(null,
  			true,
  			$modName,
  			$modInfoDesc,
  			null,
  			null,
  			null,
  			"OPEN",
  			null,
  			null,
  			"EUR",
  			$modLocation,
  			null,
  			false,
  			null,
  			$modTypeREST,
  			null,
  			null,
  			null,
  			$modStartREST,
  			$modEndREST,
  			[])
  	);
  
  	$this->deleteAllEvents();
  }
  
  public function testAdminModifyEventFnI() {
  	$this->loginAdmin();
  	
  	$name = "To be modified";
  	$type = "3"; // Conit ja miitit;
  	$start = $this->getTimestamp(2015, 1, 1);
  	$end = $this->getTimestamp(2015, 1, 2);
  	$locationDropDown = "7"; // Lappi;
  	$location = "Testiö";
  	$infoDesc = "Event for testing modification";
  	$organizerEmail = "john.doe@example.com";
  	$password = "password";
  	
  	$modName = "Modified name";
  	$modType = "4"; // Kurssit ja työpajat
  	$modTypeREST = 3; 
  	$modStart = $this->getTimestamp(2015, 1, 3);
   	$modEnd = $this->getTimestamp(2015, 1, 4);
   	$modStartUI = $this->getUIDate(2015, 1, 3);
   	$modEndUI = $this->getUIDate(2015, 1, 4);
   	$modStartREST = $this->getISODate(2015, 1, 3);
   	$modEndREST = $this->getISODate(2015, 1, 4);
   	$modLocationDropDown = "6"; // Pohjois-Suomi
  	$modLocation = "Modified location";
  	$modInfoDesc = "Modified event for testing";
  	$modOrganizerEmail = "jane.doe@example.com";
  	
  	// FnI API stubs
  	 
  	$this->stubAccessToken("fake-token");
  	$this->stubEventGenres();
  	$this->stubEventTypes();
    $this->stubEventUpdate(1234, $this->createEventJson(1234, 
      true, 
    	$modName, 
    	$modInfoDesc,
    	$this->getISODate(2015, 1, 1), 
    	"test_event", 
    	"test_event@muc.example.com", 
    	"OPEN", 
    	null,
    	null, 
    	null, 
    	$modLocation, 
    	null,
    	false, 
      null,
      $modTypeREST,
      null,
      null,
     	null,
    	$modStartREST, 
    	$modEndREST, 
    	[])
    );
  	 
  	$this->createEvent(
  			$name, 
  			$type,
  			$start, 
  			$end, 
  			null, 
  			null, 
  			null, 
  			$locationDropDown,
  			$location,
  		  null, 
  			null, 
  			null, 
  			null, 
  			false, 
  			false, 
  			false, 
  			false, 
  			null,
  			$infoDesc, 
  			null, 
  			$organizerEmail, 
  			null, 
  			null, 
  			"ACTIVE", 
  			$password, 
  			1234);
  	
  	$eventId = $this->findEventIdByPasswordAndStatus($password, "ACTIVE");
  	$this->assertEventName($eventId, $name);
  	$this->assertEventIllusionId($eventId, 1234);
  			
  	$this->webDriver->get("$this->base_url/modifyPassword.php");
  	$this->assertContains('LARP.fi Tapahtumakalenteri', $this->webDriver->getTitle());
  	$this->findElement("#modifyPassword")->sendKeys($password);
  	$this->findElement("form button")->click();

  	$this->assertContains('Muokkaa tapahtumaa', $this->findElement(".container h2")->getText());

  	$this->findElement("#eventname")->clear()->sendKeys($modName);
  	$this->select("#eventtype", $modType);
  	$this->findElement("#datestart")->clear()->sendKeys($modStartUI);
  	$this->findElement("#dateend")->clear()->sendKeys($modEndUI);
  	$this->select("#location1", $modLocationDropDown);
  	$this->findElement("#location2")->clear()->sendKeys($modLocation);
  	$this->findElement("#infodesc")->clear()->sendKeys($modInfoDesc);
  	$this->findElement("#organizeremail")->clear()->sendKeys($modOrganizerEmail);
  	$this->findElement("#save")->click();
  	
  	$this->waitElementVisible(".container div.row:nth-of-type(2) h1");
  	$this->assertContains('Tapahtumaa muokattu onnistuneesti', $this->findElement(".container div.row:nth-of-type(2) h1")->getText());
  	
  	$eventId = $this->findEventIdByPasswordAndStatus($password, "ACTIVE");
  	 
  	$this->assertEventName($eventId, $modName);
  	$this->assertEventIllusionId($eventId, 1234);
    
    // Verify API calls
    
    // Verify new event
    $this->verifyPutRequest(1, '/fni/rest/illusion/events/1234', $this->createEventJson(1234,
    	true,
    	$modName, 
	    $modInfoDesc,
	    null,
	    null,
	    null,
	    "OPEN",
    	null,
	    null,
	    "EUR",
	    $modLocation,
	    null,
	    false,
	    null,
	    $modTypeREST,
	    null,
	    null,
	    null,
	    $modStartREST,
	    $modEndREST,
	    [])
    );
  	
  	$this->deleteAllEvents();	
  }
}
?>