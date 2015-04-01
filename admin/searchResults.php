<?php
/* THIS PAGE IS PROTECTED */
require ("protectedPage.php");
?>

<!DOCTYPE html>
<html>

    <?php

    function dateToTimestampstring($date) {
        $parts = explode("/", $date);
        $timestamp = getTimeStamp($parts[1], $parts[0], $parts[2]);
        return strval($timestamp);
    }
    ?>

    <!-- HEAD -->
    <?php include(__DIR__ . "/includes/head.php"); ?>
    <?php include(__DIR__ . "/../dat/connectDB.php"); ?>

    <body>

        <?php
        include (__DIR__ . "/../dat/controller.php");
        include (__DIR__ . "/../includes/data.php");
        $activePage = 2;
        ?>

        <div class="container">

            <div class="row clearfix">
                <div class="col-md-12 column">

                    <!-- HEADER -->
                    <?php include(__DIR__ . "/includes/header.php"); ?>

                    <!-- NAVIGATION -->
                    <?php include(__DIR__ . "/includes/navigation.php"); ?>

                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12 column">

                    <h1>Search results</h1>

                    <!-- construct the query using url parameters -->
                    <?php
                    $freetext = $_POST["freetext"];
                    $eventtype = $_POST["eventtype"];
                    $datestart = $_POST["datestart"];
                    $dateend = $_POST["dateend"];
                    $location = $_POST["location"];
                    $genre = $_POST["genre"];
                    $cost = $_POST["cost"];
                    $agelimit = $_POST["agelimit"];
                    $signupopen = $_POST["signupopen"];
                    $beginnerfriendly = $_POST["beginnerfriendly"];
                    $pastevents = $_POST["pastevents"];
                    $currenttime = time();

                    $listquery = "SELECT * FROM events ";

                    $listquery .= "WHERE (eventName ILIKE '%" . $freetext . "%' 
										or dateTextField ILIKE '%" . $freetext . "%' 
										or locationTextField ILIKE '%" . $freetext . "%' 
										or storyDescription ILIKE '%" . $freetext . "%' 
										or infoDescription ILIKE '%" . $freetext . "%' 
										or organizerName ILIKE '%" . $freetext . "%')";

                    if ($eventtype != "1") {
                        $listquery .= " and eventType = '" . $eventtype . "'";
                    }
                    if ($datestart != "") {
                        $listquery .= " and startDate >= '" . dateToTimestampstring($datestart) . "'";
                    }
                    if ($dateend != "") {
                        $listquery .= " and ((endDate = '' and startDate <= '" . dateToTimestampstring($dateend) . "') or (endDate <> '' and endDate <= '" . dateToTimestampstring($dateend) . "'))";
                    }
                    if ($location != "1") {
                        $listquery .= " and locationDropDown = '" . $location . "'";
                    }
                    if ($genre != "") {
                        foreach ($genre as $value) {
                            $listquery .= " and genre like '%" . $value . "%'";
                        }
                    }
					
                    /*if ($cost != "") {
                        $numbers = array_reverse(str_split($cost, 1));
                        $listquery .= " and cost ~ '((\d)*-)?(" . $cost;
                        $regexrange = "";
                        $index = 0;
                        for ($i = 0; $i < (sizeof($numbers) - 1); $i++) {
                            $listquery .= "|[0-9]" . $regexrange;
                            $regexrange .= "[0-9]";
                            $index++;
                        }
                        $listquery .= "|[0-" . $numbers[$index];
                        $index--;
                        while ($index >= 0) {
                            $listquery .= "][0-" . $numbers[$index];
                            $index--;
                        }
                        $listquery .= "])\b'";
                    }
                    if ($agelimit != "") {
                        $numbers = array_reverse(str_split($agelimit, 1));
                        $listquery .= " and ageLimit ~ '%\b(" . $agelimit;
                        $regexrange = "";
                        $index = 0;
                        for ($i = 0; $i < (sizeof($numbers) - 1); $i++) {
                            $listquery .= "|[0-9]" . $regexrange;
                            $regexrange .= "[0-9]";
                            $index++;
                        }
                        $listquery .= "|[0-" . $numbers[$index];
                        $index--;
                        while ($index >= 0) {
                            $listquery .= "][0-" . $numbers[$index];
                            $index--;
                        }
                        $listquery .= "])\b%'";
                    }*/
					
                    if ($signupopen) {
                        $listquery .= " and startSignupTime <> '' and startSignupTime <= '" . $currenttime . "' and endSignupTime >= '" . $currenttime . "'";
                    }
                    if ($beginnerfriendly) {
                        $listquery .= " and beginnerFriendly = 't'";
                    }

                    if (!$pastevents) {
                        //$listquery .= " and startDate <= '" . $currenttime . "'";
                        $listquery .= " and (endDate >= '" . $currenttime . "' or (endDate = '' and startDate >= '" . $currenttime . "'))";
                    }

                    $listquery .= "and status = 'ACTIVE' ORDER BY startDate;";
                    $allresults = dbQuery($listquery);

                    if (pg_num_rows($allresults) == 0) {
                        echo "<p>Your search criteria didn't match any events.</p>
						<form action=\"searchEvent.php\">
							<input class=\"btn btn-default\" type=\"submit\" value=\"Back to search\">
						</form>";
                    } else {
                        echo "<p>" . pg_num_rows($allresults) . " events found.</p>";
                        while ($result = pg_fetch_assoc($allresults)) {
                            include(__DIR__ . "/../includes/eventInfo.php");
                        }
                    }
                    ?>

                    <br/>

                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12 column">

                    <!-- FOOTER -->
                    <?php include(__DIR__ . "/includes/footer.php"); ?>

                </div>
            </div>

        </div>

    </body>
</html>
