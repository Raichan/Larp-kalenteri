<?php
  
  require_once __DIR__ . '/../vendor/autoload.php';

  class Mailer {
  	
  	private $twig;
  	
  	public function __construct() {
  		$this->twig = new Twig_Environment(new Twig_Loader_Filesystem( __DIR__ . '/../twigs'));
  	}
  	
  	public function sendApprovedFnI($recipient, $modified, $event_url, $fni_event_url, $email, $password, $fni_user_created, $comments) {
  		$locale = isset($_COOKIE["language"]) && ($_COOKIE["language"] == 'en') ? 'en' : 'fi';
      include (__DIR__ . "/lang_$locale.php");
  		
  		$body = $this->twig->render("event_approved_fni_$locale.twig", [
  			'modified' => $modified,
     		'eventurl' => "http://kalenteri.larp.fi",
     		'fnieventurl' => $fni_event_url,
     		'password' => $password,
  			'fniusercreated' => $fni_user_created,
     		'fniemail' => $email,
     		'fnipassword' => $password,
     		'comments' => $comments
  		]);
  		
  		$this->sendMail($recipient, $approved_msg1, $body);
  	}
  	
  	private function sendMail($recipient, $subject, $body) {
  		$headers = 'Reply-To: larp.kalenteri@gmail.com';
  		$headers .= '\r\nX-Mailer: PHP/' . phpversion();
  		$headers .= '\r\nContent-type: text/plain; charset=\"UTF-8\"';
  		mail($recipient['mail'], $subject, $body, $headers, '-f larp.kalenteri@gmail.com');
  	}
  	
  }
  
?>