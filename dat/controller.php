<?php

//==============================================================================
// DATE FUNCTIONS
//==============================================================================

function getNextDate($date) {
    return strtotime('+1 month', $date);
}

function getPreviousDate($date) {
    return strtotime('-1 month', $date);
}

function getMonthAndYearString($date) {
    $monthyear = date(("F"), $date) . " " . date(("Y"), $date);
	
	// I know it's ugly, I'm sorry
	if (!isset($_COOKIE["language"]) || (isset($_COOKIE["language"]) && $_COOKIE["language"] != "en")){
		$monthyear = str_replace("January","Tammikuu",$monthyear);
		$monthyear = str_replace("February","Helmikuu",$monthyear);
		$monthyear = str_replace("March","Maaliskuu",$monthyear);
		$monthyear = str_replace("April","Huhtikuu",$monthyear);
		$monthyear = str_replace("May","Toukokuu",$monthyear);
		$monthyear = str_replace("June","Kesäkuu",$monthyear);
		$monthyear = str_replace("July","Heinäkuu",$monthyear);
		$monthyear = str_replace("August","Elokuu",$monthyear);
		$monthyear = str_replace("September","Syyskuu",$monthyear);
		$monthyear = str_replace("October","Lokakuu",$monthyear);
		$monthyear = str_replace("November","Marraskuu",$monthyear);
		$monthyear = str_replace("December","Joulukuu",$monthyear);
	}
	return $monthyear;
}

function isCurrentDay($day, $month, $year) {
    if ($day == intval(date("d")) && $month == intval(date("m")) && $year == intval(date("Y"))) {
        return true;
    } else {
        return false;
    }
}

/* Function which returns a timestamp for specific date given by arguments - be carefull about the order! */

function getTimeStamp($month, $day, $year) {
    // Just brutally add 3 hours to fix the time zone problem
    return mktime(0, 0, 0, $month, $day, $year) + 10800;
}

/* Function which returns a date from a timestamp in a form of dd/mm/YYYY */

function getDateFromTimestamp($timestamp) {
    // In case the timestamp is empty
    if ($timestamp == "") {
        return $timestamp;
    }
    // but if it isn't
    else {
        return date("d/m/Y", intval($timestamp));
    }
}

//==============================================================================
// EVENTS FUNCTIONS
//==============================================================================

/* Function, which gets last 3 ACTIVE upcoming events. */

function getUpcomingEvents() {
    if (file_exists('./dat/connectDB.php')) {
        require_once ('./dat/connectDB.php');
    } else {
        require_once ('./../dat/connectDB.php');
    }
    if (file_exists('./dat/cEvent.php')) {
        require_once ('./dat/cEvent.php');
    } else {
        require_once ('./../dat/cEvent.php');
    }
    $now = time();
    $query = "SELECT * FROM events where (status = 'active' or status = 'ACTIVE') and (startdate >= '$now') order by startdate limit 3;";
    $result = dbQuery($query);
    $newEvents = array();
    if ($result != null) {
        for ($i = 0; $i < 3; $i++) {
            $row = pg_fetch_row($result);
            $newEvents[] = new cEvent($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]
                    , $row[7], $row[8], $row[9], $row[10], $row[11], $row[12], $row[13]
                    , $row[14], $row[15], $row[16], $row[17], $row[18], $row[19], $row[20], $row[21], $row[22]);
        }
        return $newEvents;
    } else {
        return null;
    }
}

/* Function which gets number of ACTIVE events in database for certain date. */

function getNumberOfEventsInDay($month, $day, $year) {
    if (file_exists('./dat/connectDB.php')) {
        require_once ('./dat/connectDB.php');
    } else {
        require_once ('./../dat/connectDB.php');
    }
    $date = getTimeStamp($month, $day, $year);
    $query = "SELECT count(*) FROM events where ('" . $date . "' between startdate and enddate or '" . $date . "' = startdate) and (status = 'active' or status = 'ACTIVE');";
    $result = dbQuery($query);
    if ($result != null) {
        $rows = pg_fetch_row($result);
        $rows = $rows[0];
        return $rows;
    } else {
        return null;
    }
}

function getListOfEvents($month, $day, $year) {
    if (file_exists('./dat/connectDB.php')) {
        require_once ('./dat/connectDB.php');
    } else {
        require_once ('./../dat/connectDB.php');
    }
    $date = getTimeStamp($month, $day, $year);
    $query = "SELECT id FROM events where ('" . $date . "' between startdate and enddate or '" . $date . "' = startdate) and (status = 'active' or status = 'ACTIVE');";
    $result = dbQuery($query);
    if ($result != null) {
        $rows = pg_num_rows($result);
        if ($rows > 0) {
            for ($i = 0; $i < $rows; $i++) {
                $a = pg_fetch_row($result);
                $list[] = $a[0];
            }
            return $list;
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function getEventIdByPassword($password) {
	require_once (__DIR__ . '/connectDB.php');
	
	$result = dbQueryP('select id from events where password = $1', [$password]);
	
	if ($result) {
		$row = pg_fetch_assoc($result);
  	return intval($row['id']);
	}
	
	return null;
}

function getEventIllusionIdByEventId($id) {
	require_once (__DIR__ . '/connectDB.php');
	
	$result = dbQueryP('select illusionId from events where id = $1', [$id]);
	
	if ($result) {
		$row = pg_fetch_assoc($result);
  	return intval($row['illusionid']);
	}
	
	return null;
}

function updateEventIllusionId($eventId, $illusionEventId) {
	require_once (__DIR__ . '/connectDB.php');
	dbQueryP("update events set illusionId = $1 where id = $2", array($illusionEventId, $eventId));
}

function getEventFnIUserCreatedByEventId($id) {
	require_once (__DIR__ . '/connectDB.php');

	$result = dbQueryP('select fniusercreated from events where id = $1', [$id]);

	if ($result) {
		$row = pg_fetch_assoc($result);
		return $row['fniusercreated'] == "t";
	}

	return false;
}

function updateEventFnIUserCreated($eventId, $fniUserCreated) {
	require_once (__DIR__ . '/connectDB.php');
	dbQueryP("update events set fniUserCreated = $1 where id = $2", array($fniUserCreated ? 't' : 'f', $eventId));
}

function strToDate($str) {
	if (empty($str)) {
		return null;
	}

	return (new DateTime())
	->setTimezone(new DateTimeZone("UTC"))
	->setTimestamp(intval($str))
	->setTime(0, 0, 0);
}

function getEventData($id) {
	require_once (__DIR__ . '/connectDB.php');
	
	$result = dbQueryP(
			"select
			  id, eventName, eventType, startDate, endDate, dateTextField, startSignupTime, endSignupTime,
			  locationDropDown, locationTextField, iconUrl, genre, cost, ageLimit, beginnerFriendly, eventFull,
				invitationOnly, languageFree, storyDescription, infoDescription, organizerName, organizerEmail,
				link1, link2, status, password, illusionId
			from
			  events
			where
			  id = $1",array($id));
	
	if ($result) {
		$row = pg_fetch_assoc($result);
		
		return [
		  'id' => intval($row['id']),
			'name' => $row['eventname'],
			'type' => intval($row['eventtype']),
			'start' => strToDate($row['startdate']),
			'end' => strToDate($row['enddate']),
			'textDate' => $row['datetextfield'],			
			'signUpStart' => strToDate($row['startsignuptime']),
			'signUpEnd' => strToDate($row['endsignuptime']),
			'location' => $row['locationtextfield'],
			'iconURL' => $row['iconurl'],
			'genres' => $row['genre'] ? explode(",", $row['genre']) : [],
			'cost' => $row['cost'],
			'ageLimit' => $row['agelimit'],
			'beginnerFriendly' => $row['beginnerfriendly'] == 't',
			'storyDescription' => $row['storydescription'],
			'infoDescription' => $row['infodescription'],
			'organizerName' => $row['organizername'],
			'organizerEmail' => $row['organizeremail'],
			'link1' => $row['link1'],
			'link2' => $row['link2'],
			'status' => $row['status'],
			'password' => $row['password'],
			'eventFull' => $row['eventfull'] == 't',
			'invitationOnly' => $row['invitationonly'] == 't',
			'languageFree' => $row['languagefree'] == 't',
			'illusionId' => empty($row['illusionid']) ? null : intval($row['illusionid'])
		];
	}
	
	return null;
}

function getCeventObject($id) {
	if (file_exists ( './dat/connectDB.php' )) {
		require_once ('./dat/connectDB.php');
	} else {
		require_once ('./../dat/connectDB.php');
	}
	if (file_exists ( './dat/cEvent.php' )) {
		require_once ('./dat/cEvent.php');
	} else {
		require_once ('./../dat/cEvent.php');
	}
	$query = "SELECT * FROM events WHERE id = '$id';";
	$result = dbQuery ( $query );
	if ($result != null) {
		$row = pg_fetch_row ( $result );
		$event = new cEvent ( $row [0], $row [1], $row [2], $row [3], $row [4], $row [5], $row [6], $row [7], $row [8], $row [9], $row [10], $row [11], $row [12], $row [13], $row [14], $row [15], $row [16], $row [17], $row [18], $row [19], $row [20], $row [21], $row [22] );
		return $event;
	} else {
		return null;
	}
}

function getListOfEventsForApproval() {
    if (file_exists('./dat/connectDB.php')) {
        require_once ('./dat/connectDB.php');
    } else {
        require_once ('./../dat/connectDB.php');
    }
    $query = "SELECT id FROM events where status = 'pending' or status = 'modified' or status='PENDING' or status='MODIFIED';";
    $result = dbQuery($query);
    if ($result != null) {
        $rows = pg_num_rows($result);
        if ($rows > 0) {
            for ($i = 0; $i < $rows; $i++) {
                $a = pg_fetch_row($result);
                $list[] = $a[0];
            }
            return $list;
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function cleanData($data) {
    $data = str_replace("'", "''", $data);
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = pg_escape_string($data);
    return $data;
}

// Delete this when we're sure we don't need it anymore
/*function denyEvent($eventId) {
    if (file_exists('./dat/connectDB.php')) {
        require_once ('./dat/connectDB.php');
    } else {
        require_once ('./../dat/connectDB.php');
    }
    $query = "UPDATE events SET status = 'CANCELLED' where id = $eventId;";
    $result = dbQuery($query);
    if ($result != null) {
        return true;
    } else {
        return false;
    }
}*/

function deleteEvent($eventId) {
    if (file_exists('./dat/connectDB.php')) {
        require_once ('./dat/connectDB.php');
    } else {
        require_once ('./../dat/connectDB.php');
    }
    $query = "DELETE FROM events WHERE id = '$eventId'";
    $result = dbQuery($query);
    if ($result != null) {
        return true;
    } else {
        return false;
    }
}

function approveEvent($eventId) {
    if (file_exists('./dat/connectDB.php')) {
        require_once ('./dat/connectDB.php');
    } else {
        require_once ('./../dat/connectDB.php');
    }
    // Find the event to be approved
    $eventquery = "SELECT * FROM events WHERE id = $eventId;";
    $eventresults = dbQuery($eventquery);
    $res = pg_fetch_assoc($eventresults);
    if ($res == null) {
        return false;
    }
    
    // If it's a modified event, the original event will be updated and the modified one will be deleted
    if (strpos($res['status'], "MODIFIED") !== false) {
        $originalEvent = $res['password'];
        $replacequery = "UPDATE events SET (eventName, eventType, startDate, endDate, dateTextField, startSignupTime, endSignupTime, locationDropDown, locationTextField, iconUrl, genre, cost, ageLimit, beginnerFriendly, storyDescription, infoDescription, organizerName, organizerEmail, link1, link2) = ('" . cleanData($res['eventname']) . "', '" . cleanData($res['eventtype']) . "', '" . cleanData($res['startdate']) . "', '" . cleanData($res['enddate']) . "', '" . cleanData($res['datetextfield']) . "', '" . cleanData($res['startsignuptime']) . "', '" . cleanData($res['endsignuptime']) . "', '" . cleanData($res['locationdropdown']) . "', '" . cleanData($res['locationtextfield']) . "', '" . cleanData($res['iconurl']) . "', '" . cleanData($res['genre']) . "', '" . cleanData($res['cost']) . "', '" . cleanData($res['agelimit']) . "', '" . cleanData($res['beginnerfriendly']) . "', '" . cleanData($res['storydescription']) . "', '" . cleanData($res['infodescription']) . "', '" . cleanData($res['organizername']) . "', '" . cleanData($res['organizeremail']) . "', '" . cleanData($res['link1']) . "', '" . cleanData($res['link2']) . "') WHERE password = '" . $originalEvent . "';";
        $replaceresults = dbQuery($replacequery);
        $replaceres = pg_fetch_assoc($replaceresults);
        if ($replaceres == null) {
            return false;
        }
        $deleteresult = deleteEvent($eventid);
        return $deleteresult;
    }
    // If it's a new event, it will just be turned active
    else {
    	$query = "UPDATE events SET status = 'ACTIVE' WHERE id = $eventId;";
        $result = dbQuery($query);
        if ($result != null) {
            return true;
        } else {
            return false;
        }
    }
}

//==============================================================================
// ADMINS FUNCTIONS
//==============================================================================

function getListOfAdmins() {
    require_once ('./../dat/connectDB.php');
    $query = "SELECT username FROM ADMINS;";
    $result = dbQuery($query);
    if ($result != null) {
        $rows = pg_num_rows($result);
        for ($i = 0; $i < $rows; $i++) {
            $a = pg_fetch_row($result);
            $list[] = $a[0];
        }
        return $list;
    } else {
        return null;
    }
}

function getCadminObject($username) {
    require_once ('./../dat/connectDB.php');
    require_once ('./../dat/cAdmin.php');
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

function getUsernameOfAnAdmin($adminId) {
    require_once ('./../dat/connectDB.php');
    require_once ('./../dat/cAdmin.php');
    $query = "SELECT username FROM ADMINS WHERE id = '$adminId';";
    $result = dbQuery($query);
    if ($result != null) {
        $rows = pg_fetch_row($result);
        $uname = $rows[0];
        return $uname;
    } else {
        return null;
    }
}

function getPasswordOfAnAdmin($adminId) {
    require_once ('./../dat/connectDB.php');
    require_once ('./../dat/cAdmin.php');
    $query = "SELECT password FROM ADMINS WHERE id = '$adminId';";
    $result = dbQuery($query);
    if ($result != null) {
        $rows = pg_fetch_row($result);
        $pass = $rows[0];
        return $pass;
    } else {
        return null;
    }
}

function modifyAdmin($adminId, $currentPassword, $newPassword1, $newPassword2) {
    if (file_exists('./dat/connectDB.php')) {
        require_once ('./dat/connectDB.php');
    } else {
        require_once ('./../dat/connectDB.php');
    }
    $adminPass = getPasswordOfAnAdmin($adminId);
    /* Check if provided password matches the one in database. */
    if ($adminPass == $currentPassword) {
        /* Check if two new passwords provided match. */
        if ($newPassword1 == $newPassword2) {
            $query = "UPDATE admins SET password = '$newPassword1' where id = $adminId;";
            $result = dbQuery($query);
            if ($result != null) {
                return true;
            } else {
                return false;
            }
        } else {
            return null;
        }
    } else {
        return null;
    }
}

/* Function which deletes admin account from database if password matches.
 * Returns TRUE if successfully deleted,
 * returns FALSE if password doesn't match,
 * returns NULL in case of a failure.
 */

function deleteAdmin($adminId, $providedPass) {
    if (file_exists('./dat/connectDB.php')) {
        require_once ('./dat/connectDB.php');
    } else {
        require_once ('./../dat/connectDB.php');
    }
    $adminPass = getPasswordOfAnAdmin($adminId);
    if ($adminPass == $providedPass) {
        $query = "DELETE FROM admins WHERE id = $adminId;";
        $result = dbQuery($query);
        if ($result != null) {
            return true;
        } else {
            return null;
        }
    } else if ($adminPass != $providedPass) {
        return false;
    } else {
        return null;
    }
//    $query = "UPDATE events SET status = 'CANCELLED' where id = $eventId;";
//    $result = dbQuery($query);
//    if ($result != null) {
//        return true;
//    } else {
//        return false;
//    }
}

//==============================================================================
// CALENDAR FUNCTIONS
//==============================================================================

function generateCalendarCell($month, $day, $year) {
    $numberEvents = getNumberOfEventsInDay($month, $day, $year);
    /* Get IDs of events in current day. */
    $eventsId = getListOfEvents($month, $day, $year);
    $events = array();
    if ($eventsId != null) {
        foreach ($eventsId as $id) {
            $e = getCeventObject($id);
            if ($e != null) {
                $events[] = $e;
            }
        }
    }
    $ret = "";
    if ($numberEvents == 0) {
        $ret .= "<br><br><br>";
        return $ret;
    } else {
        $ret = "<ul id='eventsInCalendar'>";
        $i = 0;
        foreach ($events as $e) {
            include (__DIR__ . "./../includes/data.php");
            $i++;
            $eventId = $e->getEventId();
            $eventName = $e->getShortEventName();
            $ret .= "<li><a href='index.php?date=$date&eventId=$eventId'>$eventName</a></li>";
        }
//        for ($i = 0; $i < $numberEvents; $i++) {
//            $ret .= "<li><a href='index.php?eventId=2'>Event " . $i . "</a></li>";
//        }
        for ($j = $i; $j < 4; $j++) {
            $ret .= "<br>";
        }
    }
    $ret .= "</ul>";
    return $ret;
}

function getCalendarRows($date) {
    //Get year and month from the date.
    $year = date("Y", $date);
    $month = date("m", $date);
    //Get the first day in the month timestamp.
    $firstDayTimeStamp = mktime(0, 0, 0, $month, 1, $year);
    $firstDay = date("d", $firstDayTimeStamp);
    //Get number of days in the month (28-31).
    $numberOfdays = intval(date("t", $firstDayTimeStamp));
    //Get index of the first day meaning which day it is (1-7).
    $indexOfFirstDay = intval(date("N", $firstDayTimeStamp));
    $day = intval($firstDay);
    $calendar = "<tr>";
    //------------------------------------------------------------------
    //Write blanks for the first days until indexOfFirstDay.
    for ($r = 1; $r < $indexOfFirstDay; $r++) {
        //CELL DATA
        $calendar .= "<td width='14%'>";
        $calendar .= "<br><br><br>";
        $calendar .= "</td>";
    }
    //Write the rest of days starting from where previous for ended.
    for ($rem = $r; $rem <= 7; $rem++) {
        //CELL DATA
        if (isCurrentDay($day, $month, $year)) {
            $calendar .= "<td width='14%' class='danger'>";
        } else {
            $calendar .= "<td width='14%'>";
        }
        //DAY NUMBER
        $calendar .= "<small>" . $day++ . "</small><br>";
        /* Day is 1 lower, while generating the table by $day++ function. */
        $calendar .= generateCalendarCell($month, $day - 1, $year);
        $calendar .= "</td>";
    }
    $calendar .= "</tr>";
    $calendar .= "<tr>";
    //------------------------------------------------------------------
    //Write middle rows.
    for ($r = 1; $r <= 4; $r++) {
        for ($c = 1; $c <= 7; $c++) {
            //If the end of month is reached, write blank.
            if ($day != $numberOfdays + 1) {
                //CELL DATA
                if (isCurrentDay($day, $month, $year)) {
                    $calendar .= "<td width='14%' class='danger'>";
                } else {
                    $calendar .= "<td width='14%'>";
                }
                //DAY NUMBER
                $calendar .= "<small>" . $day++ . "</small><br>";
                /* Day is 1 lower, while generating the table by $day++ function. */
                $calendar .= generateCalendarCell($month, $day - 1, $year);
                $calendar .= "</td>";
            } else {
                //CELL DATA
                $calendar .= "<td width='14%'>";
                $calendar .= "<br><br><br>";
                $calendar .= "</td>";
            }
        }
        $calendar .= "</tr>";
    }
    //------------------------------------------------------------------
    //Write last row of days.
    $calendar .= "<tr>";
    for ($r = 1; $r <= 7; $r++) {
        //
        if ($day != $numberOfdays + 1) {
            //CELL DATA
            if (isCurrentDay($day, $month, $year)) {
                $calendar .= "<td class='danger'>";
            } else {
                $calendar .= "<td>";
            }
            //DAY NUMBER
            $calendar .= "<small>" . $day++ . "</small><br>";
            /* Day is 1 lower, while generating the table by $day++ function. */
            $calendar .= generateCalendarCell($month, $day - 1, $year);
            $calendar .= "</td>";
        } else {
            //CELL DATA
            $calendar .= "<td>";
            $calendar .= "<br><br><br>";
            $calendar .= "</td>";
        }
    }
    $calendar .= "</tr>";
    //------------------------------------------------------------------

    return $calendar;
}
