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

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/overblik.css">
    <link rel="stylesheet" type="text/css" href="css/phone.css">
    <link href="../fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="../fontawesome/css/brands.css" rel="stylesheet">
    <link href="../fontawesome/css/solid.css" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCRS Fest | Overblik</title>
  </head>
  <body>
    <div class="wrapper">
      <div class="title_card">
        <h1>Overblik</h1>
      </div>
      <div class="sidebar">
        <ul>
          <li class="back">
            <i class="fa-solid fa-arrow-left icon"></i>
            <a href="select">Tilbage</a>
          </li>
          <li>
            <i class="fa-solid fa-gauge icon"></i>
            <a href="dashboard">Dashboard</a>
          </li>
          <li class="active">
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
      <div class="fest-kasse">
      <div id="events" class="øko">
        <div id="stati">
          <div>
            <h2>Indtjening</h2>
          <p id="indtjening">s</p>
          </div>
          <div>
          <h2>Tilmeldte</h2>
                <p id="tilmeldte">s</p>
          </div>
          <div>
          <h2>Fremmøde</h2>
          <canvas id="myChart" style="width:100%;max-width:100rem"></canvas>
          </div>

        </div>
          <div id="color">
            <div class="filters">
              <div class="option">
                <label for="search">Søg</label>
                <input name="search" class="search" type="text">
              </div>
            </div>
            <table id="event_current">
              <thead>
                <tr>
                  <th>Navn</th>
                  <th>Email</th>
                  <th>Klasse</th>
                  <th>Mødt op</th>
                  <th>Billet pris</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
        <div id="events" class="prim">
          <div id="color">
            <div class="filters">
            
            <div class="option">
            <label for="search">Søg</label>
                <input name="search" class="search" type="text">
</div>
              <div class="option">
             
                <label for="sort">Sorter efter</label>
                <select id="sort" name="sort">
                  <option value="Navn">Navn</option>
                  <option value="Fest_start">Dato</option>
                  <option value="tilmeldinger_count">Billetter solgt</option>
                  <option value="deltager_count">Fremmøde</option>
                  <option value="pris">Pris</option>
                </select>
                
              </div>
            </div>
            <table id="event_current" >
              <thead>
                <tr>
                  <th>Navn</th>
                  <th>Dato</th>
                  <th>Billetter solgt</th>
                  <th>Fremmøde</th>
                  <th>Billet pris</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
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
          <li class="active">
            <i class="fa-solid fa-eye icon"></i>
            <a href="overblik">Fest overblik</a>
          </li>
          <li>
            <i class="fa-solid fa-list icon"></i>
            <a href="elev-koder">Kode liste</a>
          </li>
          <li>
            <i class="fa-solid fa-user icon"></i>
            <a href="kontoer">Kontoer</a>
          </li>
          <li>
            <i class="fa-solid fa-dollar-sign icon"></i>
            <a href="økonomi">Økonomi</a>
          </li>
          <li>
            <i class="fa-solid fa-right-from-bracket icon"></i>
            <a onclick="location.href='logout';" style="cursor:pointer;">Log ud</a>
          </li>
        </ul>
  </body>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js"></script>
  <script src="js/overblik.js"></script>
  
</html>