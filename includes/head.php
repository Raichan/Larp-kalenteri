<head>
    <meta charset = "UTF-8">
    <title><?php echo $head_title; ?></title>

    <!--CSS style -->
    <link href = "css/style.css" rel = "stylesheet">
    <!--Bootstrap -->
    <link href = "css/bootstrap.min.css" rel = "stylesheet">
    <!--jQuery UI theme -->
    <link href = "https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" rel = "stylesheet">
    <!--jQuery -->
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src = "https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
    <!-- JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	
	<?php
	if (isset($_COOKIE["language"])){
		if($_COOKIE["language"] == "en"){
			include (__DIR__ . "/lang_en.php");
		}
		else{
			include (__DIR__ . "/lang_fi.php");
		}
	}
	else{
		include (__DIR__ . "/lang_fi.php");
	}
	
	?>
</head>