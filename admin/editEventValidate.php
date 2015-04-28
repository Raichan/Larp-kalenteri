<?php

require_once './../dat/controller.php';
require_once './../dat/cEvent.php';
require_once './../includes/emails.php';
require_once __DIR__ . '/../illusion/illusion.php';
require_once __DIR__ . '/../includes/mailer.php';

/* Check if data were posted, otherwise assign blank string. */
if (isset($_POST["action"])) {
    $action = $_POST["action"];
} else {
    $action = "";
}

/* Check if data were posted, otherwise assign blank string. */
if (isset($_POST["eventId"])) {
    $eventId = $_POST["eventId"];
} else {
    $eventId = "";
}

/* Check if data were posted, otherwise assign blank string. */
if (isset($_POST["comment"])) {
    $comment = $_POST["comment"];
} else {
    $comment = "";
}

/* Get cEvent object according to ID provided */
$event = getCeventObject($eventId);
if ($event != null) {
    if ($action == "a") {
      $event_data = getEventData($eventId);
      $original_id = $event_data['status'] == 'MODIFIED' ? getEventIdByPasswordAndStatus($event_data['password'], "ACTIVE") : null;
      
      $ret = approveEvent($eventId);
      
      if ($original_id == null) {
        $fni_event = getIllusionController()->updateEvent($event_data);
      } else {
      	$fni_event = getIllusionController()->updateEvent(getEventData($original_id));
      }
      
      if ($fni_event != null) {
    		$fni_user_created = getEventFnIUserCreatedByEventId($event_data['id']);
    		$recipient = [ 'mail' => $event_data['organizerEmail'], 'name' => $event_data['organizerName']];
    		
    	  (new Mailer())->sendApprovedFnI(
    	  	 $recipient, 
    	  	 $original_id != null,
    	  	 "http://larp.kalenteri.fi", 
    	  	 "http://www.forgeandillusion.net/illusion/event/" . $fni_event['urlName'], 
    	  	 $event_data['organizerEmail'], 
    	  	 $event_data['password'], 
    	  	 $fni_user_created, 
    	  	 $comment);
    	  
    	  updateEventFnIUserCreated($eventId, false);
    	} else {
    	  sendEmail($event_data['organizerEmail'], "approved", $comment, $event_data['name'], $event_data['password']);
    	}
    	
      header("Location: eventsApproval.php?error=0");
    } else if ($action == "d") {
        sendEmail($event_data['organizerEmail'], "denied", $comment, $event_data['name'], $event_data['password']);
        $ret = deleteEvent($eventId);
        header("Location: eventsApproval.php?error=1");
    } else {
        header("Location: eventsApproval.php?error=2");
    }
} else {
    header("Location: eventsApproval.php?error=2");
    exit();
}


