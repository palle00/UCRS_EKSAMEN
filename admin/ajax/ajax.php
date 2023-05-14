<?php

session_start();

//Check if the user is loggedin, if not kick em out
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit();
}


require_once "../../config.php";

//Check the data from the ajax request
$data = json_decode(file_get_contents('php://input'), true);
$sort = isset($data["filter"]) ? $data["filter"] : 'Navn';

//check if if the filter is tilmeldinger_count or deltager_count and make sure it doesnt contain the 'Fest.'
//As it is not a part of the database but gets created from the INNER JOIN
$sort_val = ($sort == "tilmeldinger_count" || $sort == "deltager_count" || $sort == "pris") ? $sort : 'Fest.'.$sort;

//make sure the data gets shown correctly
$order = ($sort == 'Navn' || $sort = "pris") ? 'ASC' : 'DESC';


//sql statement that findes relevant data, joins it and sorts it
$sql = "SELECT Fest.ID, Fest.Navn, Fest.Fest_start,
COUNT(FestDeltager.id) AS tilmeldinger_count,
COUNT(CASE WHEN FestDeltager.Deltog = 1 THEN 1 END) AS deltager_count,
Pris.standard_pris AS pris
FROM Fest 
LEFT JOIN FestDeltager ON FestDeltager.FestID = Fest.ID
INNER JOIN Pris ON Pris.ID = Fest.PrisID
WHERE Fest.Aktiv = 0 
GROUP BY Fest.ID 
ORDER BY $sort_val $order
";
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
