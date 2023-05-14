<?php
// Initialize the session
session_start();

//Check if the user is loggedin, if not kick em out
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login");
    exit();
}

//connect til databasen
require_once '../config.php';



$link->close();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/edit.css">
    <link rel="stylesheet" type="text/css" href="css/phone.css">
    <link href="../fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="../fontawesome/css/brands.css" rel="stylesheet">
    <link href="../fontawesome/css/solid.css" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCRS Fest | Edit</title>
</head>

<body>
    <div class="wrapper">
        <div class="title_card">
            <h1 id="edit-title">Rediger og tilføj <a id="slet" class="btn"> SLET </a></h1> 
        </div>
        <div class="sidebar">
            <ul>
                <li class="back">
                    <i class="fa-solid fa-arrow-left icon"></i>
                    <a href="select">Tilbage</a>
                </li>
                <li class="active">
                    <i class="fa-solid fa-gauge icon"></i>
                    <a href="dashboard">Dashboard</a>
                </li>
                <li>
                    <i class="fa-solid fa-eye icon"></i>
                    <a href="overblik">Fest overblik</a>
                </li>
                <li>
                    <i class="fa-solid fa-list icon"></i>
                    <a href="elev-koder">Kode liste</a>
                </li>
                <li>
                    <i class="fa-solid fa-user icon"></i>
                    <a href="kontoer#">Kontoer</a>
                </li>
                
                <li>
                    <i class="fa-solid fa-right-from-bracket icon"></i>
                    <a onclick="location.href='logout';" style="cursor:pointer;">Log ud</a>
                </li>
            </ul>
        </div>
        <div id="bar">
            <div id="opret">
                <form id="create_party" action="<?php $_PHP_SELF; ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group form-1">
                        <label for="navn">Fest navn</label>
                        <input id="navn" name="navn" type="text" required>
                    </div>
                    <div class="form-group form-1">
                        <label for="Fest_start">Fest dato</label>
                        <input id="dato" name="Fest_start" type="date" required>
                    </div>
                    <div class="form-group form-1">
                        <label for="Drink_billetter">Gratis drink billetter</label>
                        <input id="drink" name="Drink_billetter" type="number" required>
                    </div>
                    <div class="form-group form-1">
                        <label for="Image">Banner</label>
                        <input id="image" name="Image" id="Image" type="file">
                    </div>
                    <div class="form-group form-2">
                        <label for="Billet_start">Billet start dato</label>
                        <input id="bstart" name="Billet_start" type="datetime-local" required>
                    </div>
                    <div class="form-group form-2">
                        <label for="Billet_slut">Billet slut dato</label>
                        <input id="bslut" name="Billet_slut" type="datetime-local" required>
                    </div>
                    <div class="form-group form-2">
                        <label for="Standard_pris">Billet pris</label>
                        <input id="pris" name="Standard_pris" type="number" required>
                    </div>
                    <div class="form-group form-2">
                        <label for="Tilbuds_pris">Tilbuds pris</label>
                        <input id="tpris" name="Tilbuds_pris" type="number" required>
                    </div>
                    <div class="form-group form-2">
                        <label for="Tilbuds_dage">Tilbuds dage</label>
                        <input id="tdage" name="Tilbuds_dage" type="number" required>
                    </div>
                    <div class="form-group-btn">
                        <a id="næste" class="btn form-1">Næste</a>
                        <a id="tilbage" class="btn form-2">Tilbage</a>
                        <a id="confirm" class="btn form-2">Opdater</a>
                    </div>

                    </form>
                    <div>
                    <form id="add_student" action="<?php $_PHP_SELF; ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="navn">Elev navn</label>
                        <input id="navn" name="navn" type="text" required>
                    </div>
                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input id="Email" name="Email" type="text" required>
                    </div>
                    <div class="form-group">
                        <label for="Klasse">Klasse</label>
                        <input id="Klasse" name="Klasse" type="text" required>
                    </div>
                    <div class="form-group">
                        <label for="elev_kode">Elev-kode</label>
                        <input id="elev_kode" name="elev_kode" type="text" required>
                    </div>
                    <div class="form-group">
                        <label for="pris">Pris</label>
                        <input id="pris" name="pris" type="text" required>
                    </div>
                    
                    <div class="form-group-btn">
                        <a id="tilføj" class="btn form-1">Tilføj</a>
                    </div>
                    </form>
                </div>
            </div>
       
            <div class="sidebar phone">
                <ul>
                    <li class="back">
                        <i class="fa-solid fa-arrow-left icon"></i>
                        <a href="select">Tilbage</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-gauge icon"></i>
                        <a href="dashboard">Dashboard</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-eye icon"></i>
                        <a href="overblik">Fest overblik</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-list icon"></i>
                        <a href="elev-koder">Kode liste</a>
                    </li>
                    <li class="active">
                        <i class="fa-solid fa-user icon"></i>
                        <a href="kontoer">Kontoer</a>
                    </li>
                   
                    <li>
                        <i class="fa-solid fa-right-from-bracket icon"></i>
                        <a onclick="location.href='logout';" style="cursor:pointer;">Log ud</a>
                    </li>
                </ul>
            </div>


</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="js/edit.js"></script>

</html>




