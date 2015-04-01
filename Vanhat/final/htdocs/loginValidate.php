<?php

global $_SESSION;

function checkLoginIntoDB($user, $pass) {
    require_once (__DIR__ . '/dat/connectDB.php');
    $query = "SELECT username, password FROM ADMINS WHERE username = '$user' and password = '$pass';";
    $result = dbQuery($query);
    if ($result != null) {
        if (!$result || pg_num_rows($result) <= 0) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

function getAdminObject($username) {
    require_once (__DIR__ . '/dat/connectDB.php');
    require_once (__DIR__ . '/dat/cAdmin.php');
    $query = "SELECT id, name, surname, email, username FROM ADMINS WHERE username = '$username';";
    $result = dbQuery($query);
    if ($result != null) {
        $row = pg_fetch_row($result);
        $admin = new cAdmin($row[0], $row[1], $row[2], $row[3], $row[4]);
        return $admin;
    } else {
        return null;
    }
}

if (!empty($_POST["username"]) || !empty($_POST["password"])) {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    if (checkLoginIntoDB($username, $password)) {
        /* Create new object of class cAdmin of the logged user. */
        $admin = getAdminObject($username);
        /* Start session and set its identifiactors. */
        session_start();
        $_SESSION["valid"] = true;
        $_SESSION["id"] = $admin->getID();
        $_SESSION["name"] = $admin->getNAME() . " " . $admin->getSURNAME();
        header("Location: ./admin/index.php");
    } else {
        header("Location: login.php?error=1");
    }
} else {
    header("Location: login.php?error=2");
}

