<?php
/* THIS PAGE IS PROTECTED */
require ("protectedPage.php");
?>

<!DOCTYPE html>
<html>

    <!-- HEAD -->
    <?php include(__DIR__ . "/includes/head.php"); ?>
    <?php include(__DIR__ . "/../dat/connectDB.php"); ?>

    <body>

        <?php
        require (__DIR__ . "/../dat/controller.php");
        include (__DIR__ . "/../includes/data.php");
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
                  To successfully create and submit a valid event to the administrator, fill the required information fields (Event name, Date(s), Location, Info Description, and Organizer email), which are also marked with a star (*).</p>
                        <ul>
                          <li><strong>Event name, Organizer name</strong> should be no more than 100 letters</li>
                          <li>An event should not have its <strong>Starting Date</strong> after its <strong>Ending Date,</strong> the <strong>Registration Period</strong> should not start after the event has ended</li>
                          <li><strong>Location info.</strong> should match with regional choice</li>
                          <li><strong>Prices</strong> and <strong>Age limit</strong> should take numerical forms, descriptive numerical form (16+ with parental approval), or range form (10-15), and must be non-negative values</li>
                          <li><strong>Organizer Email </strong>should follow the format of <strong>[name] @ [domain-name] . [suffix]</strong></li>
                          <li><strong>URL Links </strong>must be valid and begin with <strong>http://</strong></li>
       			  </ul>
                        <p>Event created by admin is approved right away. </p>
<br/>

                        <h4 id="modify-event">Modify/Delete a pre-submitted event</h4>

                        <p>To <strong>Modify</strong> an event, 
                        simply navigate to the <a href="/admin/listView.php">List View</a> or <a href="/admin/index.php">Calendar View</a> and click on the <strong>Modify</strong> button. Modify the previous submission and then click Submit when having finished. To <strong>Delete</strong> an event, scroll down to the end of the <strong>Modify event</strong> page. A notification of Event has been modified/deleted will show up in case of valid submission.</p> 
                        <br/>


                        <h4 id="search-event">Searching for an event</h4>

                        <p>
                            To search for an event, navigate to the <a href="/admin/searchEvent.php">Search Events</a> tab and enter known information and the system will look up from the calendar database for Events that have matching information with the specified information.
                        </p> <br/>
                        
                  		<h4 id="account-management">Account Management</h4>

                        <p>
                        To create a new admin user. Simply navigate to the <a href="/admin/accountManagement.php">Account Management</a> to add a new user. A new admin user will be appear on the list of admins.
                        </p><br/>
                        
                        <h4 id="approve-deny-event">Approve/Deny an event </h4>

                        <p>
                        The list of pending event is shown in the <a href="/admin/eventsApproval.php">Events Approval</a> menu. Admin has the right to approve, or deny a pending event. It is also possible to modify before approving an event.</p>
                        <br/>
                        
                        <h4 id="FAQ">FAQ</h4>

                        <p> Question 1 ? <br/>  Answer 1
                        </p> <br/>

                        <h4 id="support">Questions not answered?</h4>

                        <p>
                            Contact LARP admins via <a href="mailto:admin@larp.fi">admin@larp.fi</a>
                        </p> <br/>

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
