<?php
// Starter en session
session_start();
// Tjek om brugeren er logget ind
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: select");
    exit;
}
 
// Inkludere config.php - Så vi kan connecte til databasen
require_once '../config.php';
 
// Deffinere de værdier vi skal bruge
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Få fat på data fra FORMS
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Tjek om username er tom
    if(empty(trim($_POST["username"]))){ 
        $username_err = "err";
    } else{
        $username = trim($_POST["username"]); 
    }
    
    // Tjek om password er tom
    if(empty(trim($_POST["password"]))){
        $password_err = "err";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Valider koder og navn med serveren
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT ID, Brugernavn, Kode, Rolle FROM Login WHERE Brugernavn = ?";

        
        // anti sql-injection - Bruger prepared statements til at 
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $username);
            

            //executer vores prepared statement
            if(mysqli_stmt_execute($stmt)){
         
                //gem brugernavnet sikkert til senere brug
                mysqli_stmt_store_result($stmt);
                
                // Tjek om brugernavnet eksister, hvis det gør så tjek password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
              
                        //binder id username og hashed_password sammen
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $rolle);

                    //Få fat på password og tjek om det passer med password på serveren
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Hvis password er korrekt starter vi en ny session 
                            session_start();
                            
                            // Lager alt data i session
                            $_SESSION["loggedin"] = true;
                            $_SESSION["ID"] = $id;
                            $_SESSION["Brugernavn"] = $username;  
                            $_SESSION["Rolle"] = $rolle;                          
                            
                            // Send brugeren hend til welcome siden
                            header("location: select");
                        } else{
                            // Hvis koden ikke var rigtig smid en error
                            $login_err = "Forkert brugernavn eller kode";
                        }
                    }
                } else{
                    // Hvis koden ikke var rigtig smid en error
                    $login_err = "Forkert brugernavn eller kode";
                }
            } else{
                //hvis severen fejler smid en error
                echo "Oops! Noget gik galt, prøv igen senere";
            }

           //luk for statements så der ikke kan blive fundet løse packets
            mysqli_stmt_close($stmt);
        }
    }
    
   //luk linke til severen
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/login.css" /> 
  <link href="../fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="../fontawesome/css/brands.css" rel="stylesheet">
    <link href="../fontawesome/css/solid.css" rel="stylesheet">
    <title>Buy cool new product</title>
  </head>
  <body>
    
    <div id="wrapper">
    <section class="login">
    <div id="menu">
            <ul>
            <li><a href="../index"><img src="../img/ucrs_neg.png" alt=""></a></li>
            <li class="menu-item"> <i class="fa-solid fa-ticket icon" id="billet-icon"></i><a href="../billet">Billet</a></li>
            <li class="menu-item"> <i class="fa-solid fa-lock icon"></i><a href="admin/login" id="active">Login</a></li>
            </ul>
        </div>
    <div id="form-container">
    <form id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> <?php ?> 
          <h1>Admin Login </h1>
          <div class="form-group">
            <label for="navn">
            Brugernavn*
            </label>
            <input id="username" name="username" type="text" class="form-control" required>
          </div>
         <div class="form-group">
              <label>
              Kode*
            </label>
            <input id="password" type="password" name="password" class="form-control" required>
          </div>
          <div id="last" class="form-group">
             <p id="err"><?php echo $login_err ?></p>
            <input type="submit" class="btn" value="Login">
          </div>
        </form>
        </div>
  </section>
   </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"> </script>
   
   
</body>
</html>