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
        include (__DIR__ . "/dat/controller.php");
        include (__DIR__ . "/includes/data.php");
        $activePage = 5;
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

				<h2><?php echo $title_help; ?></h2>
                <?php echo $main_help; ?>

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
