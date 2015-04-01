<?php

/**
 * Function, which creates connection with database.
 * 
 * @return Link for database connection.
 */
function dbConnect() {
    require_once(__DIR__ . "/config.php");
    $link = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
    if (!$link) {
        exit();
    }
    $select = mysql_select_db(DB_DATABASE, $link);
    if (!$select) {
        exit();
    }
    mysql_set_charset('utf8', $link);
    return $link;
}

/**
 * Function, which terminates database connection.
 *
 * @param Link to database connection.
 */
function dbClose($link) {
    mysql_close($link);
}
