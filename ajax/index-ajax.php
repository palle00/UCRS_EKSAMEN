<?php
require_once "../config.php";
$sql = "SELECT  Fest.Billet_start, Fest.Billet_slut, Fest.Navn, Fest.Fest_start, Pris.Tilbuds_dage, Pris.Tilbuds_pris, Pris.Standard_pris 
        FROM Fest 
        INNER JOIN Pris ON Pris.ID = Fest.PrisID 
        WHERE `Aktiv` = 1";
$result = $link->query($sql);


$sql = 
"SELECT Image.Navn 
FROM Fest 
LEFT JOIN `Image` ON Image.ID = Fest.BilledeID
WHERE Fest.Aktiv = 1";
$result_i = $link->query($sql);


if ($result->num_rows > 0) {
    echo "[";
    $yes = 0; 
     while($row = $result->fetch_assoc()) {
       echo json_encode($row);
      
         echo ",";
     
     }
   
     while($row = $result_i->fetch_assoc()) {
    
      echo json_encode($row);
      echo "]";
     }
 } 
else echo json_encode("0");

$link->close();
?>