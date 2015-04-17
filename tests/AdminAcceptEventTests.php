<?php

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/IntegrationTest.php';

use WireMock\Client\WireMock;

class AdminAcceptEventTests extends IntegrationTests {
	
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
   	$this->clearEmails();
  }
  
  public function testApproveEvent() {
  	$this->loginAdmin();
  	
  	$name = "To be approved";
  	$type = "3"; // Conit ja miitit;
  	$start = $this->getTimestamp(2015, 1, 1);
  	$end = $this->getTimestamp(2015, 1, 2);
  	$locationDropDown = "7"; // Lappi;
  	$location = "Testiö";
  	$infoDesc = "Event for testing modification";
  	$organizerEmail = "john.doe@example.com";
  	$password = "password";
  	 
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
  			"PENDING",
  			$password,
  			null,
  			false);
  	 
  	$eventId = $this->findEventIdByPasswordAndStatus($password, "PENDING");
  	$this->assertEventName($eventId, $name);
  	$this->assertEventIllusionId($eventId, null);
  	
  	$this->webDriver->get("$this->base_url/admin/eventsApproval.php");
  	$this->assertContains('Tapahtumien hyväksyminen', $this->findElement(".container h3")->getText());
  	
  	$this->findElement("table .dropdown-toggle")->click();
  	$this->waitAndClickElement("table .dropdown-menu li:first-child a");
  	
  	$this->assertContains('Tapahtumien hyväksyminen', $this->findElement(".container h3")->getText());
  	$this->waitAndClickElement("form button");
  	 
  	// Not localized:
  	$this->assertContains('Event was approved successfully.', $this->findElement(".alert-success")->getText());
  	 
  	$sentEmails = $this->getEmails();
  	$this->assertEquals(1, count($sentEmails));
  	// FIXME Confirm email seems to go to admins and contains information that 
  	// the event should be approved.
  	// $this->assertEmailPlainContains("Your larp calendar event", $sentEmails[0]->id);
  	// $this->assertEmailRecipient($organizerEmail, $sentEmails[0]);
  	
  	$this->deleteAllEvents();
  }
  
  public function testApproveEventFnINewUser() {
  	$this->loginAdmin();
  	
  	$name = "To be approved";
  	$type = "3"; // Conit ja miitit;
  	$typeREST = 2; 
  	$start = $this->getTimestamp(2015, 1, 1);
  	$end = $this->getTimestamp(2015, 1, 2);
  	$startREST = $this->getISODate(2015, 1, 1);
  	$endREST = $this->getISODate(2015, 1, 2);
  	$locationDropDown = "7"; // Lappi;
  	$location = "Testiö";
  	$infoDesc = "Event for testing modification";
  	$organizerEmail = "john.doe@example.com";
  	$password = "password";
  	
  	// FnI API stubs
  	 
  	$this->stubAccessToken("fake-token");
  	$this->stubEventGenres();
  	$this->stubEventTypes();
    $this->stubEventUpdate(1234, $this->createEventJson(1234, 
      true, 
    	$name, 
    	$infoDesc,
    	$this->getISODate(2015, 1, 1), 
    	"test_event", 
    	"test_event@muc.example.com", 
    	"OPEN", 
    	null,
    	null, 
    	null, 
    	$location, 
    	null,
    	false, 
      null,
      $typeREST,
      null,
      null,
     	null,
    	$startREST, 
    	$endREST, 
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
  			"PENDING", 
  			$password, 
  			1234,
  			true);
  	
  	$eventId = $this->findEventIdByPasswordAndStatus($password, "PENDING");
  	
  	$this->assertEventName($eventId, $name);
  	$this->assertEventIllusionId($eventId, 1234);
  	
  	$this->webDriver->get("$this->base_url/admin/eventsApproval.php");
  	$this->assertContains('Tapahtumien hyväksyminen', $this->findElement(".container h3")->getText());
  	
  	$this->findElement("table .dropdown-toggle")->click();
  	$this->waitAndClickElement("table .dropdown-menu li:first-child a");
  	
  	$this->assertContains('Tapahtumien hyväksyminen', $this->findElement(".container h3")->getText());
  	$this->waitAndClickElement("form button");
  	 
  	// Not localized:
  	$this->waitElementVisible(".alert-success");
  	$this->assertContains('Event was approved successfully.', $this->findElement(".alert-success")->getText());
  	
  	// Verify illusion update
  	 
  	$sentEmails = $this->getEmails();
  	$this->assertEquals(1, count($sentEmails));
  	$this->assertEmailPlainContains("Tapahtumasi on hyväksytty larp-kalenteriin sekä Forge & Illusionin tapahtumakalenteriin.", $sentEmails[0]->id);
  	$this->assertEmailPlainContains("http://kalenteri.larp.fi", $sentEmails[0]->id);
  	$this->assertEmailPlainContains("http://www.forgeandillusion.net/illusion/event/test_event", $sentEmails[0]->id);
  	$this->assertEmailPlainContains("Sinulle on luotu tunnukset Forge & Illusioniin.", $sentEmails[0]->id);
  	$this->assertEmailPlainContains("Sähköposti: " . $organizerEmail, $sentEmails[0]->id);
  	$this->assertEmailPlainContains("Salasana: " . $password, $sentEmails[0]->id);
  	 
  	$this->assertEmailRecipient($organizerEmail, $sentEmails[0]);
  	
  	$this->deleteAllEvents();
  }
  
  public function testApproveEventFnIComments() {
  	$this->loginAdmin();
  	
  	$name = "To be approved";
  	$type = "3"; // Conit ja miitit;
  	$typeREST = 2; 
  	$start = $this->getTimestamp(2015, 1, 1);
  	$end = $this->getTimestamp(2015, 1, 2);
  	$startREST = $this->getISODate(2015, 1, 1);
  	$endREST = $this->getISODate(2015, 1, 2);
  	$locationDropDown = "7"; // Lappi;
  	$location = "Testiö";
  	$infoDesc = "Event for testing modification";
  	$organizerEmail = "john.doe@example.com";
  	$password = "password";
  	$comments = "Comments from admins";
  	
  	// FnI API stubs
  	 
  	$this->stubAccessToken("fake-token");
  	$this->stubEventGenres();
  	$this->stubEventTypes();
    $this->stubEventUpdate(1234, $this->createEventJson(1234, 
      true, 
    	$name, 
    	$infoDesc,
    	$this->getISODate(2015, 1, 1), 
    	"test_event", 
    	"test_event@muc.example.com", 
    	"OPEN", 
    	null,
    	null, 
    	null, 
    	$location, 
    	null,
    	false, 
      null,
      $typeREST,
      null,
      null,
     	null,
    	$startREST, 
    	$endREST, 
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
  			"PENDING", 
  			$password, 
  			1234,
  			true);
  	
  	$eventId = $this->findEventIdByPasswordAndStatus($password, "PENDING");
  	
  	$this->assertEventName($eventId, $name);
  	$this->assertEventIllusionId($eventId, 1234);
  	
  	$this->webDriver->get("$this->base_url/admin/eventsApproval.php");
  	$this->assertContains('Tapahtumien hyväksyminen', $this->findElement(".container h3")->getText());
  	
  	$this->findElement("table .dropdown-toggle")->click();
  	$this->waitAndClickElement("table .dropdown-menu li:first-child a");
  	
  	$this->assertContains('Tapahtumien hyväksyminen', $this->findElement(".container h3")->getText());
  	$this->findElement("form textarea")->sendKeys($comments);
  	$this->waitAndClickElement("form button");
  	 
  	// Not localized:
  	$this->waitElementVisible(".alert-success");
  	$this->assertContains('Event was approved successfully.', $this->findElement(".alert-success")->getText());
  	
  	// Verify illusion update
  	 
  	$sentEmails = $this->getEmails();
  	$this->assertEquals(1, count($sentEmails));
  	$this->assertEmailPlainContains("Tapahtumasi on hyväksytty larp-kalenteriin sekä Forge & Illusionin tapahtumakalenteriin.", $sentEmails[0]->id);
  	$this->assertEmailPlainContains("http://kalenteri.larp.fi", $sentEmails[0]->id);
  	$this->assertEmailPlainContains("http://www.forgeandillusion.net/illusion/event/test_event", $sentEmails[0]->id);
  	$this->assertEmailPlainContains("Sinulle on luotu tunnukset Forge & Illusioniin.", $sentEmails[0]->id);
  	$this->assertEmailPlainContains("Sähköposti: " . $organizerEmail, $sentEmails[0]->id);
  	$this->assertEmailPlainContains("Salasana: " . $password, $sentEmails[0]->id);
  	$this->assertEmailPlainContains($comments, $sentEmails[0]->id);
  	 
  	$this->assertEmailRecipient($organizerEmail, $sentEmails[0]);
  	
  	$this->deleteAllEvents();
  }

  public function testApproveEventFnIExistingUser() {
  	$this->loginAdmin();
  	 
  	$name = "To be approved";
  	$type = "3"; // Conit ja miitit;
  	$typeREST = 2;
  	$start = $this->getTimestamp(2015, 1, 1);
  	$end = $this->getTimestamp(2015, 1, 2);
  	$startREST = $this->getISODate(2015, 1, 1);
  	$endREST = $this->getISODate(2015, 1, 2);
  	$locationDropDown = "7"; // Lappi;
  	$location = "Testiö";
  	$infoDesc = "Event for testing modification";
  	$organizerEmail = "john.doe@example.com";
  	$password = "password";
  	 
  	// FnI API stubs
  
  	$this->stubAccessToken("fake-token");
  	$this->stubEventGenres();
  	$this->stubEventTypes();
  	$this->stubEventUpdate(1234, $this->createEventJson(1234,
  			true,
  			$name,
  			$infoDesc,
  			$this->getISODate(2015, 1, 1),
  			"test_event",
  			"test_event@muc.example.com",
  			"OPEN",
  			null,
  			null,
  			null,
  			$location,
  			null,
  			false,
  			null,
  			$typeREST,
  			null,
  			null,
  			null,
  			$startREST,
  			$endREST,
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
  			"PENDING",
  			$password,
  			1234,
  			false);
  	 
  	$eventId = $this->findEventIdByPasswordAndStatus($password, "PENDING");
  	 
  	$this->assertEventName($eventId, $name);
  	$this->assertEventIllusionId($eventId, 1234);
  	 
  	$this->webDriver->get("$this->base_url/admin/eventsApproval.php");
  	$this->assertContains('Tapahtumien hyväksyminen', $this->findElement(".container h3")->getText());
  	 
  	$this->findElement("table .dropdown-toggle")->click();
  	$this->waitAndClickElement("table .dropdown-menu li:first-child a");
  	 
  	$this->assertContains('Tapahtumien hyväksyminen', $this->findElement(".container h3")->getText());
  	$this->waitAndClickElement("form button");
  
  	// Not localized:
  	$this->waitElementVisible(".alert-success");
  	$this->assertContains('Event was approved successfully.', $this->findElement(".alert-success")->getText());
  	 
  	// Verify illusion update
  
  	$sentEmails = $this->getEmails();
  	$this->assertEquals(1, count($sentEmails));
  	$this->assertEmailPlainContains("Tapahtumasi on hyväksytty larp-kalenteriin sekä Forge & Illusionin tapahtumakalenteriin.", $sentEmails[0]->id);
  	$this->assertEmailPlainContains("http://kalenteri.larp.fi", $sentEmails[0]->id);
  	$this->assertEmailPlainContains("http://www.forgeandillusion.net/illusion/event/test_event", $sentEmails[0]->id);
  	$this->assertEmailPlainNotContains("Sinulle on luotu tunnukset Forge & Illusioniin.", $sentEmails[0]->id);
  	$this->assertEmailPlainNotContains("Sähköposti: " . $organizerEmail, $sentEmails[0]->id);
  	$this->assertEmailPlainNotContains("Salasana: " . $password, $sentEmails[0]->id);
  	$this->assertEmailPlainContains("Tapahtuma on liitetty tiliin Forge & Illusion tiliisi $organizerEmail", $sentEmails[0]->id);
  	 
  	$this->assertEmailRecipient($organizerEmail, $sentEmails[0]);
  	 
  	$this->deleteAllEvents();
  }

  public function testApproveEvenModificationtFnI() {
  	$this->loginAdmin();
  	 
  	$name = "To be approved";
  	$type = "3"; // Conit ja miitit;
  	$typeREST = 2;
  	$start = $this->getTimestamp(2015, 1, 1);
  	$end = $this->getTimestamp(2015, 1, 2);
  	$startREST = $this->getISODate(2015, 1, 1);
  	$endREST = $this->getISODate(2015, 1, 2);
  	$locationDropDown = "7"; // Lappi;
  	$location = "Testiö";
  	$infoDesc = "Event for testing modification";
  	$organizerEmail = "john.doe@example.com";
  	$password = "password";
  	
  	$name_modified = "To be approved modf";
  	 
  	// FnI API stubs
  
  	$this->stubAccessToken("fake-token");
  	$this->stubEventGenres();
  	$this->stubEventTypes();
  	$this->stubEventUpdate(1234, $this->createEventJson(1234,
  			true,
  			$name,
  			$infoDesc,
  			$this->getISODate(2015, 1, 1),
  			"test_event",
  			"test_event@muc.example.com",
  			"OPEN",
  			null,
  			null,
  			null,
  			$location,
  			null,
  			false,
  			null,
  			$typeREST,
  			null,
  			null,
  			null,
  			$startREST,
  			$endREST,
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
  			null,
  			false);
  
  	$this->createEvent(
  			$name_modified,
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
  			"MODIFIED",
  			$password,
  			1234,
  			false);
  	 
  	$active_event_id = $this->findEventIdByPasswordAndStatus($password, "ACTIVE");
  	$modified_event_id = $this->findEventIdByPasswordAndStatus($password, "MODIFIED");

  	$this->assertEventName($active_event_id, $name);
  	$this->assertEventIllusionId($active_event_id, null);
  	$this->assertEventName($modified_event_id, $name_modified);
  	$this->assertEventIllusionId($modified_event_id, 1234);
  	 
  	$this->webDriver->get("$this->base_url/admin/eventsApproval.php");
  	$this->assertContains('Tapahtumien hyväksyminen', $this->findElement(".container h3")->getText());
  	 
  	$this->findElement("table .dropdown-toggle")->click();
  	$this->waitAndClickElement("table .dropdown-menu li:first-child a");
  	 
  	$this->assertContains('Tapahtumien hyväksyminen', $this->findElement(".container h3")->getText());
  	$this->waitAndClickElement("form button");
  
  	// Not localized:
  	$this->waitElementVisible(".alert-success");
  	$this->assertContains('Event was approved successfully.', $this->findElement(".alert-success")->getText());
  	 
  	// Verify illusion update
    
    $this->verifyPutRequest(1, '/fni/rest/illusion/events/1234', $this->createEventJson(1234,
    	true,
    	$name_modified, 
	    $infoDesc,
	    null,
	    null,
	    null,
	    "OPEN",
    	null,
	    null,
	    "EUR",
	    $location,
	    null,
	    false,
	    null,
	    $typeREST,
	    null,
	    null,
	    null,
	    $startREST,
	    $endREST,
	    [])
    );
    
  	$sentEmails = $this->getEmails();
  	$this->assertEquals(1, count($sentEmails));
  	$this->assertEmailPlainContains("Muokkaukset tapahtumaasi on hyväksytty larp-kalenteriin sekä Forge & Illusionin tapahtumakalenteriin.", $sentEmails[0]->id);
  	$this->assertEmailPlainContains("http://kalenteri.larp.fi", $sentEmails[0]->id);
  	$this->assertEmailPlainContains("http://www.forgeandillusion.net/illusion/event/test_event", $sentEmails[0]->id);
  	$this->assertEmailPlainNotContains("Sinulle on luotu tunnukset Forge & Illusioniin.", $sentEmails[0]->id);
  	$this->assertEmailPlainNotContains("Sähköposti: " . $organizerEmail, $sentEmails[0]->id);
  	$this->assertEmailPlainNotContains("Salasana: " . $password, $sentEmails[0]->id);
  	$this->assertEmailPlainContains("Tapahtuma on liitetty tiliin Forge & Illusion tiliisi $organizerEmail", $sentEmails[0]->id);
  	 
  	$this->assertEmailRecipient($organizerEmail, $sentEmails[0]);
  	 
  	$this->deleteAllEvents();
  }
}
?>