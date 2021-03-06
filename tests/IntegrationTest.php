<?php

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../dat/config.php';

use WireMock\Client\WireMock;
use WireMock\Client\JsonValueMatchingStrategy;

class IntegrationTests extends PHPUnit_Framework_TestCase {
	
	protected $base_url = "http://kalenteri.larp.dev";
	protected $catchmail_url = 'http://127.0.0.1:1080';
	
	protected function createLocalWebDriver($capabilities) {
		return RemoteWebDriver::create("http://localhost:4444/wd/hub", $capabilities);
	}
	
	protected function createSauceLabsWebDriver($capabilities, $sauceUser, $sauceKey, $tunnelIdentifier, $buildNumber) {
		$capabilities->setCapability("tunnel-identifier", $tunnelIdentifier);
		$capabilities->setCapability("name", $this->getName());
		$capabilities->setCapability("build", $buildNumber);

		try {
		  return RemoteWebDriver::create("http://$sauceUser:$sauceKey@ondemand.saucelabs.com:80/wd/hub", $capabilities);
		} catch (Exception $e) {
			$this->fail($e->getMessage());
		}
		
		return null;
	}
	
	protected function createFnIWireMock() {
		$wireMock = WireMock::create("test.forgeandillusion.net", '8080');
		$wireMock->reset();
		$this->assertEquals($wireMock->isAlive(), true, "WireMock is not alive");
		return $wireMock;
	}

	protected function loginAdmin() {
		$username = "admin";
		$password = "password";
		 
		$this->webDriver->get("$this->base_url");
		$this->findElement(".dropdown-toggle")->click();
		$this->waitAndClickElement("a[href=\"login.php\"]");
		 
		$this->findElement("#exampleInputEmail1")->sendKeys($username);
		$this->findElement("#exampleInputPassword1")->sendKeys($password);
		$this->findElement("button")->click();
		 
		$this->assertEquals("Admin User", $this->findElement(".dropdown a")->getText());
	}
	
	protected function waitAndClickElement($selector) {
		$this->waitElementVisible($selector);
		$this->findElement($selector)->click();
	}
	
	protected function waitElementVisible($selector) {
		$this->webDriver->wait()->until(function ($webDriver) use ($selector) {
			$elements = $webDriver->findElements(WebDriverBy::cssSelector($selector));
			if (count($elements) > 0) {
				return $elements[0]->isDisplayed();
			}
	
			return false;
		});
	}
	
	protected function verifyPostRequest($count, $url, $body) {
		try {
			$this->wireMock->verify($count, WireMock::postRequestedFor(WireMock::urlMatching($url))->withRequestBody(WireMock::equalToJson($body)));
		} catch (Exception $e) {
			$loggedRequests = $this->wireMock->findAll(WireMock::postRequestedFor(WireMock::urlMatching($url)));
			foreach ($loggedRequests as $logged) {
				$requestBody = $logged->getBody();
				$this->assertEquals($body, $requestBody, "requrest body did not match expected body");
			}
		}
	}
	
	protected function verifyPutRequest($count, $url, $body) {
		try {
			$this->wireMock->verify($count, WireMock::putRequestedFor(WireMock::urlMatching($url))->withRequestBody(WireMock::equalToJson($body)));
		} catch (Exception $e) {
			$loggedRequests = $this->wireMock->findAll(WireMock::putRequestedFor(WireMock::urlMatching($url)));
			foreach ($loggedRequests as $logged) {
				$requestBody = $logged->getBody();
				$this->assertEquals($body, $requestBody, "requrest body did not match expected body");
			}
		}
	}
	
	protected function getISODate($year, $month, $day) {
		return (new DateTime())
		->setTimezone(new DateTimeZone("UTC"))
		->setDate($year, $month, $day)
		->setTime(0, 0, 0)
		->format('c');
	}
	
	protected function getTimestamp($year, $month, $day) {
		return (new DateTime())
		->setTimezone(new DateTimeZone("UTC"))
		->setDate($year, $month, $day)
		->setTime(0, 0, 0)
		->getTimestamp();
	}
	
	protected function getUIDate($year, $month, $day) {
		return (new DateTime())
		->setTimezone(new DateTimeZone("UTC"))
		->setDate($year, $month, $day)
		->setTime(0, 0, 0)
		->format('d/m/Y');
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
						->withBody('[{"id":1,"name":"Larpit"},{"id":2,"name":"Conit ja miitit"},{"id":3,"name":"Kurssit ja työpajat"},{"id":4,"name":"Muut"}]')
				)
		);
	}
	
	protected function stubEventGenres() {
		$this->wireMock->stubFor(WireMock::get(WireMock::urlEqualTo('/fni/rest/illusion/genres'))
				->willReturn(WireMock::aResponse()
						->withStatus(200)
						->withHeader('Content-Type', 'application/json')
						->withBody('[{"id":1,"name":"Fantasia"},{"id":2,"name":"Sci-fi"},{"id":3,"name":"Cyberpunk"},{"id":4,"name":"Steampunk"},{"id":5,"name":"Post-apokalyptinen"},{"id":6,"name":"Historiallinen"},{"id":7,"name":"Jännitys"},{"id":8,"name":"Kauhu"},{"id":9,"name":"Realismi"},{"id":10,"name":"Kaupunkipeli"},{"id":11,"name":"Uuskumma"},{"id":12,"name":"Toiminta"},{"id":13,"name":"Draama"},{"id":14,"name":"Huumori"}]')
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
	
	protected function stubEventUpdate($id, $body) {
		$this->wireMock->stubFor(WireMock::put(WireMock::urlEqualTo('/fni/rest/illusion/events/' . $id))
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
	
	protected function stubEventParticipantCreate($eventId, $body) {
		$this->wireMock->stubFor(WireMock::post(WireMock::urlEqualTo("/fni/rest/illusion/events/$eventId/participants"))
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
	
	protected function createEventJson($id, $published, $name, $description, $created, $urlName, $xmppRoom, $joinMode,
			$signUpFeeText, $signUpFee, $signUpFeeCurrency, $location, $ageLimit, $beginnerFriendly, $imageUrl, $typeId, $signUpStartDate, $signUpEndDate,
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
				'signUpFeeText' => $signUpFeeText,
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
	
	protected function createUserJson($id, $firstName, $lastName, $nickname, $locale, $emails) {
		return json_encode([
				'id' => $id,
				'firstName' => $firstName,
				'lastName' => $lastName,
				'nickname' => $nickname,
				'locale' => $locale,
				'emails' => array($emails)
		]);
	}
	
	protected function createEventParticipantJson($id, $userId, $role, $displayName) {
		return json_encode([
				'id' => $id,
				'userId' => $userId,
				'role' => $role,
				'displayName' => $displayName
		]);
	}
	
	protected function deleteAllEvents() {
		$dbconn = $this->getDatabaseConnection();
		pg_query("delete from events") or die('Query failed: ' . pg_last_error());
		pg_close($dbconn);
	}
	
	protected function createEvent($name, $type, $start, $end, $dateText, $signUpStart, $signUpEnd, $locationDropDown, $location,
			    $iconUrl, $genre, $cost, $ageLimit, $beginnerFriendly, $eventFull, $invitationOnly, $languageFree, $storyDescription, 
			  	$infoDescription, $organizerName, $organizerEmail, $link1, $link2, $status, $password, $illusionId, $fniUserCreated) {
		$dbconn = $this->getDatabaseConnection();
		
		$result = pg_query_params(
		  "insert into events (
		     eventName, eventType, startDate, endDate, dateTextField, startSignupTime, endSignupTime,
			   locationDropDown, locationTextField, iconUrl, genre, cost, ageLimit, beginnerFriendly, eventFull,
				 invitationOnly, languageFree, storyDescription, infoDescription, organizerName, organizerEmail,
				 link1, link2, status, password, illusionId, fniUserCreated)
		   values ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, $16, $17, $18, $19, $20, $21, $22, $23, $24, $25, $26, $27)",
				array($name, $type, $start, $end, $dateText, $signUpStart, $signUpEnd, $locationDropDown, $location, $iconUrl, $genre, $cost, 
					$ageLimit, $beginnerFriendly ? "true" : "false", $eventFull ? "true" : "false", $invitationOnly ? "true" : "false", $languageFree ? "true" : "false", 
					$storyDescription, $infoDescription, $organizerName, $organizerEmail, $link1, $link2, $status, $password, $illusionId, $fniUserCreated ? "true" : "false")
		)  or die('Query failed: ' . pg_last_error());		
				
		pg_close($dbconn);
	}
	
	protected function findEventIdByPasswordAndStatus($password, $status) {
		$dbconn = $this->getDatabaseConnection();
		$result = pg_query_params("select id from events where password = $1 and status = $2", [$password, $status]) or die('Query failed: ' . pg_last_error());
		pg_close($dbconn);
		$row = pg_fetch_assoc($result);
		return intval($row['id']);
	}
	
	protected function findEventNameById($eventId) {
		$dbconn = $this->getDatabaseConnection();
		$result = pg_query_params("select eventname from events where id = $1", [$eventId]) or die('Query failed: ' . pg_last_error());
		pg_close($dbconn);
		$row = pg_fetch_assoc($result);
		return $row['eventname'];
	}
	
	protected function findEventIllusionIdById($eventId) {
		$dbconn = $this->getDatabaseConnection();
		$result = pg_query_params("select illusionId from events where id = $1", [$eventId]) or die('Query failed: ' . pg_last_error());
		pg_close($dbconn);
		$row = pg_fetch_assoc($result);
		return empty($row['illusionid']) ? null : intval($row['illusionid']);
	}

	protected function listAdminMails() {
		$emails = [];
		
		$dbconn = $this->getDatabaseConnection();
		$result = pg_query("select email from admins") or die('Query failed: ' . pg_last_error());
		pg_close($dbconn);
		
		while ($row = pg_fetch_assoc($result)) {
			$emails[] = $row['email'];
		}
		
		return $emails;
	}
	
	protected function assertEventName($eventId, $name) {
		$this->assertEquals($name, $this->findEventNameById($eventId));
	}
	
	protected function assertEventIllusionId($eventId, $illusionId) {
		$this->assertEquals($illusionId, $this->findEventIllusionIdById($eventId));
	}
	
	private function getDatabaseConnection() {
		$d = "host=" . DB_SERVER . " port=" . DB_PORT . " dbname=" . DB_DATABASE . " user=" . DB_USER . " password=" . DB_PASSWORD;
		$dbconn = pg_connect($d) or die('Could not connect to DB: ' . pg_last_error());
		return $dbconn;
	}
	
	protected function getEmails() {
		$client = new GuzzleHttp\Client([
			'base_url' => $this->catchmail_url
	  ]);
		
		$jsonResponse = $client->get('/messages');
		return json_decode($jsonResponse->getBody());
	}
	
	protected function clearEmails() {
		$client = new GuzzleHttp\Client([
			'base_url' => $this->catchmail_url
	  ]);
		
		$client->delete('/messages');
	}
	
	protected function getEmailPlain($emailId) {
		$client = new GuzzleHttp\Client([
		  'base_url' => $this->catchmail_url
		]);
		
		return $client->get('/messages/' . $emailId . '.plain')->getBody()->getContents();
	}
	
	protected function getEmailHtml($emailId) {
		$client = new GuzzleHttp\Client([
				'base_url' => $this->catchmail_url
		]);
		
		return $client->get('/messages/' . $emailId . '.html')->getBody()->getContents();
	}
	
	protected function assertEmailHtmlContains($text, $emailId) {
		$this->assertContains($text, $this->getEmailHtml($emailId));
	}
	
	protected function assertEmailPlainContains($text, $emailId) {
		$this->assertContains($text, $this->getEmailPlain($emailId));
	}
	
	protected function assertEmailPlainNotContains($text, $emailId) {
		$this->assertNotContains($text, $this->getEmailPlain($emailId));
	}
	
	protected function assertEmailRecipient($recipient, $email) {
		foreach ($email->recipients as $emailRecipient) {
			if (preg_match("/.*<$recipient>/", $emailRecipient) == 1) {
				return;
			}
		}
		
		$this->fail("$recipient was not a recipient of email " . $email->id);
	}
	
}



?>