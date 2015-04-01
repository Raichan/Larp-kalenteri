<?php
if (isset($_SESSION["valid"])) {
    $ADMIN = true;
} else {
    $ADMIN = false;
}
?>

<script>
    $(function() {
        $("#datestart").datepicker({dateFormat: "dd/mm/yy", firstDay: 1});
        $("#dateend").datepicker({dateFormat: "dd/mm/yy", firstDay: 1});
        $("#signupstart").datepicker({dateFormat: "dd/mm/yy", firstDay: 1});
        $("#signupend").datepicker({dateFormat: "dd/mm/yy", firstDay: 1});

        if ($("#datestart").val() != "") {
            checkRadioButton('date_datepicker');
        }
        else if ($("#datetext").val() != "") {
            checkRadioButton('date_text');
        }
    });

    function dateButtons() {
        if (document.getElementById("date_datepicker").checked) {
            document.getElementById("datestart").disabled = false;
            document.getElementById("dateend").disabled = false;
            document.getElementById("datetext").disabled = true;
        }

        else if (document.getElementById("date_text").checked) {
            document.getElementById("datestart").disabled = true;
            document.getElementById("dateend").disabled = true;
            document.getElementById("datetext").disabled = false;
        }
    }

    function checkRadioButton(button) {
        document.getElementById(button).checked = true;
        dateButtons();
    }
</script>

<div id="form_container">
    <form id="submiteventform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <p>The fields marked with * are mandatory.</p>
        <input type="hidden" id="eventid" name="eventid" value="<?php echo($eventid) ?>">
        <p><label for="eventname">Event name *</label><br>
            <input id="eventname" name="eventname" type="text" maxlength="100" value="<?php echo $eventname; ?>"/><span class="error"><?php echo $nameErr; ?></span></p> 

        <p><label for="eventtype">Event type</label><br>
            <select id="eventtype" name="eventtype"> 
                <option value="2" selected="selected">Larps</option>
                <option value="3">Conventions and meetups</option>
                <option value="4">Workshops</option>
                <option value="5">Other</option>
            </select></p>

        <p><label for="datestart">Date(s) *</label><br>
            <small>Only include the necessary days. (If your event is on Saturday but people can arrive on Friday and leave on Sunday, only include Saturday.) If your event only takes one day, leave the second field empty. Use the datepicker or enter the dates as dd/mm/yyyy. If the date hasn't been decided yet, use text field for options like "Spring 2015" or "sometime next year".</small><br>
            <span>
                <input type="radio" name="dateselect" id="date_datepicker" onchange="dateButtons();" value="1" />
                <input type="text" id="datestart" name="datestart" onfocus="checkRadioButton('date_datepicker');" value="<?php echo $datestart; ?>"> - <input type="text" id="dateend" name="dateend" value="<?php echo $dateend; ?>"> 
            </span><span class="error"><?php echo $dateErr; ?></span><br>
            <input type="radio" name="dateselect" id="date_text" onchange="dateButtons();" value="2" />
            <input type="text" id="datetext" name = "datetext" onfocus="checkRadioButton('date_text');" value="<?php echo $datetext; ?>">
        </p>

        <p><label for="signupstart">Signup period</label><br>
            <span>
                <input type="text" id="signupstart" name="signupstart" value="<?php echo $signupstart; ?>"> - <input type="text" id="signupend" name="signupend" value="<?php echo $signupend; ?>"> 
            </span><span class="error"><?php echo $signupErr; ?></span></p>

        <p><label for="location1">Location *</label><br>
            <small>The dropdown will be used for searching events and the text field input will be shown in the event information.</small><br>
            <select id="location1" name="location1"> 
                <option value="2" selected="selected">Southern Finland</option>
                <option value="3">Western Finland</option>
                <option value="4">Eastern Finland</option>
                <option value="5">Northern Finland</option>
                <option value="6">Abroad</option>
            </select>
            <input id="location2" name="location2" type="text" maxlength="100" value="<?php echo $location2; ?>"/><span class="error"><?php echo $locaErr; ?></span></p>

        <p><label for="icon">Event icon</label><br>
            <small>URL of a picture you want to use. Preferred size 100x100px.</small><br>
            <input id="icon" name="icon" type="text" value="<?php echo $icon; ?>"/><span class="error"><?php echo $iconErr; ?></span></p> 

        <p><label for="genrelist">Genre</label><br>
            <span>
                <input id="genre_fantasy" name="genre[1]" type="checkbox" value="fantasy" <?php if (strpos($genrestring, 'fantasy') !== false) echo( 'checked'); ?>/>
                <label for="genre_fantasy">Fantasy</label>
                <input id="genre_scifi" name="genre[2]" type="checkbox" value="sci-fi" <?php if (strpos($genrestring, 'sci-fi') !== false) echo( 'checked'); ?>/>
                <label for="genre_scifi">Sci-fi</label>
                <input id="genre_cyberpunk" name="genre[3]" type="checkbox" value="cyberpunk" <?php if (strpos($genrestring, 'cyberpunk') !== false) echo( 'checked'); ?>/>
                <label for="genre_cyberpunk">Cyberpunk</label>
                <input id="genre_steampunk" name="genre[4]" type="checkbox" value="steampunk" <?php if (strpos($genrestring, 'steampunk') !== false) echo( 'checked'); ?>/>
                <label for="genre_steampunk">Steampunk</label>
                <input id="genre_postapo" name="genre[5]" type="checkbox" value="post-apocalyptic" <?php if (strpos($genrestring, 'post-apocalyptic') !== false) echo( 'checked'); ?>/>
                <label for="genre_postapo">Post-apocalyptic</label>
                <input id="genre_historical" name="genre[6]" type="checkbox" value="historical" <?php if (strpos($genrestring, 'historical') !== false) echo( 'checked'); ?>/>
                <label for="genre_historical">Historical</label>
                <input id="genre_thriller" name="genre[7]" type="checkbox" value="thriller" <?php if (strpos($genrestring, 'thriller') !== false) echo( 'checked'); ?>/>
                <label for="genre_thriller">Thriller</label>
                <input id="genre_horror" name="genre[8]" type="checkbox" value="horror" <?php if (strpos($genrestring, 'horror') !== false) echo( 'checked'); ?>/>
                <label for="genre_horror">Horror</label>
                <input id="genre_reality" name="genre[9]" type="checkbox" value="reality" <?php if (strpos($genrestring, 'reality') !== false) echo( 'checked'); ?>/>
                <label for="genre_reality">Reality</label>
                <input id="genre_city" name="genre[10]" type="checkbox" value="city larp" <?php if (strpos($genrestring, 'city larp') !== false) echo( 'checked'); ?>/>
                <label for="genre_city">City larp</label>
                <input id="genre_newweird" name="genre[11]" type="checkbox" value="new weird" <?php if (strpos($genrestring, 'new weird') !== false) echo( 'checked'); ?>/>
                <label for="genre_newweird">New weird</label>
                <input id="genre_action" name="genre[12]" type="checkbox" value="action" <?php if (strpos($genrestring, 'action') !== false) echo( 'checked'); ?>/>
                <label for="genre_action">Action</label>
                <input id="genre_drama" name="genre[13]" type="checkbox" value="drama" <?php if (strpos($genrestring, 'drama') !== false) echo( 'checked'); ?>/>
                <label for="genre_drama">Drama</label>
                <input id="genre_humor" name="genre[14]" type="checkbox" value="humor" <?php if (strpos($genrestring, 'humor') !== false) echo( 'checked'); ?>/>
                <label for="genre_humor">Humor</label>
            </span></p>
        <p><label for="cost">Cost</label><br>
            <small>Only single numbers (e.g. 10) and ranges (e.g. 20-25) are accepted.</small><br>
            <input id="cost" name="cost" type="text" maxlength="100" value="<?php echo $cost; ?>"/><span class="error"><?php echo $costErr; ?></span></p> 
        <p><label for="agelimit">Age limit</label><br>
            <input id="agelimit" name="agelimit" type="text" maxlength="100" value="<?php echo $agelimit; ?>"/></p>
        <p><label for="beginnerfriendliness">Beginner-friendliness</label><br>
            <span>
                <input id="beginnerfriendly" name="beginnerfriendly" type="checkbox" value="1" <?php if (isset($_POST['beginnerfriendly'])) echo( 'checked'); ?>/>
                <label for="beginnerfriendly">Yes</label>
            </span></p>
        <p><label for="storydesc">Story description</label><br>
            <small>Maximum length 1000 characters.</small><br>
            <textarea id="storydesc" name="storydesc" maxlength="1000"><?php echo $storydesc; ?></textarea></p>
        <p><label for="infodesc">Info description *</label><br>
            <small>Maximum length 3000 characters.</small><br>
            <textarea id="infodesc" name="infodesc" maxlength="3000"><?php echo $infodesc; ?></textarea><span class="error"><?php echo $infoErr; ?></span></p> 
        <p><label for="organizername">Organizer name</label><br>
            <input id="organizername" name="organizername" type="text" maxlength="100" value="<?php echo $organizername; ?>"/></p>
        <p><label for="organizeremail">Organizer email *</label><br>
            <input id="organizeremail" name="organizeremail" type="text" maxlength="100" value="<?php echo $organizeremail; ?>"/><span class="error"><?php echo $orgEmailErr; ?></span></p> 
        <p><label for="website1">Web Site 1</label><br>
            <input id="website1" name="website1" type="text" maxlength="100" value="<?php echo $website1; ?>"/><?php echo $web1Err; ?></span></p>
        <p><label for="website2">Web Site 2</label><br>
            <input id="website2" name="website2" type="text" maxlength="100" value="<?php echo $website2; ?>"/><?php echo $web2Err; ?></span></p> 
        <input class="btn btn-primary" id="save" type="submit" name="submit" value="Submit" />
    </form>	
</div>