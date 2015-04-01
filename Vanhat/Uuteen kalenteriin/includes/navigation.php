<ul class="nav nav-tabs">
    <?php
    if ($activePage == 0) {
        echo "<li class='active'>";
    } else {
        echo "<li>";
    }
    ?>
    <a href="index.php"><?php echo $nav_calendar; ?></a>
</li>
<?php
if ($activePage == 1) {
    echo "<li class='active'>";
} else {
    echo "<li>";
}
?>
<a href="listView.php"><?php echo $nav_list; ?></a>
</li>
<?php
if ($activePage == 2) {
    echo "<li class='active'>";
} else {
    echo "<li>";
}
?>  
<a href="searchEvent.php"><?php echo $nav_search; ?></a>
</li>
<?php
if ($activePage == 3) {
    echo "<li class='active'>";
} else {
    echo "<li>";
}
?>
<a href="createEvent.php"><?php echo $nav_create; ?></a>
</li>
<?php
if ($activePage == 4) {
    echo "<li class='active'>";
} else {
    echo "<li>";
}
?>
<a href="modifyPassword.php"><?php echo $nav_modify; ?></a>
</li>
<?php
if ($activePage == 5) {
    echo "<li class='active'>";
} else {
    echo "<li>";
}
?>
<a href="help.php"><?php echo $nav_help; ?></a>
</li>
<?php
	session_start();
	if (isset($_SESSION["valid"])) {
		$ADMIN = true;
		$events = getListOfEventsForApproval();
		echo '<li class="dropdown pull-right">
			<a href="#" data-toggle="dropdown" class="dropdown-toggle">' .  $_SESSION['name'] . '<strong class="caret"></strong></a>
			<ul class="dropdown-menu">
				<li>
					<a href="/admin/eventsApproval.php">Events approval 
						<span class="badge">' . count($events) . '
						</span> 
					</a>
				</li><li>
					<a href="/admin/accountManagement.php">Account management</a>
				</li>
				<li class="divider">
				</li>
				<li>
					<a href="/logout.php">Logout</a>
				</li>
			</ul>
		</li>';
	} else {
		$ADMIN = false;
		echo '<li class="dropdown pull-right">
			<a href="#" data-toggle="dropdown" class="dropdown-toggle">' .  $nav_admin . '<strong class="caret"></strong></a>
			<ul class="dropdown-menu">
				<li>
					<a href="login.php">' . $button_login . '</a>
				</li>
			</ul>
		</li>';
	}
?>

<form class="pull-right" action="includes/lang.php" method="post">
    <input type="hidden" name="lang" value="en">
	<input type="hidden" name="url" value="<?php echo $_SERVER['PHP_SELF'];?>">
    <input name="submit" id="submit" type="image" style="vertical-align: text-bottom;" src="images/en.png" onclick="this.form.submit();"/>
</form>
<form class="pull-right" action="includes/lang.php" method="post">
    <input type="hidden" name="lang" value="fi">
	<input type="hidden" name="url" value="<?php echo $_SERVER['PHP_SELF'];?>">
    <input name="submit" id="submit" type="image" style="vertical-align: text-bottom;" src="images/fi.png" onclick="this.form.submit();"/>
</form>
</ul>