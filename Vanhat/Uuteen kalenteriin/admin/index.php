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
        $activePage = 0;
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
                <div class="col-md-8 column">

                    <!-- MONTH NAVIGATOR -->
                    <?php include(__DIR__ . "/../includes/monthNavigator.php"); ?>

                    <!-- CALENDAR -->
                    <?php include(__DIR__ . "/../includes/calendar.php"); ?>

                </div>

                <div class="col-md-4 column">

                    <!-- BRIEF EVENT -->
                    <?php include(__DIR__ . "/../includes/eventBrief.php"); ?>

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
