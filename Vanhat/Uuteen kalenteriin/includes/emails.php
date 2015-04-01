<?php

function sendEmail($to, $type, $comments, $eventname, $pass) {
	if (isset($_COOKIE["language"])){
		if($_COOKIE["language"] == "en"){
			include (__DIR__ . "/lang_en.php");
		}
		else{
			include (__DIR__ . "/lang_fi.php");
		}
	}
	else{
		include (__DIR__ . "/lang_fi.php");
	}

	$approved_msg = $approved_msg1 . $eventname . $approved_msg2;
	if($comments != ''){
		$approved_msg .= $approved_msg3 . $comments;
	}
	$approved_msg .= $approved_msg4 . $pass . $approved_msg5;

	$denied_msg = $denied_msg1 . $eventname . $denied_msg2 . $comments . $denied_msg3;

	$subject = "";
	$msg = "";
	if($type == "admin" || $type == "approved" || $type == "denied"){
		if($type == "admin"){
			$subject = $admin_subject;
			$msg = $admin_msg1 . $eventname . $admin_msg2;
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