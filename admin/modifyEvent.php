<?php
/* THIS PAGE IS PROTECTED */
require ("protectedPage.php");
?>

<!DOCTYPE html>
<html>

    <!-- HEAD -->
    <?php include(__DIR__ . "/includes/head.php"); ?>
    <?php include(__DIR__ . "/../dat/connectDB.php"); ?>

    <body>

        <?php
        include (__DIR__ . "/../dat/controller.php");
        include (__DIR__ . "/../includes/data.php");
        $activePage = 4;
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


                    <?php
                    $proceedurl = "modifySuccess.php";

                    include(__DIR__ . "/../includes/checkFormErrors.php");

                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modifyid"])) {
                        // Get the event from database and set the variables
                        $eventid = htmlspecialchars($_POST["modifyid"]);
                        $query = "SELECT * FROM events WHERE id = '$eventid';";
                        $result = dbQuery($query);
                        if ($result) {
                            $result = pg_fetch_array($result, 0);
                            // Retrieve field values
                            $eventname = $result['eventname'];
                            $eventtype = $result['eventtype'];
                            $datestart = getDateFromTimestamp($result['startdate']);
                            $dateend = getDateFromTimestamp($result['enddate']);
                            $datetext = $result['datetextfield'];
                            $signupstart = getDateFromTimestamp($result['startsignuptime']);
                            $signupend = getDateFromTimestamp($result['endsignuptime']);
                            $location1 = $result['locationdropdown'];
                            $location2 = $result['locationtextfield'];
                            $icon = $result['iconurl'];
                            $genrestring = $result['genre'];
                            $cost = $result['cost'];
                            $agelimit = $result['agelimit'];
                            $beginnerfriendly = $result['beginnerfriendly'];
                            $storydesc = $result['storydescription'];
                            $infodesc = $result['infodescription'];
                            $organizername = $result['organizername'];
                            $organizeremail = $result['organizeremail'];
                            $website1 = $result['link1'];
                            $website2 = $result['link2'];
                        }
                    }
                    ?>

                    <h3>Modify an event</h3>
                    <!-- EVENT FORM -->
                    <?php include(__DIR__ . "/../includes/eventForm.php"); ?>
                    <button class="btn btn-default" data-toggle="modal" data-target="#deleteevent" style="margin-top: 10px; margin-bottom: 10px;">Delete event</button>

                    <div class="modal fade" id="deleteevent" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="deleteLabel">Delete event?</h4>
                                </div>
                                <div class="modal-body">
                                    <p>You are about to delete your event. It can't be recovered.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-bottom: 10px;">Cancel</button>
                                    <form id="deleteform" action="deleteSuccess.php" data-remote="true" method="post">
                                        <input type="hidden" id="deleteid" name="deleteid" value="<?php echo($eventid) ?>"/>
                                    </form>
                                    <a id="deletesubmit" class='btn btn-primary' href="#">Delete event</a>
                                    <script>
                                        $('#deletesubmit').on('click', function(e) {
                                            // We don't want this to act as a link so cancel the link action
                                            e.preventDefault();

                                            // Submit the form
                                            $('#deleteform').submit();
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
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
