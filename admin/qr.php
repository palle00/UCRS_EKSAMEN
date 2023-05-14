<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>QR Code Scanner</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/phone.css">
  <link href="../fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="../fontawesome/css/brands.css" rel="stylesheet">
    <link href="../fontawesome/css/solid.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/qr-scanner.css">
</head>
<body>
  <div class="wrapper">
    <div class="sidebar">
      <ul>
        <li><i class="fa-solid fa-arrow-left icon"></i><a href="select" style="cursor:pointer;">Tilbage</a></li>
        <li class="repeat"><i class="fa-solid fa-repeat icon"></i><a style="cursor:pointer;">Åben fest</a></li>
        <li><i class="fa-solid fa-right-from-bracket icon"></i><a href="logout" style="cursor:pointer;">Log ud</a></li>
      </ul>
    </div>
  </div>

  <div class="selection-container" id="qr">
    <div id="qr-reader">
      <canvas></canvas>
    </div>
    <div id="qr-reader-results">
       
    </div>
    <div id="options">
    <button id="scan-another">Scan Another QR Code</button>
    <a id="list"><i class="fa-solid fa-list icon"></i></a>
    </div>
  </div>

  <div class="selection-container" id="list-view">
  <div id="settings-bar">
  <p id="amount"></p>
    <div id="settings">
      <input name="search" id="search" type="text">
      <select name="sort" id="sort">
        <option value="ASC">Ja</option>
        <option value="DESC">Nej</option>
      </select>
      <a id="list-close"><i class="fa-solid fa-xmark icon"></i></a>
    </div>
  </div>

    <table id="list-items">
            <thead>
              <tr>
                <th>Navn</th>
                <th>Klasse</th>
                <th>Fremmødt</th>
              </tr>
            </thead>
            <tbody>
           </tbody>
      </table>
</div>
<div class="sidebar phone qr">
        <ul>
          <li class="back">
            <i class="fa-solid fa-arrow-left icon"></i>
            <a href="select">Tilbage</a>
          </li>
          <li class="repeat">
            <i class="fa-solid fa-repeat icon"></i>
            <a style="cursor:pointer;">Åben fest</a></li>
          <li>
            <i class="fa-solid fa-right-from-bracket icon"></i>
            <a onclick="location.href='logout';" style="cursor:pointer;">Log ud</a>
          </li>
        </ul>
  </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/html5-qrcode"></script>
<script src="js/qr.js"></script>
</html>