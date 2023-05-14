

<?php

session_start();

//Check if the user is loggedin, if not kick em out
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit();
}


require_once "../../config.php";

$navn = $_POST["filter"];


//sql statement that findes relevant data, joins it and sorts it
$sql = "SELECT Fest.Fest_start, Fest.Billet_start, Fest.Billet_slut, Fest.Drink_billetter, 
               Pris.Tilbuds_pris, Pris.Tilbuds_dage, Pris.Standard_pris, Image.Navn
FROM Fest
LEFT JOIN Image ON Image.ID = Fest.BilledeID
INNER JOIN Pris ON Pris.ID = Fest.PrisID
WHERE Fest.navn = '$navn'
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
