<?php
if (file_exists('./includes/share.php')) {
    require_once ('./includes/share.php');
} else {
    require_once ('./../includes/share.php');
}

if (isset($_SESSION["valid"])) {
    $ADMIN = true;
} else {
    $ADMIN = false;
}

$eventId = $result['id'];
$eventname = $result['eventname'];
$eventtype = $result['eventtype'];
$datestart = getDateFromTimestamp((int) $result['startdate']);
$dateend = getDateFromTimestamp((int) $result['enddate']);
$datetext = $result['datetextfield'];
$signupstart = getDateFromTimestamp((int) $result['startsignuptime']);
$signupend = getDateFromTimestamp((int) $result['endsignuptime']);
$location1 = $result['locationdropdown'];
$location2 = $result['locationtextfield'];
$icon = $result['iconurl'];
$genre = $result['genre'];
$cost = $result['cost'];
$agelimit = $result['agelimit'];
$beginnerfriendly = $result['beginnerfriendly'];
$storydesc = $result['storydescription'];
$infodesc = $result['infodescription'];
$organizername = $result['organizername'];
$organizeremail = $result['organizeremail'];
$website1 = $result['link1'];
$website2 = $result['link2'];

if ($dateend != "") {
    $date = $datestart . " - " . $dateend;
} else if ($datestart != "") {
    $date = $datestart;
} else {
    $date = $datetext . ",";
}

// Because in the calendar dots look better than slashes
$date = str_replace("/", ".", $date);
$signupstart = str_replace("/", ".", $signupstart);
$signupend = str_replace("/", ".", $signupend);

// Check if the signup is open
$signupopen = false;
$currenttime = (int) date("U");
if ((int) $result['startsignuptime'] != "" && (int) $result['startsignuptime'] <= $currenttime && (int) $result['endsignuptime'] >= $currenttime) {
    $signupopen = true;
}
?>

<div id="<?php
if (isset($_GET["id"])) {
    echo $_GET["id"];
}
?>" class="event">
    <h3><?php echo $eventname; ?></h3>
    <img src="<?php
    if ($icon != '') {
        echo $icon;
    } else {
        echo "/images/noimage.png";
    }
    ?>" onerror="this.src = '/images/noimage.png'" height="100" width="100" style="float: right;">
    <p><h4><?php echo($date . " " . $location2); ?></h4>
    <?php if ($signupopen) echo("<span class='label label-success' style='display: inline-block; margin-bottom: 5px'>Signup open</span><br>"); ?>
    <?php if ($signupstart != 0) echo("Signup: " . $signupstart . " - " . $signupend . "<br>"); ?>
    <?php if ($genre != "") echo($genre . "<br>"); ?>
    <?php if ($cost != "") echo("Entrance fee: " . $cost . "&euro;<br>"); ?>
    <?php if ($agelimit != "") echo("Age limit: " . $agelimit . "<br>"); ?>
    <?php if ($beginnerfriendly == "t") echo("Beginner-friendly<br>"); ?><p>
    <p><em><?php echo $storydesc; ?></em></p>
    <p><?php echo $infodesc; ?></p>
    <ul>
        <li><?php if ($organizername != "") echo($organizername . ", "); echo "<a href='mailto:" . $organizeremail . "'>$organizeremail</a>"; ?></li>
        <?php if ($website1 != "") echo("<li><a href=\"" . $website1 . "\">" . $website1 . "</a></li>"); ?>
        <?php if ($website2 != "") echo("<li><a href=\"" . $website2 . "\">" . $website2 . "</a></li>"); ?>
    </ul>
    <script type="text/javascript">
        function popup(url, windowname, width, height)
        {
            var specs = "width=" + width + ",height=" + height + ",scrollbars=yes";
            window.open(url, windowname, specs);
            return;
        }
    </script>
    <a href="#fb_share" onClick="popup('http://www.facebook.com/sharer/sharer.php?s=100&p[title]=<?php echo($result['eventname']) ?>&p[url]=<?php echo(getShareUrl($result['id'])) ?>', 'fb_share', 550, 380)"><img src="/images/share_fb.png" height="30" width="30"></a><a href="#g_share" onClick="popup('https://plus.google.com/share?url=<?php echo(getShareUrl($result['id'])) ?>', 'g_share', 500, 600)"><img src="/images/share_g.png" height="30" width="30"></a><a href="http://twitter.com/intent/tweet?text=<?php echo($result['eventname']) ?> <?php echo(getShareUrl($result['id'])) ?>"><img src="/images/share_t.png" height="30" width="30"></a>
	
    <?php
    /* If ADMIN is logged in, show Modify event button. */
    if ($ADMIN == true) {
        $ret = "
			<form id='adminmodifyform' name='adminmodifyform' style='display:inline;' action='modifyEvent.php' method='post'>
				<input type='hidden' name='modifyid' value='" . $eventId . "'/>
				<input type='submit' class='btn btn-sm btn-warning' value='Modify'>
			</form>
        ";
        echo $ret;
    }
    ?>

    <?php echo "<hr>" ?>

</div>