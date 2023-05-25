<?php
session_start();

//connect to database
require_once "config.php";

$amount = $_SESSION['pris'];
$navn = $_SESSION['navn'];
require 'vendor/autoload.php';

$stripe = new \Stripe\StripeClient('sk_test_51MeyKOJpE07KHDIi8X2ITm7spbIJezEW8wydokj8uqwKTdoKmNRYAcPvikzC7AP5E6dh2lf4azpnscdK6CSgkhGR005Y5kX7ea');

$checkout_session = $stripe->checkout->sessions->create([
  'line_items' => [[
    'price_data' => [
      'currency' => 'DKK',
      'product_data' => [
        'name' => "Fest billet",
        'description' =>  "Denne billet giver adgang til " . $navn
      ],
      'unit_amount' => $amount*100,
    ],
    'quantity' => 1,
  ]],
  'payment_method_types' => ['card'],
  'mode' => 'payment',
  'success_url' => 'http://ucrs.implex.dk/success',
  'cancel_url' => 'http://localhost:4242/cancel.php',
]);

// Store checkout session ID in session
$_SESSION['sendmail'] = 'True';

// Redirect to checkout page
header("Location: " . $checkout_session->url);


?>