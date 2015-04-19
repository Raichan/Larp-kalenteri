<?php

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/events.php';

use RestService\Server;
use RestService\Client;

class APIClient extends Client {
	
	public function asPlainJSON($pMessage) {
		if ($pMessage['status'] == 200) {
			return $this->asJSON($pMessage['data']);
		} 

		$message = isset($pMessage['message']) ? $pMessage['message'] : null;
		return $message != null ? $message : $this->asJSON($pMessage);
	}
	
}

$eventsAPI = new Events();
$server = Server::create('/events', $eventsAPI)
  ->setDebugMode(true)
  ->setHttpStatusCodes(true)
  ->addPostRoute("", 'createEvent')
  ->addGetRoute('', 'listEvents')
  ->addGetRoute('([0-9]{1,})', 'findEvent')
  ->addPutRoute('([0-9]{1,})', 'updateEvent')
  ->addDeleteRoute('([0-9]{1,})', 'deleteEvent');
$eventsAPI->setServer($server);

$client = new APIClient($server);
$client->setFormat("plain-json");
$client->addOutputFormat("plain-json", "asPlainJSON");
$server->setClient($client);

$server->run();
    
?>