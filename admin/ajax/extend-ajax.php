<?php


session_start();

// Tjek om brugeren er logget ind, hvis ikke redirect dem til login siden
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login");
    exit();
}

require_once '../../config.php';


$Dato = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +'.'1200 seconds'));


    $sql = "UPDATE Fest
            SET Fest.Billet_slut = ?
            WHERE Fest.Aktiv = 1";
    
    // Prepare the statement
    $stmt = $link->prepare($sql);

    // Bind the $filter variable to the placeholder in the statement
    $stmt->bind_param("s", $Dato);

    // Execute the statement
    $stmt->execute();
    $link->close();
?>