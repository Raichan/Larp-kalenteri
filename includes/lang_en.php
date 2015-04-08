<?php

// includes/head.php

$head_title = "LARP.fi Event calendar";

// includes/header.php

$header_title = "Event calendar";
$admin_title = "(Admin interface)";

// includes/navigation.php

$nav_calendar = "Calendar view";
$nav_list = "List view";
$nav_search = "Search events";
$nav_create = "Create event";
$nav_modify = "Modify event";
$nav_help = "Help";
$nav_admin = "Admin";

// includes/calendar.php

$cal_mon = "MON";
$cal_tue = "TUE";
$cal_wed = "WED";
$cal_thu = "THU";
$cal_fri = "FRI";
$cal_sat = "SAT";
$cal_sun = "SUN";

// includes/monthNavigator.php

$button_today = "Today";
$button_prev = "Prev";
$button_next = "Next";

// includes/upcomingEvents.php

$upcoming = "Upcoming events";

// listView.php

$noevents = "There are no events in the calendar.";
$listview = "List view";
$ambiguous = "Events with ambiguous date";

// event.php

$notfound = "Something went wrong and the event couldn't be found.";

// includes/checkFormErrors.php

$err_name = " Name is required";
$err_startdate = "Start date is required";
$err_date = "Invalid date";
$err_bothdates = "Please enter both dates";
$err_location = " Location is required";
$err_icon = " Invalid icon URL";
$err_cost = " Invalid cost";
$err_desc = " Description is required";
$err_emailreq = " Organizer email is required";
$err_emailinv = " Invalid email";
$err_url = " Invalid URL";

// includes/eventForm.php

$text_mandatory = "The fields marked with * are mandatory.";
$label_name = "Event name *";
$label_type = "Event type";
$type_larps = "Larps";
$type_cons = "Conventions and meetups";
$type_workshops = "Courses and workshops";
$type_other = "Other";
$label_dates = "Date(s) *";
$text_dates = 'The first option is for dates. Only include the necessary days. (If your event is on Saturday but people can arrive on Friday and leave on Sunday, only include Saturday.) If your event only takes one day, leave the second field empty. Use the datepicker or enter the dates as dd/mm/yyyy. If the date hasn\'t been decided yet, use the second text field for options like "Spring 2016" or "sometime next year".';
$label_signup = "Signup period";
$label_locationmandatory = "Location *";
$text_location = "The dropdown will be used for searching events and the text field input will be shown in the event information.";
$location_south = "Southern Finland";
$location_southwest = "Southwestern Finland";
$location_west = "Western and Inner Finland";
$location_east = "Eastern Finland";
$location_north = "Northern Finland";
$location_lapland = "Lapland";
$location_abroad = "Abroad";
$label_icon = "Event icon";
$text_icon = "URL of a picture you want to use. Preferred size 100x100px.";
$label_genre = "Genre";
$genre_fantasy = "Fantasy";
$genre_scifi = "Sci-fi";
$genre_cyberpunk = "Cyberpunk";
$genre_steampunk = "Steampunk";
$genre_postapo = "Post-apocalyptic";
$genre_historical = "Historical";
$genre_thriller = "Thriller";
$genre_horror = "Horror";
$genre_reality = "Reality";
$genre_city = "City larp";
$genre_newweird = "New weird";
$genre_action = "Action";
$genre_drama = "Drama";
$genre_humor = "Humor";
$label_cost = "Cost";
$text_cost = "Only single numbers (e.g. 10) and ranges (e.g. 20-25) are accepted.";
$label_agelimit = "Age limit";
$label_beginnerfriendliness = "Beginner-friendly";
$label_eventfull = "Event is full";
$label_invitationonly = "Invitation only";
$label_languagefree = "Language-free event";
$label_storydesc = "Story description";
$text_storydesc = "Maximum length 1000 characters.";
$label_infodesc = "Info description *";
$text_infodesc = "Maximum length 3000 characters.";
$label_orgname = "Organizer name";
$label_orgemail = "Organizer email *";
$label_link1 = "Web site 1";
$label_link2 = "Web site 2";
$label_illusion = "Create Illusion event";
$text_illusion = "Event will be created also into the Forge &amp; Illusionin event calendar (<a href=\"http://www.forgeandillusion.net/illusion/\">www.forgeandillusion.net/illusion</a>)";
$daterequired_illusion = "Illusion events require dates. You can create the event afterwards by modifying the event";
$button_submit = "Submit";

// includes/eventInfo.php

$button_signupopen = "Signup open";
$button_beginnerfriendly = "Beginner-friendly";
$button_eventfull = "Full";
$button_invitationonly = "Invitation only";
$button_languagefree = "Language-free";
$info_signup = "Signup: ";
$info_cost = "Participation fee: ";
$info_agelimit = "Age limit: ";

// searchEvent.php
// many of the missing fields are located under includes/eventForm.php

$title_search = "Search for events";
$label_freesearch = "Free word search";
$type_allevents = "All events";
$label_date = "Events between dates";
$label_location = "Location";
$location_any = "Any";
$genre_all = "Check all";
$label_maxcost = "Maximum cost";
$label_signupopen = "Events with signup open only";
$label_beginnerfriendly = "Beginner-friendly events only";
$label_pastevents = "Include past events">
$button_search = "Search";

// searchResults.php

$title_searchresults = "Search results";

// createEvent.php

$title_createevent = "Create a new event";

// createSuccess.php

$title_createsuccess = "Event submitted successfully";
$text_createsuccess = "Thank you!<br>
                        Your event has now been saved and is waiting for admin approval. When it has been accepted, you will get an email with a password for modifying the event.";

// modifyPassword.php

$err_pass1 = "Incorrect password.";
$err_pass2 = "Please enter a password.";
$enterpassword = "Enter event password";
$button_find = "Find event";

// modifyEvent.php

$modify_title = "Modify an event";
$modify_delete = "Delete event";
$modify_deleteconfirm = "Delete event?";
$modify_deletetext = "You are about to delete your event. It can't be recovered.";
$modify_cancel = "Cancel";

// modifySuccess.php

$title_modifysuccess = "Event modified successfully";
$text_modifysuccess = "Thank you!<br>
                        Your modifications have now been saved and are waiting for admin approval. You can still use the same password for possible further modifications.";

// deleteSuccess.php

$title_deletesuccess = "Event deleted";
$text_deletesuccess = "Your event was deleted successfully.";
						
// includes/emails.php

$admin_subject = 'Pending event in larp calendar';
$admin_msg1 = 'An event ';
$admin_msg2 = '
	has been submitted or modified in the larp calendar
	and requires your attention.
	
	Log in to see the event:
	http://beta.larp.fi/login.php';

$approved_subject = 'Your larp calendar event';
$approved_msg1 = 'Your larp calendar event (or its modifications): ';
$approved_msg2 = '
	has just been approved.';
$approved_msg3 = '
		
		Admin comments: 
		';
$approved_msg4 = '
	
	You can now view your event in the calendar:
	http://beta.larp.fi/
	
	Your password for modifying the event is: ';
$approved_msg5 = '
	
	Please contact larp.kalenteri@gmail.com if you have any questions.';
$denied_subject = 'Your larp calendar event';
$denied_msg1 = 'Your new larp calendar event: ';
$denied_msg2 = '
	was denied by the admins with the following comments:
	';
$denied_msg3 = '
	
	Please contact larp.kalenteri@gmail.com if you have any questions.';

// loginForm.php

$login_title = "Login";
$err_login1 = "Bad login.";
$err_login2 = "Please login using username and password.";
$err_login3 = "You forgot something. Please login using username and password.";	
$label_username = "Username";
$label_password = "Password";
$button_login = "Login";

// includes/footer.php

$text_footer = 'Bugs? Questions? Improvement ideas? Please give feedback <a href="https://docs.google.com/forms/d/1KjfuzsegKHCLh_10gBNYS7lqkTmwDsWwVgyiqhfO8M8/viewform">here</a>.';

// admin/accountManagement.php

$accman_title = "Account management";

// admin/eventsApproval.php

$evapp_title = "Events approval";
$evapp_text1 = "You are about to approve the event";
$evapp_text2 = "Please confirm the approval and add a comment to user if needed.";
$btn_approve = "Approve";
$btn_deny = "Deny";
$btn_back = "Back";
$evdeny_text1 = "You are about to deny the event";
$evdeny_text2 = "Please confirm the denial and add a comment to user if needed.";
$admincomments = "Comments:";
$dontsend = "Don't send an email about the denial";

// admin/includes/adminsForm.php

$addadmin = "Add new admin";
$admin_msg0 = "New user successfully added.";
$admin_msg1 = "* All the fields are mandatory.";
$admin_msg2 = "* Username already exists. Please choose another one.";
$admin_msg3 = "* Provided passwords don't match.";
$admin_msg33 = "* Password must be at least 5 characters long.";
$admin_msg4 = "* An error has occured. Please try again later.";
$admin_name = "Name";
$admin_surname = "Surname";
$admin_email = "Email";
$admin_username = "Username";
$admin_pass = "Password";
$admin_confirmpass = "Confirm password";
$admin_add = "Add";

// admin/includes/adminsFormDelete.php

$admin_deletetitle = "Delete account:";
$admin_delete = "Delete";

// admin/includes/adminsFormModify.php

$admin_modifytitle = "Modify password for account:";
$admin_currentpass = "Current password";
$admin_newpass = "New password";
$admin_confirmnewpass = "Confirm new password";
$admin_modify = "Modify";

// admin/includes/adminsTable.php

$admin_deletesuccess = "Admin account was deleted successfully.";
$admin_passnomatch = "* Provided password doesn't match. Please try again.";
$admin_shortpass = "* Password must be at least 5 characters long.";
$admin_passmodsuccess = "Password modified successfully.";
$admin_error = "* An error has occured. Please, check the provided passwords and try again.";
$admin_action = "Action";

// admin/includes/eventsTable.php

$event_approved = "Event was approved successfully.";
$event_denied = "Event was denied successfully.";
$event_error = "An error has occured. Please try again later.";
$event_name = "Event name";
$event_type = "Event type";
$event_start = "Start date";
$event_end = "End date";
$event_location = "Location";
$event_genre = "Genre";
$event_cost = "Cost";
$event_agelimit = "Age limit";
$event_beginners = "Beginners";
$event_more = "More info";
$event_action = "Action";
$event_none = "There are no events for approval.";

// help.php

$title_help = "Instructions to use the Larp Calendar";

$main_help = '<p>In the Larp Calendar you will find live action roleplaying games and other related events. The events can be viewed in either the calendar view or the list view like the one in the old Larp Calendar and you can also search for events by e.g. location, date, cost and age limit. The events can also be shared in social media. You can add your own event by filling out a form and the created events can also be modified afterwards.</p>
<hr>
<h4>What can be added to the calendar and by whom?</h4>
<p>The main objectives of the Larp Calendar are as follows:<br>
1. Helping the players: Where can I find my first larp? What kind of Potter larps are coming up this year? For which games can I sign up right now?<br>
2. Helping the game masters: Is there already an event on the weekend you have been considering? Have there been similar games recently?<br>
3. Documenting the Finnish larp scene: What kind of games were organized five years ago? What kind of sci-fi larps have there been recently? Who organized that one awesome game?</p>
<p>Therefore anyone can announce any kind of larp in the calendar. We want all the larps that want Finnish participants to be added to the calendar. This covers everything from small games by new GMs to epic fantasy stories. Even if your game is invitation only or already full, add it anyway - this way you can let other GMs know about when your game is and avoid overlapping events or maybe find interested players in case someone cancels. You can also add games organized by someone else assuming you have their permission to do so.</p>
<p>In addition to larps, other related events like cons, meetups, courses and workshops can also be announced in the calendar. For example historical dances and boffing are also welcome since they share participants with larps. If you\'re not sure if your event is suitable for the calendar, contact us!</p>
<hr>
<h4>Adding an event</h4>
<p>To add an event, fill out the form on the "Create event" page. Only the fields for name, date, location, description and organizer email are mandatory. Some instructions for adding events:<br>
- If you\'re not sure about the exact date of your event yet, use the second date field that accepts textual descriptions like "in 2016" or "next spring". Please note that this kind of events won\'t show up in search if searched by date.<br>
- When choosing a location please note that the areas have been divided by Regional State Administrative Agencies of Finland (<a href="http://en.wikipedia.org/wiki/Regional_State_Administrative_Agencies_of_Finland">lisätietoa</a>) because of the lack of a better regional division.<br>
- You can also set a logo or other 100x100px sized image for your event. Please don\'t use images you don\'t have permission to use.<br>
- There can be one or more genres or none at all.<br>
- We recommend you to mark your event as beginner-friendly if there isn\'t any specific reason why it isn\'t suited for beginners.<br>
</p>
<p>After you have sent the event form the event is sent to the admins for approval. When your event has been approved you will receive an email with a password to modify the event afterwards.</p>
<hr>
<h4>The calendar team</h4>
<p>Questions, comments and feedback can me sent to calendar admins to<br>
larp.kalenteri@gmail.com</p>
<p>The calendar was developed by Laura Sirola, Slavek Dittrich and Pham Tien Hoang as a project for a web service course in Aalto University in spring 2014.</p>';

$search_disclaimer = "The search feature is still under construction.";
$date_placeholder = "01/01/2015";
$datetext_placeholder = "sometime next year";
?>