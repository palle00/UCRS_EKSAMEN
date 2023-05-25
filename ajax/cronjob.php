<?php
session_start();


require_once "../config.php";
$sql = "SELECT Fest_start FROM `Fest` WHERE `Aktiv` = 1";
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
else echo json_encode("0");

$link->close();
$_SESSION['cron'] = 'True';
?>