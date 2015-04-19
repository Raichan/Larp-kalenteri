<?php

require_once __DIR__ . '/api.php';
require_once __DIR__ . '/model.php';
require_once __DIR__ . '/../dat/controller.php';

class Events {
	
	private $server;
	
	public function __construct() {
	  
	}
	
	public function setServer($server) {
		$this->server = $server;
	}
	
	public function createEvent() {
	}
	
	public function listEvents($status) {
		$result = [];
		
		$event_ids = null;
		if (isset($status)) {
			$event_ids = getEventIdsByStatus($status);
		} else {
			$event_ids = getEventIds();
		}
		
		foreach ($event_ids as $event_id) {
			$result[] = Event::fromEventData(getEventData($event_id))->toObject();
		}
		
		return $result;
	}
	
	public function findEvent($id) {
		$event_data = getEventData($id);
		$event = $event_data != null ? Event::fromEventData($event_data)->toObject() : null;
		
		if ($event) {
			return $event;
		} else {
			$this->sendNotFound();
		}
	}
	
	public function updateEvent($id) {
		
	}
	
	public function deleteEvent($id) {
		
	}
	
	private function sendNotFound() {
		$this->server->getClient()->sendResponse(404, array('error' => 404, 'message' => "Not Found"));
	}

}
?>