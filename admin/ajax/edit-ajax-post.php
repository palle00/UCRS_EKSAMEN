<?php
session_start();



//Check if the user is loggedin, if not kick em out
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

require_once "../../config.php";
if (!empty($data)) {
    //Loop over all the POST data and assign them as the name from the form inputs
    foreach ($data as $name => $value) {
      $$name = $value;
     
    }

   
    $sql = "SELECT Fest.prisID FROM `Fest` WHERE Aktiv = 1";
    $result = $link->query($sql);
    $row = $result->fetch_assoc();
    $prisID = $row['prisID'];

        // If the price exists, update its values
        $sql = "UPDATE `Pris` SET `Tilbuds_pris`=?, `Tilbuds_dage`=?, `Standard_pris`=? WHERE `ID`=?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("iiii", $Tilbuds_pris, $Tilbuds_dage, $Standard_pris, $prisID);
        $stmt->execute();
  
      // Update all rows in the Fest table with the new data
      $sql = "UPDATE `Fest` SET `Navn`=?, `Fest_start`=?, `Billet_start`=?, `Billet_slut`=?, `Drink_billetter`=? WHERE Aktiv = 1";
      $stmt = $link->prepare($sql);
      $stmt->bind_param(
        "ssssi",
        $navn,
        $Fest_start,
        $Billet_start,
        $Billet_slut,
        $Drink_billetter,
      );
      $stmt->execute();
    }
  
?>