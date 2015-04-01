<?php
function getEventId($pass) {
    require_once (__DIR__ . '/dat/connectDB.php');
    $query = "SELECT id FROM events WHERE password = $1 and status = 'ACTIVE';";
	$params = array($pass);
    $result = dbQueryP($query, $params);
	if ($result != null) {
        if (!$result || pg_num_rows($result) <= 0) {
            return null;
        } else {
            $row = pg_fetch_row($result);
			$eventid = $row[0];
			return $eventid;
        }
    } else {
        return null;
    }
}

if (!empty($_POST["password"])) {
    $password = trim($_POST["password"]);
	$id = getEventId($password);
	if($id == null){
		header("Location: modifyPassword.php?error=1");
	}
	else{
		// Submitting the correct event id via post to keep the system a bit more secure than just giving the id as url parameter
		echo("
		<form id='modifyform' action='modifyEvent.php' data-remote='true' method='post'>
			<input type='hidden' id='modifyid' name='modifyid' value='" . $id . "'/>
		</form>
		<script>document.getElementById('modifyform').submit();</script>");
	}
} else {
    header("Location: modifyPassword.php?error=2");
}

?>