<?php
// Initialize the session
session_start();
 
// Fjern alle sessions variabler
$_SESSION = array();
 
// Destroy sessionen
session_destroy();
 
// Redirect til login siden
header("location: login");
exit;
?>