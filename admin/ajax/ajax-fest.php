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

    // Prepare the SQL statement with a placeholder for the Navn value
    $sql = "SELECT
    FestDeltager.Elev_navn,
    FestDeltager.Email,
    FestDeltager.Klasse, 
    FestDeltager.Billet_pris,
    FestDeltager.Deltog
    FROM FestDeltager 
    INNER JOIN Fest ON Fest.ID = FestDeltager.FestID 
    WHERE Navn = ?
    GROUP BY FestDeltager.Elev_navn
    ";

    // Prepare the statement
    $stmt = $link->prepare($sql);

    // Bind the $filter variable to the placeholder in the statement
    $stmt->bind_param("s", $data);

    // Execute the statement
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
