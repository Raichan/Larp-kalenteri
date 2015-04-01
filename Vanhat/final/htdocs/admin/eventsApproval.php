<?php
/* THIS PAGE IS PROTECTED */
require ("protectedPage.php");
?>

<!DOCTYPE html>
<html>

    <!-- HEAD -->
    <?php include(__DIR__ . "/includes/head.php"); ?>

    <script>

    /* Fucntion for secure data post action for event modification. */
    function postModifyData(prom) {
        document.getElementById(prom).submit();
    }

    </script>

    <body>

        <?php
        require (__DIR__ . "/../dat/controller.php");
        include (__DIR__ . "/../includes/data.php");
        $activePage = -1;
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
                    /* Check if data were posted, otherwise assign blank string. */
                    if (isset($_GET["action"])) {
                        $action = $_GET["action"];
                    } else {
                        $action = "";
                    }

                    /* Check if data were posted, otherwise assign blank string. */
                    if (isset($_GET["eventId"])) {
                        $eventId = $_GET["eventId"];
                    } else {
                        $eventId = "";
                    }

                    /* Heading. */
                    echo "<h3>Events approval</h3>";

                    if ($action == "a") {
                        require_once './../dat/controller.php';
                        require_once './../dat/cEvent.php';
                        $event = getCeventObject($eventId);
                        $eventName = $event->getEventName();
                        echo "You are about to APPROVE event <b>$eventName</b>.";
                        echo "<br>";
                        echo "Please, confirm the <b>approval</b> and add a comment to user if you require.";
                        echo "<br>";
                        $form = "";
                        $form .= "
                                <form role='form' action='editEventValidate.php' method='post'>
                                    <label for='comment'>Comment:</label>
                                    <textarea class='form-control' rows='3' name='comment'></textarea>
                                    <input type='hidden' name='eventId' value='$eventId'>
                                    <input type='hidden' name='action' value='$action'><br>
                                    <button type='submit' class='btn btn-success'>Approve</button>
                                    <a class='btn btn-default' href='eventsApproval.php' role='button'>Back</a>
                                </form>";
                        echo $form;
                        echo "<br>";
                    } else if ($action == "d") {
                        require_once './../dat/controller.php';
                        require_once './../dat/cEvent.php';
                        $event = getCeventObject($eventId);
                        $eventName = $event->getEventName();
                        echo "You are about to DENY event <b>$eventName</b>.";
                        echo "<br>";
                        echo "Please, confirm the <b>denial</b> and add a comment to user if you require.";
                        echo "<br>";
                        $form = "";
                        $form .= "
                                <form role='form' action='editEventValidate.php' method='post'>
                                    <label for='comment'>Comment:</label>
                                    <textarea class='form-control' rows='3' name='comment'></textarea>
                                    <input type='hidden' name='eventId' value='$eventId'>
                                    <input type='hidden' name='action' value='$action'><br>
                                    <button type='submit' class='btn btn-danger'>Deny</button>
                                    <a class='btn btn-default' href='eventsApproval.php' role='button'>Back</a>
                                </form>";
                        echo $form;
                        echo "<br>";
                    } else {
                        /* Else show the events table. */
                        include(__DIR__ . "/includes/eventsTable.php");
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
