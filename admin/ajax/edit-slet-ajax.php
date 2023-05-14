<?php

session_start();

//Check if the user is loggedin, if not kick em out
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit();
}
require_once '../../config.php';
  // Prepare delete statement
  $delete_stmt = $link->prepare("DELETE FROM Fest WHERE Aktiv = 1");

  // Loop over the selected names and delete them
 
    $delete_stmt->execute();
  

  $delete_stmt->close();
  $link->close();

?>