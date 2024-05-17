<?php
include "connect.php";
// Database connection
// $servername = "localhost";
// $user = "root";
// $pass = "";
// $dbname = "coffeeshop_db";

// try {
//     $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $user, $pass);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     die("Database connection failed: " . $e->getMessage());
// }

// Fetch data from tblinventory
$sql = "SELECT * FROM tblinventory";
$statement = $pdo->prepare($sql);
$statement->execute();
$inventoryData = $statement->fetchAll(PDO::FETCH_ASSOC);

// Fetch data from tblcategory_inventory
$sqlCategoryInventory = "SELECT * FROM tblcategory_inventory";
$categoryInventoryStatement = $pdo->prepare($sqlCategoryInventory);
$categoryInventoryStatement->execute();
$categoryInventoryData = $categoryInventoryStatement->fetchAll(PDO::FETCH_ASSOC);

//adding supply for a inventory
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_add_item'])) {
        // Retrieve form data
        $inventoryItem = $_POST['supply_item'];
        $inventoryID = $_POST['item_id_increase'];
        $quantity = $_POST['new_quantity'];
        $reason = "added supply for " . $inventoryItem;

        // Fetch the unit from the tblinventory table
        $sqlFetchUnit = "SELECT unit FROM tblinventory WHERE inventory_id = :inventory_id";
        $statementFetchUnit = $pdo->prepare($sqlFetchUnit);
        $statementFetchUnit->bindParam(':inventory_id', $inventoryID);
        $statementFetchUnit->execute();
        $unitResult = $statementFetchUnit->fetch(PDO::FETCH_ASSOC);
        $unit = $unitResult['unit']; // Assuming 'unit' is the correct column name

        // Add the quantity to the inventory
        $sqlAdd = "UPDATE tblinventory SET quantity = quantity + :quantity WHERE inventory_id = :inventoryID";
        $statementAdd = $pdo->prepare($sqlAdd);
        $statementAdd->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $statementAdd->bindParam(':inventoryID', $inventoryID);
        $statementAdd->execute();

        // Insert data into tblInventoryReports
        $sqlInsertReport = "INSERT INTO tblinventoryreport (inventory_item, inventory_id, quantity, unit, reason) VALUES (:inventoryItem, :inventory_id, :quantity, :unit, :reason)";
        $statementInsertReport = $pdo->prepare($sqlInsertReport);
        $statementInsertReport->bindParam(':inventoryItem', $inventoryItem);
        $statementInsertReport->bindParam(':inventory_id', $inventoryID);
        $statementInsertReport->bindParam(':quantity', $quantity);
        $statementInsertReport->bindParam(':unit', $unit);
        $statementInsertReport->bindParam(':reason', $reason);
        $statementInsertReport->execute();

        // Redirect back to the inventory page after filing pilferage
        header("Location: /admin_dashboard/inventory");
        exit(); // Ensure that code stops executing after redirection
    }
}

// filing a pilferage
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_file'])) {
        // Retrieve form data
        $inventoryItem = $_POST['new_item'];
        $itemID = $_POST['item_id'];
        $quantity = $_POST['new_quantity'];
        $reason = $_POST['reason'];

        // Fetch the unit from the tblinventory table
        $sqlFetchUnit = "SELECT unit FROM tblinventory WHERE inventory_id = :inventory_id";
        $statementFetchUnit = $pdo->prepare($sqlFetchUnit);
        $statementFetchUnit->bindParam(':inventory_id', $itemID);
        $statementFetchUnit->execute();
        $unitResult = $statementFetchUnit->fetch(PDO::FETCH_ASSOC);
        $unit = $unitResult['unit']; // Assuming 'unit' is the correct column name


        // Deduct the quantity from the inventory
        $sqlDeduct = "UPDATE tblinventory SET quantity = quantity - :quantity WHERE inventory_id = :inventoryID";
        $statementDeduct = $pdo->prepare($sqlDeduct);
        $statementDeduct->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $statementDeduct->bindParam(':inventoryID', $itemID);
        $statementDeduct->execute();

        // Convert the quantity to a string and prepend "-"
        $quantityString = "-" . $quantity;

        // Insert data into tblInventoryReports
        $datetime = date('Y-m-d H:i:s');
        $sqlInsertReport = "INSERT INTO tblinventoryreport (inventory_item, inventory_id, quantity, unit, reason) VALUES (:inventoryItem, :itemID, :quantityString, :unit, :reason)";
        $statementInsertReport = $pdo->prepare($sqlInsertReport);
        $statementInsertReport->bindParam(':inventoryItem', $inventoryItem);
        $statementInsertReport->bindParam(':itemID', $itemID);
        $statementInsertReport->bindParam(':quantityString', $quantityString); // Bind the modified quantity string
        $statementInsertReport->bindParam(':unit', $unit); // Bind the unit directly
        $statementInsertReport->bindParam(':reason', $reason);
        $statementInsertReport->execute();


        // Redirect back to the inventory page after filing pilferage
        header("Location: /admin_dashboard/inventory");
        exit(); // Ensure that code stops executing after redirection
    }
}
// Sa add,edit,delete button
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sa Add action to
    if (isset($_POST['submit_add'])) {
        $newItem = $_POST['new_item'];
        $newType = $_POST['new_type'];
        $newQuantity = $_POST['new_quantity'];
        $newUnit = $_POST['new_unit'];

        $sqlAdd = "INSERT INTO tblinventory (inventory_item, item_type ,quantity, unit) VALUES (:newItem, :newType, :newQuantity, :newUnit)";
        $statementAdd = $pdo->prepare($sqlAdd);
        $statementAdd->bindParam(':newItem', $newItem);
        $statementAdd->bindParam(':newType', $newType);
        $statementAdd->bindParam(':newQuantity', $newQuantity);
        $statementAdd->bindParam(':newUnit', $newUnit);
        $statementAdd->execute();

        //get the next inventory_id in tblinventroy
        $sql = "SELECT MAX(inventory_id) AS last_inventory_id FROM tblinventory";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $lastInventoryIDResult = $statement->fetch(PDO::FETCH_ASSOC);
        $lastInventoryID = $lastInventoryIDResult['last_inventory_id'];

        //add a record for initial supply of a new inventory
        $reason = "New Inventory initial supply for " . $newItem;
        $sqlInsertReport = "INSERT INTO tblinventoryreport (inventory_item, inventory_id, quantity, unit, reason) VALUES (:inventoryItem, :itemID, :quantityString, :unit, :reason)";
        $statementInsertReport = $pdo->prepare($sqlInsertReport);
        $statementInsertReport->bindParam(':inventoryItem', $newItem);
        $statementInsertReport->bindParam(':itemID', $lastInventoryID);
        $statementInsertReport->bindParam(':quantityString', $newQuantity); // Bind the modified quantity string
        $statementInsertReport->bindParam(':unit', $newUnit); // Bind the unit directly
        $statementInsertReport->bindParam(':reason', $reason);
        $statementInsertReport->execute();



        //add user log [add new inventory item]
        $DateTime = new DateTime();
        $philippinesTimeZone = new DateTimeZone('Asia/Manila'); // Set to the Philippines time zone
        $DateTime->setTimeZone($philippinesTimeZone);

        $currentDateTime = $DateTime->format('Y-m-d H:i:s');
        $employeeid = $_SESSION['employeeID'];
        $loginfo = $_SESSION['username'] . ' has added a new inventory item.';

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
        header("Location: /admin_dashboard/inventory");
    }

    // Ito sa edit action
    if (isset($_POST['submit_edit'])) {

        try {
            $editItemId = $_POST['edit_item_id'];
            $editedItem = $_POST['edited_item'];
            $editedType = $_POST['edited_type'];
            // $editedQuantity = $_POST['edited_quantity'];
            $editedUnit = $_POST['edited_unit'];


            $sqlEdit = "UPDATE tblinventory SET inventory_item = :editedItem, item_type = :editedType, unit = :editedUnit  WHERE inventory_id = :editItemId";
            $statementEdit = $pdo->prepare($sqlEdit);
            $statementEdit->bindParam(':editItemId', $editItemId);
            $statementEdit->bindParam(':editedItem', $editedItem);
            $statementEdit->bindParam(':editedType', $editedType);
            // $statementEdit->bindParam(':editedQuantity', $editedQuantity);
            $statementEdit->bindParam(':editedUnit', $editedUnit);
            $statementEdit->execute();

            //add user log [edited an inventory item]
            $DateTime = new DateTime();
            $philippinesTimeZone = new DateTimeZone('Asia/Manila'); // Set to the Philippines time zone
            $DateTime->setTimeZone($philippinesTimeZone);

            $currentDateTime = $DateTime->format('Y-m-d H:i:s');
            $employeeid = $_SESSION['employeeID'];
            $loginfo = $_SESSION['username'] . ' has edited an inventory item.';

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

            header("Location: /admin_dashboard/inventory");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Sa delete 
    if (isset($_POST['submit_delete'])) {
        try {
            $deleteItemId = $_POST['delete_item_id'];

            $sqlDelete = "DELETE FROM tblinventory WHERE inventory_id = :deleteItemId";
            $statementDelete = $pdo->prepare($sqlDelete);
            $statementDelete->bindParam(':deleteItemId', $deleteItemId);
            $statementDelete->execute();

            //add user log [delete an inventory item]
            $DateTime = new DateTime();
            $philippinesTimeZone = new DateTimeZone('Asia/Manila'); // Set to the Philippines time zone
            $DateTime->setTimeZone($philippinesTimeZone);

            $currentDateTime = $DateTime->format('Y-m-d H:i:s');
            $employeeid = $_SESSION['employeeID'];
            $loginfo = $_SESSION['username'] . ' has deleted an inventory item.';

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

            // Redirect to inventory.php after successful deletion
            header("Location: /admin_dashboard/inventory");
            exit(); // Ensure that code stops executing after redirection
        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            // You might want to log the error or redirect to an error page
        }
    }

    // Ito sa update all inventory action
    if (isset($_POST['submit_update_all'])) {
        try {
            foreach ($inventoryData as $inventoryDataRow) {
                // Retrieve the submitted quantity for the specific inventory item
                $quantityKey = "newQuantity" . $inventoryDataRow['inventory_id'];
                $newQuantity = $_POST[$quantityKey];

                // Perform the update query for each inventory item
                $updateSql = "UPDATE tblinventory SET quantity = :newQuantity WHERE inventory_id = :inventoryId";
                $updateStatement = $pdo->prepare($updateSql);
                $updateStatement->bindParam(':newQuantity', $newQuantity);
                $updateStatement->bindParam(':inventoryId', $inventoryDataRow['inventory_id']);
                $updateStatement->execute();
            }

            //add user log [updated all inventory quantity]
            $DateTime = new DateTime();
            $philippinesTimeZone = new DateTimeZone('Asia/Manila'); // Set to the Philippines time zone
            $DateTime->setTimeZone($philippinesTimeZone);

            $currentDateTime = $DateTime->format('Y-m-d H:i:s');
            $employeeid = $_SESSION['employeeID'];
            $loginfo = $_SESSION['username'] . ' has updated all inventory quantity.';

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

            header("Location: /admin_dashboard/inventory");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    //add edit delete sa categories
    //add category
    if (isset($_POST['addCategory'])) {
        try {
            $newCategory = $_POST['new_category'];

            $sqlAddCategory = "INSERT INTO tblcategory_inventory (inventory_category) VALUES (:newCategory)";
            $statementAddCategory = $pdo->prepare($sqlAddCategory);
            $statementAddCategory->bindParam(':newCategory', $newCategory);
            $statementAddCategory->execute();

            //add user log [added a new inventory category]
            $DateTime = new DateTime();
            $philippinesTimeZone = new DateTimeZone('Asia/Manila'); // Set to the Philippines time zone
            $DateTime->setTimeZone($philippinesTimeZone);

            $currentDateTime = $DateTime->format('Y-m-d H:i:s');
            $employeeid = $_SESSION['employeeID'];
            $loginfo = $_SESSION['username'] . ' has added a new inventory category.';

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

            header("Location: /admin_dashboard/inventory");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    //delete category
    if (isset($_POST['categoryDelete'])) {
        try {
            $deleteCategoryId = $_POST['delete_category_id'];

            $sqlDeleteCategory = "DELETE FROM tblcategory_inventory WHERE categoryInventory_id = :deleteCategoryId";
            $statementDeleteCategory = $pdo->prepare($sqlDeleteCategory);
            $statementDeleteCategory->bindParam(':deleteCategoryId', $deleteCategoryId);
            $statementDeleteCategory->execute();

            //add user log [deleted an inventory category]
            $DateTime = new DateTime();
            $philippinesTimeZone = new DateTimeZone('Asia/Manila'); // Set to the Philippines time zone
            $DateTime->setTimeZone($philippinesTimeZone);

            $currentDateTime = $DateTime->format('Y-m-d H:i:s');
            $employeeid = $_SESSION['employeeID'];
            $loginfo = $_SESSION['username'] . ' has deleted an inventory category.';

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

            // Redirect to inventory.php after successful deletion
            header("Location: /admin_dashboard/inventory");
            exit(); // Ensure that code stops executing after redirection
        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            // You might want to log the error or redirect to an error page
        }
    }

    //save edit category
    if (isset($_POST['update_category'])) {
        try {
            $editCategoryId = $_POST['update_category_id'];
            $editedCategory = $_POST['update_inventoryCategory'];


            $sqlEditCategory = "UPDATE tblcategory_inventory SET inventory_category = :editedCategory WHERE categoryInventory_id = :editCategoryId";
            $statementEditCategory = $pdo->prepare($sqlEditCategory);
            $statementEditCategory->bindParam(':editCategoryId', $editCategoryId);
            $statementEditCategory->bindParam(':editedCategory', $editedCategory);
            $statementEditCategory->execute();

            //add user log [edited an inventory category]
            $DateTime = new DateTime();
            $philippinesTimeZone = new DateTimeZone('Asia/Manila'); // Set to the Philippines time zone
            $DateTime->setTimeZone($philippinesTimeZone);

            $currentDateTime = $DateTime->format('Y-m-d H:i:s');
            $employeeid = $_SESSION['employeeID'];
            $loginfo = $_SESSION['username'] . ' has edited an inventory category.';

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

            header("Location: /admin_dashboard/inventory");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}



// Fetch total products
$sqlTotalProducts = "SELECT COUNT(*) AS totalProducts FROM tblinventory";
$statementTotalProducts = $pdo->prepare($sqlTotalProducts);
$statementTotalProducts->execute();
$totalProductsData = $statementTotalProducts->fetch(PDO::FETCH_ASSOC);
if ($statementTotalProducts->rowCount() == 0) {
    $totalProducts = 0;
} else {
    $totalProducts = $totalProductsData['totalProducts'];
}
// Fetch data for Low Stock Chart
$sqlLowStock = "SELECT COUNT(*) as lowStock
                FROM (
                    SELECT * 
                    FROM tblinventory
                    WHERE quantity >= 0 AND quantity <= 10
                ) AS subquery";

$statementLowStock = $pdo->prepare($sqlLowStock);
$statementLowStock->execute();
if ($statementTotalProducts->rowCount() == 0) {
    $lowStockData = 0;
} else {
    $lowStockData = $statementLowStock->fetchAll(PDO::FETCH_ASSOC);
}


// Fetch data for Out of Stock Chart
$sqlOutOfStock = "SELECT item_type, COUNT(*) as out_of_stock
                  FROM tblinventory
                  WHERE quantity <= 0
                  GROUP BY item_type";

$statementOutOfStock = $pdo->prepare($sqlOutOfStock);
$statementOutOfStock->execute();
if ($statementTotalProducts->rowCount() == 0) {
    $outOfStockData = 0;
} else {
    $outOfStockData = $statementOutOfStock->fetchAll(PDO::FETCH_ASSOC);
}


// Fetch data for Most Stock Chart
$sqlMostStock = "SELECT MAX(quantity) as most_stock
                FROM tblinventory
                GROUP BY item_type
                ORDER BY quantity DESC
                ;";
$statementMostStock = $pdo->prepare($sqlMostStock);
$statementMostStock->execute();
if ($statementTotalProducts->rowCount() == 0) {
    $mostStockData = 0;
} else {
    $mostStockData = $statementMostStock->fetchAll(PDO::FETCH_ASSOC);
}

view('dashboard/inventory.view.php', [
    'totalProducts' => $totalProducts,
    'inventoryData' => $inventoryData,
    'lowStockData' => $lowStockData,
    'outOfStockData' => $outOfStockData,
    'mostStockData' => $mostStockData,
    'categoryInventoryData' => $categoryInventoryData
]);