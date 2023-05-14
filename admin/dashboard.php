<?php
// Initialize the session
session_start();

// Tjek om brugeren er logget ind, hvis ikke redirect dem til login siden
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login");
    exit();
}

require_once '../config.php';

if(!empty($_POST))
{
  //Loop over all the POST data and assign them as the name from the form inputs
  foreach ($_POST as $name => $value) {
    $$name = $value;
  }


  $sql = "SELECT `Aktiv` FROM `Fest` WHERE Aktiv = 1";
  $result = $link->query($sql);
  $aktiv = ($result->num_rows > 0) ? True : False;

  if(!$aktiv)
  {

    if(!empty($_FILES['Image']['name'])) {
    //upload image
        $target_dir = "../Header/";
            $Billede = time().$_FILES['Image']['name'];
            $Billede_tmp = $_FILES['Image']['tmp_name'];
			move_uploaded_file($Billede_tmp, $target_dir . $Billede);
    }
    else
    {
      $Billede = 'Standard.webp';
    }

    $sql = "INSERT INTO `Image`(`Navn`) 
    VALUES (?)";
    $stmt = $link->prepare($sql);
    $stmt->bind_param(
        "s",
      $Billede
    );
    $stmt->execute();
      $BilledeID = mysqli_insert_id($link);

    $sql = "INSERT INTO `Pris`(`Tilbuds_pris`, `Tilbuds_dage`, `Standard_pris`) 
    VALUES (?, ?, ?)";
    $stmt = $link->prepare($sql);
    $stmt->bind_param(
        "iii",
      $Tilbuds_pris,
      $Tilbuds_dage,
      $Standard_pris
    );
    $stmt->execute();
    $PrisId = mysqli_insert_id($link);

    $sql = "INSERT INTO `Fest`(`Navn`, `Fest_start`, `Billet_start`, `Billet_slut`, `Drink_billetter`,`BilledeID`, `PrisId`) 
    VALUES (?, ?, ?, ?, ? , ?, ?)";

    $stmt = $link->prepare($sql);
    $stmt->bind_param(
        "ssssiii",
      $navn,
      $Fest_start,
      $Billet_start,
      $Billet_slut,
      $Drink_billetter,
      $BilledeID,
      $PrisId
    );
    $stmt->execute();
  }
  else{
    echo "<script> Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Der er allerede en aktiv fest',
    });</script>";
  }
}

$solgt = 0;
$show = 0;


//sql statement that findes relevant data, joins it and sorts it
$select = "SELECT Fest.Navn, Fest.Fest_start, Fest.Billet_slut, 
COUNT(FestDeltager.id) AS tilmeldinger_count
FROM Fest 
LEFT JOIN FestDeltager ON FestDeltager.FestID = Fest.ID
WHERE Fest.Aktiv = 01
GROUP BY Fest.ID 
ORDER BY Fest.Fest_start DESC";
$query = $link->query($select);


//sql statement that findes relevant data, joins it and sorts it
$select1 = 
"SELECT Fest.Navn, Fest.Fest_start, 
COUNT(FestDeltager.id) AS tilmeldinger_count,
COUNT(CASE WHEN FestDeltager.Deltog = 1 THEN 1 END) AS deltager_count 
FROM Fest 
LEFT JOIN FestDeltager ON FestDeltager.FestID = Fest.ID
WHERE Fest.Aktiv = 0 
GROUP BY Fest.ID 
ORDER BY Fest.Fest_start DESC";
$query_g = $link->query($select1);



$link->close();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>UCRS Fest | Dashboard</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
    <link rel="stylesheet" type="text/css" href="css/phone.css">
    <link href="../fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="../fontawesome/css/brands.css" rel="stylesheet">
    <link href="../fontawesome/css/solid.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
   

  </head>
  <body>
    <div class="wrapper">
      <div class="title_card">
        <h1>Dashboard</h1>
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
            <a href="kontoer">Kontoer</a>
          </li>
      

          <li>
            <i class="fa-solid fa-right-from-bracket icon"></i>
            <a onclick="location.href='logout';" style="cursor:pointer;">Log ud</a>
          </li>
        </ul>
      </div>
      <div id="bar">
            <div id="opret">
              <h2>Opret Fest</h2>
         <form id="create_party" action="<?php $_PHP_SELF; ?>" method="POST" enctype = "multipart/form-data">
            <div class="form-group form-1">
              <label for="navn">Fest navn</label>
              <input name="navn" type="text" required>
            </div>
            <div class="form-group form-1">
              <label for="Fest_start">Fest dato</label>
              <input name="Fest_start" type="date" required>
            </div>
            <div class="form-group form-1">
              <label for="Drink_billetter">Gratis drink billetter</label>
              <input name="Drink_billetter" type="number" required>
            </div>
            <div class="form-group form-1">
              <label for="Image">Banner</label>
              <input name="Image" id="Image" type="file">
            </div>
            <div class="form-group form-2">
              <label for="Billet_start">Billet start dato</label>
              <input name="Billet_start" type="datetime-local" required>
            </div>
            <div class="form-group form-2">
              <label for="Billet_slut">Billet slut dato</label>
              <input name="Billet_slut" type="datetime-local" required>
            </div>
            <div class="form-group form-2">
              <label for="Standard_pris">Billet pris</label>
              <input name="Standard_pris" type="number" required>
            </div>
            <div class="form-group form-2">
              <label for="Tilbuds_pris">Tilbuds pris</label>
              <input name="Tilbuds_pris" type="number" required>
            </div>
            <div class="form-group form-2">
              <label for="Tilbuds_dage">Tilbuds dage</label>
              <input name="Tilbuds_dage" type="number" required>
            </div>
            <div class="form-group-btn">
          <a id="næste" class="btn form-1">Næste</a>
          <a id="tilbage" class="btn form-2">Tilbage</a>
          <a id="forhånd" class="btn form-2">Forhåndsvis</a>
          <a id="confirm" class="btn form-2">Opret</a>
        </div>
         </form>  
        
        </div>
            <div id="statistik">
              <h2>Fremmøde</h2>
              <div id="canvas">
            <canvas id="myChart" style="width:100%;max-width:100rem"></canvas>
</div>
            </div>          
      </div>
 
      <div id="events">
        <h2 id="current_event">Aktiv fest</h2>
        <div id="color">
        <table id="event_current">
            <thead>
              <tr>
                <th>Navn</th>
                <th>Fest start</th>
                <th>Billet slut</th>
                <th>Tilmeldinger</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $num = mysqli_num_rows($query);
            if ($num > 0) {
                while ($result = mysqli_fetch_assoc($query)) {
                    echo "
                    <tr class='event' onclick=\"location.href='edit?fest=".$result["Navn"]."';\">
                        <td> ".$result["Navn"]."</td>
                        <td>".$result["Fest_start"] ."</td>
                        <td>".$result["Billet_slut"]."</td>
                        <td>".$result["tilmeldinger_count"]."</td>
                      </tr>
                    ";
                }
            }
            ?>
           
            </tbody>
          </table>
        </div>
        <h2 id="recent_event">Gamle</h2>
        <div id="color">
          <table>
            <thead>
              <tr>
                <th>Navn</th>
                <th>Dato</th>
                <th>Tilmeldinger</th>
                <th>Fremmøde</th>
              </tr>
            </thead>
            <tbody>
            
            <?php
            $num = mysqli_num_rows($query_g);
            if ($num > 0) {
                $max = 0;
                while ($result = mysqli_fetch_assoc($query_g)) {
                    if ($max != 5) {
                        $max++;
                        echo "
                     <tr class='event' onclick=\"location.href='overblik?fest=" .$result["Navn"] ."';\">
                        <td>".$result["Navn"]."</td>
                        <td>".$result["Fest_start"] ."</td>
                        <td>".$result["tilmeldinger_count"]."</td>
                        <td>".$result["deltager_count"]."</td>
                       </tr>
                     ";
                    }
                    $solgt += $result["tilmeldinger_count"];
                    $show += $result["deltager_count"];
                }
                $noshow = $solgt - $show;
            }
            ?>
            </tbody>
          </table>
        </div>
   
          </div>
          <div class="sidebar phone">
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
            <a href="kontoer">Kontoer</a>
          </li>
        
          <li>
            <i class="fa-solid fa-right-from-bracket icon"></i>
            <a onclick="location.href='logout';" style="cursor:pointer;">Log ud</a>
          </li>
        </ul>
      </div>
          </div>
  </body>
  
  <script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js"></script>
  <script type="text/javascript" src="js/dashboard.js"></script>
  <?php echo "<script>go($show, $noshow);</script>" ?>
</html>