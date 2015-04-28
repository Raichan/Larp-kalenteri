<div class="page-header">
    <h1>
        <img src="/images/logo.jpg"><small>
		<?php
			if(!isset($_SESSION)) 
		    { 
		        session_start(); 
		    } 
			echo $header_title;
			if (isset($_SESSION["valid"])) {
				$ADMIN = true;
				echo " " . $admin_title;
			} else {
				$ADMIN = false;
			}
		?></small>
    </h1>
</div>