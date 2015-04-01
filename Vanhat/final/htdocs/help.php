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

				<!-- HELP CONTENT GOES HERE -->

				<h1 id="welcome-message">Welcome to LARP Calendar</h1>
                <br/>
				<p>
					LARP Calendar connects LARPers and Admins. LARPers could easily keep an eye on the coming events, share events on social networks. Admins tasks are considerably simplified and organized. The calendar is also friendly with mobile browsers through <a href="/listView.php">List View</a> interface.
				</p>
                <br/>
				<h4 id="create-event">Create an event</h4>

				<p>
					Navigate to <a href="/createEvent.php"> Create Event</a> tab to create an event
                    To successfully create and submit a valid event to the administrator, fill the required information fields (Event name, Date(s), Location, Info Description, and Organizer email), which are also marked with a star (*).
                    Below are requirements for submitting a valid event.<br/>
              <ul>
                          <li><strong>Event name, Organizer name</strong> should be no more than 100 letters</li>
                          <li>An event should not have its <strong>Starting Date</strong> after its <strong>Ending Date,</strong> the <strong>Registration Period</strong> should not start after the event has ended</li>
                          <li><strong>Location info.</strong> should match with regional choice</li>
                          <li><strong>Prices</strong> and <strong>Age limit</strong> should take numerical forms, descriptive numerical form (16+ with parental approval), or range form (10-15), and must be non-negative values</li>
                          <li><strong>Organizer Email </strong>should follow the format of <strong>[name] @ [domain-name] . [suffix]</strong></li>
                          <li><strong>URL Links </strong>must be valid and begin with <strong>http://</strong></li>
              </ul>
                    <br/>
                    A submitted event will have to be approved by one of the LARP administrators before it could be shown on the page calendar. A <em><strong>unique password</strong></em> for the event would be sent to the event organizer email which is used when modifying the event.
</p> <br/>

				<h4 id="modify-event">Modify a pre-submitted event</h4>

				<p>
				To <strong>Modify</strong> an event that was submitted previously, navigate to the <a href="/modifyPassword.php">Modify Event</a> tab, enter the <strong>Event Password</strong> which was previously sent to the event organizer email when creating the event. Modify the previous submission and then click Submit when having finished. To <strong>Delete</strong> an event, scroll down to the end of the <strong>Modify event</strong> page. A notification of Event has been modified/deleted will show up in case of valid submission.</p> 
				<br/>


				<h4 id="search-event">Searching for an event</h4>

				<p>
					To search for an event, navigate to the <a href="/searchEvent.php">Search Events</a> tab and enter known information and the system will look up from the calendar database for Events that have matching information with the specified information<strong>.</strong></p> <br/>
				<h4 id="share-event">Share an event</h4>
              <p> By clicking on the share button listed below of each event in the <a href="/index.php">Calendar</a> or <a href="/listView.php">List views</a>, it is possible to share an event to common social networks such as Facebook, Google Plus, Twitter.</p> <br/>
              <h4 id="sign-up">Sign up for an event</h4>
              <p> LARP admins are not responsible for signing up process for each particular event. LARPers who wish to sign for an event, please contact the event organizers through the email addresses mentioned in each event description. Event with open registration time are indicated with a Signup Open logo.</p>
              <p><br/>
              
              <h4 id="faq">FAQ</h4>

                <p> 
              <strong>Question: </strong>Why are events in Espoo listed in Northern Finland events search ? <br/>
              </p>
                <p>              When creating an event, event organizer should specify the regional location correctly otherwise it would create confusion to LARPers. Anyway, LARP admins work hard in order to avoid these kinds of confusion but things run out of control sometimes. </p>
                <p><strong>Question: </strong>How to modify a submitted event, before it is approved?</p>
                <p>In this case, please recreate another event with the modified information and inform the staffs by sending email to <a href="mailto:larp.kalenteri@gmail.com">larp.kalenteri@gmail.com</a>
                </p>
                <br/>
                <h4 id="support">Questions not answered?</h4>

				<p>
					Contact LARP admins via <a href="mailto:larp.kalenteri@gmail.com">larp.kalenteri@gmail.com</a>
				</p> <br/>

				<?php
                    if (isset($_SESSION["valid"])) {
                        $ADMIN = true;
                    } else {
                        $ADMIN = false;
                    }
                    echo $ADMIN;
                    ?>

				<!-- HELP CONTENT GOES HERE -->

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
