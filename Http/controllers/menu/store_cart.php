<?php

use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve('Core\Database');

// Function to generate a unique order number
function generateUniqueOrderNumber($db)
{
  // Retrieve the highest order number currently in use
  $lastOrder = $db->query("SELECT MAX(order_number) as last_order FROM tblorders")->find();

  // If there are no orders yet, start from 101
  if ($lastOrder['last_order'] === null) {
    $order_number = 101;
  } else {
    // Increment the last order number by 1
    $order_number = $lastOrder['last_order'] + 1;
  }

  return $order_number;
}
$order_number = generateUniqueOrderNumber($db);
foreach ($_SESSION['cart'] as $item) {
  $_POST = $item;

  $errors = [];

  if (empty($errors)) {
    // Generate a unique order number for each item in the cart
    $db->query("INSERT INTO tblorders(order_type, quantity, base_coffee_id, customer_id, order_number, order_status) VALUES(:order_type, :quantity,:base_coffee_id, :customer_id, :order_number, :order_status)", ['order_type' => $_POST['order_type'], 'quantity' => $_POST['quantity'], 'base_coffee_id' => $_POST['base_coffee_id'], 'customer_id' => $_SESSION['user']['id'], 'order_number' => $order_number, 'order_status' => "notpayed"]);
  }
}

$_SESSION['cart'] = [];
// Assuming you want to store the last order number submitted
$_SESSION['orderSubmited']['ordernumber'] = $order_number;

header('location: /menu');
die();
