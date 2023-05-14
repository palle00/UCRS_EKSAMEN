<?php

session_start();

//Check if the user is loggedin, if not kick em out
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit();
}

require_once "../../config.php";

if(isset($_POST['selected'])) {
  // Get the selected names array from POST
  $selected_names = $_POST['selected'];
  
  // Prepare delete statement
  $delete_stmt = $link->prepare("DELETE FROM Elev WHERE Kode = ?");

  // Loop over the selected names and delete them
  foreach ($selected_names as $name) {
    $delete_stmt->bind_param("s", $name);
    $delete_stmt->execute();
  }

  $delete_stmt->close();
}
$link->close();
?>