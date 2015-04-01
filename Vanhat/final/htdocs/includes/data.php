<?php

global $AD;
$AD = 0;

$pageId = NULL;
if (isset($_GET['pageId'])) {
    /* Get page id. */
    $pageId = $_GET['pageId'];
} else {
    /* Else setup default page id. */
    $pageId = 0;
}

if (isset($_GET['date'])) {
    /* Get date. */
    $date = $_GET['date'];
} else {
    /* Else setup current date. */
    $date = strtotime(date("Y-m"));
}

if (isset($_GET['eventId'])) {
    /* Get event ID. */
    $eventId = $_GET['eventId'];
} else {
    /* Else no event ID required. */
    $eventId = null;
}

if (isset($_GET['eventName'])) {
    /* Get event ID. */
    $eventName = $_GET['eventName'];
} else {
    /* Else no event ID required. */
    $eventName = null;
}

if (isset($_GET['moreInfo'])) {
    /* Get more info value. */
    $moreInfo = $_GET['moreInfo'];
} else {
    /* Else set more info value to null. */
    $moreInfo = null;
}

if (isset($_GET["error"])) {
    /* Get error value. */
    $error = $_GET["error"];
} else {
    /* Else set error value to null. */
    $error = -1;
}

/* Get previous and next dates - moving between months in the calendar. */
$prevDate = getPreviousDate($date);
$nextDate = getNextDate($date);
