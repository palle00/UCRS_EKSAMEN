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





if(!empty($_POST))
{
  //Loop over all the POST data and assign them as the name from the form inputs
  foreach ($_POST as $name => $value) {
    $$name = $value;
  }

  $Kode = password_hash($_POST['Kode'], PASSWORD_DEFAULT);

  $sql = "INSERT INTO `Login`(`Brugernavn`, `Kode`, `Rolle`) 
    VALUES (?, ?, ?)";
    $stmt = $link->prepare($sql);
    $stmt->bind_param(
        "sss",
      $Brugernavn,
      $Kode,
      $Rolle
    );
    $stmt->execute();
    $stmt->close();
}


$select = "SELECT Login.Brugernavn, Login.Rolle FROM Login";
$query= $link->query($select);



$link->close();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/kontoer.css">
    <link rel="stylesheet" type="text/css" href="css/phone.css">
    <link href="../fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="../fontawesome/css/brands.css" rel="stylesheet">
    <link href="../fontawesome/css/solid.css" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCRS Fest | Kontoer</title>
  </head>
  <body>
    <div class="wrapper">
      <div class="title_card">
        <h1>Kontoer</h1>
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
          <li >
          <i class="fa-solid fa-eye icon"></i>
          <a href="overblik">Fest overblik</a>
          </li>
          <li>
            <i class="fa-solid fa-list icon"></i>
            <a href="elev-koder">Kode liste</a>
          </li>
          <li class="active">
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
   <table id="event_current">
     <thead>
       <tr>
         <th>Navn</th>
         <th>Kode</th>
         <th>Rolle</th>
       </tr>
     </thead>
     <tbody> <?php
            $num = mysqli_num_rows($query);
            if ($num > 0) {
                while ($result = mysqli_fetch_assoc($query)) {
                    echo "
                      
			<tr class='event'>
				<td>".$result["Brugernavn"]."</td>
				<td>******</td>
				<td id='rolle'>".$result["Rolle"]."</td>
				<td id='icon'>
					<i class='fa-solid fa-cog icon'></i>
				</td>
			</tr>
                    ";
                }
            }
              ?> 
      </tbody>
   </table>
   <div id="opret">
     <h2>opret</h2>
     <form action="
			<?php $_PHP_SELF; ?>" method="POST">
       <div id="options">
         <div class="option">
           <label for="Brugernavn">Brugernavn</label>
           <input type="text" name="Brugernavn" required>
         </div>
         <div class="option">
           <label for="Kode">Kode</label>
           <input type="text" name="Kode" required>
         </div>
         <div class="option">
           <label for="Rolle">Rolle</label>
           <select name="Rolle">
             <option value="Super">Super</option>
             <option value="Multi">Multi</option>
             <option value="QR">QR</option>
           </select>
         </div>
         <a id="opret_bruger" class="btn">opret </a>
       </div>
   </div>
   </form>
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
  <script src="js/kontoer.js"></script>
</html>