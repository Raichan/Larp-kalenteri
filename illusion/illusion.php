<?php

  require __DIR__ . '/../vendor/autoload.php';
  require_once __DIR__ . '/config.php';
  
  class FnIClient {
  	
  	private $base_url;
  	private $client_id;
  	private $client_secret;
  	private $client;
  	
  	public function __construct($base_url, $client_id, $client_secret) {
  		$this->base_url = $base_url;
  		$this->client_id = $client_id;
  		$this->client_secret = $client_secret;
  		
  		$handler = new GuzzleHttp\Ring\Client\StreamHandler();
  		
  		$oauth2Client = new GuzzleHttp\Client([
  		  'handler' => $handler,
  		  'base_url' => "$this->base_url/"
  		]);
  		
  		$config = [
  		  'client_id' => $this->client_id,
  			'client_secret' => $this->client_secret
  		];
  		
  		$token = new CommerceGuys\Guzzle\Oauth2\GrantType\ClientCredentials($oauth2Client, $config);
  		$refreshToken = new CommerceGuys\Guzzle\Oauth2\GrantType\RefreshToken($oauth2Client, $config);
  		$oauth2 = new CommerceGuys\Guzzle\Oauth2\Oauth2Subscriber($token, $refreshToken);
  		$this->client = new GuzzleHttp\Client([
  		  'handler' => $handler,
  			'defaults' => [
  			  'auth' => 'oauth2',
  				'subscribers' => [$oauth2]
  			]
  		]);
  	}
  	
  	public function createEvent($published, $name, $description, $urlName, $joinMode, $signUpFeeText, $signUpFee, $signUpFeeCurrency, $location, $ageLimit, $beginnerFriendly, $imageUrl, $typeId, $signUpStartDate, $signUpEndDate, $domain, $start, $end, $genreIds) {
  		$event = array(
  			'id' => null,
  			'published' => $published,
  			'name' => $name,
  			'description' => $description,
  			'created' => null,
  			"urlName" => empty($urlName) ? null : $urlName,
  			'xmppRoom' => null,
  			'joinMode' => $joinMode,
  			'signUpFeeText' => empty($signUpFeeText) ? null : $signUpFeeText,
  			"signUpFee" => empty($signUpFee) ? null : $signUpFee,
  			"signUpFeeCurrency" => empty($signUpFeeCurrency) ? null : $signUpFeeCurrency,
  			"location" => empty($location) ? null : $location,
  			"ageLimit" => empty($ageLimit) ? null : intval($ageLimit),
  			'beginnerFriendly' => $beginnerFriendly,
  			"imageUrl" => empty($imageUrl) ? null : $imageUrl,
  			'typeId' => $typeId,
  			'signUpStartDate' => $signUpStartDate ? $signUpStartDate->format('c') : null,
  			'signUpEndDate' => $signUpEndDate ? $signUpEndDate->format('c') : null,
  			"domain" => empty($domain) ? null : $domain,
  			'start' => $start->format('c'),
  			'end' => $end->format('c'),
  			'genreIds' => $genreIds
  		);
  		
  		$response = $this->getClient()->post("$this->base_url/rest/illusion/events", [
  	    'json' => $event
  		]);
  		
  		if ($response->getStatusCode() == 200) {
  			return $response->json();
  		}
  		
  		return null;
  	}
  	
  	public function updateEvent($id, $published, $name, $description, $urlName, $joinMode, $signUpFeeText, $signUpFee, $signUpFeeCurrency, $location, $ageLimit, $beginnerFriendly, $imageUrl, $typeId, $signUpStartDate, $signUpEndDate, $domain, $startDate, $endDate, $genreIds) {
  		$event = array(
  		  "id" => $id,
  			"published" => $published,
  			"name" => $name,
  			"description" => $description,
  			"created" => null,
  			"urlName" => empty($urlName) ? null : $urlName,
  			"xmppRoom" => null,
  			"joinMode" => $joinMode,
  		  'signUpFeeText' => empty($signUpFeeText) ? null : $signUpFeeText,
  			"signUpFee" => empty($signUpFee) ? null : $signUpFee,
  			"signUpFeeCurrency" => empty($signUpFeeCurrency) ? null : $signUpFeeCurrency,
  		  "location" => empty($location) ? null : $location,
  			"ageLimit" => empty($ageLimit) ? null : intval($ageLimit),
  			"beginnerFriendly" => $beginnerFriendly,
  			"imageUrl" => empty($imageUrl) ? null : $imageUrl,
  			"typeId" => $typeId,
  			"signUpStartDate" => $signUpStartDate != null ? $signUpStartDate->format('c') : null,
  			"signUpEndDate" => $signUpEndDate != null ? $signUpEndDate->format('c') : null,
  			"domain" => empty($domain) ? null : $domain,
  			"start" => $startDate->format('c'),
  			"end" => $endDate->format('c'),
  			"genreIds" => $genreIds
  		);
  		
  		$response = $this->getClient()->put("$this->base_url/rest/illusion/events/$id", [
  	    'json' => $event
  		]);
  		
  	  if ($response->getStatusCode() == 200) {
  			return $response->json();
  		} else if ($response->getStatusCode() == 204) {
  			return $event;
  		}
  		
  		return null;
  	}
  	
  	public function getIllusionGenreIds($genres) {
  		$result = [];
  		
  		$genres = array_filter($genres);
  		if (empty($genres)) {
  			return $result;
  		}

  		$genreIdMap = $this->getIllusionGenreMap();
  		
  		foreach ($this->getGenreNames($genres) as $genreName) {
  			$genreId = $genreIdMap[$genreName];
  			if (!$genreId) {
  				throw new Exception("genreId for $genreName could not be found from genreMap: " . var_export($genreIdMap, true));
  			}
  			
  			$result[] = $genreId;
  		}
  		
  		return $result;
  	}
  	
  	public function getIllusionTypeId($type) {
  		return $this->getIllusionTypeMap()[$this->getTypeName($type)];
  	}
  	
  	public function findUserByEmail($email) {
  		$response = $this->getClient()->get("$this->base_url/rest/users/users", [
    		'query' => ['email' => $email]
			]);
  		
  		if ($response->getStatusCode() == 200) {
  			return $response->json()[0];
  		}
  		
  		return null;
  	}
  	
  	public function createUser($email, $firstName, $lastName, $locale, $password) {
  		$response = $this->getClient()->post("$this->base_url/rest/users/users", [
  			'json' => [
  				'id' => null,
  				'firstName' => $firstName,
  				'lastName' => $lastName,
  				'nickname' => null,
  				'locale' => $locale,
  		    'emails' => [ $email ]
  			],
  		  'query' => [
  		    'generateCredentials' => false,
  		  	'sendCredentials' => false,
  		  	'password' => $password	
  		  ]
  		]);
  		
  		if ($response->getStatusCode() == 200) {
  			return $response->json();
  		}
  		
  		return null;
  	}
  	
  	public function createEventParticipant($eventId, $userId, $role) {
  		$response = $this->getClient()->post("$this->base_url/rest/illusion/events/$eventId/participants", [
  		  'json' => [
  				'id' => null,
					'userId' => $userId,
					'role' => $role,
		  	  'displayName' => null
  			]
  		]);
  	
  		if ($response->getStatusCode() == 200) {
  			return $response->json();
  		}
  	
  		return null;
  	}
  	
  	private function listIllusionGenres() {
  		$response = $this->getClient()->get("$this->base_url/rest/illusion/genres");
  		
  		if ($response->getStatusCode() == 200) {
  			return $response->json();
  		}
  		
  		return null;
  	}
  	
  	private function getIllusionGenreMap() {
  		$result = [];
  		
  	  foreach ($this->listIllusionGenres() as $illusionGenre) {
  	  	$result[$illusionGenre['name']] = $illusionGenre['id'];
  		}
  		
  		return $result;
  	}

  	private function getGenreNames($genres) {
  		$result = [];
  		
  		foreach ($genres as $genre) {
  			$result[] = $this->getGenreName(trim($genre));
  		}
  		
  		return $result;
  	}
  	
  	private function getGenreName($genre) {
  		$event_genres = getEventGenres();
  		
  		foreach ($event_genres as $event_genre) {
  			if ($event_genre['id'] == $genre) {
  				return $event_genre['name']['fi'];
  			}
  		}
  		
  		throw new Exception("Could not resolve genre name for genre id $genre from genres " . var_export($event_genres, true));
  	}
  	
  	private function listIllusionTypes() {
  		$response = $this->getClient()->get("$this->base_url/rest/illusion/types");
  		
  		if ($response->getStatusCode() == 200) {
  			return $response->json();
  		}
  		
  		return null;
  	}
  	
  	private function getIllusionTypeMap() {
  		$result = [];
  		
  	  foreach ($this->listIllusionTypes() as $illusionType) {
  	  	$result[$illusionType['name']] = $illusionType['id'];
  		}
  		
  		return $result;
  	}
  	
  	private function getTypeName($type) {
  		foreach (getEventTypes() as $event_type) {
  			if ($event_type['id'] == $type) {
  				return $event_type['name']['fi'];
  			}
  		}
  		
  		return null;
   	}

  	private function getClient() {
  		return $this->client;
  	}
  	
  }
  
  class IllusionController {

  	private static $instance;
  	 
  	public static function getInstance() {
  		if ( is_null( self::$instance ) ) {
  			self::$instance = new self();
  		}
  	
  		return self::$instance;
  	}
  	
  	private $client;
  	 
  	public function __construct() {
  		$this->client = new FnIClient(FNI_BASE_URL, FNI_CLIENT_ID, FNI_CLIENT_SECRET);
  	}
  	
  	public function findUserByEmail($email) {
  		return $this->client->findUserByEmail($email);
  	}
  	
  	public function createEvent($eventData) {
  		$typeId = $this->client->getIllusionTypeId($eventData['type']);
  		$genreIds = $this->client->getIllusionGenreIds($eventData['genres']);
  		
  		$illusionEvent = $this->client->createEvent(
  		  $eventData['status'] == 'ACTIVE',
  			$eventData['name'],
  			$eventData['infoDescription'],
  			null,
  			$eventData['invitationOnly'] ? 'INVITE_ONLY' : 'OPEN',
  			$eventData['cost'],
  			null,
  			'EUR',
  			$eventData['location'],
  			$eventData['ageLimit'],
  			$eventData['beginnerFriendly'],
  			$eventData['iconURL'],
  			$typeId,
  			$eventData['signUpStart'],
  			$eventData['signUpEnd'],
  			null,
  			$eventData['start'],
  			$eventData['end'],
  			$genreIds
  	  );

  		$illusionEventId = $illusionEvent['id'];
  		$user = $this->findUserByEmail($eventData['organizerEmail']);
  		if (!$user) {
  			// user does not yet exist on the Forge & Illusion so we create new with given password
  		
  			$firstName = $lastName = null;
  			if ($eventData['organizerName']) {
  				$nameArray = explode(' ', $eventData['organizerName'], 2);
  				if (count($nameArray) == 2) {
  					$firstName = $nameArray[0];
  					$lastName = $nameArray[1];
  				} else {
  					$firstName = $nameArray[0];
  				}
  			}
  		
  			$locale = "fi";
  			if (isset($_COOKIE["language"])){
  				$locale = $_COOKIE["language"];
  			}
  		
  			$user = $this->client->createUser($eventData['organizerEmail'], $firstName, $lastName, $locale, $eventData['password']);
  		}
  		 
  		$participant = $this->client->createEventParticipant($illusionEventId, $user['id'], "ORGANIZER");
  		
  		return $illusionEvent;
  	}
  	
  	public function updateEvent($eventData) {
  		if ($eventData['illusionId']) {
  			$typeId = $this->client->getIllusionTypeId($eventData['type']);
  			$genreIds = $this->client->getIllusionGenreIds($eventData['genres']);
  	
  			return $this->client->updateEvent($eventData['illusionId'],
  					$eventData['status'] == 'ACTIVE',
  					$eventData['name'],
  					$eventData['infoDescription'],
  					null,
  					$eventData['invitationOnly'] ? 'INVITE_ONLY' : 'OPEN',
  					$eventData['cost'],
  					null,
  					'EUR',
  					$eventData['location'],
  					$eventData['ageLimit'],
  					$eventData['beginnerFriendly'],
  					$eventData['iconURL'],
  					$typeId,
  					$eventData['signUpStart'],
  					$eventData['signUpEnd'],
  					null,
  					$eventData['start'],
  					$eventData['end'],
  					$genreIds
  			);
  		}
  		
  		return null;
  	}
  }

  function getIllusionController() {
  	return IllusionController::getInstance();
  }

?>