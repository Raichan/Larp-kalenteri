<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

    <!-- HEAD -->
    <?php include(__DIR__ . "/includes/head.php"); ?>
    <?php include(__DIR__ . "/dat/connectDB.php"); ?>

    <body>

        <?php
        include (__DIR__ . "/dat/controller.php");
        include (__DIR__ . "/includes/data.php");
        include (__DIR__ . "/includes/share.php");
        $activePage = 1;
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

                    <!-- some introductory text here -->

                    <!-- construct a query that fetches all upcoming events sorted by start date and then include eventInfo.php for every event -->
                    <?php
                    
                    // DELETE THIS AFTERWARDS
                    function debug_to_console($data) {

                        if (is_array($data))
                            $output = "<script>console.log( 'Debug Objects: " . implode(',', $data) . "' );</script>";
                        else
                            $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

                        echo $output;
                    }

                    $currentdate = time();
                    // First we list events with set dates
                    $listquery = "SELECT * FROM events WHERE (endDate >= '$currentdate' OR (endDate = '' AND startDate >= '$currentdate')) AND status = 'ACTIVE' ORDER BY startDate";

                    $allresults = dbQuery($listquery);
                    if (pg_num_rows($allresults) == 0) {
                        echo "<p><h2>There are no events in the calendar.</h2></p>";
                    } else {
                        echo("<h2>List view</h2>");
                        while ($result = pg_fetch_assoc($allresults)) {
                            include(__DIR__ . "/includes/eventInfo.php");
                        }
                    }
                    // ... and at the end there are the events with no set date
                    $listquery = "SELECT * FROM events WHERE startDate = '' AND status = 'ACTIVE'";

                    $allresults = dbQuery($listquery);
                    if (pg_num_rows($allresults) > 0) {
                        echo("<h2>Events with ambiguous date</h2>");
                        while ($result = pg_fetch_assoc($allresults)) {
                            include(__DIR__ . "/includes/eventInfo.php");
                        }
                    }
                    ?>

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
