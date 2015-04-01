<?php
function sendEmail($to, $type, $comments, $eventname, $pass) {
	// Using single quotes here to avoid problems with newlines
	// FIX: Move these to a separate file to make changing language easier
	$admin_subject = 'Pending event in larp calendar';
	$admin_msg = 'An event has been submitted or modified in the larp calendar
	and requires your attention.
	
	Log in to approve, modify or deny the event:
	http://demo.hype2019.hype.tml.hut.fi/login.php';

	$approved_subject = 'Your larp calendar event has been approved';
	$approved_msg = 'Your new larp calendar event: ' . $eventname . '
	has just been approved.';
	if($comments != ''){
		$approved_msg .= '
		
		Admin comments: 
		' . $comments;
	}
	$approved_msg .= '
	
	You can now view your event in the calendar:
	http://demo.hype2019.hype.tml.hut.fi/
	
	Your password for modifying the event is: ' . $pass . '
	
	Please contact larp.kalenteri@gmail.com if you have any questions.';

	$denied_subject = 'Your larp calendar event has been denied';
	$denied_msg = 'Your new larp calendar event: ' . $eventname . '
	was denied by the admins with the following comments:
	' . $comments . '
	
	Please contact larp.kalenteri@gmail.com if you have any questions.';

	$subject = "";
	$msg = "";
	if($type == "admin" || $type == "approved" || $type == "denied"){
		if($type == "admin"){
			$subject = $admin_subject;
			$msg = $admin_msg;
		}
		if($type == "approved"){
			$subject = $approved_subject;
			$msg = $approved_msg;
		}
		if($type == "denied"){
			$subject = $denied_subject;
			$msg = $denied_msg;
		}
		$headers = 'Reply-To: larp.kalenteri@gmail.com';
		$headers .= '\r\nX-Mailer: PHP/' . phpversion();
		$headers .= '\r\nContent-type: text/plain; charset=\"UTF-8\"';
		mail($to,$subject,$msg,$headers,'-f larp.kalenteri@gmail.com');
	}
	// FIX: Error messages?
}
?>