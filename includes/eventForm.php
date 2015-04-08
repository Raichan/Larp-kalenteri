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

            $("#illusionsync")
              .removeAttr('title')
              .removeAttr('disabled');

            $("#illusionsync").parent().find('span.illusion-error').remove();
        }

        else if (document.getElementById("date_text").checked) {
            document.getElementById("datestart").disabled = true;
            document.getElementById("dateend").disabled = true;
            document.getElementById("datetext").disabled = false;
            
            var dateRequiredText = $("#illusionsync").attr('data-date-required');
            $("#illusionsync")
              .attr({
                'title': dateRequiredText,
                'disabled': 'disabled'
              });
            $("#illusionsync")
              .parent()
              .append($('<span>').addClass('illusion-error').text(dateRequiredText));
        }


        
    }

    function checkRadioButton(button) {
        document.getElementById(button).checked = true;
        dateButtons();
    }
</script>

<div id="form_container">
    <form id="submiteventform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <p><?php echo $text_mandatory; ?></p>
        <input type="hidden" id="eventid" name="eventid" value="<?php echo($eventid) ?>">
        <p><label for="eventname"><?php echo $label_name; ?></label><br>
            <input id="eventname" name="eventname" type="text" maxlength="100" value="<?php echo $eventname; ?>"/><span class="error"><?php echo $nameErr; ?></span></p> 

        <p><label for="eventtype"><?php echo $label_type; ?></label><br>
            <select id="eventtype" name="eventtype"> 
                <option value="2" selected="selected"><?php echo $type_larps; ?></option>
                <option value="3"><?php echo $type_cons; ?></option>
                <option value="4"><?php echo $type_workshops; ?></option>
                <option value="5"><?php echo $type_other; ?></option>
            </select></p>

        <p><label for="datestart"><?php echo $label_dates; ?></label><br>
            <small><?php echo $text_dates; ?></small><br>
            <span>
                <input type="radio" name="dateselect" id="date_datepicker" onchange="dateButtons();" value="1" />
                <input type="text" id="datestart" name="datestart" onfocus="checkRadioButton('date_datepicker');" value="<?php echo $datestart; ?>"> - <input type="text" id="dateend" name="dateend" value="<?php echo $dateend; ?>"> 
            </span><span class="error"><?php echo $dateErr; ?></span><br>
            <input type="radio" name="dateselect" id="date_text" onchange="dateButtons();" value="2" />
            <input type="text" id="datetext" name = "datetext" onfocus="checkRadioButton('date_text');" value="<?php echo $datetext; ?>">
        </p>

        <p><label for="signupstart"><?php echo $label_signup; ?></label><br>
            <span>
                <input type="text" id="signupstart" name="signupstart" value="<?php echo $signupstart; ?>"> - <input type="text" id="signupend" name="signupend" value="<?php echo $signupend; ?>"> 
            </span><span class="error"><?php echo $signupErr; ?></span></p>

        <p><label for="location1"><?php echo $label_locationmandatory; ?></label><br>
            <small><?php echo $text_location; ?></small><br>
            <select id="location1" name="location1"> 
                <option value="2" selected="selected"><?php echo $location_south; ?></option>
                <option value="3"><?php echo $location_southwest; ?></option>
                <option value="4"><?php echo $location_west; ?></option>
                <option value="5"><?php echo $location_east; ?></option>
                <option value="6"><?php echo $location_north; ?></option>
				<option value="7"><?php echo $location_lapland; ?></option>
				<option value="8"><?php echo $location_abroad; ?></option>
            </select>
            <input id="location2" name="location2" type="text" maxlength="100" value="<?php echo $location2; ?>"/><span class="error"><?php echo $locaErr; ?></span></p>

        <p><label for="icon"><?php echo $label_icon; ?></label><br>
            <small><?php echo $text_icon; ?></small><br>
            <input id="icon" name="icon" type="text" value="<?php echo $icon; ?>"/><span class="error"><?php echo $iconErr; ?></span></p> 

        <p><label for="genrelist"><?php echo $label_genre; ?></label><br>
            <span>
                <input id="genre_fantasy" name="genre[1]" type="checkbox" value="fantasy" <?php if (strpos($genrestring, 'fantasy') !== false) echo( 'checked'); ?>/>
                <label for="genre_fantasy"><?php echo $genre_fantasy; ?></label>
                <input id="genre_scifi" name="genre[2]" type="checkbox" value="sci-fi" <?php if (strpos($genrestring, 'sci-fi') !== false) echo( 'checked'); ?>/>
                <label for="genre_scifi"><?php echo $genre_scifi; ?></label>
                <input id="genre_cyberpunk" name="genre[3]" type="checkbox" value="cyberpunk" <?php if (strpos($genrestring, 'cyberpunk') !== false) echo( 'checked'); ?>/>
                <label for="genre_cyberpunk"><?php echo $genre_cyberpunk; ?></label>
                <input id="genre_steampunk" name="genre[4]" type="checkbox" value="steampunk" <?php if (strpos($genrestring, 'steampunk') !== false) echo( 'checked'); ?>/>
                <label for="genre_steampunk"><?php echo $genre_steampunk; ?></label>
                <input id="genre_postapo" name="genre[5]" type="checkbox" value="post-apocalyptic" <?php if (strpos($genrestring, 'post-apocalyptic') !== false) echo( 'checked'); ?>/>
                <label for="genre_postapo"><?php echo $genre_postapo; ?></label>
				<br>
                <input id="genre_historical" name="genre[6]" type="checkbox" value="historical" <?php if (strpos($genrestring, 'historical') !== false) echo( 'checked'); ?>/>
                <label for="genre_historical"><?php echo $genre_historical; ?></label>
                <input id="genre_thriller" name="genre[7]" type="checkbox" value="thriller" <?php if (strpos($genrestring, 'thriller') !== false) echo( 'checked'); ?>/>
                <label for="genre_thriller"><?php echo $genre_thriller; ?></label>
                <input id="genre_horror" name="genre[8]" type="checkbox" value="horror" <?php if (strpos($genrestring, 'horror') !== false) echo( 'checked'); ?>/>
                <label for="genre_horror"><?php echo $genre_horror; ?></label>
                <input id="genre_reality" name="genre[9]" type="checkbox" value="reality" <?php if (strpos($genrestring, 'reality') !== false) echo( 'checked'); ?>/>
                <label for="genre_reality"><?php echo $genre_reality; ?></label>
                <input id="genre_city" name="genre[10]" type="checkbox" value="city larp" <?php if (strpos($genrestring, 'city larp') !== false) echo( 'checked'); ?>/>
                <label for="genre_city"><?php echo $genre_city; ?></label>
				<br>
                <input id="genre_newweird" name="genre[11]" type="checkbox" value="new weird" <?php if (strpos($genrestring, 'new weird') !== false) echo( 'checked'); ?>/>
                <label for="genre_newweird"><?php echo $genre_newweird; ?></label>
                <input id="genre_action" name="genre[12]" type="checkbox" value="action" <?php if (strpos($genrestring, 'action') !== false) echo( 'checked'); ?>/>
                <label for="genre_action"><?php echo $genre_action; ?></label>
                <input id="genre_drama" name="genre[13]" type="checkbox" value="drama" <?php if (strpos($genrestring, 'drama') !== false) echo( 'checked'); ?>/>
                <label for="genre_drama"><?php echo $genre_drama; ?></label>
                <input id="genre_humor" name="genre[14]" type="checkbox" value="humor" <?php if (strpos($genrestring, 'humor') !== false) echo( 'checked'); ?>/>
                <label for="genre_humor"><?php echo $genre_humor; ?></label>
            </span></p>
        <p><label for="cost"><?php echo $label_cost; ?></label><br>
            <small><?php echo $text_cost; ?></small><br>
            <input id="cost" name="cost" type="text" maxlength="100" value="<?php echo $cost; ?>"/><span class="error"><?php echo $costErr; ?></span></p> 
        <p><label for="agelimit"><?php echo $label_agelimit; ?></label><br>
            <input id="agelimit" name="agelimit" type="text" maxlength="100" value="<?php echo $agelimit; ?>"/></p>
        <p>
            <span>
                <input id="beginnerfriendly" name="beginnerfriendly" type="checkbox" value="1" <?php if ($beginnerfriendly == "t") echo( 'checked'); ?>/>
                <label for="beginnerfriendly"><?php echo $label_beginnerfriendliness; ?></label>
            </span>
			<br>
			<span>
                <input id="eventfull" name="eventfull" type="checkbox" value="1" <?php if ($eventfull == "t") echo( 'checked'); ?>/>
                <label for="eventfull"><?php echo $label_eventfull; ?></label>
            </span>
			<br>
			<span>
                <input id="invitationonly" name="invitationonly" type="checkbox" value="1" <?php if ($invitationonly == "t") echo( 'checked'); ?>/>
                <label for="invitationonly"><?php echo $label_invitationonly; ?></label>
            </span>
			<br>
			<span>
                <input id="languagefree" name="languagefree" type="checkbox" value="1" <?php if ($languagefree == "t") echo( 'checked'); ?>/>
                <label for="languagefree"><?php echo $label_languagefree; ?></label>
            </span></p>
        <p><label for="storydesc"><?php echo $label_storydesc; ?></label><br>
            <small><?php echo $text_storydesc; ?></small><br>
            <textarea id="storydesc" name="storydesc" maxlength="1000"><?php echo $storydesc; ?></textarea></p>
        <p><label for="infodesc"><?php echo $label_infodesc; ?></label><br>
            <small><?php echo $text_infodesc; ?></small><br>
            <textarea id="infodesc" name="infodesc" maxlength="3000"><?php echo $infodesc; ?></textarea><span class="error"><?php echo $infoErr; ?></span></p> 
        <p><label for="organizername"><?php echo $label_orgname; ?></label><br>
            <input id="organizername" name="organizername" type="text" maxlength="100" value="<?php echo $organizername; ?>"/></p>
        <p><label for="organizeremail"><?php echo $label_orgemail; ?></label><br>
            <input id="organizeremail" name="organizeremail" type="text" maxlength="100" value="<?php echo $organizeremail; ?>"/><span class="error"><?php echo $orgEmailErr; ?></span></p> 
        <p><label for="website1"><?php echo $label_link1; ?></label><br>
            <input id="website1" name="website1" type="text" maxlength="100" value="<?php echo $website1; ?>"/><span class="error"><?php echo $web1Err; ?></span></p>
        <p><label for="website2"><?php echo $label_link2; ?></label><br>
            <input id="website2" name="website2" type="text" maxlength="100" value="<?php echo $website2; ?>"/><span class="error"><?php echo $web2Err; ?></span></p> 
        
        <p>
          <span>
            <input id="illusionsync" name="illusionsync" type="checkbox" value="1" checked="checked" data-date-required="<?php echo $daterequired_illusion ?>"/>
            <label for="illusionsync"><?php echo $label_illusion; ?></label>
          </span>
          <p>
            <small><?php echo $text_illusion; ?></small>
          </p>
        </p>
            
        <input class="btn btn-primary" id="save" type="submit" name="submit" value="<?php echo $button_submit; ?>" />
    </form>	
</div>