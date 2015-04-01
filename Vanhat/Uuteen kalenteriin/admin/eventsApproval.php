<?php
/* THIS PAGE IS PROTECTED */
require ("protectedPage.php");
?>

<!DOCTYPE html>
<html>

    <!-- HEAD -->
    <?php include(__DIR__ . "./../includes/head.php"); ?>

    <script>

    /* Function for secure data post action for event modification. */
    function postModifyData(prom) {
        document.getElementById(prom).submit();
    }

    </script>

    <body>

        <?php
        require (__DIR__ . "./../dat/controller.php");
        include (__DIR__ . "./../includes/data.php");
        $activePage = -1;
        ?>

        <div class="container">

            <div class="row clearfix">
                <div class="col-md-12 column">

                    <!-- HEADER -->
                    <?php include(__DIR__ . "./../includes/header.php"); ?>

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
                    echo "<h3>" . $evapp_title . "</h3>";

                    if ($action == "a") {
                        require_once './../dat/controller.php';
                        require_once './../dat/cEvent.php';
                        $event = getCeventObject($eventId);
                        $eventName = $event->getEventName();
                        echo $evapp_text1 . " <b>" . $eventName . "</b>.";
                        echo "<br>";
                        echo $evapp_text2;
                        echo "<br>";
                        $form = "";
                        $form .= "
                                <form role='form' action='editEventValidate.php' method='post'>
                                    <label for='comment'>" . $admincomments . "</label>
                                    <textarea class='form-control' rows='3' name='comment'></textarea>
                                    <input type='hidden' name='eventId' value='$eventId'>
                                    <input type='hidden' name='action' value='$action'><br>
                                    <button type='submit' class='btn btn-success'>" . $btn_approve . "</button>
                                    <a class='btn btn-default' href='eventsApproval.php' role='button'>" . $btn_back . "</a>
                                </form>";
                        echo $form;
                        echo "<br>";
                    } else if ($action == "d") {
                        require_once './../dat/controller.php';
                        require_once './../dat/cEvent.php';
                        $event = getCeventObject($eventId);
                        $eventName = $event->getEventName();
                        echo $evdeny_text1 . " <b>" . $eventName . "</b>.";
                        echo "<br>";
                        echo $evdeny_text2;
                        echo "<br>";
                        $form = "";
                        $form .= "
                                <form role='form' action='editEventValidate.php' method='post'>
                                    <label for='comment'>" . $admincomments . "</label>
                                    <textarea class='form-control' rows='3' name='comment'></textarea>
									<input type='checkbox' name='dontsend'>" . $dontsend . "<br>
                                    <input type='hidden' name='eventId' value='$eventId'>
                                    <input type='hidden' name='action' value='$action'><br>
                                    <button type='submit' class='btn btn-danger'>" . $btn_deny . "</button>
                                    <a class='btn btn-default' href='eventsApproval.php' role='button'>" . $btn_back . "</a>
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
