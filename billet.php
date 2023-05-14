<?php
session_start();
$err = '';

require_once "config.php";
$sql = "SELECT Fest.Navn, Fest.Billet_start, Fest.ID, 
               Pris.Tilbuds_pris, Pris.Tilbuds_dage, Pris.Standard_pris
        FROM Fest
        INNER JOIN Pris
        ON Fest.PrisID = Pris.id
        WHERE Fest.Aktiv = 1";
$result = $link->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
   $row = $result->fetch_assoc();
   $billet_start = $row['Billet_start'];
  
   $FestID = $row['ID'];
   $Dato = date('Y-m-d H:i:s', strtotime($billet_start . ' +'.$row['Tilbuds_dage'].' day'));

   if($Dato >= date('Y-m-d H:i:s'))
   {
      $_SESSION['pris'] = $row["Tilbuds_pris"];
      $_SESSION['navn'] = $row["Navn"];
   }
   else
   {
      $_SESSION['pris'] = $row["Standard_pris"];
      $_SESSION['navn'] = $row["Navn"];
   }
  }


if (!empty($_POST))
 {
  $code = $_POST['kode'];
  $select ="SELECT Elev.*
            FROM Elev
            WHERE Kode ='$code'";
  $query_l = $link->query($select);
 
  $select ="SELECT Elev.Kode
            FROM Elev 
            JOIN FestDeltager 
            ON Elev.ID = FestDeltager.ElevID 
            WHERE Elev.Kode='$code' 
            AND FestDeltager.FestID=$FestID";
  $query = $link->query($select);

  $link -> close(); 

  $codes=mysqli_num_rows($query_l);
  $exists_in_party=mysqli_num_rows($query);
  if($codes == 0)
  {
    $err = 'Koden findes ikke';
   
  }
  else if($exists_in_party)
  {
    $err = 'Koden er brugt';
    
  }
  else
  {
    $_SESSION['Billet_navn'] = $_POST['navn'];
    $_SESSION['Billet_email'] = $_POST['email'];
    $_SESSION['Billet_klasse'] = $_POST['klasse'];
    $_SESSION['Kode'] = $code;
    $_SESSION['FestID'] = $FestID;
    $_SESSION['Fest_start'] = $billet_start;
    while($result=mysqli_fetch_assoc($query_l))
    {
        $_SESSION['ElevID'] = $result['ID'];
    }
    header('Location: create-checkout-session.php');
  }
 }
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="css/Billet.css" /> 
  <link href="fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="fontawesome/css/brands.css" rel="stylesheet">
    <link href="fontawesome/css/solid.css" rel="stylesheet">
    <title>UCRS | Billet salg</title>
  </head>
  <body>
    <div id="wrapper">
    <section class="ticket">
    <div id="menu">
            <ul>
            <li><a href="index"><img src="img/ucrs_neg.png" alt=""></a></li>
            <li class="menu-item"> <i class="fa-solid fa-ticket icon" id="billet-icon"></i><a id="active" href="billet">Billet</a></li>
            <li class="menu-item"> <i class="fa-solid fa-lock icon"></i><a href="admin/login">Login</a></li>
            </ul>
        </div>
    <div id="form-container">
    <form id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> <?php ?> 
          <h1><?php echo $_SESSION['navn'].' - '.$_SESSION['pris'].'kr'; ?></h1>
          <div class="form-group">
            <label for="navn">
              Navn*
            </label>
            <input id="navn" name="navn" type="text" class="form-control" required>
          </div>
         <div class="form-group">
              <label>
              Email*
            </label>
            <input id="email" type="email" name="email" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="klasse">
              Klasse*
            </label>
            <input id="klasse" name="klasse" type="text" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="kode">
              Elev-kode*
            </label>
            <input id="kode" name="kode" type="text" class="form-control" required>
          </div>
          <div id="last" class="form-group">
             <p id="err"><?php echo $err ?></p>
            <input type="submit" class="btn" value="Betal">
          </div>
        </form>
        </div>
  </section>

    <section class="countdown-section">
      <p>Billet salg åbner om</p>
      <div id="countdown"></div>  
 	</section> 
   </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"> </script>
    <script src="js/billet_countdown.js"></script>
   
</body>
</html>