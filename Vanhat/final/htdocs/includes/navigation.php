<ul class="nav nav-tabs">
    <?php
    if ($activePage == 0) {
        echo "<li class='active'>";
    } else {
        echo "<li>";
    }
    ?>
    <a href="index.php">Calendar view</a>
</li>
<?php
if ($activePage == 1) {
    echo "<li class='active'>";
} else {
    echo "<li>";
}
?>
<a href="listView.php">List view</a>
</li>
<?php
if ($activePage == 2) {
    echo "<li class='active'>";
} else {
    echo "<li>";
}
?>  
<a href="searchEvent.php">Search events</a>
</li>
<?php
if ($activePage == 3) {
    echo "<li class='active'>";
} else {
    echo "<li>";
}
?>
<a href="createEvent.php">Create event</a>
</li>
<?php
if ($activePage == 4) {
    echo "<li class='active'>";
} else {
    echo "<li>";
}
?>
<a href="modifyPassword.php">Modify event</a>
</li>
<?php
if ($activePage == 5) {
    echo "<li class='active'>";
} else {
    echo "<li>";
}
?>
<a href="help.php">Help</a>
</li>
<li class="dropdown pull-right">
    <a href="#" data-toggle="dropdown" class="dropdown-toggle">Admin<strong class="caret"></strong></a>
    <ul class="dropdown-menu">
        <li>
            <a href="login.php">Login</a>
        </li>
    </ul>
</li>
</ul>