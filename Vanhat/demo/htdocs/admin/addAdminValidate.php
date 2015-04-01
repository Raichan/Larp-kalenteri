<?php

/* Function which searches for provided username in database
 * if exists, return true, else return false.
 */

function usernameExists($username) {
    require_once ('./../dat/connectDB.php');
    $query = "SELECT username FROM ADMINS where username = '" . $username . "';";
    $result = dbQuery($query);
    if ($result != null) {
        $rows = pg_num_rows($result);
        if ($rows > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        return null;
    }
}

/* Function which inserts data to database table admins */

function insertAdminToDB($name, $surname, $email, $username, $password) {
    require_once ('./../dat/connectDB.php');
    $query = "INSERT INTO admins (username, password, name, surname, email) values ("
            . "'" . $username . "', "
            . "'" . $password . "', "
            . "'" . $name . "', "
            . "'" . $surname . "', "
            . "'" . $email . "'"
            . ");";
    $result = dbQuery($query);
    if ($result != null) {
        return true;
    } else {
        return false;
    }
}

/* Check if data were posted, otherwise assign blank string. */
if (isset($_POST["name"])) {
    $name = $_POST["name"];
} else {
    $name = "";
}

if (isset($_POST["surname"])) {
    $surname = $_POST["surname"];
} else {
    $surname = "";
}

if (isset($_POST["email"])) {
    $email = $_POST["email"];
} else {
    $email = "";
}

if (isset($_POST["username"])) {
    $username = $_POST["username"];
} else {
    $username = "";
}

/* Check if all the mandatory data were provided. */
if (!empty($_POST["name"]) && !empty($_POST["surname"]) && !empty($_POST["email"]) &&
        !empty($_POST["username"]) && !empty($_POST["password1"]) &&
        !empty($_POST["password2"]) && !empty($_POST["password1"]) && !empty($_POST["password2"])) {
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];
    $username = $_POST["username"];
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    /* Check all the data provided if they are ok. */

    /* TODO */

    /* Check if username already exists in the database. */
    if (usernameExists($username)) {
        header("Location: accountManagement.php?error=2&name=$name&surname=$surname&email=$email&username=$username");
        exit();
    }

    /* Check if passwords match. */
    if ($password1 != $password2) {
        header("Location: accountManagement.php?error=3&name=$name&surname=$surname&email=$email&username=$username");
        exit();
    }
    
    /* Check if password is long enough. */
    if (strlen($password1) < 5) {
        header("Location: accountManagement.php?error=33&name=$name&surname=$surname&email=$email&username=$username");
        exit();
    }

    /* Insert record to database. */
    if (insertAdminToDB($name, $surname, $email, $username, $password1)) {
        header("Location: accountManagement.php?error=0");
        exit();
    } else {
        header("Location: accountManagement.php?error=4&name=$name&surname=$surname&email=$email&username=$username");
        exit();
    }
} else {
    header("Location: accountManagement.php?error=1&name=$name&surname=$surname&email=$email&username=$username");
    exit();
}