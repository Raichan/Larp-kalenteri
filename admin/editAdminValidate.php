<?php

require_once './../dat/controller.php';

/* Check if data were posted, otherwise assign blank string. */
if (isset($_POST["action"])) {
    $action = $_POST["action"];
} else {
    $action = "";
}

if (isset($_POST["adminId"])) {
    $adminId = $_POST["adminId"];
} else {
    $adminId = "";
}

/* Get cEvent object according to ID provided */
$admin = getCadminObject($adminId);
if ($admin != null) {
    if ($action == "m") {
        /* Check if data were posted, otherwise assign blank string. */
        if (isset($_POST["currentPassword"])) {
            $currentPassword = $_POST["currentPassword"];
        } else {
            $currentPassword = "";
        }
        if (isset($_POST["newPassword1"])) {
            $newPassword1 = $_POST["newPassword1"];
        } else {
            $newPassword1 = "";
        }
        if (isset($_POST["newPassword2"])) {
            $newPassword2 = $_POST["newPassword2"];
        } else {
            $newPassword2 = "";
        }

        /* Check if password is long enough. */
        if (strlen($newPassword1) < 5) {
            header("Location: accountManagement.php?error=66&action=m&adminId=$adminId");
            exit();
        }

        $ret = modifyAdmin($adminId, $currentPassword, $newPassword1, $newPassword2);
        if ($ret == true) {
            header("Location: accountManagement.php?error=7");
        } else if ($ret == false) {
            header("Location: accountManagement.php?error=8&action=m&adminId=$adminId");
        } else {
            header("Location: accountManagement.php?error=4");
        }
    } else if ($action == "d") {
        /* Check if data were posted, otherwise assign blank string. */
        if (isset($_POST["password"])) {
            $password = $_POST["password"];
        } else {
            $password = "";
        }
        $ret = deleteAdmin($adminId, $password);
        if ($ret == true) {
            header("Location: accountManagement.php?error=5");
        } else if ($ret == false) {
            header("Location: accountManagement.php?error=6");
        } else {
            header("Location: accountManagement.php?error=4");
        }
    } else {
        header("Location: accountManagement.php?error=4");
    }
} else {
    header("Location: accountManagement.php?error=4");
    exit();
}


