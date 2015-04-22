<?php

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../dat/config.php';

use WireMock\Client\WireMock;
use WireMock\Client\JsonValueMatchingStrategy;

class IntegrationTest extends PHPUnit_Framework_TestCase {

	protected $base_url = "http://kalenteri.larp.dev";
	protected $catchmail_url = 'http://127.0.0.1:1080';
	
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
		   values ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, $16, $17, $18, $19, $20, $21, $22, $23, $24, $25, $26, $27) returning id",
				array($name, $type, $start, $end, $dateText, $signUpStart, $signUpEnd, $locationDropDown, $location, $iconUrl, $genre, $cost, 
					$ageLimit, $beginnerFriendly ? "true" : "false", $eventFull ? "true" : "false", $invitationOnly ? "true" : "false", $languageFree ? "true" : "false", 
					$storyDescription, $infoDescription, $organizerName, $organizerEmail, $link1, $link2, $status, $password, $illusionId, $fniUserCreated ? "true" : "false")
		)  or die('Query failed: ' . pg_last_error());		
				
		pg_close($dbconn);
		
		$row = pg_fetch_assoc($result);
		return intval($row['id']);
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
	
	protected function createOAuthClient($name, $client_id, $client_secret) {
		$dbconn = $this->getDatabaseConnection();
		
		$result = pg_query_params(
		  "insert into oauth_clients 
			   (name, client_id, client_secret)
		   values ($1, $2, $3)",
				array($name, $client_id, $client_secret)
		)  or die('Query failed: ' . pg_last_error());		
				
		pg_close($dbconn);
	}
	
	protected function deleteOAuthClient($client_id) {
		$dbconn = $this->getDatabaseConnection();

		pg_query_params("delete from oauth_access_tokens where session_id = (select id from oauth_sessions where client_id = (select id from oauth_clients where client_id = $1))", array($client_id)) or die('Query failed: ' . pg_last_error());
		pg_query_params("delete from oauth_sessions where client_id = (select id from oauth_clients where client_id = $1)", array($client_id)) or die('Query failed: ' . pg_last_error());
		pg_query_params("delete from oauth_clients where client_id = $1", array($client_id)) or die('Query failed: ' . pg_last_error());
		
		pg_close($dbconn);
	}
	
}



?>