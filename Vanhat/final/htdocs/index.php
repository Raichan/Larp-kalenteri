<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

    <!-- HEAD -->
    <?php include(__DIR__ . "/includes/head.php"); ?>

    <body>

        <?php
        require (__DIR__ . "/dat/controller.php");
        include (__DIR__ . "/includes/data.php");
	require(__DIR__ . "/includes/share.php");
        $activePage = 0;
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
                <div class="col-md-8 column">

                    <!-- MONTH NAVIGATOR -->
                    <?php include(__DIR__ . "/includes/monthNavigator.php"); ?>

                    <!-- CALENDAR -->
                    <?php include(__DIR__ . "/includes/calendar.php"); ?>

                </div>

                <div class="col-md-4 column">

                    <!-- BRIEF EVENT -->
                    <?php include(__DIR__ . "/includes/eventBrief.php"); ?>

                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12 column">

                    <!-- NEW EVENTS -->
                    <?php include(__DIR__ . "/includes/upcomingEvents.php"); ?>

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
