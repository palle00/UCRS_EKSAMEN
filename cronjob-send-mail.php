<?php
session_start();

if (!isset($_SESSION['cron'])) {
  header('Location: index.php');
  exit;
}

require_once('config.php');
$sql = "SELECT FestDeltager.Email, FestDeltager.Elev_navn FROM `FestDeltager` 
        INNER JOIN Fest ON FestDeltager.FestID = Fest.ID 
        WHERE Fest.Aktiv = 1";

$query = $link->query($sql);




require_once('vendor/autoload.php');
//Mail and QR system
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
  // Server settings
  $mail->SMTPDebug = 0; // Enable verbose debug output
  $mail->isSMTP(); // Send using SMTP
  $mail->Host = 'mail'; // Set the SMTP server to send through
  $mail->SMTPAuth = true; // Enable SMTP authentication
  $mail->Username = 'smtp'; // SMTP username
  $mail->Password = 'pass'; // SMTP password
  $mail->SMTPSecure = 'tls';
  $mail->Port = 587;

  // Recipients
  $mail->setFrom('mail', 'UCRS Fest Billet');

  // Email body
  $mail->isHTML(true); // Set email format to HTML
  $mail->Subject = 'Så går det snart løst!';
  $mail->CharSet = 'UTF-8';
  $mail->ContentType = 'text/html; charset=UTF-8';
  $mail->Body = 'Så er der under en dag til at festen starter!';
  // Send the email

  $num = mysqli_num_rows($query);
if ($num > 0) {
    while ($result = mysqli_fetch_assoc($query)) {

        $mail->setFrom('mail', 'UCRS Fest Billet');
        $mail->addAddress( $result['Email'], $result['Elev_navn']); // Add a recipient
        $mail->send();
      
    }
}

 


  

} catch (Exception $e) {
  echo "Email error: {$mail->ErrorInfo}";
}




session_unset();
session_destroy();
?>