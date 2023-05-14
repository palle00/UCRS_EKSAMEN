<?php

session_start();



require_once "../../config.php";

    $sort = isset($_POST['data']) ? $_POST['data'] : 'ASC';

    

    // Prepare the SQL statement with a placeholder for the $filter value
    
   $sql = "SELECT
    FestDeltager.Elev_navn,
    FestDeltager.Klasse, 
    FestDeltager.Deltog
    FROM FestDeltager 
    INNER JOIN Fest ON Fest.ID = FestDeltager.FestID 
    WHERE Aktiv = 1
    GROUP BY FestDeltager.Elev_navn
    ORDER BY FestDeltager.Deltog $sort
    ";

    $result = $link->query($sql);

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
