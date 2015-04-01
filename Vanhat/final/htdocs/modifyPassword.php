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
        require (__DIR__ . "/dat/controller.php");
        include (__DIR__ . "/includes/data.php");
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
                    if (isset($_GET["error"])) {
                        $error = $_GET["error"];
                    } else {
                        $error = 0;
                    }

                    if ($error == 1) {
                        $message = "Incorrect password.";
                    } else if ($error == 2) {
                        $message = "Please enter a password.";
                    } else {
                        $message = "";
                    }
                    ?>

                    <h3>Enter event password</h3>
                    <h5 class="error"><?php echo $message; ?></h5>
                    <form role="form" action="modifyPasswordValidate.php" method="post">
                        <div class="form-group">
                            <input class="form-control" id="modifyPassword" type="password" name="password" />
                        </div>
                        <button type="submit" class="btn btn-default">Find event</button>
                    </form>
                    <br/>
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
