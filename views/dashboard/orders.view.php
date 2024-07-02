<?php require "partials/head.php";
include "connect.php";
?>

<head>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F5F5DC;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            color: #333;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #2473c0;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .finishbutton,
        .cancelbutton {
            font-size: 16px;
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        /* Finish Button */
        .finishbutton {
            background-color: #28a745;
            /* Green */
            color: #fff;
        }

        .finishbutton:hover {
            background-color: #218838;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Cancel Button */
        .cancelbutton {
            background-color: #dc3545;
            /* Red */
            color: #fff;
        }

        .cancelbutton:hover {
            background-color: #c82333;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }


        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            /* 15% from the top and centered */
            padding: 0 2% 2% 2%;
            border: 1px solid #888;
            width: 30%;
            /* Could be more or less, depending on screen size */
        }

        /* The Close Button */
        .close {
            color: black;
            float: right;
            font-size: 28px;
            font-weight: bold;
            margin-right: 5%;
            margin-top: 5%;
        }

        .close:hover,
        .close:focus {
            color: gray;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>


<body>
    <!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <form method="post" action="/admin_dashboard/orders" onsubmit="return confirm('Are you sure you want to proceed with this transaction?')">
                <span class="close">&times;</span>
                <br><br>
                <div id="modalText"></div>
            </form>
        </div>
    </div>

    <!-- vissible main -->
    <div class="dashboard">
        <div class="sidebar">
            <h1>Coffee Shop</h1>
            <?php require "partials/nav.php"; ?>
        </div>

        <!--ORDERS TAB-->
        <div class="content">
            <h2>Orders
                <?php echo " (" . $_SESSION['user']['email'] . " the " . $_SESSION['user']['position'] . ") " ?>
            </h2>
            <div><!--SHOW ORDERS THAT ARE ACTIVE-->
                <form method="post" action="/admin_dashboard/orders">
                    <table class="table table-bordered" id="ordersTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th colspan="6" style="background-color: #222e5d;">
                                    <h3>Active Orders</h3>
                                </th>
                            </tr>
                            <tr>
                                <th>Order Number</th>
                                <th>Customer User Name</th>
                                <th>No. of Items</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

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

                            // $sql_ordersActive = "SELECT oi.orderitem_id, oi.orderid, oi.productid,e.username, p.product_name, oi.quantity,oi.orderid,oi.status FROM tblorderitem oi JOIN tblproducts p ON oi.productid = p.product_id JOIN tblorders o ON oi.orderid = o.order_number JOIN tblemployees e ON o.customer_id = e.employeeID WHERE oi.status = 'active' and o.order_status = 'payed' and oi.orderitem_id IN (SELECT orderitem_id from tblorderitem) GROUP BY oi.orderitem_id;";
                            $sql_ordersActive = "SELECT sub.orderid, sub.total_quantity, sub.status, e.username, sub.date_time FROM ( SELECT oi.orderid, SUM(oi.quantity) AS total_quantity, oi.status, oi.date_time FROM tblorderitem oi WHERE oi.status = 'active' GROUP BY oi.orderid, oi.status ) sub JOIN tblorders o ON sub.orderid = o.order_number JOIN tblemployees e ON o.customer_id = e.employeeID WHERE o.order_status = 'payed' and sub.status = 'active' GROUP BY sub.orderid,date(sub.date_time) ORDER BY sub.orderid;";
                            $result_ordersActive = $conn->query($sql_ordersActive);
                            while ($row = $result_ordersActive->fetch_assoc()) : ?>
                                <tr>
                                    <td>
                                        <?php echo $row['orderid']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['username']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['total_quantity']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['status']; ?>
                                    </td>
                                    <td>
                                        <button type="button" onclick="view('<?= $row['orderid'] ?>','<?= $row['date_time'] ?>','<?= $row['username'] ?>','<?= $row['total_quantity'] ?>','<?= $row['status'] ?>')">View</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </form>
            </div>

            <!--SHOW ORDERS THAT ARE ENDED-->
            <div>
                <form method="post" action="/admin_dashboard/orders">
                    <table class="table table-bordered" id="ordersTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th colspan="6" style="background-color: #800000;">
                                    <h3>Ended Orders</h3>
                                </th>
                            </tr>
                            <tr>
                                <th>Order Number</th>
                                <th>Customer User Name</th>
                                <th>No. of Items</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_ordersEnded = "SELECT sub.orderid, sub.total_quantity, sub.status, e.username, sub.date_time FROM ( SELECT oi.orderid, SUM(oi.quantity) AS total_quantity, oi.status, oi.date_time FROM tblorderitem oi WHERE oi.status = 'ended' GROUP BY oi.orderid, oi.status ) sub JOIN tblorders o ON sub.orderid = o.order_number JOIN tblemployees e ON o.customer_id = e.employeeID WHERE o.order_status = 'payed' and sub.status = 'ended' GROUP BY sub.orderid,date(sub.date_time) ORDER BY sub.orderid;";
                            $result_ordersEnded = $conn->query($sql_ordersEnded);
                            while ($row = $result_ordersEnded->fetch_assoc()) : ?>
                                <tr>
                                    <td>
                                        <?php echo $row['orderid']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['username']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['total_quantity']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['status']; ?>
                                    </td>
                                    <td>
                                        <button type="button" onclick="view('<?= $row['orderid'] ?>','<?= $row['date_time'] ?>','<?= $row['username'] ?>','<?= $row['total_quantity'] ?>','<?= $row['status'] ?>')">View</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </form>
            </div>

            <!--SHOW ORDERS THAT ARE COMPLETED-->
            <div>

                <table class="table table-bordered" id="ordersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th colspan="5" style="background-color: #008000;">
                                <h3>Completed Orders</h3>
                            </th>
                        </tr>
                        <tr>
                            <th>Order Number</th>
                            <th>Customer User Name</th>
                            <th>Order Quantity</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_ordersComplete = "SELECT sub.orderid, sub.total_quantity, sub.status, e.username, sub.date_time FROM ( SELECT oi.orderid, SUM(oi.quantity) AS total_quantity, oi.status, oi.date_time FROM tblorderitem oi WHERE oi.status = 'completed' GROUP BY oi.orderid, oi.status ) sub JOIN tblorders o ON sub.orderid = o.order_number JOIN tblemployees e ON o.customer_id = e.employeeID WHERE o.order_status = 'payed' and sub.status = 'completed' GROUP BY sub.orderid,date(sub.date_time) ORDER BY sub.orderid;";
                        $result_ordersComplete = $conn->query($sql_ordersComplete);
                        while ($row = $result_ordersComplete->fetch_assoc()) : ?>
                            <tr>
                                <td>
                                    <?php echo $row['orderid']; ?>
                                </td>
                                <td>
                                    <?php echo $row['username']; ?>
                                </td>
                                <td>
                                    <?php echo $row['total_quantity']; ?>
                                </td>
                                <td>
                                    <?php echo $row['status']; ?>
                                </td>
                                <td>
                                    <button type="button" onclick="view('<?= $row['orderid'] ?>','<?= $row['date_time'] ?>','<?= $row['username'] ?>','<?= $row['total_quantity'] ?>','<?= $row['status'] ?>')">View</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

            </div>
            <br><br>
        </div>

    </div>
</body>

<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    function view(order_number, order_date, username, item_count, status) {
        // Fetch the order items from the server
        getOrderItemsFromServer(order_number, order_date).then(items => {
            // Construct the modal content
            var modalContent = `<h4>Order number: ${order_number}</h4>
                                <h4>Customer Name: ${username}</h4>
                                <h4>Order Quantity: ${item_count}</h4>
                                <h4>Status: ${status}</h4>
                                <table>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                    </tr>`;
            items.forEach(item => {
                modalContent += `<tr>
                                    <td>${item.name}</td>
                                    <td>${item.quantity}</td>
                                </tr>
                `;
            });
            if (status == 'active') {
                modalContent += `</table>
                            <div style="text-align:center;">
                                <button type="submit" name="action" value="finish_${order_number}_${order_date}</td>
                                                </tr>" class="finishbutton">Finish</button>
                                <button type="submit" name="action" value="decline_${order_number}_${order_date}" class="cancelbutton">Cancel</button>
                            </div>
                            
                            `;
            } else if ((status == 'ended')) {
                modalContent += `</table>
                            <div style="text-align:center;">
                                <button type="submit" name="reactivate" value="reactivate_${order_number}_${order_date}</td>
                                                </tr>" class="finishbutton">Re-Activate</button>
                            </div>
                            
                            `;
            } else {
                modalContent += `</table>`;
            }


            // Update the modal text
            document.getElementById('modalText').innerHTML = modalContent;

            // Show the modal
            document.getElementById('myModal').style.display = "block";
        });
    }

    // Function to fetch order items from the server
    function getOrderItemsFromServer(orderNumber, orderDate) {
        return fetch(`/fetch_orderitems.php?orderNumber=${orderNumber}&orderDate=${orderDate}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json(); // Assuming the server responds with JSON
            })
            .catch(error => console.error('Fetch error:', error));
    }
</script>