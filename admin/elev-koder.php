<?php
// Initialize the session
session_start();

// Tjek om brugeren er logget ind, hvis ikke redirect dem til login siden
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login");
    exit();
}

require_once '../config.php';

require_once '../vendor/autoload.php'; // Load the PHPSpreadsheet library

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


if(isset($_POST["submit"])) {
  if (isset($_FILES['excel']) && !empty($_FILES['excel']['name'])) {
      // Read the file contents and get the "kode" column data
      $file_tmp = $_FILES['excel']['tmp_name'];
      $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file_tmp);
      $spreadsheet = $reader->load($file_tmp);
      $worksheet = $spreadsheet->getActiveSheet();

      $koder = array();
      foreach ($worksheet->getRowIterator() as $row) {
          $cellIterator = $row->getCellIterator();
          $cellIterator->setIterateOnlyExistingCells(false);

          $row_kode = '';
          foreach ($cellIterator as $cell) {
              if (!is_null($cell)) {
                  $cell_value = $cell->getValue();
                  if ($cell->getColumn() == 'A') {
                      $row_kode = $cell_value;
                  }
              }
          }
          if (!empty($row_kode)) {
              $koder[] = $row_kode;
          }
      }

      // Remove duplicate koder
      $koder = array_unique($koder);
      // Insert koder into database
      $insert_stmt = $link->prepare("INSERT INTO Elev (Kode) VALUES (?)");
      foreach ($koder as $kode) {
          // Check if kode already exists in database
          $check_stmt = $link->prepare("SELECT Kode FROM Elev WHERE Kode = ?");
          $check_stmt->bind_param("s", $kode);
          $check_stmt->execute();
          $check_result = $check_stmt->get_result();

          // If kode does not exist in database, insert it
          if ($check_result->num_rows == 0) {
              $insert_stmt->bind_param("s", $kode);
              $insert_stmt->execute();
          }
          $check_stmt->close();
      }
      $insert_stmt->close();
  } else {
      $elev = $_POST['tilføj'];
      if (!empty($elev)) {
          // Insert koder into database
          $insert_stmt = $link->prepare("INSERT INTO Elev (Kode) VALUES (?)");
          // Check if kode already exists in database
          $check_stmt = $link->prepare("SELECT Kode FROM Elev WHERE Kode = ?");
          $check_stmt->bind_param("s", $elev);
          $check_stmt->execute();
          $check_result = $check_stmt->get_result();

          // If kode does not exist in database, insert it
          if ($check_result->num_rows == 0) {
              $insert_stmt->bind_param("s", $elev);
              $insert_stmt->execute();
          }
          $check_stmt->close();
          $insert_stmt->close();
      }
  }
}




?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/elev-koder.css">
    <link rel="stylesheet" type="text/css" href="css/phone.css">
    <link href="../fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="../fontawesome/css/brands.css" rel="stylesheet">
    <link href="../fontawesome/css/solid.css" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCRS Fest | Elev koder</title>
  </head>
  <body>
    <div class="wrapper">
      <div class="title_card">
        <h1>Elev koder</h1>
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
          <li>
            <i class="fa-solid fa-eye icon"></i>
            <a href="overblik">Fest overblik</a>
          </li>
          <li class="active">
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
        <div id="events">
          <div id="color">
            <form action="?php $_PHP_SELF; ?>" method="POST" enctype="multipart/form-data">
              <div class="filters">
                <div class="option">
                  <label for="search">Søg</label>
                  <input name="search" id="search" type="text">
                  <a id="delete-selected" class="btn">Fjern Valgte</a>
                </div>
                <div class="option">
                  
                  <label for="tilføj">Tilføj kode eller upload excel</label>
                  <div id="uploads"> 
                  <input name="tilføj" id="tilføj" type="text">
                  <input name="excel" id="excel" type="file" accept=".xlsx,.xls">
                  </div>
                  <button class="btn" name="submit">Tilføj</button>
                  
            </form>
          </div>
        </div>
  
        <table id="elev_kode">
       
          <tbody>
          
            <form action="">
            </form>

          </tbody>
        </table>
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
          <li class="active">
            <i class="fa-solid fa-list icon"></i>
            <a href="elev-koder">Kode liste</a>
          </li>
          <li>
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
  <script src="js/elev_koder-ajax.js"></script>
</html>