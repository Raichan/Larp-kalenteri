<?php

  require __DIR__ . '/../vendor/autoload.php';
  require_once __DIR__ . '/config.php';
  
  class IllusionEventController {
  	
  	private $base_url;
  	private $client_id;
  	private $client_secret;
  	
  	public function __construct($base_url, $client_id, $client_secret) {
  		$this->base_url = $base_url;
  		$this->client_id = $client_id;
  		$this->client_secret = $client_secret;
  	}
  	
  	public function createEvent($published, $name, $description, $urlName, $joinMode, $signUpFeeText, $signUpFee, $signUpFeeCurrency, $location, $ageLimit, $beginnerFriendly, $imageUrl, $typeId, $signUpStartDate, $signUpEndDate, $domain, $start, $end, $genreIds) {
  		$event = array(
  			'id' => null,
  			'published' => $published,
  			'name' => $name,
  			'description' => $description,
  			'created' => null,
  			'urlName' => $urlName,
  			'xmppRoom' => null,
  			'joinMode' => $joinMode,
  			'signUpFeeText' => $signUpFeeText,
  			'signUpFee' => $signUpFee,
  			'signUpFeeCurrency' => $signUpFeeCurrency,
  			'location' => $location,
  			'ageLimit' => empty($ageLimit) ? null : $ageLimit,
  			'beginnerFriendly' => $beginnerFriendly,
  			'imageUrl' => empty($imageUrl) ? null : $imageUrl,
  			'typeId' => $typeId,
  			'signUpStartDate' => $signUpStartDate ? $signUpStartDate->format('c') : null,
  			'signUpEndDate' => $signUpEndDate ? $signUpEndDate->format('c') : null,
  			'domain' => $domain,
  			'start' => $start->format('c'),
  			'end' => $end->format('c'),
  			'genreIds' => $genreIds
  		);
  		
  		$response = $this->createClient()->post("$this->base_url/rest/illusion/events", [
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
  			"urlName" => $urlName,
  			"joinMode" => $joinMode,
  		  'signUpFeeText' => $signUpFeeText,
  			"signUpFee" => $signUpFee,
  			"signUpFeeCurrency" => $signUpFeeCurrency,
  		  "location" => $location,
  			"ageLimit" => $ageLimit,
  			"beginnerFriendly" => $beginnerFriendly,
  			"imageUrl" => $imageUrl,
  			"typeId" => $typeId,
  			"signUpStartDate" => $signUpStartDate->format('c'),
  			"signUpEndDate" => $signUpEndDate->format('c'),
  			"domain" => $domain,
  			"start" => $startDate->format('c'),
  			"end" => $endDate->format('c'),
  			"genreIds" => $genreIds
  		);
  		
  		$response = $this->createClient()->put("$this->base_url/rest/illusion/events/$id", [
  	    'json' => $event
  		]);
  		
  		if ($response->getStatusCode() == 204) {
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
  				throw new Exception("genreId for '$genreName' could not be found.");
  			}
  			
  			$result[] = $genreId;
  		}
  		
  		return $result;
  	}
  	
  	public function getIllusionTypeId($type) {
  		return $this->getIllusionTypeMap()[$this->getTypeName($type)];
  	}
  	
  	public function findUserByEmail($email) {
  		$response = $this->createClient()->get("$this->base_url/rest/users/users", [
    		'query' => ['email' => $email]
			]);
  		
  		if ($response->getStatusCode() == 200) {
  			return $response->json()[0];
  		}
  		
  		return null;
  	}
  	
  	public function createUser($email, $firstName, $lastName, $locale, $password) {
  		$response = $this->createClient()->post("$this->base_url/rest/users/users", [
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
  		$response = $this->createClient()->post("$this->base_url/rest/illusion/events/$eventId/participants", [
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
  		$response = $this->createClient()->get("$this->base_url/rest/illusion/genres");
  		
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
  			$result[] = $this->getGenreName($genre);
  		}
  		
  		return $result;
  	}
  	
  	private function getGenreName($genre) {
  		// TODO: This mapping should be in database 
  		switch (trim($genre)) {
  			case "fantasy":
  			  return "Fantasia";
  			case "sci-fi":
	  		case "scifi":
	  			return "Sci-fi";
  			case "cyberpunk":
  				return "Cyberpunk";
  			case "steampunk":
  				return "Steampunk";
  			case "post-apocalyptic":
  			case "postapo":
  				return "Post-apokalyptinen";
  			case "historical":
  				return "Historiallinen";
  			case "thriller":
  				return "Jännitys";
  			case "horror":
  				return "Kauhu";
  			case "reality":
  				return "Realismi";
  			case "city larp":
  			case "city":
  				return "Kaupunkipeli";
  			case "new weird":
  			case "newweird":
  				return "Uuskumma";
  			case "action":
  				return "Toiminta";
  			case "drama":
  				return "Draama";
  			case "humor":
  				return "Huumori";
  		}
  		
  		return null;
  	}
  	
  	private function listIllusionTypes() {
  		$response = $this->createClient()->get("$this->base_url/rest/illusion/types");
  		
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
  		// TODO: This mapping should be in database
  		switch ($type) {
        case "2": 
        	return "Larpit";
        case "3": 
        	return "Conit ja miitit";
        case "4": 
        	return "Kurssit ja työpajat";
        case "5": 
        	return "Muut";
  		}
  		
  		return null;
   	}

  	private function createClient() {
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
  		$client = new GuzzleHttp\Client([
  		  'handler' => $handler,
  			'defaults' => [
  				'auth' => 'oauth2',
  				'subscribers' => [$oauth2]
 				]
  		]);
  		
  		return $client;
  	}
  	
  }
  
  function getIllusionClient() {
  	return new IllusionEventController(FNI_BASE_URL, FNI_CLIENT_ID, FNI_CLIENT_SECRET);
  }
  

?>