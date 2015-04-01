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
        $activePage = 3;
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

                    <h1>Event modified successfully</h1>
                    <p>Thank you!<br>
                        Your modifications have now been saved and are waiting for admin approval. You can still use the same password for possible further modifications.</p>

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
