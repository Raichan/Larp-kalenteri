<?php

$lang = "fi";
if( isset( $_POST["lang"] ) ) {
    $lang = $_POST["lang"];
    setcookie ( 'language', $lang, time() + 60*60*24*30, '/', $_SERVER['HTTP_HOST']);
    header( "Location: " . $_POST["url"] );
}

if( isset( $_POST["url"] ) ) {
	header( "Location: " . $_POST["url"] );
}
else{
	header( "Location: http://" . $_SERVER['HTTP_HOST'] );
}

?>