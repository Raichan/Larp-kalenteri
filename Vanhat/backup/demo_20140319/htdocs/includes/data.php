<?php

if (isset($_GET['date'])) {
    /* Get passed date. */
    $date = $_GET['date'];
} else {
    /* Else setup current date. */
    $date = strtotime(date("Y-m"));
}

/* Get previous and next dates - moving between months in the calendar. */
$prevDate = getPreviousDate($date);
$nextDate = getNextDate($date);
