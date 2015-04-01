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
<a href="#">List view</a>
</li>
<li>
    <?php
    if ($activePage == 2) {
        echo "<li class='active'>";
    } else {
        echo "<li>";
    }
    ?>  
    <a href="search.php">Search event</a>
</li>
<?php
if ($activePage == 3) {
    echo "<li class='active'>";
} else {
    echo "<li>";
}
?>
<a href="#">Submit event</a>
</li>
<?php
if ($activePage == 4) {
    echo "<li class='active'>";
} else {
    echo "<li>";
}
?>
<a href="#">Modify event</a>
</li>
<li class="dropdown pull-right">
    <a href="#" data-toggle="dropdown" class="dropdown-toggle">Admin<strong class="caret"></strong></a>
    <ul class="dropdown-menu">
        <li>
            <a href="#">Login</a>
        </li>
        <li class="divider">
        </li>
        <li>
            <a href="#">Help</a>
        </li>
    </ul>
</li>
</ul>