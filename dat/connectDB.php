<?php

function dbQuery($query) {
    require_once(__DIR__ . "/config.php");

    // Connecting, selecting database
    $d = "host=" . DB_SERVER . " port=" . DB_PORT . " dbname=" . DB_DATABASE . " user=" . DB_USER . " password=" . DB_PASSWORD;
    $dbconn = pg_connect($d) or die('Could not connect to DB: ' . pg_last_error());
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());

    if (!$result) {
        // In case of failure return null
        return null;
    } else {
        // Closing connection
        pg_close($dbconn);

        // Return the obtained result
        return $result;
    }
}

function dbQueryP($query, $params) {
    require_once(__DIR__ . "/config.php");

    // Connecting, selecting database
    $d = "host=" . DB_SERVER . " port=" . DB_PORT . " dbname=" . DB_DATABASE . " user=" . DB_USER . " password=" . DB_PASSWORD;
    $dbconn = pg_connect($d) or die('Could not connect to DB: ' . pg_last_error());
    $result = pg_query_params($query, $params) or die('Query failed: ' . pg_last_error());

    if (!$result) {
        // In case of failure return null
        return null;
    } else {
        // Closing connection
        pg_close($dbconn);

        // Return the obtained result
        return $result;
    }
}