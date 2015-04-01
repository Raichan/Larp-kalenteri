<?php

if (file_exists('./dat/connectDB.php')) {
    require_once ('./dat/connectDB.php');
} else {
    require_once ('./../dat/connectDB.php');
}

if ($eventId != null) {
    if (file_exists('./dat/controller.php')) {
        require_once ('./dat/controller.php');
    } else {
        require_once ('./../dat/controller.php');
    }

    $query = "select * from events where id = $eventId;";
    $resultAll = dbQuery($query);
    $result = pg_fetch_assoc($resultAll);
    include("eventInfo.php");
}