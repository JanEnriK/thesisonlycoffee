<?php

use Core\App;
use Core\Database;

$db = App::resolve('Core\Database');

// Retrieve the form data
$totalAmount = $_POST['totalAmount'];
$customerId = $_POST['customerId'];
$orderNumber = $_POST['orderNumber'];
$paymentCash = $_POST['amountPaid'];
$paymentOnline = $_POST['referenceNumber'];

// Check which payment method was selected
if (!empty($paymentCash)) {
    // Insert the payment details into the database (CASH)
    $db->query("INSERT INTO tblpayment(amountpayed, paymenttype, customerid, orderNumber) VALUES(:total_amount, :payment_type, :customer_id, :order_number)", [
        'total_amount' => $totalAmount,
        'payment_type' => "cash",
        'customer_id' => $customerId,
        'order_number' => $orderNumber,
    ]);
    //update status of the order
    $db->query("UPDATE `tblorders` SET `order_status` = 'payed' WHERE order_number = ?", [$orderNumber]);
    //pass the order to order items for preparation
    $orderedItems = $db->query("SELECT * FROM tblorders JOIN tblproducts ON base_coffee_id = product_id WHERE order_status = 'payed' AND order_number = ?;", [$orderNumber])->get();
    foreach ($orderedItems as $items) {
        $db->query("INSERT INTO tblorderitem(quantity, status, orderid, productid) VALUES(:quantity, :status, :orderid, :productid)", [
            'quantity' => $items['quantity'],
            'status' => "active",
            'orderid' => $orderNumber,
            'productid' => $items['product_id'],
        ]);
    }
} elseif (!empty($paymentOnline)) {
    // Insert the payment details into the database (ONLINE)
    $db->query("INSERT INTO tblpayment(amountpayed, paymenttype, customerid, orderNumber, reference_no) VALUES(:total_amount, :payment_type, :customer_id, :order_number,:reference_no)", [
        'total_amount' => $totalAmount,
        'payment_type' => "online",
        'customer_id' => $customerId,
        'order_number' => $orderNumber,
        'reference_no' => $paymentOnline,
    ]);
    //update status of the order
    $db->query("UPDATE `tblorders` SET `order_status` = 'payed' WHERE order_number = ?", [$orderNumber]);

    //pass the order to order items for preparation
    $orderedItems = $db->query("SELECT * FROM tblorders JOIN tblproducts ON base_coffee_id = product_id WHERE order_status = 'payed' AND order_number = ?;", [$orderNumber])->get();
    foreach ($orderedItems as $items) {
        $db->query("INSERT INTO tblorderitem(quantity, status, orderid, productid) VALUES(:quantity, :status, :orderid, :productid)", [
            'quantity' => $items['quantity'],
            'status' => "active",
            'orderid' => $orderNumber,
            'productid' => $items['product_id'],
        ]);
    }
} else {
    echo "No transaction detected";
}

// Assuming you want to store the last order number submitted
$_SESSION['orderSubmited']['ordernumber'] = $orderNumber;

// Redirect to a success page or back to the order details page
header('Location: /pos_frontend/online_orders');
exit;
