<?php

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function create_random_password($length = 8) {
    $all_characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $pw = substr(str_shuffle($all_characters), 0, $length);
    return $pw;
}

function redirect($url)
{
    $string = '<script type="text/javascript">';
    $string .= 'window.location = "' . $url . '"';
    $string .= '</script>';

    echo $string;
}

function dateToTimestampstring($date)
{
	$parts = explode("/", $date);
	$timestamp = getTimeStamp($parts[1], $parts[0], $parts[2]);
	return strval($timestamp);
}

// DELETE THIS AFTERWARDS
function debug_to_console($data) {

    if (is_array($data))
        $output = "<script>console.log( 'Debug Objects: " . implode(',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}

// Define variables and set to empty values
$nameErr = $dateErr = $signupErr = $locaErr = $iconErr = $costErr = $infoErr = $orgEmailErr = $web1Err = $web2Err = "";
$eventname = $eventtype = $datestart = $dateend = $datetext = $signupstart = $signupend = $location1 = $location2 = $icon = $genrestring = $cost = $agelimit = $beginnerfriendly = $storydesc = $infodesc = $organizername = $organizeremail = $website1 = $website2 = $status = $password = "";
$genre = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid = true; // Are there errors in the form?

    if (empty($_POST["eventname"])) {
        $nameErr = " Name is required";
        $valid = false;
    } else {
        $eventname = test_input($_POST["eventname"]);
    }

    $eventtype = test_input($_POST["eventtype"]);

    if (empty($_POST["datestart"])) {
        if (empty($_POST["datetext"])) {
            $dateErr = "Start date is required";
            $valid = false;
        } else {
            $datetext = test_input($_POST["datetext"]);
        }
    } else {
        $datestart = test_input($_POST["datestart"]);
        if (!preg_match("/(\b\d{2}\/\d{2}\/\d{4}\b)/", $datestart)) {
            $dateErr = "Invalid date";
            $valid = false;
        }
    }

    if (empty($_POST["dateend"])) {
        $dateend = "";
    } else if (empty($_POST["datetext"])) {
        $dateend = test_input($_POST["dateend"]);
        if (!preg_match("/(\b\d{2}\/\d{2}\/\d{4}\b)/", $dateend)) {
            $dateErr = "Invalid date";
            $valid = false;
        }
    }
    // FIX: Prevent signup being after the event
    if (empty($_POST["signupstart"]) xor empty($_POST["signupend"])) {
        $dateErr = "Please enter both dates";
        $valid = false;
    } else if (!empty($_POST["signupstart"]) and !empty($_POST["signupend"])) {
        $signupstart = test_input($_POST["signupstart"]);
        $signupend = test_input($_POST["signupend"]);
        if (!preg_match("/(\b\d{2}\/\d{2}\/\d{4}\b)/", $signupstart) or !preg_match("/(\b\d{2}\/\d{2}\/\d{4}\b)/", $signupend)) {
            $signupErr = "Invalid date";
            $valid = false;
        }
    }

    if (empty($_POST["location2"])) {
        $locaErr = " Location is required";
        $valid = false;
    } else {
        $location1 = test_input($_POST["location1"]);
        $location2 = test_input($_POST["location2"]);
    }

    if (empty($_POST["icon"])) {
        $icon = "";
    } else {
        $icon = test_input($_POST["icon"]);
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $icon)) {
            $iconErr = " Invalid icon URL";
            $valid = false;
        }
    }

    if (empty($_POST["genre"])) {
        $genre = "";
    } else {
        $genre = $_POST["genre"];
    }
    if (empty($_POST["cost"])) {
        $cost = "";
    } else {
        $cost = test_input($_POST["cost"]);
        if (!preg_match("/(\d+(-(\d+))?)/", $cost)) { // Not sure about this
            $costErr = " Invalid cost";
            $valid = false;
        }
    }

    $agelimit = test_input($_POST["agelimit"]);

    if (empty($_POST["beginnerfriendly"])) {
        $beginnerfriendly = "";
    } else {
        $beginnerfriendly = test_input($_POST["beginnerfriendly"]);
    }

    if (empty($_POST["storydesc"])) {
        $storydesc = "";
    } else {
        $storydesc = test_input($_POST["storydesc"]);
    }

    if (empty($_POST["infodesc"])) {
        $infoErr = " Description is required";
        $valid = false;
    } else {
        $infodesc = test_input($_POST["infodesc"]);
    }

    if (empty($_POST["organizername"])) {
        $organizername = "";
    } else {
        $organizername = test_input($_POST["organizername"]);
    }

    if (empty($_POST["organizeremail"])) {
        $orgEmailErr = " Organizer email is required";
        $valid = false;
    } else {
        $organizeremail = test_input($_POST["organizeremail"]);
        if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $organizeremail)) {
            $orgEmailErr = " Invalid email";
            $valid = false;
        }
    }

    if (empty($_POST["website1"])) {
        $website1 = "";
    } else {
        $website1 = test_input($_POST["website1"]);
        if (!preg_match("/^(https?:\/\/)?(www\.)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/", $website1)) {
            $web1Err = " Invalid URL";
            $valid = false;
        }
    }

    if (empty($_POST["website2"])) {
        $website2 = "";
    } else {
        $website2 = test_input($_POST["website2"]);
        if (!preg_match("/^(https?:\/\/)?(www\.)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/", $website2)) {
            $web2Err = " Invalid URL";
            $valid = false;
        }
    }
	
    if ($valid) { // Form is valid, add the event to the database
		if($datestart != "") {
			$datestart = dateToTimestampstring($datestart);
		}
		if($dateend != "") {
			$dateend = dateToTimestampstring($dateend);
		}
		if($signupstart != "") {
			$signupstart = dateToTimestampstring($signupstart);
		}
		if($signupend != "") {
			$signupend = dateToTimestampstring($signupend);
		}
	
        $eventname = pg_escape_string($eventname);
        $eventtype = pg_escape_string($eventtype);
		$datestart = pg_escape_string($datestart);
		$dateend = pg_escape_string($dateend);
        $datetext = pg_escape_string($datetext);
		$signupstart = pg_escape_string($signupstart);
		$signupend = pg_escape_string($signupend);
        $location1 = pg_escape_string($location1);
        $location2 = pg_escape_string($location2);
        $icon = pg_escape_string($icon);
		if(!empty($genre)){
			$genrestring = implode(', ', $genre);
        }
		$cost = pg_escape_string($cost);
        $agelimit = pg_escape_string($agelimit);
        $beginnerfriendly = pg_escape_string($beginnerfriendly);
        if ($beginnerfriendly == "") {
            $beginnerfriendly = "false";
        }
        $storydesc = pg_escape_string($storydesc);
        $infodesc = pg_escape_string($infodesc);
        $organizername = pg_escape_string($organizername);
        $organizeremail = pg_escape_string($organizeremail);
        $website1 = pg_escape_string($website1);
        $website2 = pg_escape_string($website2);
        if ($proceedurl == "modifySuccess.php") {
            $status = "MODIFIED";
        } else {
            $status = "PENDING";
        }
		
        $password = create_random_password();
        // FIX: If we wanted to be super sure about everything we should check if the password already exists. The chances are super low, but anyway.

        $query = "INSERT INTO events(eventName, eventType, startDate, endDate, dateTextField, startSignupTime, endSignupTime, locationDropDown, locationTextField, iconUrl, genre, cost, ageLimit, beginnerFriendly, storyDescription, infoDescription, organizerName, organizerEmail, link1, link2, status, password) VALUES('" . $eventname . "', '" . $eventtype . "', '" . $datestart . "', '" . $dateend . "','" . $datetext . "', '" . $signupstart . "', '" . $signupend . "', '" . $location1 . "', '" . $location2 . "', '" . $icon . "', '" . $genrestring . "', '" . $cost . "', '" . $agelimit . "', '" . $beginnerfriendly . "', '" . $storydesc . "', '" . $infodesc . "', '" . $organizername . "', '" . $organizeremail . "', '" . $website1 . "', '" . $website2 . "', '" . $status . "', '" . $password . "')";
        $result = dbQuery($query);
        
        if ($result) {
			// Sending all admins an email notification
			include(__DIR__ . "/emails.php");
			
			$adminquery = "SELECT * FROM admins;";
			$admins = dbQuery($adminquery);
			while($result = pg_fetch_assoc($admins)){
				sendEmail($result['email'], "admin");
			}
			
			// And then move on to the success page
			redirect($proceedurl);
        }
    }
}
?>