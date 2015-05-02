<?php

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../dat/config.php';
require_once __DIR__ . '/IntegrationTest.php';

use WireMock\Client\WireMock;
use WireMock\Client\JsonValueMatchingStrategy;

class UITest extends IntegrationTest {
	
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
	
}



?>