<?php
include "connect.php";
// Database connection
// $servername = "localhost";
// $user = "root";
// $pass = "";
// $dbname = "coffeeshop_db";


// // Create a database connection
// $conn = new mysqli($servername, $user, $pass, $dbname);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

//for pdo
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}


// complete order button 
if (isset($_POST['finish_order'])) {
    $orderitemID = $_POST['finish_order'];
    $productID = $_POST['product_id'];

    $itemDeductSql = "SELECT * FROM tblproducts_inventory WHERE products_id = :productid";
    $itemDeductStmt = $pdo->prepare($itemDeductSql);
    $itemDeductStmt->bindParam(':productid', $productID, PDO::PARAM_INT);
    $itemDeductStmt->execute();
    $itemDeduct = $itemDeductStmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($itemDeduct as $deduct) {
        //getquantity of the order
        $deductMultiSql = "SELECT * FROM tblorderitem WHERE orderitem_id = :orderitemid";
        $deductMultiStmt = $pdo->prepare($deductMultiSql);
        $deductMultiStmt->bindParam(':orderitemid', $orderitemID, PDO::PARAM_INT);
        $deductMultiStmt->execute();
        $deductMulti = $deductMultiStmt->fetch(PDO::FETCH_ASSOC);

        // Deduct the quantity from the inventory
        $sqlDeduct = "UPDATE tblinventory SET quantity = quantity - (:quantity * :quantityOrder) WHERE inventory_id = :inventoryID";
        $statementDeduct = $pdo->prepare($sqlDeduct);
        $statementDeduct->bindParam(':quantity', $deduct['quantity'], PDO::PARAM_INT);
        $statementDeduct->bindParam(':quantityOrder', $deductMulti['quantity'], PDO::PARAM_INT);
        $statementDeduct->bindParam(':inventoryID', $deduct['inventory_id']);
        $statementDeduct->execute();

        //fetch product details
        $getProductSql = "SELECT * FROM tblproducts WHERE product_id = :productid";
        $getProductStmt = $pdo->prepare($getProductSql);
        $getProductStmt->bindParam(':productid', $deduct['products_id'], PDO::PARAM_INT);
        $getProductStmt->execute();
        $fetchProduct = $getProductStmt->fetch(PDO::FETCH_ASSOC);

        //fetch inventory details
        $getInventorySql = "SELECT * FROM tblinventory WHERE inventory_id = :inventoryid";
        $getInventoryStmt = $pdo->prepare($getInventorySql);
        $getInventoryStmt->bindParam(':inventoryid', $deduct['inventory_id'], PDO::PARAM_INT);
        $getInventoryStmt->execute();
        $fetchInventory = $getInventoryStmt->fetch(PDO::FETCH_ASSOC);

        // Convert the quantity to a string and prepend "-", set the reason for inventory deduct
        $quantityString = "-" . $deduct['quantity'] * $deductMulti['quantity'];
        $reason = "inventory deduct for preparing " . $deductMulti['quantity'] . " " . $fetchProduct['product_name'];

        // Insert data into tblInventoryReports
        $sqlInsertReport = "INSERT INTO tblinventoryreport (inventory_item, inventory_id, quantity, unit, reason) VALUES (:inventoryItem, :itemID, :quantityString, :unit, :reason)";
        $statementInsertReport = $pdo->prepare($sqlInsertReport);
        $statementInsertReport->bindParam(':inventoryItem', $fetchInventory['inventory_item']);
        $statementInsertReport->bindParam(':itemID', $deduct['inventory_id']);
        $statementInsertReport->bindParam(':quantityString', $quantityString); // Bind the modified quantity string
        $statementInsertReport->bindParam(':unit', $fetchInventory['unit']); // Bind the unit directly
        $statementInsertReport->bindParam(':reason', $reason);
        $statementInsertReport->execute();
    }

    // Construct the SQL query for updating the record
    $update_sql = "UPDATE tblorderitem
                   SET status = 'completed'
                   WHERE tblorderitem.orderitem_id= $orderitemID";
    if ($conn->query($update_sql) === TRUE) {

        //add user log [complete an order]
        $DateTime = new DateTime();
        $philippinesTimeZone = new DateTimeZone('Asia/Manila'); // Set to the Philippines time zone
        $DateTime->setTimeZone($philippinesTimeZone);

        $currentDateTime = $DateTime->format('Y-m-d H:i:s');
        $employeeid = $_SESSION['employeeID'];
        $loginfo = $_SESSION['username'] . ' has completed an order.';

        try {
            $sqlLogAdd = "INSERT INTO tbluserlogs (log_datetime, loginfo, employeeid) VALUES (:currentDateTime, :loginfo, :employeeid)";
            $statementLogAdd = $pdo->prepare($sqlLogAdd);
            $statementLogAdd->bindParam(':loginfo', $loginfo);
            $statementLogAdd->bindParam(':employeeid', $employeeid);
            $statementLogAdd->bindParam(':currentDateTime', $currentDateTime);
            $statementLogAdd->execute();
        } catch (PDOException $e) {
            // Handle the exception/error
            echo "Error: " . $e->getMessage();
        }

        // Handle a successful update (you can redirect or show a success message)
        header('Location: /admin_dashboard/orders'); // Use Location: to specify the redirect location
        exit(); // Exit to prevent further execution
    } else {
        // Handle the update errors
        echo "Error: " . $conn->error;
    }
}

// ended order button 
if (isset($_POST['ended_order'])) {
    $orderitemID = $_POST['ended_order'];

    // Construct the SQL query for updating the record
    $endorder_sql = "UPDATE tblorderitem
                   SET status = 'ended'
                   WHERE tblorderitem.orderitem_id = $orderitemID";

    if ($conn->query($endorder_sql) === TRUE) {

        //add user log [archived an order]
        $DateTime = new DateTime();
        $philippinesTimeZone = new DateTimeZone('Asia/Manila'); // Set to the Philippines time zone
        $DateTime->setTimeZone($philippinesTimeZone);

        $currentDateTime = $DateTime->format('Y-m-d H:i:s');
        $employeeid = $_SESSION['employeeID'];
        $loginfo = $_SESSION['username'] . ' has archived an order.';

        try {
            $sqlLogAdd = "INSERT INTO tbluserlogs (log_datetime, loginfo, employeeid) VALUES (:currentDateTime, :loginfo, :employeeid)";
            $statementLogAdd = $pdo->prepare($sqlLogAdd);
            $statementLogAdd->bindParam(':loginfo', $loginfo);
            $statementLogAdd->bindParam(':employeeid', $employeeid);
            $statementLogAdd->bindParam(':currentDateTime', $currentDateTime);
            $statementLogAdd->execute();
        } catch (PDOException $e) {
            // Handle the exception/error
            echo "Error: " . $e->getMessage();
        }

        // Handle a successful update (you can redirect or show a success message)
        header('Location: /admin_dashboard/orders'); // Use Location: to specify the redirect location
        exit(); // Exit to prevent further execution
    } else {
        // Handle the update errors
        echo "Error: " . $conn->error;
    }
}


// Unarchive button 
if (isset($_POST['unarchive_order'])) {
    $orderitemID = $_POST['unarchive_order'];

    // Construct the SQL query for updating the record
    $update_sql = "UPDATE tblorderitem
                   SET status = 'active'
                   WHERE tblorderitem.orderitem_id = $orderitemID";

    if ($conn->query($update_sql) === TRUE) {
        //add user log [unarchived an order]
        $DateTime = new DateTime();
        $philippinesTimeZone = new DateTimeZone('Asia/Manila'); // Set to the Philippines time zone
        $DateTime->setTimeZone($philippinesTimeZone);

        $currentDateTime = $DateTime->format('Y-m-d H:i:s');
        $employeeid = $_SESSION['employeeID'];
        $loginfo = $_SESSION['username'] . ' has unarchived an order.';

        try {
            $sqlLogAdd = "INSERT INTO tbluserlogs (log_datetime, loginfo, employeeid) VALUES (:currentDateTime, :loginfo, :employeeid)";
            $statementLogAdd = $pdo->prepare($sqlLogAdd);
            $statementLogAdd->bindParam(':loginfo', $loginfo);
            $statementLogAdd->bindParam(':employeeid', $employeeid);
            $statementLogAdd->bindParam(':currentDateTime', $currentDateTime);
            $statementLogAdd->execute();
        } catch (PDOException $e) {
            // Handle the exception/error
            echo "Error: " . $e->getMessage();
        }
        // Handle a successful update (you can redirect or show a success message)
        header('Location: /admin_dashboard/orders'); // Use Location: to specify the redirect location
        exit(); // Exit to prevent further execution
    } else {
        // Handle the update errors
        echo "Error: " . $conn->error;
    }
}

view('dashboard/orders.view.php');
