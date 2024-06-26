<?php
// Example PHP endpoint for fetching order history
require_once 'connect.php'; // Include your database connection settings

session_start(); // Start the session
header('Content-Type: application/json');
$userID = $_SESSION['user']['id']; // Assuming you store user ID in session upon login

$query = "SELECT order_number, COUNT(*) as record_count FROM tblorders WHERE customer_id = ? GROUP BY order_number  ORDER BY order_number DESC;";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $userID);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
echo json_encode($orders);
