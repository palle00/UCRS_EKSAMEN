<?php

session_start();

//Check if the user is loggedin, if not kick em out
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit();
}

require_once "../../config.php";


if(isset($_POST['origNavn'])) {
  // Get the selected names array from POST
  $origNavn = $_POST['origNavn'];
  $navn = $_POST['navn'];
  $kode = $_POST['kode'];
  $rolle = $_POST['rolle'];

  // Prepare delete statement
  if(isset($_POST['origNavn'])) {
    // Get the selected names array from POST
    $origNavn = $_POST['origNavn'];
    $navn = $_POST['navn'];
    $kode = password_hash($_POST['kode'], PASSWORD_DEFAULT);
    $rolle = $_POST['rolle'];
  
    // Prepare update statement
    $sql = "UPDATE `Login` SET `Brugernavn` = ?, `Kode` = ?, `Rolle` = ? WHERE `Brugernavn` = ?";
  
    // Update the row with the new values
    $stmt = $link->prepare($sql);
    $stmt->bind_param("ssss", $navn, $kode, $rolle, $origNavn);
    $stmt->execute();
    $stmt->close();
  }
}  

?>