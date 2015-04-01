<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>LARP event calendar</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <!-- JavaScript -->
        <script src="js/bootstrap.min.js"></script>

    </head>
    <body>

        <?php
        require (__DIR__ . "/dat/controller.php");
        include (__DIR__ . "/includes/data.php");
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
                    <div class="row clearfix">
                        <div class="col-md-12 column">

                            <!-- EVENT SEARCH -->
                            <?php include(__DIR__ . "/includes/eventSearch.php"); ?>

                        </div>
                    </div>
                </div> 
            </div>

            <div class="row clearfix">
                <div class="col-md-12 column">

                    <!-- NEW EVENTS -->
                    <?php include(__DIR__ . "/includes/newEvents.php"); ?>

                </div>
            </div>
        </div>

    </body>
</html>
