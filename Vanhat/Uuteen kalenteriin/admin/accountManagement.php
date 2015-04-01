<?php
/* THIS PAGE IS PROTECTED */
require ("protectedPage.php");
?>

<!DOCTYPE html>
<html>

    <!-- HEAD -->
    <?php include(__DIR__ . "./../includes/head.php"); ?>

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
                    <?php include(__DIR__ . "./../includes/navigation.php"); ?>

                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-6 column">

                    <h3><?php echo $accman_title; ?></h3>

                    <!-- ADMINS TABLE -->
                    <?php include(__DIR__ . "/includes/adminsTable.php"); ?>

                </div>

                <div class="col-md-6 column">

                    <!-- ADMINS FORM -->

                    <?php
                    /* Check if data were posted, otherwise assign blank string. */
                    if (isset($_GET["action"])) {
                        $action = $_GET["action"];
                    } else {
                        $action = "";
                    }
                    if (isset($_GET["id"])) {
                        $id = $_GET["id"];
                    } else {
                        $id = "";
                    }

                    if ($action == "m") {
                        include(__DIR__ . "/includes/adminsFormModify.php");
                    } else if ($action == "d") {
                        include(__DIR__ . "/includes/adminsFormDelete.php");
                    } else {
                        include(__DIR__ . "/includes/adminsForm.php");
                    }
                    ?>
                    <br>
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
