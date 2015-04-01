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
		require(__DIR__ . "/includes/share.php"); 
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
					$found = true;
					if(isset($_GET["id"]) && !($_GET["id"] === "")) {
						$listquery = "SELECT * FROM events WHERE id='" . htmlspecialchars($_GET["id"]) . "'";
						
						$allresults = dbQuery($listquery);
						if(pg_num_rows($allresults) != 1){
							$found = false;
						}
						else{
							$result = pg_fetch_assoc($allresults);
							include(__DIR__ . "/includes/eventInfo.php");
						}
					}
					else{
						$found = false;
					}
					
					if(!$found){
						echo("<div class='contentbox' style='margin-top: 10px; margin-bottom: 10px;'><p>Something went wrong and the event couldn't be found.</p>
						<form action='searchEvent.php'>
							<input class='btn btn-default' type='submit' value='Go to event search'>
						</form></div>");
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
