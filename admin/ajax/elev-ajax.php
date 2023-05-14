<?php

session_start();

//Check if the user is loggedin, if not kick em out
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit();
}


require_once "../../config.php";

//sql statement that findes relevant data, joins it and sorts it
$sql = "SELECT Kode FROM Elev";
$result = $link->query($sql);


//make sure the data gets encoded in the correct json format
if ($result->num_rows > 0) {
   echo "[";
   $yes = 0; 
    while($row = $result->fetch_assoc()) {
      echo json_encode($row);
     if($yes < $result->num_rows-1)
     {
        echo ",";
     }
      $yes++;
      
    }
    echo "]";
} 

//close the connection to the server for safty reason
$link->close();
?>
