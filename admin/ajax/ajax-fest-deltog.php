<?php

session_start();

//Check if the user is loggedin, if not kick em out
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit();
}

require_once "../../config.php";
$data = $_POST['data'];

if(isset($data)){

    $to_insert = 1;
    // Prepare the SQL statement with a placeholder for the $filter value
    $sql = "UPDATE FestDeltager
            INNER JOIN Fest ON Fest.ID = FestDeltager.FestID
            SET FestDeltager.`Deltog` = ?
            WHERE Fest.ID = ?
            AND FestDeltager.Elev_navn = ?
            AND Fest.Aktiv = 1";
            
    
    // Prepare the statement
    $stmt = $link->prepare($sql);

    // Bind the $filter variable to the placeholder in the statement
    $stmt->bind_param("iis", $to_insert, $data[0], $data[1]);

    // Execute the statement
    $stmt->execute();

//close the connection to the server for safty reason
$link->close();
}
?>
