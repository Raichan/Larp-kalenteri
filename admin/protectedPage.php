<?php

/* Function checks if the session variable exists in the web browser. */

function checkLogin() {
    session_start();
    if (empty($_SESSION["id"])) {
        return false;
    } else {
        return true;
    }
}

/* If the checkLogin returns false, redirection to login page is done. */

if (!checkLogin()) {
    header("Location: /login.php?error=3");
    exit;
}
