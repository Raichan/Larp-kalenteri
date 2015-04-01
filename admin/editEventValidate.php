<?php

require_once './../dat/controller.php';
require_once './../dat/cEvent.php';
require_once './../includes/emails.php';

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
        sendEmail($event->getOrganizerEmail(), "approved", $comment, $event->getEventName(), $event->getEventPassword());
        $ret = approveEvent($eventId);
        header("Location: eventsApproval.php?error=0");
    } else if ($action == "d") {
        sendEmail($event->getOrganizerEmail(), "denied", $comment, $event->getEventName(), $event->getEventPassword());
        $ret = deleteEvent($eventId);
        header("Location: eventsApproval.php?error=1");
    } else {
        header("Location: eventsApproval.php?error=2");
    }
} else {
    header("Location: eventsApproval.php?error=2");
    exit();
}


