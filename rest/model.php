<?php

class Event {
	
	private $id;
	private $name;
	private $type;
	private $start;
	private $end;
	private $textDate;
	private $signUpStart;
	private $signUpEnd;
	private $location;
	private $iconURL;
	private $genres;
	private $cost;
	private $ageLimit;
	private $beginnerFriendly;
	private $storyDescription;
	private $infoDescription;
	private $organizerName;
	private $organizerEmail;
	private $link1;
	private $link2;
	private $status;
	private $password;
	private $eventFull;
	private $invitationOnly;
	private $languageFree;
	private $illusionId;
	
	public function __construct() {
		
	}
	
	public function parseJSON($json) {
		$assoc = json_decode($json, true);
		
		foreach ($assoc AS $key => $value) {
			$this->{$key} = $value;
		};
	}
	
	public function getId() {
		return $this->id;
	}
	
	private function setId($id) {
		$this->id = $id;
	}
	
	public function getName() {
		return $this->name;
	}
	
	private function setName($name) {
		$this->name = $name;
	}

	public function getType() {
		return $this->type;
	}
	
	private function setType($type) {
		$this->type = $type;
	}
	
	public function getStart() {
		return $this->start;
	}
	
	private function setStart($start) {
		$this->start = $start;
	}
	
	public function getEnd() {
		return $this->end;
	}
	
	private function setEnd($end) {
		$this->end = $end;
	}
	
	public function getTextDate() {
		return $this->textDate;
	}
	
	private function setTextDate($textDate) {
		$this->textDate = $textDate;
	}
	
	public function getSignUpStart() {
		return $this->signUpStart;
	}
	
	private function setSignUpStart($signUpStart) {
		$this->signUpStart = $signUpStart;
	}
	
	public function getSignUpEnd() {
		return $this->signUpEnd;
	}
	
	private function setSignUpEnd($signUpEnd) {
		$this->signUpEnd = $signUpEnd;
	}
	
	public function getLocation() {
		return $this->location;
	}
	
	private function setLocation($location) {
		$this->location = $location;
	}
	
	public function getIconURL() {
		return $this->iconURL;
	}
	
	private function setIconURL($iconURL) {
		$this->iconURL = $iconURL;
	}
	
	public function getGenres() {
		return $this->genres;
	}
	
	private function setGenres($genres) {
		$this->genres = $genres;
	}
	
	public function getCost() {
		return $this->cost;
	}
	
	private function setCost($cost) {
		$this->cost = $cost;
	}	
	
	public function getAgeLimit() {
		return $this->ageLimit;
	}
	
	private function setAgeLimit($ageLimit) {
		$this->ageLimit = $ageLimit;
	}
	
	public function getBeginnerFriendly() {
		return $this->beginnerFriendly;
	}
	
	private function setBeginnerFriendly($beginnerFriendly) {
		$this->beginnerFriendly = $beginnerFriendly;
	}
		
	public function getStoryDescription() {
		return $this->storyDescription;
	}
	
	private function setStoryDescription($storyDescription) {
		$this->storyDescription = $storyDescription;
	}
	public function getInfoDescription() {
		return $this->infoDescription;
	}
	
	private function setInfoDescription($infoDescription) {
		$this->infoDescription = $infoDescription;
	}
	
	public function getOrganizerName() {
		return $this->organizerName;
	}
	
	private function setOrganizerName($organizerName) {
		$this->organizerName = $organizerName;
	}
	
	public function getOrganizerEmail() {
		return $this->organizerEmail;
	}
	
	private function setOrganizerEmail($organizerEmail) {
		$this->organizerEmail = $organizerEmail;
	}
	
	public function getLink1() {
		return $this->link1;
	}
	
	private function setLink1($link1) {
		$this->link1 = $link1;
	}
	
	public function getLink2() {
		return $this->link2;
	}
	
	private function setLink2($link2) {
		$this->link2 = $link2;
	}
	
	public function getStatus() {
		return $this->status;
	}
	
	private function setStatus($status) {
		$this->status = $status;
	}
	
	public function getPassword() {
		return $this->password;
	}
	
	private function setPassword($password) {
		$this->password = $password;
	}
	
  public function getEventFull() {
		return $this->eventFull;
	}
	
	private function setEventFull($eventFull) {
		$this->eventFull = $eventFull;
	}
	
	public function getInvitationOnly() {
		return $this->invitationOnly;
	}
	
	private function setInvitationOnly($invitationOnly) {
		$this->invitationOnly = $invitationOnly;
	}
	
	public function getLanguageFree() {
		return $this->languageFree;
	}
	
	private function setLanguageFree($languageFree) {
		$this->languageFree = $languageFree;
	}
	
	public function getIllusionId() {
		return $this->illusionId;
	}
	
	private function setIllusionId($illusionId) {
		$this->illusionId = $illusionId;
	}
	
	public function toObject() {
		return get_object_vars($this);
	}
	
	public static function fromEventData($event_data) {
		$event = new Event();
		
		$event->setId($event_data['id']);
		$event->setName($event_data['name']);
		$event->setType($event_data['type']);
		$event->setStart($event_data['start']);
		$event->setEnd($event_data['end']);
		$event->setTextDate($event_data['textDate']);
		$event->setSignUpStart($event_data['signUpStart']);
		$event->setSignUpEnd($event_data['signUpEnd']);
		$event->setLocation($event_data['location']);
		$event->setIconURL($event_data['iconURL']);
		$event->setGenres($event_data['genres']);
		$event->setCost($event_data['cost']);
		$event->setAgeLimit($event_data['ageLimit']);
		$event->setBeginnerFriendly($event_data['beginnerFriendly']);
		$event->setStoryDescription($event_data['storyDescription']);
		$event->setInfoDescription($event_data['infoDescription']);
		$event->setOrganizerName($event_data['organizerName']);
		$event->setOrganizerEmail($event_data['organizerEmail']);
		$event->setLink1($event_data['link1']);
		$event->setLink2($event_data['link2']);
		$event->setStatus($event_data['status']);
		$event->setPassword($event_data['password']);
		$event->setEventFull($event_data['eventFull']);
		$event->setInvitationOnly($event_data['invitationOnly']);
		$event->setLanguageFree($event_data['languageFree']);
		$event->setIllusionId($event_data['illusionId']);
		
		return $event;
	}
	
	public static function fromJSON($json) {
		$event = new Event();
		$event->parseJSON($json);
		return $event;	
  }
	
}

?>