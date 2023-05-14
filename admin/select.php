<?php
// Initialize the session
session_start();
 
// Tjek om brugeren er logget ind, hvis ikke redirect dem til login siden
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login");
    exit;
}

if($_SESSION["Rolle"] == "Scanner")
{
header("location: qr");
}
//connect til databasen
require_once  '../config.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/select.css">

    <link href="../fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="../fontawesome/css/brands.css" rel="stylesheet">
    <link href="../fontawesome/css/solid.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    
    <div class="wrapper">
        <div class="sidebar">
            <ul>
    
                <li><i class="fa-solid fa-right-from-bracket icon"></i><a onclick="location.href='logout';" style="cursor:pointer;">Log ud</a></li>
            </ul>
        </div>
    </div>
    <div class="selection-container">
        <div class="container" onclick="location.href='qr';" style="cursor:pointer;">
            <i class="fa-solid fa-qrcode icon"></i>
            <p>Billet scanner</p>
        </div>
        <div class="container" onclick="location.href='dashboard';" style="cursor:pointer;">
            <i class="fa-solid fa-gauge icon"></i>
            <p>Fest panel</p>
        </div>
     
    
</body>
</html>