<?php
/* Database oplysninger */
define('DB_SERVER', 'local');
define('DB_USERNAME', 'local');
define('DB_PASSWORD', 'local');
define('DB_NAME', 'local');
 
/* Prøv og connect til databasen */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Tjek om vi er connected
if($link === false){
    die("ERROR: Kunne ikke connecte. " . mysqli_connect_error());
}
?>
