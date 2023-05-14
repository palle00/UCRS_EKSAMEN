<?php

session_start();

//Check if the user is loggedin, if not kick em out
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit();
}

require_once "../../config.php";

if(isset($_POST['data'])) {
  // Get the selected names array from POST
  $selected_names = $_POST['data'];

    $sql = 'SELECT Fest.Navn, FestDeltager.Deltog FROM Fest
    LEFT JOIN FestDeltager ON Fest.ID = FestDeltager.FestID
    WHERE Fest.ID = ? 
    AND FestDeltager.Elev_navn = ? 
    AND Fest.Aktiv = 1 
    AND FestDeltager.Deltog IN (0,1)';

    $stmt = $link->prepare($sql);
    $stmt->bind_param("is", $_POST['data'][0], $_POST['data'][1]);
    $stmt->execute();
    

     // Get the result set
     $result = $stmt->get_result();

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


}

?>