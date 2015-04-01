<?php
/* THIS PAGE IS PROTECTED */
require ("protectedPage.php");
?>

<!DOCTYPE html>
<html>

    <!-- HEAD -->
    <?php include(__DIR__ . "/includes/head.php"); ?>

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
                    if (isset($_SESSION["valid"])) {
                        $ADMIN = true;
                    } else {
                        $ADMIN = false;
                    }
                    ?>

                    <div class="row clearfix">
                        <div class="col-md-12 column">

                            <h1>Event modified successfully</h1>
                            <p>Thank you!<br>Your modifications have now been saved.</p>
							<form action="eventsApproval.php">
							<input class="btn btn-primary" type="submit" value="Back to pending events">
							</form>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </body>
</html>
